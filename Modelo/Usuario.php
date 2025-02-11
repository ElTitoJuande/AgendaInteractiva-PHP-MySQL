<?php
require_once('../Modelo/class.db.php');

class Usuario {
    private $conn;
    public $id;
    public $nombre;
    public $contrasena;
    public $tipo;

    public function __construct() {
        $this->conn = new db();
        $this->id;
        $this->nombre;
        $this->contrasena;
        $this->tipo;
    }

    public function listarUsuarios() {
        $sentencia="SELECT id, nombre, contrasena, tipo FROM usuarios";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_result($id, $nombre, $contrasena, $tipo);
        $usuarios=array();
        $stmt->execute();
        while ($stmt->fetch()) {
            $usuarios[] = array("id" => $id,"nombre" => $nombre, "contrasena" => $contrasena, "tipo" => $tipo);
        }

        $stmt -> close();
        
        return $usuarios;
    }

    public function buscarUsuarioPorIdAdmin($id) {
        $stmt = $this->conn->getConn()->prepare("SELECT id, nombre, contrasena, tipo FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);  
        $stmt->bind_result($id, $nombre, $contrasena, $tipo);
        $stmt->execute();
        $stmt->fetch();
        $usuarios = array("id" => $id,"nombre" => $nombre, "contrasena" => $contrasena, "tipo" => $tipo);
        
        $stmt->close();
        return $usuarios;
    }
    public function buscarUsuarioNombre($busqueda, $id) {
        $stmt = $this->conn->getConn()->prepare("SELECT id, nombre, contrasena, tipo FROM usuarios WHERE nombre LIKE ?");
        $busqueda = "%$busqueda%";
        $stmt->bind_param("s", $busqueda);  
        $stmt->bind_result($id, $nombre, $contrasena, $tipo);
        $stmt->execute();
        $usuarios = array();
        while ($stmt->fetch()) {
            $usuarios[] = array("id" => $id,"nombre" => $nombre, "contrasena" => $contrasena, "tipo" => $tipo);
        }
        
        $stmt->close();
        return $usuarios;
    }

    public function editarUsuario($id, $nombre, $contrasena, $tipo) {

        $stmt = $this->conn->getConn()->prepare("UPDATE usuarios SET nombre = ?, contrasena = ?, tipo = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nombre, $contrasena, $tipo, $id);
        $stmt->execute();

        if($stmt->affected_rows > 0) return true;
        else return false;
    }
    public function agregarUsuario($nombre, $contrasena) {
        $stmt = $this->conn->getConn()->prepare("INSERT INTO usuarios (nombre, contrasena, tipo) VALUES (?, ?, 'usuario')");
        $stmt->bind_param("ss", $nombre, $contrasena);        
        $stmt->execute();

        if($stmt->affected_rows > 0) return true;
        else return false;
    }

    public function autenticarUsuario($nombre, $contrasena) {
               
        $stmt = $this->conn->getConn()->prepare("SELECT id FROM usuarios WHERE nombre = ? AND contrasena = ?");
        $stmt->bind_param("ss", $nombre, $contrasena);  
        $stmt->bind_result($usuario_id);
        $stmt->execute();
        
        $usuario = null;
        
        if($stmt->fetch()) $usuario = $usuario_id;
        
        $stmt->close();
        
        return $usuario;
    }
    
    public function identificarTipo($usuario_id){

        $stmt = $this->conn->getConn()->prepare("SELECT tipo FROM usuarios WHERE id = ?;");
        $stmt->bind_param("s", $usuario_id);  
        $stmt->bind_result($tipo);
        $stmt->execute();

        $stmt->fetch();
        return $tipo;
    }   

}
?>