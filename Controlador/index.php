<?php
// Cargar los modelos
require_once '../Modelo/Amigo.php';
require_once '../Modelo/Juego.php';
require_once '../Modelo/Prestamo.php';
require_once '../Modelo/Usuario.php';

function login() {
  
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        $usuario = new Usuario();
        
        if ($usuario->autenticarUsuario($nombre, $contrasena)) {
            session_start();
            $_SESSION['usuario_id'] = $usuario->$usuario->autenticarUsuario($nombre, $contrasena);
            // $_SESSION['usuario_tipo'] = $usuario->tipo;
            
            header('Location: index.php?action=dashboard');
            exit();
        } else {
            $error = 'Credenciales incorrectas';
        }
    }else{var_dump($_POST);
  die();
        require_once ("../Vista/login.php");
    }
}
function dashboard() {
    session_start();


    // var_dump($_SESSION['usuario_id']);
    // die();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }
    
    $tabla = new Amigo();
    $amigos = $tabla->listarPorUsuario($_SESSION['usuario_id']);

    require_once '../Vista/listaAmigos.php';

}

if (isset($_REQUEST['action'])) {
    $action = strtolower( $_REQUEST['action']); 
    $action();

}else{
    login();
}

?>
