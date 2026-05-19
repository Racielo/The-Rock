<?php
class ProductoModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {
        $sql = "SELECT id_producto, nombre_producto, descripcion, precio_venta, 
                       categoria, dias_vida_util, estado_producto
                FROM productos ORDER BY id_producto DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar($nombre, $descripcion, $precio, $categoria, $dias_vida_util, $estado) {
        $sql = "INSERT INTO productos (nombre_producto, descripcion, precio_venta, categoria, dias_vida_util, estado_producto)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $precio, $categoria, $dias_vida_util, $estado]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $categoria, $dias_vida_util, $estado) {
        $sql = "UPDATE productos SET
                    nombre_producto  = ?,
                    descripcion      = ?,
                    precio_venta     = ?,
                    categoria        = ?,
                    dias_vida_util   = ?,
                    estado_producto  = ?
                WHERE id_producto = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $precio, $categoria, $dias_vida_util, $estado, $id]);
    }
}
?>