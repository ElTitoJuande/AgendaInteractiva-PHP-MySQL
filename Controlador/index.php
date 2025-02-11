<?php
// require_once '../Vista/header.php';
// require_once '../Vista/login.php';
// require_once '../Vista/footer.php';
// Cargar los modelos
require_once '../Modelo/Amigo.php';
require_once '../Modelo/Juego.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Prestamo.php';

function login() {
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        $usuario = new Usuario();
        
        if ($usuario->autenticarUsuario($nombre, $contrasena)!=null) {
            session_start();
            $_SESSION['usuario_id'] = $usuario->autenticarUsuario($nombre, $contrasena);

            if (isset($_POST['recuerdame']) && $_POST['recuerdame'] == 1) {
                setcookie("usuario", $nombre, time()  + (86400 * 30));
                setcookie("recuerdame", 1, time()  + (86400 * 30));
            }

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
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarAmigo.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarAmigo();
    }

}
function redirigirBuscarAmigo(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    $amigos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarAmigo.php");
    require_once ("../Vista/footer.php");

}
function redirigirNuevoAmigo(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    $usuario = new Usuario();

    $usuarios = $usuario->listarUsuarios();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoAmigo.php");
    require_once ("../Vista/footer.php");
}
function buscarAmigoAdmin(){
    $busqueda = $_POST['busqueda'];
    // var_dump($busqueda);
    
    if (strlen($busqueda) > 0) {
        session_start();
        $amigo = new Amigo();
        
        $amigos = $amigo->buscarAmigoPorNombreAdmin($busqueda);
        // var_dump($amigos);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarAmigo.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarAmigoAdmin();
    }
}
function redirigirBuscarAmigoAdmin(){
    session_start();
    $amigos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarAmigo.php");
    require_once ("../Vista/footer.php");

}
function agregarAmigoAdmin() {
    session_start();
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $usuario_id = $_POST['usuario_id'];

    $amigo = new Amigo();

    $amigos = $amigo->agregarAmigo($nombre, $apellidos, $fecha_nac, $usuario_id);

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
    
    if (!isset($_SESSION["usuario_id"])) {
        header("Location: index.php?action=login");
        exit;
    }
    
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $plataforma = $_POST['plataforma'];
    $lanzamiento = $_POST['lanzamiento'];
    
    $nombre_archivo = "";
    
    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
        $nombre_archivo = basename($_FILES["img"]["name"]);
        $ruta_archivo = "../img/" . $nombre_archivo;
        
        if (!move_uploaded_file($_FILES["img"]["tmp_name"], $ruta_archivo)) {
            echo "Error al mover el archivo.";
            exit;
        }
    }
    
    $juego = new Juego();
    $juegos = $juego->editarJuego($id, $titulo, $plataforma, $lanzamiento, $nombre_archivo);
    var_dump($juegos);
    
    if ($juegos) {
        echo "Juego actualizado correctamente.";
        header('Location: index.php?action=listarJuegos');
        exit;
    } else {
        echo "Error al actualizar el juego.";
        require_once ("../Vista/header.php");
        require_once ("../Vista/editarJuegos.php");
        require_once ("../Vista/footer.php");
    } 
}
function buscarJuego(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $id = $_SESSION['usuario_id'];
        $juego = new Juego();
        
        $juegos = $juego->buscarJuegoTituloPlata($busqueda, $id);
        // var_dump($juegos);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarJuego.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarJuego();
    }

}
function redirigirBuscarJuego(){
    session_start();
    $juegos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarJuego.php");
    require_once ("../Vista/footer.php");

}
function agregarJuego(){
    session_start();
    
    if (!isset($_SESSION["usuario_id"])) {
        header("Location: index.php?action=login");
        exit;
    }
    
    $usuario = $_SESSION["usuario_id"];
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo = $_POST["titulo"];
        $plataforma = $_POST["plataforma"];
        $lanzamiento = $_POST["lanzamiento"];
        
        $nombre_archivo = "";
        
        if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
            $nombre_archivo = basename($_FILES["img"]["name"]);
            $ruta_archivo = "../img/" . $nombre_archivo;
            
            if (!move_uploaded_file($_FILES["img"]["tmp_name"], $ruta_archivo)) {
                echo "Error al mover el archivo.";
                exit;
            }
        }
        
        $juego = new Juego();
        $resultado = $juego->agregarJuego($titulo, $plataforma, $lanzamiento, $nombre_archivo, $usuario);
        
        if ($resultado) {
            header("Location: index.php?action=listarJuegos");
            exit;
        } else {
            echo "Error al agregar el juego.";
            require_once("../Vista/header.php");
            require_once("../Vista/nuevoJuego.php");
            require_once("../Vista/footer.php");
        }
    }
}
function redirigirNuevoJuego(){
    session_start();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoJuego.php");
    require_once ("../Vista/footer.php");
}
function listarUsuarios(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    // var_dump($_SESSION["tipo"]);
    
    $tabla = new Usuario();
    $usuarios = $tabla->listarUsuarios();
    
    require_once ("../Vista/header.php");
    require_once ('../Vista/listaUsuarios.php');
    require_once ("../Vista/footer.php");
    
}
function editarUsuario(){
    session_start();

    $id = $_POST['id'];
    
    $usuarioClass = new Usuario();
    $usuarios = $usuarioClass->buscarUsuarioPorIdAdmin($id);
    // var_dump($amigo);
    
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarUsuario.php");
    require_once ("../Vista/footer.php");
}
function actualizarUsuario(){
    session_start();
    $id = $_POST['id_Usuario'];
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];
    
    $usuario = new Usuario();
    
    $usuarios = $usuario->editarUsuario($id, $nombre, $contrasena, $tipo);
    var_dump($usuarios);
    
    if ($usuarios) {
        echo "Usuario actualizado correctamente.";
        header('Location: index.php?action=listarUsuarios');
    } else {
        echo "Error al actualizar el usuario.";
        require_once ("../Vista/header.php");
        require_once ("../Vista/editarUsuario.php");
        require_once ("../Vista/footer.php");
    }
}
function redirigirNuevoUsuario(){
    session_start();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoUsuario.php");
    require_once ("../Vista/footer.php");
}
function agregarUsuario(){
    session_start();
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    $usuario = new Usuario();

    $usuarios = $usuario->agregarUsuario($nombre, $contrasena);

    if ($usuarios) {
        echo "Usuario agregado correctamente.";
        header('Location: index.php?action=listarUsuarios');
    } else {
        echo "Error al agregar el usuario.";
        require_once ("../Vista/header.php");
        require_once ("../Vista/nuevoUsuario.php");
        require_once ("../Vista/footer.php");
    }
}
function buscarUsuario(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $id = $_SESSION['usuario_id'];
        $usuario = new Usuario();
        
        $usuarios = $usuario->buscarUsuarioNombre($busqueda, $id);
        // var_dump($usuarios);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarUsuario.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarUsuario();
    }
}
function redirigirBuscarUsuario(){
    session_start();
    $usuarios = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarUsuario.php");
    require_once ("../Vista/footer.php");

}
function volverListaUsuarios(){
    session_start();
    header('Location: index.php?action=listarUsuarios');
}
function listarPrestamos(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    
    $tabla = new Prestamo();
    $prestamos = $tabla->listaPrestamos($_SESSION['usuario_id']);

    //
    // $nombre = $_POST['nombreUsu'];
    $usuario = new Usuario();
    $usuarios = $usuario->listarUsuarios();
    // var_dump($usuarios);

    $amigo = new Amigo();
    $amigos = $amigo->listarAmigosPorUsuario($_SESSION["usuario_id"]);
    // var_dump($amigos);

    $juegoClass = new Juego();
    $juegos = $juegoClass->listarJuegos($_SESSION["usuario_id"]);
    // var_dump($juego);

    $prestamoClass = new Prestamo();
    $prestamos = $prestamoClass->buscarPrestamoPorId($id);
    // var_dump($prestamos);

    //
    require_once ("../Vista/header.php");
    require_once ('../Vista/listaPrestamos.php');
    require_once ("../Vista/footer.php");
}
function buscarPrestamo(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $prestamo = new Prestamo();
        $id = $_SESSION['usuario_id'];
        
        $prestamos = $prestamo->buscarPrestamos($busqueda, $id);
        var_dump($prestamos);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarPrestamo.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarPrestamo();
    }
}
function redirigirBuscarPrestamo(){
    session_start();
    $prestamos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarPrestamo.php");
    require_once ("../Vista/footer.php");

}
function redirigirNuevoPrestamo(){
    session_start();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoPrestamo.php");
    require_once ("../Vista/footer.php");
}
function agregarPrestamo(){
    session_start();
    $usuario = $_SESSION["usuario_id"];
    $amigo = $_POST['amigo_id'];
    $juego = $_POST['juego_id'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $devuelto = $_POST['devuelto'];
    
    $prestamo = new Prestamo();
    $prestamos = $prestamo->agregarPrestamo( $usuario, $amigo, $juego, $fecha_prestamo, $devuelto);
    // var_dump($prestamo);
    
    if ($prestamos) {
        echo "Prestamo agregado correctamente.";
        header('Location: index.php?action=listarPrestamos');
    } else {
        echo "Error al agregar el prestamo.";
        require_once ("../Vista/header.php");
        require_once ("../Vista/nuevoPrestamo.php");
        require_once ("../Vista/footer.php");
    }
}
function actualizarPrestamo(){
    session_start();
    
    $id = $_SESSION["usuario_id"];
    
    // $nombre = $_POST['nombreUsu'];
    $usuario = new Usuario();
    $usuarios = $usuario->listarUsuarios();
    // var_dump($usuarios);

    $amigo = new Amigo();
    $amigos = $amigo->listarAmigosPorUsuario($_SESSION["usuario_id"]);
    // var_dump($amigos);

    $juegoClass = new Juego();
    $juegos = $juegoClass->listarJuegos($_SESSION["usuario_id"]);
    // var_dump($juego);

    $prestamoClass = new Prestamo();
    $prestamos = $prestamoClass->buscarPrestamoPorId($id);
    // var_dump($prestamos);
    
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoPrestamo.php");
    require_once ("../Vista/footer.php");
}
function volverListaPrestamos(){
    session_start();
    header('Location: index.php?action=listarPrestamos');
}
function devolverPrestamos(){
    session_start();
    $id = $_POST['id'];
    
    $devuelto = 1;

    $prestamo = new Prestamo();
    $prestamos = $prestamo->devolverPrestamo($id, $devuelto);
    // var_dump($prestamo);
    
    if ($prestamos) {
        echo "Prestamo devuelto correctamente.";
        header('Location: index.php?action=listarPrestamos');
    }else{
        echo "Error al devolver el prestamo.";
    }

}
function salir(){
    session_start();
    session_unset();
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