<?php
session_start();
require_once('../modelos/Juego.php');

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$juegos = Juego::listarPorUsuario($_SESSION['usuario_id'], $busqueda);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Juegos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mis Juegos</h1>
        
        <form method="get" class="busqueda">
            <input type="text" name="busqueda" placeholder="Buscar juegos" value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit">Buscar</button>
        </form>

        <a href="nuevo_juego.php" class="btn">Añadir Nuevo Juego</a>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Plataforma</th>
                    <th>Año</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($juegos as $juego): ?>
                <tr>
                    <td><?= htmlspecialchars($juego->titulo) ?></td>
                    <td><?= htmlspecialchars($juego->plataforma) ?></td>
                    <td><?= htmlspecialchars($juego->lanzamiento) ?></td>
                    <td>
                        <?php if($juego->img): ?>
                            <img src="<?= htmlspecialchars($juego->img) ?>" alt="Portada" width="50">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editar_juego.php?id=<?= $juego->id ?>">Editar</a>
                        <a href="eliminar_juego.php?id=<?= $juego->id ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>