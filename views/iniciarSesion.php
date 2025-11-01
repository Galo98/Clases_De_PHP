<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Galaxy | Iniciar Sesión</title>
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
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <div class="login-box">

            <h2>Iniciar Sesión</h2>

            <?php
            //if (isset($_GET['error'])) {
            //    echo '<p class="error-message">' . htmlspecialchars('Registro exitoso') . '</p>';
            //}
            if (isset($_GET['registro'])) {
                echo '<p class="success-message">' . htmlspecialchars('Registro exitoso') . '</p>';
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