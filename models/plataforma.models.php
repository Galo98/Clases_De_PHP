<?php

function getAllPlat($con)
{

    $q = "SELECT id_plat, nombre FROM plataformas WHERE fec_baja IS NULL";

    $plataformas = mysqli_query($con, $q);

    return $plataformas;
}
