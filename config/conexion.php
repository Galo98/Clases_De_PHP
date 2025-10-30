<?php

function conDB()
{
    $servidor = "localhost";
    $usuario = "dbremote";
    $contrasena = "1234";
    $baseDeDatos = "Game_Galaxy";

    $con = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    return $con;
}
