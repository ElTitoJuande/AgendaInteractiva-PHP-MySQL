<?php
session_start();
require_once('../modelo/Prestamo.php');

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$mostrarActivos = isset($_GET['activos']) ? true : false;
$prestamos = Prestamo::listarPorUsuario($_SESSION['usuario_id'], $busqueda, $mostrarActivos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Préstamos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mis Préstamos</h1>
        
        <form method="get" class="busqueda">
            <input type="text" name="busqueda" placeholder="Buscar préstamos" value="<?= htmlspecialchars($busqueda) ?>">
            <label>
                <input type="checkbox" name="activos" <?= $mostrarActivos ? 'checked' : '' ?>> 
                Solo préstamos activos
            </label>
            <button type="submit">Buscar</button>
        </form>

        <a href="nuevo_prestamo.php" class="btn">Nuevo Préstamo</a>

        <table>
            <thead>
                <tr>
                    <th>Amigo</th>
                    <th>Juego</th>
                    <th>Fecha Préstamo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($prestamos as $prestamo): ?>
                <tr>
                    <td><?= htmlspecialchars($prestamo->nombre_amigo) ?></td>
                    <td><?= htmlspecialchars($prestamo->titulo_juego) ?></td>
                    <td><?= htmlspecialchars($prestamo->fecha_prestamo) ?></td>
                    <td><?= $prestamo->devuelto ? 'Devuelto' : 'Pendiente' ?></td>
                    <td>
                        <?php if(!$prestamo->devuelto): ?>
                            <a href="devolver_prestamo.php?id=<?= $prestamo->id ?>">Marcar como Devuelto</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>