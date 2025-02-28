<main>
<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Gestión de usuarios (Administrador)</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="container">
                <h1>Mis usuarios</h1>

                <div class="botones">
                    <form action="index.php?action=redirigirBuscarUsuario" method="post">
                         <button type="submit" class="btn">Buscar</button>
                     </form>
                     <form action="index.php?action=redirigirNuevoUsuario" method="post">
                         <button type="submit" class="btn">Añadir nuevo contacto</button>
                     </form>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Contraseña</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario["id"] ?></td>
                                <td><?= $usuario["nombre"] ?></td>
                                <?php
                                for($i = 0; $i < strlen($usuario["contrasena"]); $i++){
                                    $usuario["contrasena"] = str_repeat("*", strlen($usuario["contrasena"]));
                                }?>
                                <td><?= $usuario["contrasena"] ?></td>
                                <td>
                            <form action="index.php?action=editarUsuario" method="post">
                                <input type="hidden" name="id" value="<?= $usuario["id"] ?>">
                                <input type="hidden" name="nombreUsu" value="<?=$usuario["id"]?>">
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
        </main>