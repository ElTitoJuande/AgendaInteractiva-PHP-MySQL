<?php
require_once('../Modelo/class.db.php');

class Prestamo {
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

    public function guardar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("INSERT INTO prestamos (usuario, amigo, juego, fecha_prestamo, devuelto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisi", $this->usuario, $this->amigo, $this->juego, $this->fecha_prestamo, $this->devuelto);
        
        $resultado = $stmt->execute();
        $this->id = $conn->insert_id;
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public function marcarDevuelto() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("UPDATE prestamos SET devuelto = 1 WHERE id = ? AND usuario = ?");
        $stmt->bind_param("ii", $this->id, $this->usuario);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public static function buscarPorId($id, $usuario) {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("
            SELECT p.*, a.nombre as nombre_amigo, j.titulo as titulo_juego 
            FROM prestamos p
            JOIN amigos a ON p.amigo = a.id
            JOIN juegos j ON p.juego = j.id
            WHERE p.id = ? AND p.usuario = ?
        ");
        $stmt->bind_param("ii", $id, $usuario);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $prestamo = null;
        
        if ($fila = $resultado->fetch_object()) {
            $prestamo = new Prestamo();
            $prestamo->id = $fila->id;
            $prestamo->usuario = $fila->usuario;
            $prestamo->amigo = $fila->amigo;
            $prestamo->juego = $fila->juego;
            $prestamo->fecha_prestamo = $fila->fecha_prestamo;
            $prestamo->devuelto = $fila->devuelto;
            $prestamo->nombre_amigo = $fila->nombre_amigo;
            $prestamo->titulo_juego = $fila->titulo_juego;
        }
        
        $stmt->close();
        $conn->close();
        
        return $prestamo;
    }

    public static function listarPorUsuario($usuario, $busqueda = '', $mostrarSoloActivos = false) {
        $db = new db();
        $conn = $db->getConn();
        
        $query = "
            SELECT p.*, a.nombre as nombre_amigo, j.titulo as titulo_juego 
            FROM prestamos p
            JOIN amigos a ON p.amigo = a.id
            JOIN juegos j ON p.juego = j.id
            WHERE p.usuario = ?
        ";
        $parametros = [$usuario];
        
        if ($mostrarSoloActivos) {
            $query .= " AND p.devuelto = 0";
        }
        
        if (!empty($busqueda)) {
            $query .= " AND (a.nombre LIKE ? OR j.titulo LIKE ?)";
            $busquedaParam = "%$busqueda%";
            $parametros[] = $busquedaParam;
            $parametros[] = $busquedaParam;
        }
        
        $stmt = $conn->prepare($query);
        
        // Bind dinámico de parámetros
        $tipos = str_repeat('s', count($parametros));
        $stmt->bind_param($tipos, ...$parametros);
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $prestamos = [];
        while ($fila = $resultado->fetch_object()) {
            $prestamo = new Prestamo();
            $prestamo->id = $fila->id;
            $prestamo->usuario = $fila->usuario;
            $prestamo->amigo = $fila->amigo;
            $prestamo->juego = $fila->juego;
            $prestamo->fecha_prestamo = $fila->fecha_prestamo;
            $prestamo->devuelto = $fila->devuelto;
            $prestamo->nombre_amigo = $fila->nombre_amigo;
            $prestamo->titulo_juego = $fila->titulo_juego;
            $prestamos[] = $prestamo;
        }
        
        $stmt->close();
        $conn->close();
        
        return $prestamos;
    }
}
?>