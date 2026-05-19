<?php
require_once 'models/ProductoModel.php';

class ProductoController {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new ProductoModel($conexion);
    }

    public function index() {
        $productos = $this->modelo->listar();
        include 'views/productos.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->guardar(
                $_POST['nombre_producto'],
                $_POST['descripcion'],
                $_POST['precio_venta'],
                $_POST['categoria'],
                $_POST['dias_vida_util'],
                $_POST['estado_producto']
            );
            header("Location: ?menu=productos");
            exit;
        }
    }

    public function borrar($id) {
        $this->modelo->eliminar($id);
        header("Location: ?menu=productos");
        exit;
    }

    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->actualizar(
                $id,
                $_POST['nombre_producto'],
                $_POST['descripcion'],
                $_POST['precio_venta'],
                $_POST['categoria'],
                $_POST['dias_vida_util'],
                $_POST['estado_producto']
            );
            header("Location: ?menu=productos");
            exit;
        }
        $producto = $this->modelo->obtenerPorId($id);
        if (!$producto) { echo "Producto no encontrado"; exit; }
        include 'views/editProducto.php';
    }
}
?>