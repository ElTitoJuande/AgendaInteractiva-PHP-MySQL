<?php
require_once '../Modelo/class.db.php';

class Juego {
    public $id;
    public $titulo;
    public $plataforma;
    public $lanzamiento;
    public $img;
    public $usuario;

    public function guardar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("INSERT INTO juegos (titulo, plataforma, lanzamiento, img, usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $this->titulo, $this->plataforma, $this->lanzamiento, $this->img, $this->usuario);
        
        $resultado = $stmt->execute();
        $this->id = $conn->insert_id;
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public function actualizar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("UPDATE juegos SET titulo = ?, plataforma = ?, lanzamiento = ?, img = ? WHERE id = ? AND usuario = ?");
        $stmt->bind_param("ssssii", $this->titulo, $this->plataforma, $this->lanzamiento, $this->img, $this->id, $this->usuario);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public function eliminar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("DELETE FROM juegos WHERE id = ? AND usuario = ?");
        $stmt->bind_param("ii", $this->id, $this->usuario);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public static function buscarPorId($id, $usuario) {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("SELECT * FROM juegos WHERE id = ? AND usuario = ?");
        $stmt->bind_param("ii", $id, $usuario);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $juego = null;
        
        if ($fila = $resultado->fetch_object()) {
            $juego = new Juego();
            $juego->id = $fila->id;
            $juego->titulo = $fila->titulo;
            $juego->plataforma = $fila->plataforma;
            $juego->lanzamiento = $fila->lanzamiento;
            $juego->img = $fila->img;
            $juego->usuario = $fila->usuario;
        }
        
        $stmt->close();
        $conn->close();
        
        return $juego;
    }

    public static function listarPorUsuario($usuario, $busqueda = '') {
        $db = new db();
        $conn = $db->getConn();
        
        $query = "SELECT * FROM juegos WHERE usuario = ?";
        $parametros = [$usuario];
        
        if (!empty($busqueda)) {
            $query .= " AND (titulo LIKE ? OR plataforma LIKE ?)";
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
        
        $juegos = [];
        while ($fila = $resultado->fetch_object()) {
            $juego = new Juego();
            $juego->id = $fila->id;
            $juego->titulo = $fila->titulo;
            $juego->plataforma = $fila->plataforma;
            $juego->lanzamiento = $fila->lanzamiento;
            $juego->img = $fila->img;
            $juego->usuario = $fila->usuario;
            $juegos[] = $juego;
        }
        
        $stmt->close();
        $conn->close();
        
        return $juegos;
    }
}
?>