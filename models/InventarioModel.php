<?php

class InventarioModel {

    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {

        $sql = "SELECT * FROM inventario
                ORDER BY id_insumo DESC";

        return $this->db
                    ->query($sql)
                    ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar(
        $nombre,
        $cantidad,
        $unidad,
        $stock,
        $ingreso,
        $caducidad,
        $estado
    ) {

        $sql = "INSERT INTO inventario
        (
            nombre,
            cantidad_actual,
            unidad_medida,
            stock_minimo,
            fecha_ingreso,
            fecha_caducidad,
            estado
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            trim($nombre),
            $cantidad,
            trim($unidad),
            $stock,
            $ingreso,
            $caducidad,
            trim($estado)
        ]);
    }

    public function eliminar($id) {

        $sql = "DELETE FROM inventario
                WHERE id_insumo = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {

        $sql = "SELECT * FROM inventario
                WHERE id_insumo = ?";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar(
        $id,
        $nombre,
        $cantidad,
        $unidad,
        $stock,
        $ingreso,
        $caducidad,
        $estado
    ) {

        $sql = "UPDATE inventario SET

                nombre = ?,
                cantidad_actual = ?,
                unidad_medida = ?,
                stock_minimo = ?,
                fecha_ingreso = ?,
                fecha_caducidad = ?,
                estado = ?

                WHERE id_insumo = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            trim($nombre),
            $cantidad,
            trim($unidad),
            $stock,
            $ingreso,
            $caducidad,
            trim($estado),
            $id
        ]);
    }
}

?>