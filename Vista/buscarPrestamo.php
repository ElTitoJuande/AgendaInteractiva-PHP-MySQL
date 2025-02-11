<main>

<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Gestión de Préstamos</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Mis Prestamos</h1>

                <div class="botones">
                    <form action="index.php?action=buscarPrestamo" method="post">
                        <input type="text" name="busqueda" placeholder="Buscar Prestamos" value="<?php $busqueda?>">
                         <button type="submit">Buscar</button>
                     </form>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Amigo</th>
                            <th>Juego</th>
                            <th>Fecha préstamo</th>
                            <th>Devuelto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($prestamos as $prestamo): ?>
                        <tr>
                            <td><?= $prestamo["amigo"] ?></td>
                            <td><?= $prestamo["juego"] ?></td>
                            <td><?= $prestamo["fecha_prestamo"] ?></td>
                            <td><?= $prestamo["devuelto"] ?></td>
                            <td> 
                            <form action="index.php?action=editarPrestamos" method="post">
                                <input type="hidden" name="id" value="<?= $prestamo["id"] ?>">
                                <input type="submit" class="btn" value="Editar">
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