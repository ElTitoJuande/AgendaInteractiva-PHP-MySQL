<?php
require_once('../Modelo/class.db.php');

//Clase para gestionar los usuarios
class Usuario {
    private $conn;
    public $id;
    public $nombre;
    public $contrasena;
    public $tipo;

    //Inicializa la conexion a la base de datos y los atributos
    public function __construct() {
        $this->conn = new db();
        $this->id;
        $this->nombre;
        $this->contrasena;
        $this->tipo;
    }

    //Obtiene la lista completa de usuarios del sistema
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

    //Busca un usuario por ID incluyendo todos sus datos
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

    //Busca usuarios por nombre
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

    //Actualiza la información completa de un usuario
    public function editarUsuario($id, $nombre, $contrasena, $tipo) {

        $stmt = $this->conn->getConn()->prepare("UPDATE usuarios SET nombre = ?, contrasena = ?, tipo = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nombre, $contrasena, $tipo, $id);
        $stmt->execute();

        return true;
    }

    //Agrega un nuevo usuario al sistema con rol 'usuario'
    public function agregarUsuario($nombre, $contrasena) {
        $stmt = $this->conn->getConn()->prepare("INSERT INTO usuarios (nombre, contrasena, tipo) VALUES (?, ?, 'usuario')");
        $stmt->bind_param("ss", $nombre, $contrasena);        
        $stmt->execute();

        if($stmt->affected_rows > 0) return true;
        else return false;
    }

    //Verifica las credenciales del usuario durante el login
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
    
    //Obtiene el tipo de usuario (admin/usuario) según su ID
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