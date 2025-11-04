<?php

function getUserByEmail($con, string $email): ?array
{

    if (!isset($con)) {
        error_log("Error: No hay conexión con la base de datos.");
        return null;
    }

    $q = "SELECT id_usuario, nombre, apellido, email, password_hash, rol_id, activo FROM usuarios WHERE email = '$email';";

    $datos = mysqli_query($con, $q);

    $usuario = [];

    $usuario = mysqli_fetch_assoc($datos);

    return $usuario;
}

// Creamos un nuevo usuario, con sentencias MYSQLI procedurales

function createUser($con, string $nombre, string $apellido, string $email, string $password, int $rol_id = 2): int|bool
{
    if (!isset($con)) {
        error_log("Error: No hay conexión con la base de datos.");
        return false;
    }

    $sql = "INSERT INTO usuarios (nombre, apellido, email, password_hash, rol_id) VALUES (?, ?, ?, ?, ?)";

    $resultado = mysqli_prepare($con, $sql);

    if (!$resultado) {
        error_log("Error preparando la consulta de registro: " . mysqli_error($con));
        return false;
    }

    mysqli_stmt_bind_param($resultado, "ssssi", $nombre, $apellido, $email, $password, $rol_id);

    if (mysqli_stmt_execute($resultado)) {

        $insert_id = mysqli_insert_id($con);


        mysqli_stmt_close($resultado);

        return $insert_id;
    } else {

        error_log("Error al ejecutar el registro: " . mysqli_stmt_error($resultado));
        mysqli_stmt_close($resultado);

        return false;
    }
}
