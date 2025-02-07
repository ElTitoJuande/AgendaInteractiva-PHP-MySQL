<main>

<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Nuevo Juego</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Añadir Nuevo Juego</h1>

                <form action="../Controlador/index.php?action=agregarJuego" method="post">
                    <div class="form-grupo">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" required>
                    </div>

                    <div class="form-grupo">
                        <label for="plataforma">Plataforma:</label>
                        <input type="text" id="plataforma" name="plataforma" required>
                    </div>

                    <div class="form-grupo">
                        <label for="lanzamiento">Fecha de Nacimiento:</label>
                        <input type="date" id="lanzamiento" name="lanzamiento" required>
                    </div>

                    <div class="form-grupo">
                        <label for="img">Imagen:</label>
                        <input type="file" id="img" name="img" required>
                    </div>

                    <button type="submit" class="btn">Guardar juego</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaJuegos" method="post">
                        <button type="submit" class="btn">Volver a la lista de juegos</button>
                    </form>
            </div>
        </body>
        </html>

</main>