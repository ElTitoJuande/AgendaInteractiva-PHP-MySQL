<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Nuevo Usuario (Administrador)</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Añadir Nuevo Usuario (Administrador)</h1>

                <form action="../Controlador/index.php?action=agregarUsuarioAdmin" method="post">
                    <div class="form-grupo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-grupo">
                        <label for="contrasena">Contraseña:</label>
                        <input type="text" id="contrasena" name="contrasena" required>
                    </div>
                    <button type="submit" class="btn">Guardar Usuario</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaUsuarios" method="post">
                        <button type="submit" class="btn">Volver a la lista de Usuarios</button>
                    </form>
            </div>
        </body>
        </html>