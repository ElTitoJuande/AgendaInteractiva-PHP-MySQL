<main>
<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Usuario</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Editar Usuario</h1>
                
                <form action="index.php?action=actualizarUsuario" method="post">
                    <input type="hidden" name="id_Usuario" value="<?= $usuarios["id"] ?>">  
                    <input type="hidden" name="tipo" value="<?= $usuarios["tipo"] ?>">
                    
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?= $usuarios["nombre"] ?>" required>
                    <br>
                    <label for="propietario">Contraseña:</label>
                    <input type="password" name="contrasena" value="<?= $usuarios["contrasena"] ?>" required>
                    <br>
                    <button type="submit" class="btn">Editar</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaUsuarios" method="post">
                        <button type="submit" class="btn">Volver a la lista de Usuarios</button>
                    </form>
            </div>
        </body>
        </html>
</main>