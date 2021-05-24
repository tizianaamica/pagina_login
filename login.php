<?php session_start();

//comprobar si hay una sesion con el valor USUARIO iniciada
if (isset($_SESSION['usuario'])) {
    header('Location: index.php'); //Me envia al index.php
}

$errores = '';
//comprobar si se enviaron los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario  = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = hash('sha512', $password);

    //conectamos a la BD
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=login_practica', 'root', '');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $statement = $conexion->prepare('SELECT *  FROM usuarios WHERE usuario = :usuario AND pass = :password');
    //sustituir los placeholder
    $statement->execute(array(
        ':usuario' => $usuario,
        ':password' => $password
    ));

    //guardamos el resultado
    $resultado = $statement->fetch();
    //var_dump($resultado);

    if ($resultado !== false) {
        $_SESSION['usuario'] = $usuario;
        //header('Location: index.php');
        //echo "Datos correctos";
    }else{
        $errores .= '<li>Datos Incorrectos </li>';
    }
}

require 'views/login.view.php';

?>