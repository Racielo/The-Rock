<?php
class InventarioModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {
        $sql = "SELECT id_insumo, nombre, cantidad_actual, unidad_medida,
                       stock_minimo, fecha_ingreso, fecha_caducidad, estado
                FROM inventario ORDER BY id_insumo DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar($nombre, $cantidad, $unidad, $stockMinimo, $fechaIngreso, $fechaCaducidad) {
        $sql = "INSERT INTO inventario (nombre, cantidad_actual, unidad_medida, stock_minimo, fecha_ingreso, fecha_caducidad, estado)
                VALUES (?, ?, ?, ?, ?, ?, 'Disponible')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $cantidad, $unidad, $stockMinimo, $fechaIngreso, $fechaCaducidad ?: null]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM inventario WHERE id_insumo = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM inventario WHERE id_insumo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $cantidad, $unidad, $stockMinimo, $fechaIngreso, $fechaCaducidad, $estado) {
        $sql = "UPDATE inventario SET
                    nombre          = ?,
                    cantidad_actual = ?,
                    unidad_medida   = ?,
                    stock_minimo    = ?,
                    fecha_ingreso   = ?,
                    fecha_caducidad = ?,
                    estado          = ?
                WHERE id_insumo = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $cantidad, $unidad, $stockMinimo, $fechaIngreso, $fechaCaducidad ?: null, $estado, $id]);
    }
}
?>