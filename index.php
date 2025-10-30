<?php
require "config/conexion.php";
require "models/juegos.models.php";
require "models/categoria.models.php";

$conexion = conDB();

$juegos = getAllDestacados($conexion);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Galaxy | El Universo de Videojuegos</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="main-header">
        <div class="logo">
            <h1>Game Galaxy</h1>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="index.html" class="active">Inicio</a></li>
                <li><a href="categorias.php">Categorías</a></li>
                <li><a href="plataformas.php">Plataformas</a></li>
                <li><a href="contacto.html">Contacto</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <section class="hero">
            <h2>Descubre tu Próxima Aventura</h2>
            <p>Explora miles de títulos para PC, Consolas y Móviles.</p>
            <a href="videojuegos.php" class="btn-primary">Ver Catálogo Completo</a>
        </section>

        <section class="featured-games">
            <h3>Destacados de la Semana</h3>

            <?php while ($juego = mysqli_fetch_assoc($juegos)) { ?>

                <div class="game-card">
                    <div class="game-card-image-container">
                        <img src=" <?php echo $juego['imagen']; ?> " alt="Portada <?php echo $juego['titulo']; ?>">
                    </div>
                    <div class="game-card-info">
                        <h4><?php echo $juego['titulo']; ?></h4>
                        <p>Categoría: <?php
                                        $cats = getCatByVid($conexion, $juego['id_vid']);

                                        $categoria = [];
                                        while ($dato = mysqli_fetch_assoc($cats)) {
                                            $categoria[] = $dato['nombre'];
                                        }
                                        $dat = "";
                                        $total = count($categoria);
                                        $i = 0;
                                        foreach ($categoria as $value) {
                                            $i++;
                                            if ($total === $i) {
                                                $dat = $dat . $value . ".";
                                            } else {
                                                $dat = $dat . $value . ", ";
                                            }
                                        }
                                        unset($categoria);
                                        echo $dat;
                                        ?></p>
                        <p>Precio: <?php echo $juego['precio']; ?></p>
                        <a href="detalle.php?id=<?php echo $juego['id_vid']; ?>" class="btn-secondary">Ver Detalle</a>
                    </div>
                </div>

            <?php } ?>

        </section>

    </main>

    <footer>
        <p>&copy; 2025 Game Galaxy. Todos los derechos reservados.</p>
        <div class="footer-links">
            <a href="#">Términos y Condiciones</a> | <a href="#">Política de Privacidad</a>
        </div>
    </footer>

</body>

</html>