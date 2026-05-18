<?php

class InventarioModel {

    private $db;

    public function __construct($conexion) {

        $this->db = $conexion;
    }

    /* =========================
       LISTAR INVENTARIO
    ========================= */

    public function listar() {

        $sql = "SELECT * FROM inventario
                ORDER BY id_inventario DESC";

        return $this->db
                    ->query($sql)
                    ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       GUARDAR
    ========================= */

    public function guardar(
        $nombre,
        $categoria,
        $unidad,
        $stockActual,
        $stockMinimo,
        $costo,
        $fechaCaducidad
    ) {

        $sql = "INSERT INTO inventario (

                    nombre,
                    categoria,
                    unidad_medida,
                    stock_actual,
                    stock_minimo,
                    costo_unitario,
                    fecha_caducidad

                )

                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([

            $nombre,
            $categoria,
            $unidad,
            $stockActual,
            $stockMinimo,
            $costo,
            $fechaCaducidad

        ]);
    }

    /* =========================
       ELIMINAR
    ========================= */

    public function eliminar($id) {

        $sql = "DELETE FROM inventario
                WHERE id_inventario = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }

    /* =========================
       OBTENER POR ID
    ========================= */

    public function obtenerPorId($id) {

        $sql = "SELECT * FROM inventario
                WHERE id_inventario = ?";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       ACTUALIZAR
    ========================= */

    public function actualizar(

        $id,
        $nombre,
        $categoria,
        $unidad,
        $stockActual,
        $stockMinimo,
        $costo,
        $fechaCaducidad,
        $estado

    ) {

        $sql = "UPDATE inventario SET

                    nombre = ?,
                    categoria = ?,
                    unidad_medida = ?,
                    stock_actual = ?,
                    stock_minimo = ?,
                    costo_unitario = ?,
                    fecha_caducidad = ?,
                    estado = ?

                WHERE id_inventario = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([

            $nombre,
            $categoria,
            $unidad,
            $stockActual,
            $stockMinimo,
            $costo,
            $fechaCaducidad,
            $estado,
            $id

        ]);
    }
}

?>