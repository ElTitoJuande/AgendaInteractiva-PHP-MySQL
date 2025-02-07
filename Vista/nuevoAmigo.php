 <?php
        session_start();
// Verifica si el usuario tiene una sesión iniciada
// var_dump($_SESSION['usuario_id']);
if (isset($_SESSION['usuario_id'])) {
    
    // Verifica si el usuario es administrador
    if (strcmp($_SESSION["tipo"], "admin") == 0) {
        
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Nuevo Amigo (Administrador)</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Añadir Nuevo Amigo (Administrador)</h1>

                <form action="../Controlador/index.php?action=agregarAmigoAdmin" method="post">
                    <div class="form-grupo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-grupo">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="form-grupo">
                        <label for="fecha_nac">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nac" name="fecha_nac" required>
                    </div>
                    <button type="submit" class="btn">Guardar Amigo</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaAmigos" method="post">
                        <button type="submit" class="btn">Volver a la lista de amigos</button>
                    </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Vista para usuarios normales
        ?>
        
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Nuevo Amigo</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Añadir Nuevo Amigo</h1>

                <form action="../Controlador/index.php?action=agregarAmigo" method="post">
                    <div class="form-grupo">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-grupo">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" required>
                    </div>

                    <div class="form-grupo">
                        <label for="fecha_nac">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nac" name="fecha_nac" required>
                    </div>

                    <button type="submit" class="btn">Guardar Amigo</button>
                </form>
                <form action="../Controlador/index.php?action=volverListaAmigos" method="post">
                        <button type="submit" class="btn">Volver a la lista de amigos</button>
                    </form>
            </div>
        </body>
        </html>
        <?php
    }
}
?>