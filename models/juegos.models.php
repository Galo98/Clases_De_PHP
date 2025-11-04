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
            v.id_vid, v.titulo, v.precio, v.imagen, cat.nombre AS cat_nombre
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

function cargarVideojuego($con, string $titulo, string $desarrollador, float $precio, string $formato, int $microtran, int $requisitos, string $lanzamiento, int $stock, int $destacado): int|bool
{

    $sql = "INSERT INTO videojuegos (titulo, desarrollador, precio, formato, microtran, requisitos, lanzamiento, stock, destacado, fec_alta) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $insert = mysqli_prepare($con, $sql);

    if (!$insert) {
        error_log("Error preparando INSERT de videojuego: " . mysqli_error($con));
        return false;
    }

    // vincula parámetros: s=string, s=string, d=double (para el precio float)
    mysqli_stmt_bind_param($insert, "ssdsiisii", $titulo, $desarrollador, $precio, $formato, $microtran, $requisitos, $lanzamiento, $stock, $destacado);

    if (mysqli_stmt_execute($insert)) {
        $insert_id = mysqli_insert_id($con);
        mysqli_stmt_close($insert);
        return $insert_id;
    } else {
        error_log("Error al ejecutar el INSERT de videojuego: " . mysqli_stmt_error($insert));
        mysqli_stmt_close($insert);
        return false;
    }
}


function cargarVideojuegosCategorias($con, int $producto_id, array $categorias): bool
{

    if (empty($categorias)) {
        return true;
    }

    $sql = "INSERT INTO videojuegos_categorias (videojuego_id, categoria_id) VALUES (?, ?)";
    $insert = mysqli_prepare($con, $sql);

    if (!$insert) {
        error_log("Error preparando INSERT de categorías: " . mysqli_error($con));
        return false;
    }

    // Vinculamos los parámetros: i=integer (videojuego_id), i=integer (categoria_id)
    mysqli_stmt_bind_param($insert, "ii", $v_id, $c_id);

    $success = true;

    foreach ($categorias as $categoria_id) {
        $v_id = $producto_id;
        $c_id = (int)$categoria_id; // nos aseguramos de que el id sea entero

        if (!mysqli_stmt_execute($insert)) {
            error_log("Fallo al insertar categoría $c_id para videojuego $v_id: " . mysqli_stmt_error($insert));
            $success = false;
        }
    }

    mysqli_stmt_close($insert);
    return $success;
}

function cargarVideojuegosPlataformas($con, int $producto_id, array $plataformas): bool
{

    if (empty($plataformas)) {
        return true;
    }

    $sql = "INSERT INTO videojuegos_plataformas (videojuego_id, plataforma_id) VALUES (?, ?)";
    $insert = mysqli_prepare($con, $sql);

    if (!$insert) {
        error_log("Error preparando INSERT de plataformas: " . mysqli_error($con));
        return false;
    }

    // Vinculamos los parámetros: i=integer (videojuego_id), i=integer (plataforma_id)
    mysqli_stmt_bind_param($insert, "ii", $v_id, $p_id);

    $success = true;

    foreach ($plataformas as $plataforma_id) {
        $v_id = $producto_id;
        $p_id = (int)$plataforma_id; // nos aseguramos de que el id sea entero

        if (!mysqli_stmt_execute($insert)) {
            error_log("Fallo al insertar plataforma $p_id para videojuego $v_id: " . mysqli_stmt_error($insert));
            $success = false;
        }
    }

    mysqli_stmt_close($insert);
    return $success;
}

function actualizarImagen($con, int $juego_id, string $ruta): bool
{

    $sql = "UPDATE videojuegos SET imagen = ? WHERE id_vid = ?;";

    $update = mysqli_prepare($con, $sql);

    if (!$update) {
        error_log("Error preparando UPDATE de videojuego: " . mysqli_error($con));
        return false;
    }

    // Vinculamos los parámetros: s=string (ruta), i=integer (juego_id)
    mysqli_stmt_bind_param($update, "si", $ruta, $juego_id);

    if (mysqli_stmt_execute($update) && mysqli_stmt_affected_rows($update) > 0) {
        mysqli_stmt_close($update);
        return true;
    } else {
        error_log("Error al ejecutar el UPDATE de videojuego: " . mysqli_stmt_error($update));
        mysqli_stmt_close($update);
        return false;
    }
}
