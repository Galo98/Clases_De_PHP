<?php 

    require "productos.php";


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>Game Galaxy</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php verCategorias(); ?>
        </tbody>
    </table>
</body>
</html>