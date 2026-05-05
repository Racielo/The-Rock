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

            $ingrediente = $_POST['ingrediente'];
            $actual = $_POST['cantidad'];
            $maximo = $_POST['maximo'];
            $unidad = $_POST['unidad'];
            $fecha = $_POST['fecha'];

            $this->modelo->guardar($ingrediente, $actual, $maximo, $unidad, $fecha);

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

            $ingrediente = $_POST['ingrediente'];
            $actual = $_POST['cantidad'];
            $maximo = $_POST['maximo'];
            $unidad = $_POST['unidad'];
            $fecha = $_POST['fecha'];

            $this->modelo->actualizar($id, $ingrediente, $actual, $maximo, $unidad, $fecha);

            header("Location: ?menu=productos");
            exit;
        }

        // 🔥 ESTA PARTE SOLUCIONA TU ERROR
        $producto = $this->modelo->obtenerPorId($id);

        if (!$producto) {
            echo "Producto no encontrado";
            exit;
        }

        include 'views/editProducto.php';
    }
}
?>