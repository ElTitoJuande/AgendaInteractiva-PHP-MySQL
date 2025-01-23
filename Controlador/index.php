<?php
// Cargar los modelos
require_once '../modelos/Amigo.php';
require_once '../modelos/Juego.php';
require_once '../modelos/Prestamo.php';
require_once '../modelos/Usuario.php';

// Definir la acción a realizar
$accion = $_GET['accion'] ?? 'inicio';

switch ($accion) {
    case 'listarAmigos':
        // Lógica para listar amigos
        include '../vistas/amigos/index.php';
        break;
    case 'insertarAmigo':
        // Lógica para insertar un amigo
        include '../vistas/amigos/insertar.php';
        break;
    // Agregar más casos para las diferentes acciones
    default:
        include '../vistas/layouts/header.php';
        echo "Bienvenido a la aplicación";
        include '../vistas/layouts/footer.php';
        break;
}
?>
