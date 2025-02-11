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

                <form action="index.php?action=agregarPrestamo" method="post" enctype='multipart/form-data'>
                <input type="hidden" name="id" value="<?= $prestamo["id"] ?>">
                <label for="nombre">Amigo:</label>
                    <select name="amigo_id">
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
                    <select name="juego_id">
                        <?php
                        foreach ($juegos as $juego) {   
                        ?>
                            <option value="<?= $juego["id"] ?>"><?= $juego["titulo"] ?></option>
                       <?php 
                            }
                        ?>
                    </select>
                <br>
                <label for="fecha_prestamo">Fecha préstamo:</label>
                <input type="date" name="fecha_prestamo" value="<?= $prestamo["fecha_prestamo"] ?>" required>
                <br>
                <input type="hidden" name="devuelto" value="0" required>
                <button type="submit">Guardar</button>
            </form>
            <form action="../Controlador/index.php?action=volverListaprestamos" method="post">
                    <button type="submit" class="btn">Volver a la lista de prestamos</button>
            </form>
            </div>
        </body>
        </html>

</main>