<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Agenda</title>
</head>
<body>
    <header>
        <div>
            <img src="../img/logo1.png" alt="">
        </div>
        <div>
            
        </div>
        <?php
    if(isset($_REQUEST['action'])) {
        $action = strtolower( $_REQUEST['action']);
        if(strcmp($action,"login")!==0) {
            if(strcmp($_SESSION["tipo"], "admin") == 0) {
    ?>
                <div id="menu">
                    <h3>Agenda personal</h3>
                    <div>
                        <ul>
                            <li><a href="../Controlador/index.php?action=dashboard">AMIGOS</a></li>
                            <li><a href="../Controlador/index.php?action=listarUsuarios">USUARIOS</a></li>
                            <li><a href="../Controlador/index.php?action=salir">SALIR</a></li>
                        </ul>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div id="menu">
                    <h3>Agenda personal</h3>
                    <div>
                        <ul>
                            <li><a href="../Controlador/index.php?action=dashboard">AMIGOS</a></li>
                            <li><a href="../Controlador/index.php?action=listarJuegos">JUEGOS</a></li>
                            <li><a href="../Controlador/index.php?action=listarPrestamos">PRESTAMOS</a></li>
                            <li><a href="../Controlador/index.php?action=salir">SALIR</a></li>
                        </ul>
                    </div>
                </div>
            <?php
            }
        }
    }
    ?>

</header>