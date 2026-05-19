<?php
// Suprimir warnings que contaminan la respuesta
error_reporting(0);
ini_set('display_errors', 0);

// Solo iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Solo admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'mensaje' => 'Acceso denegado.']);
    exit;
}

$env      = require 'env.php';
$host     = $env['DB_HOST'];
$db       = $env['DB_NAME'];
$user     = $env['DB_USER'];
$pass     = $env['DB_PASS'];
$charset  = $env['DB_CHARSET'];

// Archivo de historial
$historialFile = 'storage/historial_restauraciones.json';

// Crear carpeta storage si no existe
if (!is_dir('storage')) {
    mkdir('storage', 0755, true);
}

$respuesta = ['success' => false, 'mensaje' => ''];

// Limpiar cualquier salida previa de index.php y responder JSON limpio
while (ob_get_level()) ob_end_clean();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_sql'])) {

    $archivo = $_FILES['archivo_sql'];

    // Validar que sea .sql
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if ($extension !== 'sql') {
        $respuesta['mensaje'] = 'Solo se permiten archivos .sql';
        echo json_encode($respuesta);
        exit;
    }

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        $respuesta['mensaje'] = 'Error al subir el archivo.';
        echo json_encode($respuesta);
        exit;
    }

    $sql = file_get_contents($archivo['tmp_name']);

    if (empty(trim($sql))) {
        $respuesta['mensaje'] = 'El archivo SQL está vacío.';
        echo json_encode($respuesta);
        exit;
    }

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$db;charset=$charset",
            $user, $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            ]
        );

        // Limpiar el SQL: quitar líneas que contengan HTML o warnings de PHP
        $lineas = explode("\n", $sql);
        $lineasLimpias = array_filter($lineas, function($linea) {
            $l = trim($linea);
            // Descartar líneas vacías o con HTML/PHP warnings
            if (empty($l)) return false;
            if (strpos($l, '<') !== false) return false;   // HTML
            if (strpos($l, 'Notice:') !== false) return false;
            if (strpos($l, 'Warning:') !== false) return false;
            if (strpos($l, 'Deprecated:') !== false) return false;
            return true;
        });
        $sql = implode("\n", $lineasLimpias);

        // Ejecutar el SQL completo
        $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");

        // Separar sentencias por ";\n"
        $sentencias = array_filter(
            array_map('trim', explode(";\n", $sql)),
            fn($s) => !empty($s)
        );

        foreach ($sentencias as $sentencia) {
            if (!empty(trim($sentencia))) {
                $pdo->exec($sentencia);
            }
        }

        $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");

        // Guardar en historial
        $historial = [];
        if (file_exists($historialFile)) {
            $historial = json_decode(file_get_contents($historialFile), true) ?? [];
        }

        array_unshift($historial, [
            'archivo'  => $archivo['name'],
            'usuario'  => $_SESSION['usuario'] ?? 'admin',
            'fecha'    => date('d/m/Y'),
            'hora'     => date('H:i:s'),
            'dia'      => date('d'),
            'mes'      => date('m'),
            'anio'     => date('Y'),
            'timestamp'=> time(),
        ]);

        // Guardar solo últimas 50
        $historial = array_slice($historial, 0, 50);
        file_put_contents($historialFile, json_encode($historial, JSON_PRETTY_PRINT));

        $respuesta['success'] = true;
        $respuesta['mensaje'] = 'Base de datos restaurada correctamente.';

    } catch (PDOException $e) {
        $respuesta['mensaje'] = 'Error al ejecutar SQL: ' . $e->getMessage();
    }

    echo json_encode($respuesta);
    exit;
}

// GET — devolver historial
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['historial'])) {
    header('Content-Type: application/json');
    $historial = [];
    if (file_exists($historialFile)) {
        $historial = json_decode(file_get_contents($historialFile), true) ?? [];
    }
    echo json_encode($historial);
    exit;
}