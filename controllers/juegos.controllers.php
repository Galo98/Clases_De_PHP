<?php

require_once "../models/juegos.models.php";

function agruparJuegosPorCategoria(array $Juegos): array
{

    $juegosAgrupados = [];

    foreach ($Juegos as $fila) {

        $id = $fila['id_vid'];

        // isset()  Determina si una variable está declarada y es diferente de null
        // ! es la negación
        // Por lo tanto !isset() se entiende como si no existe

        // En este caso si no existe nada en $juegosAgrupados en la posicion $id, carga el juego en el array de forma asociativa.

        if (!isset($juegosAgrupados[$id])) {
            $juegosAgrupados[$id] = [
                'id_vid'       => $id,
                'titulo'       => $fila['titulo'],
                'precio'       => $fila['precio'],
                'categorias'   => [],
                'imagen'       => $fila['imagen']
            ];
        }

        // Ahora, cuando ya hay algo en la posicion $id del array $juegosAgrupados
        // Validamos que $fila en la posicion 'cat_nombre' no este vacia y lo guardamos en la posicion $id en la posicion categorias;

        if (!empty($fila['cat_nombre'])) {
            $juegosAgrupados[$id]['categorias'][] = $fila['cat_nombre'];
        }
    }

    // retornamos todos los valores del array

    return array_values($juegosAgrupados);
}

function procesarCatalogo($con): array
{

    // Las variables de "formularios" viajan por metodos HTTP
    // Estos metodos pueden ser "GET", "POST", "PUT", "DELETE", revisar README.md
    //  Para validar rapidamente si existe un metodo GET para categoria y plataforma, utilizamos un operador ternario, revisar README.md
    // Si existe un filtro, seteamos la variable como entera (int) y la asignamos a su variable correspondiente, de otra forma no hacemos nada (null).

    $cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : null;
    $plat_id = isset($_GET['plat']) ? (int)$_GET['plat'] : null;

    // Si el numero que asignamos es 0 o negativo, se descarta.

    $cat_id = ($cat_id > 0) ? $cat_id : null;
    $plat_id = ($plat_id > 0) ? $plat_id : null;

    if (!isset($_GET['cat']) && !isset($_GET['plat'])) {
        // Sin filtros
        $juegosYCats = getAllDestYCats($con);
        $juegos = agruparJuegosPorCategoria($juegosYCats);
    } else {
        // Con filtros
        $juegosYCats = getJuegosConFiltros($con, $cat_id, $plat_id);
        $juegos = agruparJuegosPorCategoria($juegosYCats);
    }

    // traemos los juegos con la funcion que definimos en los juegos.models.php



    return $juegos;
}
