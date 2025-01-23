<?php
session_start();
require_once('../Modelo/Usuario.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    $usuario = Usuario::autenticar($nombre, $contrasena);
    
    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_tipo'] = $usuario->tipo;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Credenciales incorrectas';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <form method="post" class="login-form">
            <h2>Agenda Personal</h2>
            
            <?php if ($error): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>

            <div class="form-grupo">
                <label for="nombre">Usuario</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-grupo">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>

            <button type="submit" class="btn btn-block">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>