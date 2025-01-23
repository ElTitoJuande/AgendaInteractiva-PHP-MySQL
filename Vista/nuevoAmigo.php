<?php
session_start();
require_once('../modelos/Amigo.php');

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amigo = new Amigo();
    $amigo->nombre = $_POST['nombre'];
    $amigo->apellidos = $_POST['apellidos'];
    $amigo->fecha_nac = $_POST['fecha_nac'];
    $amigo->usuario = $_SESSION['usuario_id'];

    if ($amigo->guardar()) {
        header('Location: lista_amigos.php');
        exit();
    } else {
        $error = 'Error al guardar el amigo';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Amigo</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Añadir Nuevo Amigo</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-grupo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>

            <div class="form-grupo">
                <label for="fecha_nac">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nac" name="fecha_nac" required>
            </div>

            <button type="submit" class="btn">Guardar Amigo</button>
            <a href="lista_amigos.php" class="btn btn-secundario">Cancelar</a>
        </form>
    </div>
</body>
</html>