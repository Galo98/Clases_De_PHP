<?php 

$servidor = "localhost";
$usuario = "root";
$contrasena = "1234";
$baseDeDatos = "game_galaxy";


// comentario simple
# comentario simple
/* Comentario
en
varias
lineas */
/*
echo "<h1> Titulo de la pagina <h1>";

$numeroA = 2;
$numeroB = 3;

echo "Este es el valor que contiene la variable numeroA " .$numeroA;

$resultado = $numeroA + $numeroB;

echo "<br>El resultado de A + B $resultado";

function saludar(){
    //global $usuario;
    echo "<h1 class='colorido'>Hola ". $GLOBALS['contrasena'] ."<h1>";
}
*/

function saludar($a){
    echo "<h1> Hola $a </h1>";
}

saludar("Enrique");

// Declare la funcio sumar
function sumar($num,$num2){
    $resul = $num + $num2;
    return $resul;
}
$dato = sumar(1,2);
$dato = sumar($dato,$dato);

echo "<h1> $dato </h1>";

$conexion = mysqli_connect($servidor,$usuario,$contrasena,$baseDeDatos);

$consultaCategorias = "select * from categorias;";

$resultados = mysqli_query($conexion,$consultaCategorias);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/600e7f7446.js" crossorigin="anonymous"></script>
    <title>Game Galaxy</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php while($categoria = mysqli_fetch_assoc($resultados)) {?>
                <tr>
                    <td> <?php echo $categoria['id_cat'] ?> </td>
                    <td> <?php echo $categoria['nombre'] ?> </td>
                    <td>
                        <p class="acciones">
                            <a class="modificar" href="modificar.php?pan=1&acc=1&id=<?php echo $categoria['id_cat'];?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a class="eliminar" href="eliminar.php?pan=1&acc=2&id=<?php echo $categoria['id_cat'];?>">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </p>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>