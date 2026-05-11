<?php

class UsuarioModel {

    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function listar() {

        $sql = "SELECT * FROM usuarios ORDER BY id DESC";

        return $this->db
                    ->query($sql)
                    ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar($nombre, $correo, $pass, $estado) {

        $sql = "INSERT INTO usuarios
                (nombre, correo, pass, estado)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            trim($nombre),
            trim($correo),
            trim($pass),
            trim($estado)
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

        $sql = "SELECT * FROM usuarios
                WHERE correo = ? AND pass = ?";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$correo, $pass]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $correo, $estado) {

        $sql = "UPDATE usuarios
                SET nombre = ?, correo = ?, estado = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            trim($nombre),
            trim($correo),
            trim($estado),
            $id
        ]);
    }

}

?>