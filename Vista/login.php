<main>
    <section>
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="../Controlador/index.php?action=login">
            
            <?php if (isset($error)) echo "<div><?= $error ?></div>"?>
            
            <label for="nombre">Usuario</label>
            <input type="text" id="nombre" name="nombre" value=<?php if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"];?>>
            <br>
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <br>
            <label for="devuelto">Recuerdame:</label>
            <input type="checkbox" name="recuerdame" value="1">
            <br>
            <button type="submit" >Iniciar Sesión</button>
        </form>
    </section>
</main>