<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Amigo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Amigo</h1>

        <form method="post">
            <div class="form-grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value=" <?= $amigo["nombre"] ?>" required>
            </div>

            <div class="form-grupo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="<?= $amigo["apellidos"] ?>" required>
            </div>

            <div class="form-grupo">
                <label for="fecha_nac">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nac" name="fecha_nac" value="<?= $amigo["fecha_nac"] ?>" required>
            </div>

            <button type="submit" class="btn">Actualizar Amigo</button>
            <a href="listaAmigos.php" class="btn btn-secundario">Cancelar</a>
        </form>
    </div>
</body>
</html> -->

<?php
// Verifica si el usuario tiene una sesión iniciada
if (isset($_SESSION['usuario_id'])) {

    // Verifica si el usuario es administrador
    if (strcmp($_SESSION["tipo"], "admin") == 0) {
        // Vista de editar amigo para administradores
        $amigo = new Amigo();
        $amigo->id = $_GET['id'];
        $amigo->obtenerAmigo();

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Amigo (Administrador)</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Editar Amigo (Administrador)</h1>
                
                <form action="index.php?action=actualizarAmigoAdmin" method="post">
                    <input type="hidden" name="id" value="<?= $amigo->id ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value=" <?= $amigo["nombre"] ?>" required>
                    <br>
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" value="<?= $amigo["apellidos"] ?>" required>
                    <br>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" value="<?= $amigo["fecha_nac"] ?>" required>
                    <br>
                    <button type="submit">Actualizar</button>
                    <a href="listaAmigos.php">Volver a la lista de amigos</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Vista de editar amigo para usuarios normales
        $amigo = new Amigo();
        $amigo->id = $_GET['id'];
        $amigo->obtenerAmigo();

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Amigo</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Editar Amigo</h1>
                
                <form action="actualizarAmigo" method="post">
                    <input type="hidden" name="id" value="<?= $amigo->id ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value=" <?= $amigo["nombre"] ?>" required>
                    <br>
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" value="<?= $amigo["apellidos"] ?>" required>
                    <br>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" value="<?= $amigo["fecha_nac"] ?>" required>
                    <br>
                    <button type="submit">Actualizar</button>
                    <a href="listaAmigos.php">Volver a la lista de amigos</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    }
} else {
    // Si no hay sesión iniciada, redirige al usuario a la página de login
    header('Location: login.php');
    exit;
}
?>