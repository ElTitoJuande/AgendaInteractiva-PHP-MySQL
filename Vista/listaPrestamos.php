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
            
            <form action="index.php?action=redirigirBuscarPrestamo" method="post">
                <button type="submit">Buscar</button>
            </form>
                <a href="../Controlador/index.php?action=redirigirNuevoPrestamo">Añadir nuevo préstamo</a>
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
                        <td><?= $prestamo["juego"] ?></td>
                        <td><?= $prestamo["fecha_prestamo"] ?></td>
                        <td> 
                        <form action="index.php?action=devolverPrestamo" method="post">
                            <input type="hidden" name="id" value="<?= $prestamo["devuelto"] ?>">
                            <input type="submit" class="btn" value="Devolver">
                        </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>

</main>