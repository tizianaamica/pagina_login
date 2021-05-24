<?php session_start();

//Si la sesion esta seteada = puedo enviar al contenido
if(isset($_SESSION['usuario'])){
    header('Location: contenido.php'); //Enviamos al contenido
}else{
    header('Location: registrate.php'); //Envio a registrarse
}

?>