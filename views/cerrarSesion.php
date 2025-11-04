<?php 

session_start();

// Limpiamos las varaibles de sesion
$_SESSION = array();

session_destroy();

header("Location: iniciarSession.php?c=exitoso");
exit;

?>