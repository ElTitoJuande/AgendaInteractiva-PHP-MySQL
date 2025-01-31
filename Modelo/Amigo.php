<?php
require_once('../Modelo/class.db.php');

class Amigo {
    private $conn;
    public $id;
    public $nombre;
    public $apellidos;
    public $fecha_nac;
    public $usuario;

    public function __construct() {
        $this->conn = new db();
        $this->id;
        $this->nombre;
        $this->apellidos;
        $this->fecha_nac;
        $this->usuario;
    }

    public function listarAmigosPorUsuario($usuarioId) {
        $sentencia = "SELECT id, nombre, apellidos, fecha_nac FROM amigos WHERE usuario = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $usuarioId);
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac);
        $amigos=array();
        $stmt->execute();
        while ($stmt->fetch()) {
            $amigos[] = array("id" => $id,"nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac);
        }

        $stmt -> close();
        
        return $amigos;
    }
    public function listarAmigos() {
        $sentencia = "SELECT amigos.id, amigos.nombre, apellidos, fecha_nac, usuarios.nombre FROM amigos, usuarios WHERE amigos.usuario = usuarios.id";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac, $usuario);
        $amigos=array();
        $stmt->execute();
        while ($stmt->fetch()) {
            $amigos[] = array("id" => $id,"nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac, "usuario" => $usuario);
        }

        $stmt -> close();
        
        return $amigos;
    }

    public function editarAmigoAdmin($id, $nombre, $apellidos, $fecha_nac, $usuario) {
        $sentencia = "UPDATE amigos SET nombre = ?, apellidos = ?, fecha_nac = ?, usuario = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("ssssi", $nombre, $apellidos, $fecha_nac, $usuario, $id);
        return $stmt->execute();
    }

    public function agregarAmigo($nombre, $apellidos, $fecha_nac, $usuario) {
        $sentencia = "INSERT INTO amigos (nombre, apellidos, fecha_nac, usuario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->getConn()->prepare($sentencia);
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
