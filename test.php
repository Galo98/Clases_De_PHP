
// Variables en C++
/* int variable1 = 10; */


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


$consultaCategorias = "select * from categorias;";

$resultados = mysqli_query($conexion,$consultaCategorias);
//var_dump($resultados);

/*
"1",	"shooter"
"2",	"accion"
"3",	"miedo"
*/



?>