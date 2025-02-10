<main class="login-container">
    <section class="login-box">
        <h2>Iniciar Sesión</h2>
        
        <?php if (isset($error)) : ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="../Controlador/index.php?action=login">
            
            <label for="nombre">Usuario</label>
            <input type="text" id="nombre" name="nombre" 
                   value="<?= isset($_COOKIE["usuario"]) ? $_COOKIE["usuario"] : '' ?>" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <div class="remember-me">
                <input type="checkbox" id="recuerdame" name="recuerdame" value="1" <?= isset($_COOKIE["recuerdame"]) ? 'checked' : '' ?>>
                <label for="recuerdame">Recuérdame</label>
            </div>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </section>
</main>
