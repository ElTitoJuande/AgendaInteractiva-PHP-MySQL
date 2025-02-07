<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Usuario (Administrador)</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Editar Usuario (Administrador)</h1>
                
                <form action="index.php?action=actualizarUsuarioAdmin" method="post">
                    <input type="hidden" name="id_Usuario" value="<?= $usuarios["id"] ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?= $usuarios["nombre"] ?>" required>
                    <br>
                    <label for="propietario">Contrasena:</label>
                    <input type="text" name="contrasena" value="<?= $usuarios["contrasena"] ?>" required>
                    <br>
                    <button type="submit">Editar</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaUsuarios" method="post">
                        <button type="submit" class="btn">Volver a la lista de Usuarios</button>
                    </form>
            </div>
        </body>
        </html>