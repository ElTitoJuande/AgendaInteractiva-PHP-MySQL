<main>
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
                <input type="hidden" name="id" value="<?= $juegos["id"] ?>">
                <label for="nombre">Título:</label>
                <input type="text" name="titulo" value="<?= $juegos["titulo"] ?>" required>
                <br>
                <label for="plataforma">Plataforma:</label>
                <input type="text" name="plataforma" value="<?= $juegos["plataforma"] ?>" required>
                <br>
                <label for="lanzamiento">Lanzamiento:</label>
                <input type="input" name="lanzamiento" value="<?= $juegos["lanzamiento"] ?>" required>
                <br>
                <label for="img">Imagen:</label>
                <input type="text" name="img" value="<?= $juegos["img"] ?>" required>
                <br>
                <button type="submit">Editar</button>
            </form>
            <form action="../Controlador/index.php?action=volverListaJuegos" method="post">
                    <button type="submit" class="btn">Volver a la lista de juegos</button>
            </form>
            
        </div>
    </body>
    </html>
</main>