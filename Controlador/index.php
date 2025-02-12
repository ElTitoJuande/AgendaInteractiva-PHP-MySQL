<?php
//Cargar los modelos
require_once '../Modelo/Amigo.php';
require_once '../Modelo/Juego.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/Prestamo.php';

//Autenticación de usuarios y establece la sesión si las credenciales son correctas
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
//Verifica la sesión del usuario y muestra el dashboard correspondiente según el tipo de usuario
function dashboard() {
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?action=login");
        exit();
    }
    
    $tipo = new Usuario();

    $_SESSION["tipo"] = $tipo->identificarTipo($_SESSION['usuario_id']);
    
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
//Actualiza la información de un amigo para usuarios normales
function actualizarAmigo(){
    session_start();    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];

    $amigo = new Amigo();
    
    $amigos = $amigo->editarAmigo($id, $nombre, $apellidos, $fecha_nac);

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
//Actualiza la información de un amigo incluyendo su usuario asignado (admin)
function actualizarAmigoAdmin(){
    session_start();    
    $id = $_POST['id_amigo'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $usuario = $_POST['id'];


    $amigo = new Amigo();
    
    $amigos = $amigo->editarAmigoAdmin($id, $nombre, $apellidos, $fecha_nac, $usuario);

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
//Redirige al usuario de vuelta a la lista de amigos
function volverListaAmigos(){
    session_start();
    header('Location: index.php?action=dashboard');
}
//Busca amigos por nombre o apellidos para un usuario concreto
function buscarAmigo(){
    session_start();
    $busqueda = $_POST['busqueda'];
    $id = $_SESSION['usuario_id'];
    
    if (strlen($busqueda) > 0) {
        $amigo = new Amigo();
        
        $amigos = $amigo->buscarAmigoPorNombre($busqueda, $id);
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarAmigo.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarAmigo();
    }

}
//Redirige a la vista de búsqueda de amigos con un array vacío
function redirigirBuscarAmigo(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    $amigos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarAmigo.php");
    require_once ("../Vista/footer.php");

}
//Redirige a la vista de nuevo amigo cargando la lista de usuarios disponibles
function redirigirNuevoAmigo(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    $usuario = new Usuario();

    $usuarios = $usuario->listarUsuarios();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoAmigo.php");
    require_once ("../Vista/footer.php");
}
//Busca amigos por nombre o apellidos para todos los usuarios (admin)
function buscarAmigoAdmin(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $amigo = new Amigo();
        
        $amigos = $amigo->buscarAmigoPorNombreAdmin($busqueda);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarAmigo.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarAmigoAdmin();
    }
}
//Redirige a la vista de búsqueda de amigos para admin con un array vacío
function redirigirBuscarAmigoAdmin(){
    session_start();
    $amigos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarAmigo.php");
    require_once ("../Vista/footer.php");

}
//Agrega un nuevo amigo al sistema asociándolo a un usuario específico
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
}
//Agrega un nuevo amigo asociado al usuario actual
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
//Carga el formulario de edición de amigo para administradores
function editarAmigoAdmin(){
    session_start();
    
    $id = $_POST['id'];
    $usuario = new Usuario();
    $usuarios = $usuario->listarUsuarios();
    
    $amigoClass = new Amigo();
    $amigos = $amigoClass->buscarAmigoPorIdAdmin($id);
    
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarAmigo.php");
    require_once ("../Vista/footer.php");
    
}
//Carga el formulario de edición de amigo para usuarios normales
function editarAmigo(){
    session_start();
    
    $id = $_POST['id'];
    $usuario = new Usuario();
    $usuarios = $usuario->listarUsuarios();
    
    $amigoClass = new Amigo();
    $amigos = $amigoClass->buscarAmigoPorIdAdmin($id);
    
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarAmigo.php");
    require_once ("../Vista/footer.php");
    
}
//Lista todos los juegos disponibles en el sistema
function listarJuegos(){
    session_start();
    
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
//Carga la vista de edición de juegos
function editarJuegos(){
    session_start();
    
    $id = $_POST['id'];
    
    $juegoClass = new Juego();
    $juegos = $juegoClass->buscarJuegoPorId($id);
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarJuegos.php");
    require_once ("../Vista/footer.php");
}
//Redirige al usuario de vuelta a la lista de juegos
function volverListaJuegos(){
    session_start();
    header('Location: index.php?action=listarJuegos');
}
//Actualiza la información de un juego
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
//Busca juegos por título o plataforma
function buscarJuego(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $id = $_SESSION['usuario_id'];
        $juego = new Juego();
        
        $juegos = $juego->buscarJuegoTituloPlata($busqueda, $id);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarJuego.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarJuego();
    }

}
//Redirige a la vista de búsqueda de juegos con un array vacío
function redirigirBuscarJuego(){
    session_start();
    $juegos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarJuego.php");
    require_once ("../Vista/footer.php");

}
//Agrega un nuevo juego a la base de datos
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
//Redirige a la vista de nuevo juego
function redirigirNuevoJuego(){
    session_start();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoJuego.php");
    require_once ("../Vista/footer.php");
}
//Lista todos los usuarios registrados en el sistema
function listarUsuarios(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    
    $tabla = new Usuario();
    $usuarios = $tabla->listarUsuarios();
    
    require_once ("../Vista/header.php");
    require_once ('../Vista/listaUsuarios.php');
    require_once ("../Vista/footer.php");
    
}
//Carga el formulario de edición de usuario
function editarUsuario(){
    session_start();

    $id = $_POST['id'];
    
    $usuarioClass = new Usuario();
    $usuarios = $usuarioClass->buscarUsuarioPorIdAdmin($id);
    
    require_once ("../Vista/header.php");
    require_once ("../Vista/editarUsuario.php");
    require_once ("../Vista/footer.php");
}
//Actualiza la información de un usuario existente
function actualizarUsuario(){
    session_start();

    $id = $_POST['id_Usuario'];
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];
    
    $usuario = new Usuario();

    $usuarios = $usuario->editarUsuario($id, $nombre, $contrasena, $tipo);

    if ($usuarios) {
        echo "Usuario actualizado correctamente.";
        header('Location: index.php?action=listarUsuarios');
    } 
}
//Redirige a la vista de nuevo usuario
function redirigirNuevoUsuario(){
    session_start();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoUsuario.php");
    require_once ("../Vista/footer.php");
}
//Agrega un nuevo usuario al sistema
function agregarUsuario() {
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
//Busca usuarios por nombre o apellidos para un usuario específico
function buscarUsuario() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $busqueda = $_POST['busqueda'];
    $id = $_SESSION['usuario_id'];

    if (strlen($busqueda) > 0) {
        $usuario = new Usuario();

        $usuarios = $usuario->buscarUsuarioNombre($busqueda, $id);
        if ($usuarios === null) {
            $usuarios = array();
        }
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarUsuario.php");
        require_once ("../Vista/footer.php");
    } else {
        redirigirBuscarUsuario();
    }
}
//Redirige a la página de búsqueda de usuarios
function redirigirBuscarUsuario(){
    if(session_status() == PHP_SESSION_NONE){session_start();}    
    $usuarios = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarUsuario.php");
    require_once ("../Vista/footer.php");
}
//Redirige al usuario de vuelta a la lista de usuarios
function volverListaUsuarios(){
    session_start();
    header('Location: index.php?action=listarUsuarios');
}
//Gestiona los préstamos de juegos a amigos
function listarPrestamos(){
    if(session_status() == PHP_SESSION_NONE){session_start();}
    
    $tabla = new Prestamo();
    $prestamos = $tabla->listaPrestamos($_SESSION['usuario_id']);

    $usuario = new Usuario();
    $usuarios = $usuario->listarUsuarios();

    $amigo = new Amigo();
    $amigos = $amigo->listarAmigosPorUsuario($_SESSION["usuario_id"]);

    $juegoClass = new Juego();
    $juegos = $juegoClass->listarJuegos($_SESSION["usuario_id"]);

    $prestamoClass = new Prestamo();
    $prestamos = $prestamoClass->buscarPrestamoPorId($_SESSION["usuario_id"]);
    require_once ("../Vista/header.php");
    require_once ('../Vista/listaPrestamos.php');
    require_once ("../Vista/footer.php");
}
//Busca préstamos por criterios específicos
function buscarPrestamo(){
    $busqueda = $_POST['busqueda'];
    
    if (strlen($busqueda) > 0) {
        session_start();
        $prestamo = new Prestamo();
        $id = $_SESSION['usuario_id'];
        
        $prestamos = $prestamo->buscarPrestamos($busqueda, $id);
        
        require_once ("../Vista/header.php");
        require_once ("../Vista/buscarPrestamo.php");
        require_once ("../Vista/footer.php");
    }else{
        redirigirBuscarPrestamo();
    }
}
//Redirige a la vista de búsqueda de préstamos con un array vacío
function redirigirBuscarPrestamo(){
    session_start();
    $prestamos = [];        
    require_once ("../Vista/header.php");
    require_once ("../Vista/buscarPrestamo.php");
    require_once ("../Vista/footer.php");

}
//Redirige a la vista de nuevo préstamo
function redirigirNuevoPrestamo(){
    session_start();
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoPrestamo.php");
    require_once ("../Vista/footer.php");
}
//Agrega un nuevo registro de préstamo
function agregarPrestamo(){
    session_start();
    $usuario = $_SESSION["usuario_id"];
    $amigo = $_POST['amigo_id'];
    $juego = $_POST['juego_id'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $devuelto = $_POST['devuelto'];
    
    $prestamo = new Prestamo();
    $prestamos = $prestamo->agregarPrestamo( $usuario, $amigo, $juego, $fecha_prestamo, $devuelto);
    
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
//Actualiza el estado de un préstamo
function actualizarPrestamo(){
    session_start();
    
    $id = $_SESSION["usuario_id"];
    
    $usuario = new Usuario();
    $usuarios = $usuario->listarUsuarios();

    $amigo = new Amigo();
    $amigos = $amigo->listarAmigosPorUsuario($_SESSION["usuario_id"]);

    $juegoClass = new Juego();
    $juegos = $juegoClass->listarJuegos($_SESSION["usuario_id"]);

    $prestamoClass = new Prestamo();
    $prestamos = $prestamoClass->buscarPrestamoPorId($id);
    
    require_once ("../Vista/header.php");
    require_once ("../Vista/nuevoPrestamo.php");
    require_once ("../Vista/footer.php");
}
//Redirige al usuario de vuelta a la lista de préstamos
function volverListaPrestamos(){
    session_start();
    header('Location: index.php?action=listarPrestamos');
}
//Marca un préstamo como devuelto
function devolverPrestamos(){
    session_start();
    $id = $_POST['id'];
    
    $devuelto = 1;

    $prestamo = new Prestamo();
    $prestamos = $prestamo->devolverPrestamo($id, $devuelto);
    
    if ($prestamos) {
        echo "Prestamo devuelto correctamente.";
        header('Location: index.php?action=listarPrestamos');
    }else{
        echo "Error al devolver el prestamo.";
    }

}
//Cierra la sesión del usuario y redirige al login
function salir(){
    session_start();
    session_unset();
    session_destroy();
    header("Location:../Controlador/index.php");
}

// Ejecuta la accion, sino inicia sesión
if (isset($_REQUEST['action'])) {
    $action = strtolower( $_REQUEST['action']);
    $action();

}else{
    login();
}

?>