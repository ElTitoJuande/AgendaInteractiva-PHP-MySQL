<?php
require_once '../Modelo/class.db.php';

//Clase para gestionar los juegos
class Juego {
    private $conn;
    public $id;
    public $titulo;
    public $plataforma;
    public $lanzamiento;
    public $img;
    public $usuario;
    
    //Inicia la conexión a la bd y los atributos
    public function __construct() {
        $this->conn = new db();
        $this->id;
        $this->titulo;
        $this->plataforma;
        $this->lanzamiento;
        $this->img;
        $this->usuario;
    }

    //Obtiene todos los juegos de un usuario específico
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

    //Busca juegos por título o plataforma para un usuario específico
    public function buscarJuegoTituloPlata($busqueda, $id) {
        
        $sentencia = "SELECT * FROM juegos WHERE (titulo LIKE ? OR plataforma LIKE ?) AND usuario = ?";
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

    //Obtiene los detalles de un juego especifico por su ID
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

    //Actualiza la información de un juego existente
    public function editarJuego($id, $titulo, $plataforma, $lanzamiento, $img){
        $sentencia = "UPDATE juegos SET titulo = ?, plataforma = ?, lanzamiento = ?, img = ? WHERE id = ?";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("ssssi", $titulo, $plataforma, $lanzamiento, $img, $id);
        return $stmt->execute();
    }

    //Agrega un nuevo juego a la base de datos
    public function agregarJuego($titulo, $plataforma, $lanzamiento, $img, $usuario){
        var_dump($lanzamiento); 
        $sentencia = "INSERT INTO juegos (titulo, plataforma, lanzamiento, img, usuario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->getConn()->prepare($sentencia);
        $stmt->bind_param("ssssi", $titulo, $plataforma, $lanzamiento, $img, $usuario);
        return $stmt->execute();
    }
    
}
?>