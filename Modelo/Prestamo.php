<?php
require_once('../Modelo/class.db.php');

//Clase para gestionar los préstamos
class Prestamo {
    private $conn;
    public $id;
    public $usuario;
    public $amigo;
    public $juego;
    public $fecha_prestamo;
    public $devuelto;

    //Inicializa la conexión a la base de datos y los atributos
    public function __construct() {
        $this->conn=new db();
        $this->id;
        $this->usuario;
        $this->amigo;
        $this->juego;
        $this->fecha_prestamo;
        $this->devuelto;
    }

    //Obtiene todos los préstamos de un usuario
    public function listaPrestamos($usuario_id) {
        $sentencia = "SELECT * from prestamos WHERE usuario = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
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

    //Busca préstamos por nombre de amigo o título de juego
    public function buscarPrestamos($busqueda, $id) {
        $sentencia = "SELECT amigos.nombre, juegos.titulo, juegos.img, prestamos.fecha_prestamo, prestamos.devuelto, prestamos.id from prestamos 
        LEFT JOIN amigos ON prestamos.amigo = amigos.id 
        LEFT JOIN juegos ON prestamos.juego = juegos.id
        LEFT JOIN usuarios ON prestamos.usuario = usuarios.id
        WHERE amigos.nombre LIKE ? OR juegos.titulo LIKE ? ";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $busqueda = "%$busqueda%";
        $stmt->bind_param("ss",$busqueda,$busqueda);
        $stmt->bind_result($amigo, $juego, $img, $fecha_prestamo, $devuelto, $id);
        $prestamos = array();
        $stmt->execute();
        while($stmt->fetch()){
            $prestamos[]=array("amigo" => $amigo, "juego" => $juego, "img" => $img, "fecha_prestamo" => $fecha_prestamo, "devuelto" => $devuelto, "id" => $id);
        }
        $stmt->close();
        return $prestamos;
    }


    //Obtiene los detalles de los préstamos de un usuario específico
    public function buscarPrestamoPorId($id) {
        $sentencia = "SELECT amigos.nombre, juegos.titulo, juegos.img, prestamos.fecha_prestamo, prestamos.devuelto, prestamos.id from prestamos 
        LEFT JOIN amigos ON prestamos.amigo = amigos.id 
        LEFT JOIN juegos ON prestamos.juego = juegos.id
        LEFT JOIN usuarios ON prestamos.usuario = usuarios.id
        WHERE usuarios.id = ? ";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $id);
        $stmt->bind_result($amigo, $juego, $img, $fecha_prestamo, $devuelto, $id);
        $prestamos = array();
        $stmt->execute();
        while($stmt->fetch()){
            $fecha_prestamo = date("d-m-Y", strtotime($fecha_prestamo));
            $prestamos[]=array("amigo" => $amigo, "juego" => $juego, "img" => $img, "fecha_prestamo" => $fecha_prestamo, "devuelto" => $devuelto, "id" => $id);
        }
        $stmt->close();
        return $prestamos;
    }

    //Marca un préstamo como devuelto o no devuelto
    public function devolverPrestamo($id, $devuelto) {
        $sentencia = "UPDATE prestamos SET devuelto = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("ii", $devuelto, $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    //Registra un nuevo préstamo en el sistema
    public function agregarPrestamo($usuario, $amigo, $juego, $fecha_prestamo, $devuelto) {
        $sentencia = "INSERT INTO prestamos (usuario, amigo, juego, fecha_prestamo, devuelto) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("iiisi", $usuario, $amigo, $juego, $fecha_prestamo, $devuelto);
        $stmt->execute();
        $stmt->close();
        return true;
    }
}
?>