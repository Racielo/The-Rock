<?php

require_once 'models/ProductoModel.php';

class ProductoController {

    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new ProductoModel($conexion);
    }

    /* =========================
       MOSTRAR
    ========================= */

    public function index() {

        $productos = $this->modelo->listar();

        include 'views/productos.php';
    }

    /* =========================
       CREAR
    ========================= */

    public function crear() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->modelo->guardar(

                $_POST['nombre_producto'],
                $_POST['descripcion'],
                $_POST['precio_venta'],
                $_POST['categoria'],
                $_POST['fecha_elaboracion'],
                $_POST['dias_vida_util'],
                $_POST['imagen_url'],
                $_POST['estado_producto']
            );
        }

        header("Location: ?menu=productos");
        exit;
    }

    /* =========================
       ELIMINAR
    ========================= */

    public function borrar($id) {

        $this->modelo->eliminar($id);

        header("Location: ?menu=productos");
        exit;
    }

    /* =========================
       ACTUALIZAR
    ========================= */

    public function editar($id) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->modelo->actualizar(

                $id,

                $_POST['nombre_producto'],
                $_POST['descripcion'],
                $_POST['precio_venta'],
                $_POST['categoria'],
                $_POST['fecha_elaboracion'],
                $_POST['dias_vida_util'],
                $_POST['imagen_url'],
                $_POST['estado_producto']
            );
        }

        header("Location: ?menu=productos");
        exit;
    }
}

?>