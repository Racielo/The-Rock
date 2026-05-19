<?php
// Suprimir warnings que contaminan el SQL
error_reporting(0);
ini_set('display_errors', 0);

// Solo iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Solo admin puede descargar
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ?menu=home");
    exit;
}

// Limpiar cualquier salida previa
while (ob_get_level()) ob_end_clean();

$env = require 'env.php';

$host    = $env['DB_HOST'];
$db      = $env['DB_NAME'];
$user    = $env['DB_USER'];
$pass    = $env['DB_PASS'];
$charset = $env['DB_CHARSET'];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset",
        $user, $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$fecha  = date('Y-m-d_H-i-s');
$nombre = "backup_{$db}_{$fecha}.sql";

// Headers para forzar descarga
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$nombre\"");
header('Pragma: no-cache');

// ── Encabezado del archivo SQL ──
echo "-- Backup de base de datos: $db\n";
echo "-- Generado: " . date('Y-m-d H:i:s') . "\n";
echo "-- Servidor: $host\n\n";
echo "SET FOREIGN_KEY_CHECKS=0;\n\n";

// ── Obtener todas las tablas ──
$tablas = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

foreach ($tablas as $tabla) {

    // Estructura de la tabla
    echo "-- -----------------------------------------------\n";
    echo "-- Tabla: `$tabla`\n";
    echo "-- -----------------------------------------------\n\n";

    echo "DROP TABLE IF EXISTS `$tabla`;\n";

    $create = $pdo->query("SHOW CREATE TABLE `$tabla`")->fetch(PDO::FETCH_ASSOC);
    echo $create['Create Table'] . ";\n\n";

    // Datos de la tabla
    $filas = $pdo->query("SELECT * FROM `$tabla`")->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($filas)) {
        $columnas = '`' . implode('`, `', array_keys($filas[0])) . '`';
        echo "INSERT INTO `$tabla` ($columnas) VALUES\n";

        $totalFilas = count($filas);
        foreach ($filas as $i => $fila) {
            $valores = array_map(function($v) use ($pdo) {
                if ($v === null) return 'NULL';
                return "'" . addslashes($v) . "'";
            }, array_values($fila));

            $sep = ($i < $totalFilas - 1) ? ',' : ';';
            echo "(" . implode(', ', $valores) . ")" . $sep . "\n";
        }
        echo "\n";
    }
}

echo "SET FOREIGN_KEY_CHECKS=1;\n";
exit;
?>