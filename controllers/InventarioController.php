<?php

require_once 'models/InventarioModel.php';

class InventarioController {

    private $modelo;

    public function __construct($conexion) {

        $this->modelo = new InventarioModel($conexion);
    }

    /* =========================
       INDEX
    ========================= */

    public function index() {

        $inventario = $this->modelo->listar();

        include 'views/inventario.php';
    }

    /* =========================
       CREAR
    ========================= */

    public function crear() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = $_POST['nombre'];
            $categoria = $_POST['categoria'];
            $unidad = $_POST['unidad'];
            $stockActual = $_POST['stock_actual'];
            $stockMinimo = $_POST['stock_minimo'];
            $costo = $_POST['costo'];
            $fechaCaducidad = $_POST['fecha'];

            $this->modelo->guardar(

                $nombre,
                $categoria,
                $unidad,
                $stockActual,
                $stockMinimo,
                $costo,
                $fechaCaducidad

            );

            header("Location: ?menu=inventario");
            exit;
        }
    }

    /* =========================
       BORRAR
    ========================= */

    public function borrar($id) {

        $this->modelo->eliminar($id);

        header("Location: ?menu=inventario");

        exit;
    }

    /* =========================
       EDITAR
    ========================= */

    public function editar($id) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = $_POST['nombre'];
            $categoria = $_POST['categoria'];
            $unidad = $_POST['unidad'];
            $stockActual = $_POST['stock_actual'];
            $stockMinimo = $_POST['stock_minimo'];
            $costo = $_POST['costo'];
            $fechaCaducidad = $_POST['fecha'];
            $estado = $_POST['estado'];

            $this->modelo->actualizar(

                $id,
                $nombre,
                $categoria,
                $unidad,
                $stockActual,
                $stockMinimo,
                $costo,
                $fechaCaducidad,
                $estado

            );

            header("Location: ?menu=inventario");
            exit;
        }

        $producto = $this->modelo->obtenerPorId($id);

        if (!$producto) {

            echo "Registro no encontrado";
            exit;
        }

        include 'views/editInventario.php';
    }
}

?>