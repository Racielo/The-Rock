<?php
class UsuarioModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {
        $sql = "SELECT * FROM usuarios ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function guardar($nombre, $email) {
        $sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([trim($nombre), trim($email)]);
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
        return $stmt->fetch();
    }

    public function actualizar($id, $nombre, $email) {
        $sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([trim($nombre), trim($email), $id]);
    }
}