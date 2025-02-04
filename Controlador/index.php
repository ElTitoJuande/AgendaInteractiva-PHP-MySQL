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
            header('Location: index.php?action=dashboard');
        }else{
            require_once ("../HeaderFooter/header.html");
            require_once ("../Vista/login.php");
            require_once ("../HeaderFooter/footer.html");
        }
    }else{

            require_once ("../HeaderFooter/header.html");
            require_once ("../Vista/login.php");
            require_once ("../HeaderFooter/footer.html");
    }
}
function actualizarAmigo(){
    session_start();    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    // $usuario = $_SESSION['usuario_id'];

    $amigo = new Amigo();
    
    $amigos = $amigo->editarAmigo($id, $nombre, $apellidos, $fecha_nac);
    var_dump($amigos);


    if ($amigos) {
        echo "Amigo actualizado correctamente.";
        header('Location: index.php?action=dashboard');
    } else {
        echo "Error al actualizar el amigo.";
        require_once ("../HeaderFooter/header.html");
        require_once ("../Vista/editarAmigo.php");
        require_once ("../HeaderFooter/footer.html");
    }
}
function volverListaAmigos(){
    session_start();
    header('Location: index.php?action=dashboard');
}
function buscarAmigo(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $amigo = new Amigo();
        
        $amigos = $amigo->buscarAmigoPorNombre($busqueda);
        $amigos = array($amigos);
        var_dump($amigos);
        
        require_once ("../Vista/listaAmigos.php");
    }else{
        header('Location: index.php?action=dashboard');
    }

}
function buscarAmigoAdmin(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $amigo = new Amigo();
        
        $amigos = $amigo->buscarAmigoPorNombreAdmin($busqueda);
        $amigos = array($amigos);
        var_dump($amigos);
        
        require_once ("../Vista/listaAmigos.php");
    }else{
        header('Location: index.php?action=dashboard');
    }

}

function agregarAmigoAdmin() {
    session_start();
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $usuario = $_SESSION['usuario_id'];

    $amigo = new Amigo();

    $amigos = $amigo->agregarAmigo($nombre, $apellidos, $fecha_nac, $usuario);

    if ($amigos) {
        echo "Amigo agregado correctamente.";
        header('Location: index.php?action=dashboard');
    } else {
        echo "Error al agregar el amigo.";
        require_once ("../HeaderFooter/header.html");
        require_once ("../Vista/nuevoAmigo.php");
        require_once ("../HeaderFooter/footer.html");
    }
    // dashboard();
}
function agregarAmigo(){
    session_start();
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $usuario = $_SESSION['usuario_id'];

    $amigo = new Amigo();

    $amigos = $amigo->agregarAmigo($nombre, $apellidos, $fecha_nac, $usuario);

    if ($amigos) {
        echo "Amigo agregado correctamente.";
        header('Location: index.php?action=dashboard');
    } else {
        echo "Error al agregar el amigo.";
        require_once ("../HeaderFooter/header.html");
        require_once ("../Vista/nuevoAmigo.php");
        require_once ("../HeaderFooter/footer.html");
    }
}
function editarAmigoAdmin(){
    session_start();
    
    $id = $_POST['id'];
    
    $amigoClass = new Amigo();
    $amigo = $amigoClass->buscarAmigoPorIdAdmin($id);
    var_dump($amigo);

    // header('Location: index.php?action=editarAmigo&amigo=' . $amigo);
    require_once ("../Vista/editarAmigo.php");

}
function editarAmigo(){
    session_start();

    $id = $_POST['id'];

    $amigoClass = new Amigo();

    $amigo = $amigoClass->buscarAmigoPorId($id);

    // header('Location: index.php?action=editarAmigo&amigo=' . $amigo);
    require_once ("../Vista/editarAmigo.php");

}

function dashboard() {
    session_start();
    // var_dump($_SESSION['usuario_id']);
    // die();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?action=login");
        exit();
    }
    
    $tipo = new Usuario();

    $_SESSION["tipo"] = $tipo->identificarTipo($_SESSION['usuario_id']);
    // var_dump($_SESSION["tipo"]);
    // die();
    
    if (strcmp($_SESSION["tipo"], "admin") == 0) {
        $tabla = new Amigo();
        $amigos = $tabla->listarAmigos($_SESSION['usuario_id']);
    
        require_once ("../HeaderFooter/header.html");
        require_once '../Vista/listaAmigos.php';
        require_once ("../HeaderFooter/footer.html");
    }else{
        $tabla = new Amigo();
        $amigos = $tabla->listarAmigosPorUsuario($_SESSION['usuario_id']);
        require_once ("../HeaderFooter/header.html");
        require_once '../Vista/listaAmigos.php';  
        require_once ("../HeaderFooter/footer.html");  
    }
}

if (isset($_REQUEST['action'])) {
    $action = strtolower( $_REQUEST['action']);
    // var_dump($action);
    // die();
    $action();

}else{
    login();
}

?>
