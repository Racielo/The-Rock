<?php

class ProductoModel {

    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /* =========================
       LISTAR
    ========================= */

    public function listar() {

        $sql = "SELECT * FROM productos
                ORDER BY id_producto DESC";

        return $this->db
                    ->query($sql)
                    ->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       GUARDAR
    ========================= */

    public function guardar(
        $nombre,
        $descripcion,
        $precio,
        $categoria,
        $fecha,
        $vida,
        $imagen,
        $estado
    ) {

        $sql = "INSERT INTO productos
        (
            nombre_producto,
            descripcion,
            precio_venta,
            categoria,
            fecha_elaboracion,
            dias_vida_util,
            imagen_url,
            estado_producto
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            trim($nombre),
            trim($descripcion),
            $precio,
            trim($categoria),
            $fecha,
            $vida,
            trim($imagen),
            trim($estado)
        ]);
    }

    /* =========================
       ELIMINAR
    ========================= */

    public function eliminar($id) {

        $sql = "DELETE FROM productos
                WHERE id_producto = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }

    /* =========================
       OBTENER POR ID
    ========================= */

    public function obtenerPorId($id) {

        $sql = "SELECT * FROM productos
                WHERE id_producto = ?";

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
        $descripcion,
        $precio,
        $categoria,
        $fecha,
        $vida,
        $imagen,
        $estado
    ) {

        $sql = "UPDATE productos SET
                nombre_producto = ?,
                descripcion = ?,
                precio_venta = ?,
                categoria = ?,
                fecha_elaboracion = ?,
                dias_vida_util = ?,
                imagen_url = ?,
                estado_producto = ?
                WHERE id_producto = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            trim($nombre),
            trim($descripcion),
            $precio,
            trim($categoria),
            $fecha,
            $vida,
            trim($imagen),
            trim($estado),
            $id
        ]);
    }
}

?>