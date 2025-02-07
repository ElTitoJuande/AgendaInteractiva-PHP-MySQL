<main>

<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis Juegos</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
            <h1>Mis Juegos</h1>
            
            <div class="botones">
                <form action="index.php?action=buscarJuego" method="post">
                    <input type="text" name="busqueda" placeholder="Buscar juegos" value="<?php $busqueda?>">
                        <button type="submit">Buscar</button>
                    </form>
                    <a href="../Vista/nuevoJuegos.php">Añadir nuevo juego</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Plataforma</th>
                        <th>lanzamiento</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($juegos as $juego): ?>
                    <tr>
                        <td><?= $juego["titulo"] ?></td>
                        <td><?= $juego["plataforma"] ?></td>
                        <td><?= $juego["lanzamiento"] ?></td>
                        <td><img src="../img/<?= $juego["img"]?>" class="imgJuego"></td>
                        <td> 
                        <form action="index.php?action=editarJuegos" method="post">
                            <input type="hidden" name="id" value="<?= $juego["id"] ?>">
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