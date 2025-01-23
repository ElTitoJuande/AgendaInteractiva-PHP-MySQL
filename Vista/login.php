<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body >
    
    <h2>Agenda Personal</h2>
        <form method="POST" action="../Controlador/index.php?action=login">
           

            <?php if (isset($error)) echo "<div><?= $error ?></div>"?>

            
                <label for="nombre">Usuario</label>
                <input type="text" id="nombre" name="nombre" required>
            

            
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>
            

            <button type="submit" >Iniciar Sesión</button>
        </form>

</body>
</html>