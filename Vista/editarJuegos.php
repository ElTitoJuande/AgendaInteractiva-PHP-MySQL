<main>
<?php
// Verifica si el usuario tiene una sesión iniciada
if (isset($_SESSION['usuario_id'])) {

    // Verifica si el usuario es administrador
    if (strcmp($_SESSION["tipo"], "admin") == 0) {

        // var_dump($_POST['id']);
        $juego = new Juego();
        $juego->id = $_POST['id'];
        $juegoDatos = $juego->buscarJuegoPorId($juego->id);

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Juego (Administrador)</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Editar Juego (Administrador)</h1>
                
                <form action="index.php?action=actualizarJuego" method="post">
                    <input type="hidden" name="id" value="<?= $juegoDatos["id"] ?>">
                    <label for="nombre">Título:</label>
                    <input type="text" name="titulo" value="<?= $juegoDatos["titulo"] ?>" required>
                    <br>
                    <label for="plataforma">Plataforma:</label>
                    <input type="text" name="plataforma" value="<?= $juegoDatos["plataforma"] ?>" required>
                    <br>
                    <label for="lanzamiento">Lanzamiento:</label>
                    <input type="date" name="lanzamiento" value="<?= $juegoDatos["lanzamiento"] ?>" required>
                    <br>
                    <label for="img">Imagen:</label>
                    <input type="text" name="img" value="<?= $juegoDatos["img"] ?>" required>
                    <br>
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" value="<?= $juegoDatos["usuario"] ?>" required>
                    <br>
                    <button type="submit">Editar</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaJuegos" method="post">
                        <button type="submit" class="btn">Volver a la lista de juegos</button>
                </form>
                
            </div>
        </body>
        </html>
        <?php
    } else {
        // Vista de editar juego para usuarios normales
        // var_dump($_POST['id']);

        $juego = new Juego();
        $juego->id = $_POST['id'];
        $juegoDatos = $juego->buscarJuegoPorId($juego->id);

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Juego</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Editar Juego</h1>
                
                <form action="index.php?action=actualizarJuego" method="post">
                    <input type="hidden" name="id" value="<?= $juegoDatos["id"] ?>">
                    <label for="nombre">Título:</label>
                    <input type="text" name="titulo" value="<?= $juegoDatos["titulo"] ?>" required>
                    <br>
                    <label for="plataforma">Plataforma:</label>
                    <input type="text" name="plataforma" value="<?= $juegoDatos["plataforma"] ?>" required>
                    <br>
                    <label for="lanzamiento">Lanzamiento:</label>
                    <input type="date" name="lanzamiento" value="<?= $juegoDatos["lanzamiento"] ?>" required>
                    <br>
                    <label for="img">Imagen:</label>
                    <input type="text" name="img" value="<?= $juegoDatos["img"] ?>" required>
                    <br>
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" value="<?= $juegoDatos["usuario"] ?>" required>
                    <br>
                    <button type="submit">Editar</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaJuegos" method="post">
                        <button type="submit" class="btn">Volver a la lista de juegos</button>
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