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
}
?>