<?php
require_once 'models/UsuarioModel.php';

class UsuarioController {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new UsuarioModel($conexion);
    }

    public function index(): void {
        $usuarios = $this->modelo->listar();
        include 'views/usuarios.php';
    }

    public function verificar() {
        $correo = $_POST['correo'] ?? '';
        $pass = $_POST['password'] ?? '';

        $usuario = $this->modelo->verificar($correo, $pass);

        if ($usuario) {
            header("Location: ?menu=usuarios");
        } else {
            header("Location: ?menu=login");
        }
        exit;
    }

public function crear(): void {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $pass = $_POST['pass'] ?? '';

        $estado = "Activo";

        if (!empty($nombre) &&
            filter_var($correo, FILTER_VALIDATE_EMAIL)) {

            $this->modelo->guardar(
                $nombre,
                $correo,
                $pass,
                $estado
            );
        }

        header("Location: ?menu=usuarios");
        exit;
    }
}

    public function borrar($id): void {
        if ($id) {
            $this->modelo->eliminar($id);
        }

        header("Location: ?menu=usuarios");
        exit;
    }

public function editar(int $id): void {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['email'] ?? '';
        $estado = $_POST['estado'] ?? '';

        if (!empty($nombre) && filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->modelo->actualizar($id, $nombre, $correo, $estado);
        }

        header("Location: ?menu=usuarios");
        exit;
    }

    // 🔥 ESTA PARTE ES LA QUE TE FALTA
    $usuario = $this->modelo->obtenerPorId($id);

    if (!$usuario) {
        echo "Usuario no encontrado";
        exit;
    }   

    include 'views/editUsuario.php';
}
}
?>