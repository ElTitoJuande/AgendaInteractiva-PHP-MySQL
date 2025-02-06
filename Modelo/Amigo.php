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

    public function buscarAmigoPorIdAdmin($id) {
        $sentencia = "SELECT id, nombre, apellidos, fecha_nac, usuario FROM amigos WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $id);        
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac, $usuario);
        $stmt->execute();
        $stmt->fetch();
        $amigo = array("id" => $id,"nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac, "usuario" => $usuario);
        $stmt -> close();
        return $amigo;
    }

    public function buscarAmigoPorId($id) {
        $sentencia = "SELECT id, nombre, apellidos, fecha_nac FROM amigos WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $id);        
        $stmt->bind_result($id,$nombre, $apellidos, $fecha_nac);
        $stmt->execute();
        $stmt->fetch();
        $amigo = array("id" => $id,"nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac);
        $stmt -> close();
        return $amigo;
    }

    public function buscarAmigoPorNombre($busqueda,$id) {
        $sentencia = "SELECT DISTINCT amigos.id, amigos.nombre, amigos.apellidos, amigos.fecha_nac FROM amigos LEFT JOIN usuarios ON amigos.usuario = usuarios.id WHERE usuarios.id = amigos.usuario AND (amigos.nombre LIKE ? OR amigos.apellidos LIKE ?) AND usuarios.id = ?";
        $amigos = array();
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $busqueda = "%$busqueda%";
        $stmt->bind_param("ssi", $busqueda, $busqueda, $id);
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac);
        $stmt->execute();
        // var_dump($sentencia);
        while ($stmt->fetch()) {
            $amigos[] = array("id" => $id, "nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac);
        }
        // var_dump($amigos);
        $stmt -> close();
        return $amigos;        
    }
    
    public function buscarAmigoPorNombreAdmin($busqueda) {
        $sentencia = "SELECT DISTINCT amigos.id, amigos.nombre, amigos.apellidos, amigos.fecha_nac, usuarios.nombre FROM amigos LEFT JOIN usuarios ON amigos.usuario = usuarios.id WHERE usuarios.id = amigos.usuario AND (amigos.nombre LIKE ? OR amigos.apellidos LIKE ?)";    
        $amigos = array();
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $busqueda = "%$busqueda%";
        $stmt->bind_param("ss", $busqueda, $busqueda);
        $stmt->execute();
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac, $usuario);
        
        while ($stmt->fetch()) {
            $amigos[] = array("id" => $id, "nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac, "usuario" => $usuario);
        }
        
        $stmt->close();
        return $amigos;        
    }
    

    public function editarAmigoAdmin($id, $nombre, $apellidos, $fecha_nac, $usuario) {
        $sentencia = "UPDATE amigos SET nombre = ?, apellidos = ?, fecha_nac = ?, usuario = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("sssii", $nombre, $apellidos, $fecha_nac, $usuario, $id);
        return $stmt->execute();
    } 
    public function editarAmigo($id, $nombre, $apellidos, $fecha_nac) {
        $sentencia = "UPDATE amigos SET nombre = ?, apellidos = ?, fecha_nac = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("sssi", $nombre, $apellidos, $fecha_nac, $id);
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
