<?php

session_start();

if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] != 1) {
    header('Location: ../index.php');
}

require_once "../config/conexion.php";
require_once "../controllers/alta.controllers.php";
require_once "../controllers/catalogo.controllers.php";

$con = conDb();

$mensaje = handleAltaJuegos($con);
$plataformas = getAllPlat($con);
$categorias = getAllCat($con);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Galaxy Admin | Alta de Videojuegos</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght=400;700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="main-header">
        <div class="logo">
            <h1>Game Galaxy</h1>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="altaJuegos.php" class="active">Productos</a></li>
                <li><a href="cerrarSession.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="admin-container">
        <div class="admin-box">

            <h2>Registro de Nuevo Videojuego</h2>

            <?php
            if (isset($mensaje) && $mensaje !== "cargado") {
                echo '<p class="mensaje-message">' . htmlspecialchars($mensaje) . '</p>';
            } else if (isset($mensaje) && $mensaje == "cargado") {
                echo '<p class="success-message">' . htmlspecialchars("Juego cargado exitosamente!") . '</p>';
            }
            var_dump($mensaje);
            ?>

            <form action="altaJuegos.php" method="POST" enctype="multipart/form-data" class="admin-form">
                
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Ej: Cyberpunk 2077" class="form-control">
                </div>
                <div class="form-group">
                    <label for="desarrollador">Desarrollador</label>
                    <input type="text" id="desarrollador" name="desarrollador" required placeholder="Ej: CD Projekt RED" class="form-control">
                </div>
                <div class="form-group">
                    <label for="precio">Precio ($)</label>
                    <input type="number" step="0.01" min="0" id="precio" name="precio" required placeholder="49.99" class="form-control">
                </div>

                <div class="form-row">
                    <div class="form-group col-50">
                        <label for="formato">Formato</label>
                        <select id="formato" name="formato" required class="form-control">
                            <option value="">Seleccione formato</option>
                            <option value="Digital">Digital</option>
                            <option value="Físico">Físico</option>
                        </select>
                    </div>

                    <div class="form-group col-50">
                        <label for="lanzamiento">Fecha de Lanzamiento</label>
                        <input type="date" id="lanzamiento" name="lanzamiento" required class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-50">
                        <label for="requisitos">Set de Requisitos</label>
                        <select id="requisitos" name="requisitos" required class="form-control">
                            <option value="">-- Seleccione un set de requisitos --</option>
                            <option value="1">Requisitos Básicos</option>
                            <option value="2">Requisitos Medios</option>
                            <option value="3">Requisitos Altos</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-50">
                        <label for="stock">Stock Inicial</label>
                        <input type="number" min="0" id="stock" name="stock" required placeholder="0" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-50">
                        <label for="categorias">Categorías</label>
                        <select id="categorias" name="categorias[]" multiple required class="form-control select-multiple">
                            <?php while ($categoria = mysqli_fetch_array($categorias)) {?>
                                <option value="<?php echo $categoria[0]; ?>"> <?php echo $categoria[1]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-50">
                        <label for="plataformas">Plataformas</label>
                        <select id="plataformas" name="plataformas[]" multiple required class="form-control select-multiple">
                            <?php while ($plataforma = mysqli_fetch_array($plataformas)) {?>
                                <option value="<?php echo $plataforma[0]; ?>"> <?php echo $plataforma[1]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row form-row-checks">
                    <div class="form-group col-auto checkbox-group">
                        <input type="checkbox" id="microtran" name="microtran" value="1">
                        <label for="microtran">Contiene Microtransacciones</label>
                    </div>

                    <div class="form-group col-auto checkbox-group">
                        <input type="checkbox" id="destacado" name="destacado" value="1">
                        <label for="destacado">Marcar como Destacado</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="imagen">Portada del Juego</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required class="form-control-file">
                </div>

                <button type="submit" class="btn-primary admin-btn">GUARDAR VIDEOJUEGO</button>
            </form>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Game Galaxy Admin.</p>
    </footer>

</body>

</html>