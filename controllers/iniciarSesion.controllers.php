<?php

require_once "../models/usuarios.models.php";

function handleInicioUsuario($con){
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $error = null;

        if (empty($email) || empty($password)){
            $error = "Por favor, ingrese email y contraseña";
            return $error;
        }

        $usuario = getUserByEmail($con,$email);
        
            if ($usuario){

                if (password_verify($password, $usuario['password_hash'])){

                    if ($usuario['activo'] == 1){

                        // Creamos la sesion del usuario que se intenta logear

                        // primero regeneramos cualqueir sesion

                        session_regenerate_id(true);

                        // Guardamos los dtos del usuario en las variables de sesion

                        $_SESSION['user_id'] = $usuario['id_usuario'];
                        $_SESSION['user_email'] = $usuario['email'];
                        $_SESSION['user_nombre'] = $usuario['nombre'];
                        $_SESSION['user_rol'] = $usuario['rol_id'];

                        // redirigimos al usuario al index

                        header('Location: ../index.php');
                        exit;

                    } else {
                        $error = "La cuenta está inactiva.";
                    }

                } else {
                    $error = "Contraseña incorrecta.";
                }

            } else {
                $error = "Email incorrecto.";
            }

            return $error;

        }

    return null;
}
