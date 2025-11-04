<?php

session_start();

require_once "../config/conexion.php";
require_once "../controllers/iniciarSesion.controllers.php";

$con = conDB();
$error = handleInicioUsuario($con);

if (isset($_GET['registro'])) {
    $success = $_GET['registro'];
}


if (isset($_GET['c']) && $_GET['c'] === 'exitoso') {
    $success = "Se ha cerrado sesion";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Galaxy | Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <?php
    if (isset($_SESSION['user_rol']) && !isset($_GET['c'])) {
        $success = "Ya se ha iniciado sesión, redirigiendo ...";
    ?>
        <!-- Con esta etiqueta, logramos que se cargue la página y luego de 1 segundo, se haga la redirección al index. -->
        <meta http-equiv="refresh" content="2; url=../index.php">
    <?php } ?>

</head>

<body>

    <header class="main-header">
        <div class="logo">
            <h1>Game Galaxy</h1>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="../index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <div class="login-box">

            <h2>Iniciar Sesión</h2>

            <?php
            if (isset($error) and $error == "c") {
                echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
            }
            if (isset($success)) {
                echo '<p class="success-message">' . htmlspecialchars($success) . '</p>';
            }

            ?>

            <form action="iniciarSesion.php" method="POST" class="login-form">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                        placeholder="ejemplo@correo.com" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        placeholder="Ingresa tu contraseña" class="form-control">
                </div>

                <button type="submit" class="btn-primary login-btn">ACCEDER</button>
            </form>

            <div class="login-links">
                <a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a>
                <span class="separator">|</span>
                <a href="registro.php">¿No tienes cuenta?</a>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Game Galaxy.</p>
    </footer>

</body>

</html>