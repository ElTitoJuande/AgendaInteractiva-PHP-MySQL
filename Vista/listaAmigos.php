<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Amigos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mis Amigos</h1>
        
        <form action="index.php?action=nuevoAmigo" method="get" class="busqueda">
            <input type="text" name="busqueda" placeholder="Buscar amigos" value="<?= $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : ''?>">
            <button type="submit">Buscar</button>
            <a href="../Vista/nuevoAmigo.php">Añadir nuevo amigo</a>
        </form>


        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Fecha Nacimiento</th>
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
                        <form action="../Vista/editarAmigo.php?id=<?= $amigo["id"] ?>" method="get">
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