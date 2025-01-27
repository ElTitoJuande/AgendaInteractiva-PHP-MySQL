<?php
// Cargar los modelos
require_once '../Modelo/Amigo.php';
require_once '../Modelo/Juego.php';
require_once '../Modelo/Prestamo.php';
require_once '../Modelo/Usuario.php';

function login() {
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        $usuario = new Usuario();
        
        if ($usuario->autenticarUsuario($nombre, $contrasena)!=null) {
            session_start();
            $_SESSION['usuario_id'] = $usuario->autenticarUsuario($nombre, $contrasena);

            dashboard();
        }else{
    
            require_once ("../Vista/login.php");
        }
    }else{

        require_once ("../Vista/login.php");
    }
}


function dashboard() {
    //session_start();
    // var_dump($_SESSION['usuario_id']);
    // die();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }
    
    $tabla = new Amigo();
    $amigos = $tabla->obtenerAmigosPorUsuario($_SESSION['usuario_id']);

    require_once '../Vista/listaAmigos.php';
}

if (isset($_REQUEST['action'])) {
    $action = strtolower( $_REQUEST['action']);
    $action();

}else{
    login();
}

?>
