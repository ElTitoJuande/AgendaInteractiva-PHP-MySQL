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

    public static function listarUsuarios() {
        $db = new db();
        $conn = $db->getConn();
        
        $query = "SELECT id, nombre, tipo FROM usuarios";
        $resultado = $conn->query($query);
        
        $usuarios = [];
        while ($fila = $resultado->fetch_object()) {
            $usuario = new Usuario();
            $usuario->id = $fila->id;
            $usuario->nombre = $fila->nombre;
            $usuario->tipo = $fila->tipo;
            $usuarios[] = $usuario;
        }
        
        $conn->close();
        
        return $usuarios;
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