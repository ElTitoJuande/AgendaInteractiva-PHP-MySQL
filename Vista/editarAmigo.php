<main>
<?php
// Verifica si el usuario tiene una sesión iniciada
if (isset($_SESSION['usuario_id'])) {

    // Verifica si el usuario es administrador
    if (strcmp($_SESSION["tipo"], "admin") == 0) {

        // var_dump($_POST['id']);
        $amigo = new Amigo();
        $amigo->id = $_POST['id'];
        // $amigo->buscarAmigoPorId($id);
        $amigoDatos = $amigo->buscarAmigoPorId($amigo->id);

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
                
                <form action="index.php?action=actualizarAmigo" method="post">
                    <input type="hidden" name="id" value="<?= $amigoDatos["id"] ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?= $amigoDatos["nombre"] ?>" required>
                    <br>
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellidos" value="<?= $amigoDatos["apellidos"] ?>" required>
                    <br>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nac" value="<?= $amigoDatos["fecha_nac"] ?>" required>
                    <br>
                    <button type="submit">Editar</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaAmigos" method="post">
                        <button type="submit" class="btn">Volver a la lista de amigos</button>
                    </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Vista de editar amigo para usuarios normales
        // var_dump($_POST['id']);

        $amigo = new Amigo();
        $amigo->id = $_POST['id'];
        // $amigo->buscarAmigoPorId($id);
        $amigoDatos = $amigo->buscarAmigoPorId($amigo->id);

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
                
                <form action="index.php?action=actualizarAmigo" method="post">
                    <input type="hidden" name="id" value="<?= $amigoDatos["id"] ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?= $amigoDatos["nombre"] ?>" required>
                    <br>
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellidos" value="<?= $amigoDatos["apellidos"] ?>" required>
                    <br>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nac" value="<?= $amigoDatos["fecha_nac"] ?>" required>
                    <br>
                    <button type="submit">Editar</button>
                    </form>
                    <form action="../Controlador/index.php?action=volverListaAmigos" method="post">
                        <button type="submit" class="btn">Volver a la lista de amigos</button>
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
</main>