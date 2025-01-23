<?php
require_once '../Modelo/class.bd.php';

class Amigo {
    public $id;
    public $nombre;
    public $apellidos;
    public $fecha_nac;
    public $usuario;

    public function guardar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("INSERT INTO amigos (nombre, apellidos, fecha_nac, usuario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $this->nombre, $this->apellidos, $this->fecha_nac, $this->usuario);
        
        $resultado = $stmt->execute();
        $this->id = $conn->insert_id;
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public function actualizar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("UPDATE amigos SET nombre = ?, apellidos = ?, fecha_nac = ? WHERE id = ? AND usuario = ?");
        $stmt->bind_param("sssii", $this->nombre, $this->apellidos, $this->fecha_nac, $this->id, $this->usuario);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public function eliminar() {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("DELETE FROM amigos WHERE id = ? AND usuario = ?");
        $stmt->bind_param("ii", $this->id, $this->usuario);
        
        $resultado = $stmt->execute();
        
        $stmt->close();
        $conn->close();
        
        return $resultado;
    }

    public static function buscarPorId($id, $usuario) {
        $db = new db();
        $conn = $db->getConn();
        
        $stmt = $conn->prepare("SELECT * FROM amigos WHERE id = ? AND usuario = ?");
        $stmt->bind_param("ii", $id, $usuario);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $amigo = null;
        
        if ($fila = $resultado->fetch_object()) {
            $amigo = new Amigo();
            $amigo->id = $fila->id;
            $amigo->nombre = $fila->nombre;
            $amigo->apellidos = $fila->apellidos;
            $amigo->fecha_nac = $fila->fecha_nac;
            $amigo->usuario = $fila->usuario;
        }
        
        $stmt->close();
        $conn->close();
        
        return $amigo;
    }

    public static function listarPorUsuario($usuario, $busqueda = '') {
        $db = new db();
        $conn = $db->getConn();
        
        $query = "SELECT * FROM amigos WHERE usuario = ?";
        $parametros = [$usuario];
        
        if (!empty($busqueda)) {
            $query .= " AND (nombre LIKE ? OR apellidos LIKE ?)";
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
        
        $amigos = [];
        while ($fila = $resultado->fetch_object()) {
            $amigo = new Amigo();
            $amigo->id = $fila->id;
            $amigo->nombre = $fila->nombre;
            $amigo->apellidos = $fila->apellidos;
            $amigo->fecha_nac = $fila->fecha_nac;
            $amigo->usuario = $fila->usuario;
            $amigos[] = $amigo;
        }
        
        $stmt->close();
        $conn->close();
        
        return $amigos;
    }
}
?>