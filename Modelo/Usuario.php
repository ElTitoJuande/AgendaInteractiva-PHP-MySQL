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
    public function registrarUsuario() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, contrasena, tipo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->nombre, $this->contrasena, $this->tipo);
        
        $resultado = $stmt->execute();
        $this->id = $conn->insert_id;
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public static function existeNombre($nombre) {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        
        $stmt->close();
        $conn->close();
        
        return $fila['count'] > 0;
    }

    

    public function actualizarUsuario() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, contrasena = ?, tipo = ? WHERE id = ?");
        $stmt->bind_param("sssi", $this->nombre, $this->contrasena, $this->tipo, $this->id);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public function eliminarUsuario() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public static function buscarPorId($id) {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $usuario = null;
        
        if ($fila = $resultado->fetch_object()) {
            $usuario = new Usuario();
            $usuario->id = $fila->id;
            $usuario->nombre = $fila->nombre;
            $usuario->contrasena = $fila->contrasena;
            $usuario->tipo = $fila->tipo;
        }
        
        $stmt->close();
        $conn->close();
        
        return $usuario;
    }
}
?>