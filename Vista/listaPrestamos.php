<main>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis Prestamos</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
            <h1>Mis Prestamos</h1>

            <div class="botones">
                <form action="index.php?action=redirigirBuscarPrestamo" method="post">
                        <button type="submit" class="btn">Buscar</button>
                    </form>
                    <form action="index.php?action=actualizarPrestamo" method="post">
                        <button type="submit" class="btn">Añadir nuevo préstamo</button>
                    </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Amigo</th>
                        <th>Juego</th>
                        <th>Fecha préstamo</th>
                        <th>Devuelto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($prestamos as $prestamo): ?>
                    <tr>
                        <td><?= $prestamo["amigo"] ?></td>
                        <td><?= $prestamo["juego"] ?></td> <!-- Teno que llamar a la imagen tb -->
                        <td><?= $prestamo["fecha_prestamo"] ?></td>
                        <td> <?php if($prestamo["devuelto"] == 0){
                            ?>
                            <form action="index.php?action=devolverPrestamos" method="post">
                            <input type="hidden" name="id" value="<?= $prestamo["id"] ?>">
                            <input type="submit" class="btn" value="Devolver">
                            </form>
                            <?php
                        }else{
                            ?>
                            <form action="index.php?action=devolverPrestamos" method="post">
                                <button value="<?= $prestamo["id"] ?>" disabled>Devuelto</button>
                            </form>
                            <?php
                        } ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>

</main>