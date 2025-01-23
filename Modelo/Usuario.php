<?php
require_once('../Modelo/Usuario.php');

class Usuario {
    public $id;
    public $nombre;
    public $contrasena;
    public $tipo;

    public static function autenticar($nombre, $contrasena) {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = ? AND contrasena = ?");
        $stmt->bind_param("ss", $nombre, $contrasena);
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

    public function registrar() {
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

    public function actualizar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, contrasena = ?, tipo = ? WHERE id = ?");
        $stmt->bind_param("sssi", $this->nombre, $this->contrasena, $this->tipo, $this->id);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public function eliminar() {
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