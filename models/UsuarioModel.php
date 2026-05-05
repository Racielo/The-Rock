<?php
class UsuarioModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {
        $sql = "SELECT * FROM usuarios ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar($nombre, $correo, $pass) {
        $sql = "INSERT INTO usuarios (nombre, correo, pass) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            trim($nombre),
            trim($correo),
            trim($pass)
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verificar($correo, $pass) {
        $sql = "SELECT * FROM usuarios WHERE correo = ? AND pass = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo, $pass]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function actualizar($id, $nombre, $correo) {
    $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        trim($nombre),
        trim($correo),
        $id
    ]);
}
}
?>