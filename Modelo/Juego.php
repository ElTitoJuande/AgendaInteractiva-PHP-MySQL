<?php
require_once '../Modelo/class.db.php';

class Juego {
    private $conn;
    public $id;
    public $titulo;
    public $plataforma;
    public $lanzamiento;
    public $img;
    public $usuario;
    
    public function __construct() {
        $this->conn = new db();
        $this->id;
        $this->titulo;
        $this->plataforma;
        $this->lanzamiento;
        $this->img;
        $this->usuario;
    }

    public function listarJuegos($id) {
        $sentencia = "SELECT juegos.id, juegos.titulo, juegos.plataforma, juegos.lanzamiento, juegos.img, juegos.usuario FROM juegos,usuarios WHERE juegos.usuario = usuarios.id AND usuarios.id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id, $titulo, $plataforma, $lanzamiento, $img, $usuario);
        $juegos=array();
        $stmt->execute();
        while ($stmt->fetch()) {
            $juegos[] = array("id" => $id,"titulo" => $titulo, "plataforma" => $plataforma, "lanzamiento" => $lanzamiento, "img" => $img, "usuario" => $usuario);
        }
        $stmt -> close();
        return $juegos;

    }

    public function buscarJuegoTituloPlata($busqueda, $id) {
        
        $sentencia = "SELECT * FROM juegos WHERE (titulo LIKE ? OR plataforma LIKE ?) AND usuario = ?";
        // $sentencia = "SELECT DISTINCT juegos.id, juegos.titulo, juegos.plataforma, juegos.lanzamiento, juegos.img, juegos.usuario FROM juegos LEFT JOIN usuarios ON juegos.usuario = usuarios.id  WHERE juegos.titulo LIKE ? AND juegos.usuario = ?"; 
        $juegos=array();
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $busqueda = "%$busqueda%";
        $stmt->bind_param("ssi", $busqueda, $busqueda, $id);
        $stmt->bind_result($id, $titulo, $plataforma, $lanzamiento, $img, $usuario);
        $stmt->execute();
        while ($stmt->fetch()) {
            $juegos[] = array("id" => $id,"titulo" => $titulo, "plataforma" => $plataforma, "lanzamiento" => $lanzamiento, "img" => $img, "usuario" => $usuario);
        }
        
        $stmt -> close();
        return $juegos;
    }

    public function buscarJuegoPorId($id) {
        $sentencia = "SELECT juegos.id, juegos.titulo, juegos.plataforma, juegos.lanzamiento, juegos.img, juegos.usuario FROM juegos WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id, $titulo, $plataforma, $lanzamiento, $img, $usuario);
        $stmt->execute();
        $stmt->fetch();
        $juego = array("id" => $id,"titulo" => $titulo, "plataforma" => $plataforma, "lanzamiento" => $lanzamiento, "img" => $img, "usuario" => $usuario);
        $stmt -> close();
        return $juego;
    }

    //ver si tengo que pasarle id de la session o del usuario
    public function editarJuego($id, $titulo, $plataforma, $lanzamiento, $img){
        $sentencia = "UPDATE juegos SET titulo = ?, plataforma = ?, lanzamiento = ?, img = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("ssssi", $titulo, $plataforma, $lanzamiento, $img, $id);
        return $stmt->execute();
    }

    //ver si tengo que pasarle id de la session o del usuario
    public function agregarJuego($titulo, $plataforma, $lanzamiento, $img, $usuario){
        var_dump($lanzamiento); 
        $sentencia = "INSERT INTO juegos (titulo, plataforma, lanzamiento, img, usuario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("ssssi", $titulo, $plataforma, $lanzamiento, $img, $usuario);
        return $stmt->execute();
    }
    
}
?>