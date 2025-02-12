<?php
require_once('../Modelo/class.db.php');

//Clase para gestionar los amigos
class Amigo {
    private $conn;
    public $id;
    public $nombre;
    public $apellidos;
    public $fecha_nac;
    public $usuario;

    //Inicializa la conexion a la base de datos y los atributos
    public function __construct() {
        $this->conn = new db();
        $this->id;
        $this->nombre;
        $this->apellidos;
        $this->fecha_nac;
        $this->usuario;
    }

    //Obtiene la lista completa de amigos con información de sus usuarios
    public function listarAmigos() {
        $sentencia = "SELECT amigos.id, amigos.nombre, apellidos, fecha_nac, usuarios.nombre FROM amigos, usuarios WHERE amigos.usuario = usuarios.id";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac, $usuario);
        $amigos=array();
        $stmt->execute();
        while ($stmt->fetch()) {
            $fecha_nac = date("d-m-Y", strtotime($fecha_nac));
            $amigos[] = array("id" => $id,"nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac, "usuario" => $usuario);
        }
        $stmt -> close();
        
        return $amigos;
    }

    //Obtiene la lista de amigos asociados a un usuario específico
    public function listarAmigosPorUsuario($usuarioId) {
        $sentencia = "SELECT id, nombre, apellidos, fecha_nac FROM amigos WHERE usuario = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $usuarioId);
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac);
        $amigos=array();
        $stmt->execute();
        while ($stmt->fetch()) {
            $fecha_nac = date("d-m-Y", strtotime($fecha_nac));
            $amigos[] = array("id" => $id,"nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac);
        }

        $stmt -> close();
        
        return $amigos;
    }

    //Busca un amigo por ID incluyendo información del usuario (admin)
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

    //Busca un amigo por ID incluyendo información del usuario (admin)
    public function buscarAmigoPorId($id) {
        $sentencia = "SELECT id, nombre, apellidos, fecha_nac FROM amigos WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $id);        
        $stmt->bind_result($id,$nombre, $apellidos, $fecha_nac);
        $stmt->execute();
        $stmt->fetch();
        $fecha_nac = date("d-m-Y", strtotime($fecha_nac));
        $amigo = array("id" => $id,"nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac);
        $stmt -> close();
        return $amigo;
    }

    //Busca amigos por nombre o apellidos para un usuario específico
    public function buscarAmigoPorNombre($busqueda,$id) {
        $sentencia = "SELECT DISTINCT amigos.id, amigos.nombre, amigos.apellidos, amigos.fecha_nac FROM amigos LEFT JOIN usuarios ON amigos.usuario = usuarios.id WHERE usuarios.id = amigos.usuario AND (amigos.nombre LIKE ? OR amigos.apellidos LIKE ?) AND usuarios.id = ?";
        $amigos = array();
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $busqueda = "%$busqueda%";
        $stmt->bind_param("ssi", $busqueda, $busqueda, $id);
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac);
        $stmt->execute(); 
        while ($stmt->fetch()) {
            $fecha_nac = date("d-m-Y", strtotime($fecha_nac));
            $amigos[] = array("id" => $id, "nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac);
        } 
        $stmt -> close();
        return $amigos;        
    }
    
    //Busca amigos por nombre o apellidos para un usuario específico
    public function buscarAmigoPorNombreAdmin($busqueda) {
        $sentencia = "SELECT DISTINCT amigos.id, amigos.nombre, amigos.apellidos, amigos.fecha_nac, usuarios.nombre FROM amigos LEFT JOIN usuarios ON amigos.usuario = usuarios.id WHERE usuarios.id = amigos.usuario AND (amigos.nombre LIKE ? OR amigos.apellidos LIKE ?)";    
        $amigos = array();
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $busqueda = "%$busqueda%";
        $stmt->bind_param("ss", $busqueda, $busqueda);
        $stmt->execute();
        $stmt->bind_result($id, $nombre, $apellidos, $fecha_nac, $usuario);
        
        while ($stmt->fetch()) {
            $fecha_nac = date("d-m-Y", strtotime($fecha_nac));
            $amigos[] = array("id" => $id, "nombre" => $nombre, "apellidos" => $apellidos, "fecha_nac" => $fecha_nac, "usuario" => $usuario);
        }
        
        $stmt->close();
        return $amigos;        
    }
    
    //Actualiza la información completa de un amigo incluyendo su usuario asignado
    public function editarAmigoAdmin($id, $nombre, $apellidos, $fecha_nac, $usuario) {
        $sentencia = "UPDATE amigos SET nombre = ?, apellidos = ?, fecha_nac = ?, usuario = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("sssii", $nombre, $apellidos, $fecha_nac, $usuario, $id);
        return $stmt->execute();
    } 
    
    //Actualiza la información completa de un amigo incluyendo su usuario asignado
    public function editarAmigo($id, $nombre, $apellidos, $fecha_nac) {
        $sentencia = "UPDATE amigos SET nombre = ?, apellidos = ?, fecha_nac = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("sssi", $nombre, $apellidos, $fecha_nac, $id);
        return $stmt->execute();
    }

    //Agrega un nuevo amigo al sistema
    public function agregarAmigo($nombre, $apellidos, $fecha_nac, $usuario) {
        $sentencia = "INSERT INTO amigos (nombre, apellidos, fecha_nac, usuario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("sssi", $nombre, $apellidos, $fecha_nac, $usuario);
        return $stmt->execute();
    }

}
?>
