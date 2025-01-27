<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Amigo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Amigo</h1>

        <form method="post">
            <div class="form-grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value=" <?= $amigo["nombre"] ?>" required>
            </div>

            <div class="form-grupo">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="<?= $amigo["apellidos"] ?>" required>
            </div>

            <div class="form-grupo">
                <label for="fecha_nac">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nac" name="fecha_nac" value="<?= $amigo["fecha_nac"] ?>" required>
            </div>

            <button type="submit" class="btn">Actualizar Amigo</button>
            <a href="listaAmigos.php" class="btn btn-secundario">Cancelar</a>
        </form>
    </div>
</body>
</html>