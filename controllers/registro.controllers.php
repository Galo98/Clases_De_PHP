<?php

require_once '../models/usuarios.models.php';

// Manejamos los datos que se envían del formulario de registro
function handleRegistro($con)
{

    // Utilizamos una variable predefinida $_SERVER en la posicion ['REQUEST_METHOD'] para trabajar con los datos cuando el metodo es POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Limpiamos los datos, con trim(), sacamos los espacios adelante y al final de los datos ingresados por el usuario
        // con $_POST['nombre'] ?? '', hacemos que si viene nulo, la variable $nombre quede con vacio (''), pero si contiene algo, guarde lo que tiene.
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        $error = null;

        // Hacemos una minima validación de los campos
        if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($password_confirm)) {
            $error = "Todos los campos son obligatorios.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "El formato del email no es válido.";
        } elseif ($password !== $password_confirm) {
            $error = "Las contraseñas no coinciden.";
        } elseif (strlen($password) < 8) {
            $error = "La contraseña debe tener al menos 8 caracteres.";
        }

        // Si no hay errores continuamos

        if ($error === null) {

            // Ciframos la contraseña con la función password_hash(), que recibe
            // la contraseña ingresada por el usuario y un algoritmo cifrado, en este caso:
            // PASSWORD_DEFAULT, esté utiliza el algoritmo más fuerte disponible (actualmente Argon2 o bcrypt)
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $rol_cliente_id = 2;

            $user_id = createUser($con, $nombre, $apellido, $email, $password_hash, $rol_cliente_id);

            if ($user_id) {
                // Si el registro fue exitoso, redirigimos con la fonción header.
                // Está función limpia el POST y previene envíos múltiples.
                header('Location: /views/iniciarSesion.php?registro=exitoso');
                exit;
            } else {
                // Si hubo un error creamos el mensaje de error.
                $error = "El email ya está registrado o hubo un error en la base de datos.";
            }
        }

        // Si hay un error, se devuelve la variable $error para mostrarla en la vista.
        return $error;
    }

    return null; // Si no hay POST, no hay error.
}
