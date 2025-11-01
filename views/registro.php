<?php
require_once "../config/conexion.php";
require_once "../controllers/registro.controllers.php";
$con = conDB();
$error = handleRegistro($con);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Galaxy | Registro de Usuario</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="main-header">
        <div class="logo">
            <h1>Game Galaxy</h1>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="iniciarSesion.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <div class="login-box registro-box">

            <h2>Crear Cuenta</h2>

            <?php
            if (isset($error)) {
                echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
            }
            ?>

            <form action="/views/registro.php" method="POST" class="registro-form">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required
                        placeholder="Ingresa tu nombre" class="form-control">
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" required
                        placeholder="Ingresa tu apellido" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                        placeholder="ejemplo@correo.com" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        placeholder="Mínimo 8 caracteres" class="form-control" minlength="8">
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirmar Contraseña</label>
                    <input type="password" id="password_confirm" name="password_confirm" required
                        placeholder="Repite tu contraseña" class="form-control" minlength="8">
                </div>

                <button type="submit" class="btn-primary login-btn">REGISTRARME</button>
            </form>

            <div class="login-links">
                <a href="iniciarSesion.php">¿Ya tienes una cuenta? Inicia Sesión</a>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Game Galaxy.</p>
    </footer>

</body>

</html>