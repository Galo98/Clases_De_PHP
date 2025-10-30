<?php

function getAllDestacados($conexion)
{

    $q = "SELECT id_vid, titulo, precio, imagen from videojuegos where destacado = true";

    $productos = mysqli_query($conexion, $q);

    return $productos;
}
