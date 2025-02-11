<?php
require_once('../Modelo/class.db.php');

class Prestamo {
    private $conn;
    public $id;
    public $usuario;
    public $amigo;
    public $juego;
    public $fecha_prestamo;
    public $devuelto;

    public function __construct() {
        $this->conn=new db();
        $this->id;
        $this->usuario;
        $this->amigo;
        $this->juego;
        $this->fecha_prestamo;
        $this->devuelto;
    }

    public function listaPrestamos($usuario_id) {
        $setencia = "SELECT * from prestamos WHERE usuario = ?";
        $stmt = $this->conn->getConn()->prepare($setencia);
        $stmt->bind_param("i", $usuario_id);
        $stmt->bind_result($id, $usuario, $amigo, $juego, $fecha_prestamo, $devuelto);
        $prestamos = array();
        $stmt->execute();
        while($stmt->fetch()){
            $prestamos[]=array("id" => $id, "usuario" => $usuario, "amigo" => $amigo, "juego" => $juego, "fecha_prestamo" => $fecha_prestamo, "devuelto" => $devuelto);
        }
        $stmt->close();
        return $prestamos;
    }

    public function buscarPrestamos($busqueda, $id) {
        $setencia = "SELECT * from prestamos WHERE amigo = ?";
        $stmt = $this->conn->getConn()->prepare($setencia);
        $stmt->bind_param("i", $busqueda);
        $stmt->bind_result($id, $usuario, $amigo, $juego, $fecha_prestamo, $devuelto);
        $prestamos = array();
        $stmt->execute();
        while($stmt->fetch()){
            $prestamos[]=array("id" => $id, "usuario" => $usuario, "amigo" => $amigo, "juego" => $juego, "fecha_prestamo" => $fecha_prestamo, "devuelto" => $devuelto);
        }
        $stmt->close();
        return $prestamos;
    }


    public function buscarPrestamoPorId($id) {
        $setencia = "SELECT amigos.nombre, usuarios.id, juegos.titulo, juegos.img, prestamos.fecha_prestamo, prestamos.devuelto from prestamos 
        INNER JOIN amigos ON prestamos.amigo = amigos.id 
        INNER JOIN juegos ON prestamos.juego = juegos.id
        INNER JOIN usuarios ON prestamos.usuario = usuarios.id
        WHERE usuarios.id = ? ";
        $stmt = $this->conn->getConn()->prepare($setencia);
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id, $usuario, $amigo, $juego, $fecha_prestamo, $devuelto);
        $prestamos = array();
        $stmt->execute();
        while($stmt->fetch()){
            $prestamos[]=array("id" => $id, "usuario" => $usuario, "amigo" => $amigo, "juego" => $juego, "fecha_prestamo" => $fecha_prestamo, "devuelto" => $devuelto);
        }
        $stmt->close();
        return $prestamos;
    }

    // public function buscarPrestamosPorNombre($busqueda, $id) {
    //     $setencia = "SELECT * from prestamos WHERE amigo = ?";
    //     $stmt = $this->conn->getConn()->prepare($setencia);
    //     $stmt->bind_param("i", $busqueda);
    //     $stmt->bind_result($id, $usuario, $amigo, $juego, $fecha_prestamo, $devuelto);
    //     $prestamos = array();
    //     $stmt->execute();
    //     while($stmt->fetch()){
    //         $prestamos[]=array("id" => $id, "usuario" => $usuario, "amigo" => $amigo, "juego" => $juego, "fecha_prestamo" => $fecha_prestamo, "devuelto" => $devuelto);
    //     }
    //     $stmt->close();
    //     return $prestamos;
    // }
}
?>