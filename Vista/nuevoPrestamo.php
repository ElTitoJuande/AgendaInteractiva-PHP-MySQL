<main>

<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Nuevo Prestamo</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Añadir Nuevo Prestamo</h1>

                <form action="index.php?action=actualizarPrestamo" method="post" enctype='multipart/form-data'>
                <input type="hidden" name="prestamo.id" value="<?= $_POST["id"] ?>">
                <label for="amigos.nombre">Amigo:</label>
                    <select name="id">
                        <?php
                        foreach ($amigos as $amigo) {
                        ?>
                            <option value="<?= $amigo["id"] ?>"><?= $amigo["nombre"] ?></option>
                       <?php 
                            }
                        ?>
                    </select>
                    <br>
                <label for="nombre">Juego:</label>
                <select name="id">
                        <?php
                        foreach ($juegos as $juego) {   
                        ?>
                            <option value="<?= $juego["id"] ?>"><?= $juego["nombre"] ?></option>
                       <?php 
                            }
                        ?>
                    </select>
                <input type="text" name="titulo" value="<?= $prestamos["titulo"] ?>" required>
                <input type="file" name="img" value="<?= $prestamos["img"] ?>" required>
                <br>
                <label for="fecha_prestamo">Fecha préstamo:</label>
                <input type="input" name="fecha_prestamo" value="<?= $prestamos["fecha_prestamo"] ?>" required>
                <br>
                <button type="submit">Editar</button>
            </form>
            <form action="../Controlador/index.php?action=volverListaprestamos" method="post">
                    <button type="submit" class="btn">Volver a la lista de prestamos</button>
            </form>
            </div>
        </body>
        </html>

</main>