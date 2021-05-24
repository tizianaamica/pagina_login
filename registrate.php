<?php session_start();

//comprobar si hay una sesion con el valor USUARIO iniciada
if (isset($_SESSION['usuario'])) {
    header('Location: index.php'); //Me envia al index.php
}

//Si recibe los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Validamos los datos que se estan enviando 
    $usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    //echo "$usuario . $password . $password2";

    //Posibles errores
    $errores = '';
    //Comprobar que los campos NO ESTEN VACIOS
    if (empty($usuario) or empty($password) or empty($password2)) {
        $errores .= '<li>Por favor rellena todos los datos correctamente</li>';
    } else {
        try { //Hacemos la conexion
            $conexion = new PDO('mysql:host=localhost;dbname=login_practica', 'root', '');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        //Consultas
        //Devuelve de la tabla los datos de el usuario 
        $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
        //Queremos que el valor sea igual al que usamos arriba (el que se envio por elm post)
        $statement->execute(array(':usuario' => $usuario));
        //Si devuelve FALSE significa que el usuario NO EXISTE
        $resultado = $statement->fetch();

        if ($resultado != false) { //sig que si existe
            $errores .= '<li>El nombre de usuario ya existe</li>';
        }

        //encriptacion de la contraseña
        $password = hash('sha512', $password);
        $password2 = hash('sha512', $password2);

        //echo "$usuario . $password  . $password2";

        if ($password != $password2) {
            $errores .=  '<li>Las contraseñas no son iguales</li>';
        }
    }

    //Enviar los datos limpios a la BD 
    if ($errores == '') {
        $statement = $conexion->prepare('INSERT INTO usuarios (id, usuario, pass) VALUES (null, :usuario, :pass)');
        $statement->execute(array(':usuario' => $usuario, ':pass' => $password));
    }

    header('Location: login.php');
}

require 'views/registrate.view.php';
