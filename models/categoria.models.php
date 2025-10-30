<?php

    function getCatByVid($con,$vid){
        $q = "SELECT cat.nombre FROM categorias cat INNER JOIN videojuegos_categorias vc ON cat.id_cat = vc.categoria_id WHERE vc.videojuego_id = $vid;";

        $categorias = mysqli_query($con,$q);

        return $categorias;
    }

?>