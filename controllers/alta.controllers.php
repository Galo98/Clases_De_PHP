<?php

require_once "../models/juegos.models.php";

function handleAltaJuegos($con)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $titulo = trim($_POST['titulo'] ?? '');
        $desarrollador = trim($_POST['desarrollador'] ?? '');
        $precio = floatval($_POST['precio'] ?? 0);
        $formato = $_POST['formato'] ?? '';
        $requisitos = (int)($_POST['requisitos'] ?? 0);
        $lanzamiento = $_POST['lanzamiento'] ?? null;
        $stock = (int)($_POST['stock'] ?? 0);
        $microtran = isset($_POST['microtran']) ? 1 : 0;
        $destacado = isset($_POST['destacado']) ? 1 : 0;
        $categorias = $_POST['categorias'] ?? [];
        $plataformas = $_POST['plataformas'] ?? [];

        $error = null;

        if (empty($titulo) || empty($desarrollador) || $precio <= 0) {
            $error = "Faltan campos obligatorios o el precio no es válido.";
        } elseif (empty($categorias) || empty($plataformas)) {
            $error = "Debes seleccionar al menos una Categoría y una Plataforma.";
        }

        // tomamos la ruta temporal
        $imagen = $_FILES['imagen']['tmp_name'] ?? null;
        $extension = null;
        $errorTipoImg = null;
        // Si existe la ruta temporal a la imagen, revisamos su extension, para validarla y cargarla en la base de datos.
        // Para mas info del tipo mime revisar el readme.md
        if ($imagen) {
            $tipo_mime = mime_content_type($imagen);
            if ($tipo_mime === 'image/jpeg' || $tipo_mime === 'image/jpg') {
                $extension = 'jpg';
            } elseif ($tipo_mime === 'image/png') {
                $extension = 'png';
            } elseif ($tipo_mime === 'image/webp') {
                $extension = 'webp';
            } else {
                $errorTipoImg = "Tipo de archivo no permitido";
            }
        }

        // NOTA: Esta función requiere que la extensión 'fileinfo' esté habilitada en tu PHP.

        $imagenError = $_FILES['imagen']['error'] ?? UPLOAD_ERR_NO_FILE;

        if ($imagenError !== UPLOAD_ERR_OK) {
            $error = "Error al subir la imagen. Código: $imagenError";
        } else if ($errorTipoImg) {
            $error = $errorTipoImg;
        }

        if ($error === null) {

            $juego_id = cargarVideojuego($con, $titulo, $desarrollador, $precio, $formato, $microtran, $requisitos, $lanzamiento, $stock, $destacado);

            if ($juego_id) {

                // Al tener el id del producto, guardamos la imagen con su id
                $ruta = "../img/";
                $rutaDestino = $ruta . $titulo . ".$extension"; // Usamos el ID como nombre de archivo

                // movemos la imagen subido de la carpeta temporal a la carpeta de destino
                if (move_uploaded_file($imagen, $rutaDestino)) {


                    $errorCategoria = cargarVideojuegosCategorias($con, $juego_id, $categorias);
                    if (!$errorCategoria) {
                        $error = "No se pudo cargar la/s categoria del videojuego";
                    }

                    if (!cargarVideojuegosPlataformas($con, $juego_id, $plataformas)) {
                        $error = "No se pudo cargar la/s categorias del videojuego";
                    }

                    // hacemos el update de videojuegos para cargar la imagen.
                    if (!actualizarImagen($con, $juego_id, $rutaDestino)) {
                        $error = "No se pudo cargar la portada de la imagen";
                    }

                    if ($error === null) {
                        $error = "cargado";
                    }
                } else {
                    // Si falla la subida de imagen, se puede revertir la inserción del producto
                    // deleteProducto($juego_id); // Esto sería necesario para una reversión completa
                    $error = "Fallo la subida del archivo. Revise permisos de carpeta.";

                    return $error;
                }
            } else {
                $error = "Error al guardar los datos del producto en la base de datos.";

                return $error;
            }
        }
    }
}
