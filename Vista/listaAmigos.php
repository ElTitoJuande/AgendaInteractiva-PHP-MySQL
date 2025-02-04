<main>

<?php
// Verifica si el usuario tiene una sesión iniciada
if (isset($_SESSION['usuario_id'])) {
    
    // Verifica si el usuario es administrador
    if (strcmp($_SESSION["tipo"], "admin") == 0) {
        // Vista de lista de amigos para administradores
        var_dump($amigos);
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Gestión de Amigos (Administrador)</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Mis Amigos - Contactos (Administrador)</h1>

                <form action="index.php?action=buscarAmigoAdmin" method="post" class="busqueda">
                    <input type="text" name="busqueda" placeholder="Buscar amigos" value="<?php $busqueda?>">
                    <button type="submit">Buscar</button>
                    <a href="../Vista/nuevoAmigo.php">Añadir nuevo amigo</a>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Propietario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($amigos as $amigo): ?>
                        <tr>
                            <td><?= $amigo["nombre"] ?></td>
                            <td><?= $amigo["apellidos"] ?></td>
                            <td><?= $amigo["fecha_nac"] ?></td>
                            <td><?= $amigo["usuario"] ?></td>
                            <td> 
                            <form action="index.php?action=editarAmigoAdmin" method="post">
                                <input type="hidden" name="id" value="<?= $amigo["id"] ?>">
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
        <?php
    } else {
        // Vista de lista de amigos para usuarios normales
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Mis Amigos</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Mis Amigos</h1>
                
                <form action="index.php?action=buscarAmigo" method="post" class="busqueda">
                    <input type="text" name="busqueda" placeholder="Buscar amigos" value="<?php $busqueda?>">
                    <button type="submit">Buscar</button>
                    <a href="../Vista/nuevoAmigo.php">Añadir nuevo amigo</a>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($amigos as $amigo): ?>
                        <tr>
                            <td><?= $amigo["nombre"] ?></td>
                            <td><?= $amigo["apellidos"] ?></td>
                            <td><?= $amigo["fecha_nac"] ?></td>
                            <td> 
                            <form action="index.php?action=editarAmigo" method="post">
                                <input type="hidden" name="id" value="<?= $amigo["id"] ?>">
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
        <?php
    }
}
?>

</main>