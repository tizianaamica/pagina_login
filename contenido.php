<?php session_start();

//El usuario solo puede acceder al contenido 
//Siempre y cuando tenga una sesion
if (isset($_SESSION['usuario'])) {
    require 'views/contenido.view.php';
}else{
    header('Location: login.php');
}

?>