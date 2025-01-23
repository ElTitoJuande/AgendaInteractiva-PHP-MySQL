<?php
session_start();
require_once('../modelo/Amigo.php');

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$amigo = null;

if (isset($_GET['id'])) {
    $amigo = Amigo::buscarPorId($_GET['id'], $_SESSION['usuario_id']);
    
    if (!$amigo) {
        header('Location: lista_amigos.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amigo->nombre = $_POST['nombre'];
    $amigo->apellidos = $_POST['apellidos'];
    $amigo->fecha_nac = $_POST['fecha_nac'];

    if ($amigo->actualizar()) {
        header('Location: lista_amigos.php');
        exit();
    } else {
        $error = 'Error al actualizar el amigo';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Amigo</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Amigo</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($amigo->nombre) ?>" required>
            </div>

            <div class="form-grupo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($amigo->apellidos) ?>" required>
            </div>

            <div class="form-grupo">
                <label for="fecha_nac">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nac" name="fecha_nac" value="<?= $amigo->fecha_nac ?>" required>
            </div>

            <button type="submit" class="btn">Actualizar Amigo</button>
            <a href="lista_amigos.php" class="btn btn-secundario">Cancelar</a>
        </form>
    </div>
</body>
</html>