<?php

    require "bd.php";

    
    function verCategorias(){

        $consultaCategorias = "select * from categorias;";

        $resultados = mysqli_query(,$consultaCategorias);

        while($categoria = mysqli_fetch_assoc($resultados)){
            echo "<tr>";
            echo "<td>". $categoria['id_cat'] ."</td>";
            echo "<td>". $categoria['nombre'] ."</td>";
            echo "<td>";
            echo "<p class='acciones'>";
            echo "<a class='modificar' href='modificar.php?pan=1&acc=1&id=". $categoria['id_cat'] ."\>";
            echo "<i class=\"fa-solid fa-pen-to-square\"></i>";
            echo "</a>";
            echo "<a class=\"eliminar\" href=\"eliminar.php?pan=1&acc=2&id=". $categoria['id_cat'].">";
            echo "<i class=\"fa-solid fa-trash-can\"></i>";
            echo "</a>";
            echo "</p>";
            echo "</td>";
            echo "</tr>";
        }

    }
    



?>