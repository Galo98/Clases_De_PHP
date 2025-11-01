<?php

function getAllJuegos($conexion)
{

    $q = "SELECT * FROM videojuegos;";

    $juegos = mysqli_query($conexion, $q);

    return $juegos;
}

function getAllDestacados($conexion)
{

    $q = "SELECT id_vid, titulo, precio, imagen from videojuegos where destacado = true";

    $juegos = mysqli_query($conexion, $q);

    return $juegos;
}

// Traer juegos y sus categorias

function getAllDestYCats($conexion): array
{

    $q = "SELECT v.id_vid, v.titulo, v.precio, v.imagen, cat.nombre as cat_nombre FROM videojuegos v INNER JOIN videojuegos_categorias vc ON v.id_vid = vc.videojuego_id INNER JOIN categorias cat ON vc.categoria_id = cat.id_cat ORDER BY v.id_vid;";

    // Defino un array vacio, que va a contener los juegos y sus categorias de forma asociativa
    $destacados = [];

    $resultado = mysqli_query($conexion, $q);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $destacados[] = $fila;
        }

        mysqli_free_result($resultado);
    }

    return array_values($destacados);
}

function getJuegoById($conexion, $id)
{

    $q = "SELECT * FROM videojuegos where id_vid = $id";

    $juego = mysqli_query($conexion, $q);

    return $juego;
}

// Para buscar con filtros, tal vez no se apliquen los dos a la vez, por lo tanto, tenemos que indicar que los parametros pueden ser nulos
// Esto se hace anteponiendo ? al tipo de dato que acepta nuestra funcion.
// Además, como los filtros son numeros enteros, también establecemos que el tipo de dato de los parametros sea entero.

function getJuegosConFiltros($con, ?int $cat_id, ?int $plat_id): array
{

    // Usamos sentencias preparadas para seguridad, aunque solo filtremos por ID
    $sql = "
        SELECT 
            v.id_vid, v.titulo, v.precio, v.imagen, cat.nombre AS categoria_nombre
        FROM 
            videojuegos v
        INNER JOIN videojuegos_categorias vc ON v.id_vid = vc.videojuego_id
        INNER JOIN categorias cat ON vc.categoria_id = cat.id_cat
        WHERE 1=1 ";

    // Se agrega el filtro por categoria si es distinto de nulo
    if ($cat_id !== null) {
        $sql .= " AND vc.categoria_id = $cat_id";
    }
    // Se agrega el filtro por plataforma si es distinto de nulo
    if ($plat_id !== null) {
        $sql .= " AND v.id_vid IN (SELECT videojuego_id FROM videojuegos_plataformas WHERE plataforma_id = $plat_id)";
    }
    // Si esta vacio, se ejecuta la consulta sin filtros, pero si hay filtros se aplican en la consulta.
    if (empty($parametros)) {
        $resultado = mysqli_query($con, $sql);
    } else {
        $resultado = mysqli_query($con, $sql);
    }

    $videojuegos_planos = [];
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $videojuegos_planos[] = $fila;
        }
        mysqli_free_result($resultado);
    }

    return $videojuegos_planos;
}
