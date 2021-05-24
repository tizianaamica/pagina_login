<?php session_start();

//Cerrar sesion
session_destroy();
//limpiamos y la dejamos en 0
$_SESSION = array();

//Enviamos a otra pagina
header('Location: login.php');

?>