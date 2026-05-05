<?php
class ProductoModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar($ingrediente, $actual, $maximo, $unidad, $fecha) {
        $sql = "INSERT INTO productos 
        (ingrediente, cantidad_actual, cantidad_maxima, unidad_medida, fecha)
        VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $ingrediente,
            $actual,
            $maximo,
            $unidad,
            $fecha
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

public function obtenerPorId($id) {
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function actualizar($id, $ingrediente, $actual, $maximo, $unidad, $fecha) {
        $sql = "UPDATE productos SET 
            ingrediente = ?, 
            cantidad_actual = ?, 
            cantidad_maxima = ?, 
            unidad_medida = ?, 
            fecha = ?
            WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $ingrediente,
            $actual,
            $maximo,
            $unidad,
            $fecha,
            $id
        ]);
    }
}
?>