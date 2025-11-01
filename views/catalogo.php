<?php

require_once "../config/conexion.php";
require_once "../controllers/catalogo.controllers.php";

$con = conDB();

$juegos = procesarCatalogo($con);

$totales = count($juegos);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Galaxy | Catálogo de Videojuegos</title>
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
                <li><a href="/views/catalogo.php" class="active">Catálogo</a></li>
                <li><a href="contacto.html">Contacto</a></li>
                <li><a href="iniciarSesion.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <nav class="filter-nav-floating">
        <ul class="filter-list">

            <?php procesarFiltros($con); ?>

            <li class="filter-item">
                <a href="/views/catalogo.php" class="btn-clean">Limpiar Filtros</a>
            </li>

        </ul>
    </nav>

    <main>

        <section class="catalogo-header">
            <h2>Catálogo Completo</h2>
            <p>Mostrando <?php echo $totales; ?> juegos.</p>
        </section>

        <section class="featured-games full-catalogo">
            <?php foreach ($juegos as $juego) { ?>
                <div class="game-card">
                    <div class="game-card-image-container">
                        <img src="<?php echo $juego['imagen']; ?>" alt="Portada de <?php $juego['titulo']; ?>">
                    </div>
                    <div class="game-card-info">
                        <h4><?php echo $juego['titulo']; ?></h4>
                        <p>Categorías: <?php echo implode(', ', $juego['categorias']); ?></p>
                        <p>Precio: <?php echo $juego['precio']; ?></p>
                        <a href="detalle.php?<?php echo $juego['id_vid']; ?>" class="btn-secondary">Ver Detalle</a>
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

    <script>
        document.querySelectorAll('.dropdown-toggle').forEach(item => {
            item.addEventListener('click', () => {
                item.querySelector('.dropdown-menu').classList.toggle('show');
            });
        });
    </script>

</body>

</html>