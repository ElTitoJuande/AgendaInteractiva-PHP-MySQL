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

    public function obtenerAmigosPorUsuario($usuarioId) {
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

    public function agregarAmigo($nombre, $apellidos, $fecha_nac, $usuario) {
        $sentencia = "INSERT INTO amigos (nombre, apellidos, fecha_nac, usuario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sentencia);
        $stmt->bind_param("sssi", $nombre, $apellidos, $fecha_nac, $usuario);
        return $stmt->execute();
    }

    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     $nombre = $_POST['nombre'];
    //     $apellidos = $_POST['apellidos'];
    //     $fecha_nac = $_POST['fecha_nac'];
    
    //     $amigo = new Amigo();
    //     $amigo->nombre = $nombre;
    //     $amigo->apellidos = $apellidos;
    //     $amigo->fecha_nac = $fecha_nac;
    //     $amigo->usuario = $_SESSION['usuario_id'];
    // }
    
    //     if ($amigo->agregarAmigo()) {
    //         header('Location: lista_amigos.php');
    //         exit();
    //     } else {
    //         $error = 'Error al guardar el amigo';
    //     }


    public function eliminarAmigo($id) {
        $sentencia = "DELETE FROM amigos WHERE id = ?";
        $stmt = $this->conn->prepare($sentencia);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
