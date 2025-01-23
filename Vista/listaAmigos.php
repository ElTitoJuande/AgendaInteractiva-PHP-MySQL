<?php
session_start();
require_once('../modelos/Amigo.php');

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$amigos = Amigo::listarPorUsuario($_SESSION['usuario_id'], $busqueda);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Amigos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mis Amigos</h1>
        
        <form method="get" class="busqueda">
            <input type="text" name="busqueda" placeholder="Buscar amigos" value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit">Buscar</button>
        </form>

        <a href="nuevo_amigo.php" class="btn">Añadir Nuevo Amigo</a>

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
                    <td><?= htmlspecialchars($amigo->nombre) ?></td>
                    <td><?= htmlspecialchars($amigo->apellidos) ?></td>
                    <td><?= htmlspecialchars($amigo->fecha_nac) ?></td>
                    <td>
                        <a href="editar_amigo.php?id=<?= $amigo->id ?>">Editar</a>
                        <a href="eliminar_amigo.php?id=<?= $amigo->id ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>