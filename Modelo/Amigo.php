<?php
require_once('../Modelo/class.db.php');

class Amigo {
    private $conn;
    private $id;
    private $nombre;
    private $apellidos;
    private $fecha_nac;
    private $usuario;

    public function __construct() {
        $this->conn = new db();
        $this->id;
        $this->nombre;
        $this->apellidos;
        $this->fecha_nac;
        $this->usuario;
    }

    public function obtenerAmigosPorUsuario($usuarioId) {
        $sentencia = "SELECT nombre, apellidos, fecha_nac FROM amigos WHERE usuario = ?";
        $stmt = $this->conn->prepare($sentencia);
        $stmt->bind_param("i", $usuarioId);
        $stmt->bind_result($nombre, $apellidos, $fecha_nac);
        $amigos=array();
        while ($stmt->fetch()) {
            $amigos[] = array("nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac);
        }

        $stmt->execute();
        return $amigos;

    }

    public function agregarAmigo($nombre, $apellidos, $fecha_nac, $usuario) {
        $sentencia = "INSERT INTO amigos (nombre, apellidos, fecha_nac, usuario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sentencia);
        $stmt->bind_param("sssi", $nombre, $apellidos, $fecha_nac, $usuario);
        return $stmt->execute();
    }

    public function eliminarAmigo($id) {
        $sentencia = "DELETE FROM amigos WHERE id = ?";
        $stmt = $this->conn->prepare($sentencia);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
