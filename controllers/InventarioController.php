<?php

require_once 'models/InventarioModel.php';

class InventarioController {

    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new InventarioModel($conexion);
    }

    public function index() {

        $inventario = $this->modelo->listar();

        include 'views/inventario.php';
    }

    public function crear() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->modelo->guardar(

                $_POST['nombre'],
                $_POST['cantidad_actual'],
                $_POST['unidad_medida'],
                $_POST['stock_minimo'],
                $_POST['fecha_ingreso'],
                $_POST['fecha_caducidad'],
                $_POST['estado']
            );
        }

        header("Location: ?menu=inventario");
        exit;
    }

    public function borrar($id) {

        $this->modelo->eliminar($id);

        header("Location: ?menu=inventario");
        exit;
    }

    public function editar($id) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->modelo->actualizar(

                $id,

                $_POST['nombre'],
                $_POST['cantidad_actual'],
                $_POST['unidad_medida'],
                $_POST['stock_minimo'],
                $_POST['fecha_ingreso'],
                $_POST['fecha_caducidad'],
                $_POST['estado']
            );
        }

        header("Location: ?menu=inventario");
        exit;
    }
}

?>