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
            require_once ("../Vista/header.php");
            require_once ("../Vista/login.php");
            require_once ("../Vista/footer.php");
        }
    }else{

            require_once ("../Vista/header.php");
            require_once ("../Vista/login.php");
            require_once ("../Vista/footer.php");
    }
}
function actualizarAmigo(){
    session_start();    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];

    $amigo = new Amigo();
    
    $amigos = $amigo->editarAmigo($id, $nombre, $apellidos, $fecha_nac);
    var_dump($amigos);


    if ($amigos) {
        echo "Amigo actualizado correctamente.";
        header('Location: index.php?action=dashboard');
    } else {
        echo "Error al actualizar el amigo.";
        require_once ("../Vista/header.php");
        require_once ("../Vista/editarAmigo.php");
        require_once ("../Vista/footer.php");
    }
}
function actualizarAmigoAdmin(){
    session_start();    
    $id = $_POST['id_amigo'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $usuario = $_POST['id'];


    $amigo = new Amigo();
    
    $amigos = $amigo->editarAmigoAdmin($id, $nombre, $apellidos, $fecha_nac, $usuario);
    var_dump($amigos);


    if ($amigos) {
        echo "Amigo actualizado correctamente.";
        header('Location: index.php?action=dashboard');
    } else {
        echo "Error al actualizar el amigo.";
        require_once ("../Vista/header.php");
        require_once ("../Vista/editarAmigo.php");
        require_once ("../Vista/footer.php");
    }
}
function volverListaAmigos(){
    session_start();
    header('Location: index.php?action=dashboard');
}
// Función para buscar un amigo
function buscarAmigo(){
    session_start();
    $busqueda = $_POST['busqueda'];
    $id = $_SESSION['usuario_id'];
    
    if (strlen($busqueda) > 0) {
        $amigo = new Amigo();
        
        $amigos = $amigo->buscarAmigoPorNombre($busqueda, $id);
        // var_dump($amigos);
        
        require_once ("../Vista/buscarAmigo.php");
    }

}
function redirigirBuscarAmigo(){
    session_start();
    $amigos = [];        
    require_once ("../Vista/buscarAmigo.php");

}
function buscarAmigoAdmin(){
    $busqueda = $_POST['busqueda'];
    // var_dump($busqueda);
    
    if (strlen($busqueda) > 0) {
        session_start();
        $amigo = new Amigo();
        
        $amigos = $amigo->buscarAmigoPorNombreAdmin($busqueda);
        // var_dump($amigos);
        
        require_once ("../Vista/buscarAmigo.php");
    }
}
function redirigirBuscarAmigoAdmin(){
    session_start();
    $amigos = [];        
    require_once ("../Vista/buscarAmigo.php");

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
        require_once ("../Vista/header.php");
        require_once ("../Vista/nuevoAmigo.php");
        require_once ("../Vista/footer.php");
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
        require_once ("../Vista/header.php");
        require_once ("../Vista/nuevoAmigo.php");
        require_once ("../Vista/footer.php");
    }
}
function editarAmigoAdmin(){
    session_start();
    
    $id = $_POST['id'];
    // $nombre = $_POST['nombreUsu'];
    $usuario = new Usuario();
    $usuarios = $usuario->listarUsuarios();
    // var_dump($usuarios);
    
    $amigoClass = new Amigo();
    $amigos = $amigoClass->buscarAmigoPorIdAdmin($id);
    // var_dump($amigo);
    
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarAmigo.php");
    require_once ("../Vista/footer.php");
    
}
function editarAmigo(){
    session_start();

    $id = $_POST['id'];

    $amigoClass = new Amigo();

    $amigos = $amigoClass->buscarAmigoPorId($id);

    // header('Location: index.php?action=editarAmigo&amigo=' . $amigo);
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarAmigo.php");
    require_once ("../Vista/footer.php");

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
    
        require_once ("../Vista/header.php");
        require_once '../Vista/listaAmigos.php';
        require_once ("../Vista/footer.php");
    }else{
        $tabla = new Amigo();
        $amigos = $tabla->listarAmigosPorUsuario($_SESSION['usuario_id']);
        require_once ("../Vista/header.php");
        require_once '../Vista/listaAmigos.php';  
        require_once ("../Vista/footer.php");  
    }
}
function listarJuegos(){
    session_start();
    // var_dump($_SESSION["tipo"]);
    
    if (strcmp($_SESSION["tipo"], "admin") == 0) {
        $tabla = new Juego();
        $juegos = $tabla->listarJuegos($_SESSION['usuario_id']);
        
        require_once ("../Vista/header.php");
        require_once ('../Vista/listaJuegos.php');
        require_once ("../Vista/footer.php");
    }else{
        $tabla = new Juego();
        $juegos = $tabla->listarJuegos($_SESSION['usuario_id']);
        require_once ("../Vista/header.php");
        require_once ('../Vista/listaJuegos.php');
        require_once ("../Vista/footer.php");  
    }
}
function editarJuegos(){
    session_start();
    
    $id = $_POST['id'];
    
    $juegoClass = new Juego();
    $juegos = $juegoClass->buscarJuegoPorId($id);
    // var_dump($juego);
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarJuegos.php");
    require_once ("../Vista/footer.php");
}
function volverListaJuegos(){
    session_start();
    header('Location: index.php?action=listarJuegos');
}
function actualizarJuego(){
    session_start();   
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $plataforma = $_POST['plataforma'];
    $lanzamiento = $_POST['lanzamiento'];
    $img = $_POST['img'];

    $juego = new Juego();
    
    $juegos = $juego->editarJuego($id, $titulo, $plataforma, $lanzamiento, $img);
    var_dump($juegos);


    if ($juegos) {
        echo "Juego actualizado correctamente.";
        header('Location: index.php?action=listarJuegos');
    } else {
        echo "Error al actualizar el juego.";
        require_once ("../Vista/header.php");
        require_once ("../Vista/editarJuegos.php");
        require_once ("../Vista/footer.php");
    } 

    ///////
    // session_start();    
    // $id = $_POST['id'];
    // $nombre = $_POST['nombre'];
    // $apellidos = $_POST['apellidos'];
    // $fecha_nac = $_POST['fecha_nac'];

    // $amigo = new Amigo();
    
    // $amigos = $amigo->editarAmigo($id, $nombre, $apellidos, $fecha_nac);
    // var_dump($amigos);


    // if ($amigos) {
    //     echo "Amigo actualizado correctamente.";
    //     header('Location: index.php?action=dashboard');
    // } else {
    //     echo "Error al actualizar el amigo.";
    //     require_once ("../Vista/header.php");
    //     require_once ("../Vista/editarAmigo.php");
    //     require_once ("../Vista/footer.php");
    // }
    
}
function buscarJuego(){
    session_start();
    $busqueda = $_POST['busqueda'];
    $id = $_SESSION['usuario_id'];
    
    if (strlen($busqueda) > 0) {
        $juego = new Juego();
        
        $juegos = $juego->buscarJuegoTituloPlata($busqueda, $id);
        // var_dump($juegos);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarJuego.php");
        require_once ("../Vista/footer.php");
    }else{
        require_once ("../Vista/buscarJuego.php");
    }

}
function redirigirBuscarJuego(){
    session_start();
    $juegos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarJuego.php");
    require_once ("../Vista/footer.php");

}

function listarUsuarios(){
    session_start();
    // var_dump($_SESSION["tipo"]);
    
    if (strcmp($_SESSION["tipo"], "admin") == 0) {
        $tabla = new Usuario();
        $usuarios = $tabla->listarUsuarios($_SESSION['usuario_id']);
        
        require_once ("../Vista/header.php");
        require_once ('../Vista/listaUsuarios.php');
        require_once ("../Vista/footer.php");
    }else{
        $tabla = new Usuario();
        $usuarios = $tabla->listarUsuarios($_SESSION['usuario_id']);
        require_once ("../Vista/header.php");
        require_once ('../Vista/listaUsuarios.php');
        require_once ("../Vista/footer.php");  
    }
}

function salir(){
    session_start();
    session_destroy();
    header("Location:../Controlador/index.php");
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
