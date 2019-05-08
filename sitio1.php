<?php

session_start();
// si pulsamos el botón de desconectar de sitio1 o sitio2, eliminar las variables de sesión, es como si el usuario se desconectara
if (isset($_POST['desconectar'])) {
    unset($_SESSION['user'], $_SESSION['pass']);
    session_destroy();
    header('Location:index.php');
    exit();
}

$user = $_SESSION['user'];
// el usuario no se ha identificado, por lo que lo mandamos al index para que se registre
if (!isset($_SESSION['user'])) {
    header('Location:index.php?msj=Debes loguearte para acceder.'); // lo redirecciona al index y le pasamos por get a la url un mensaje, también podríamos crear una variable de sesión para esto
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/sitios.css">
    <title>sitio 1</title>
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-light mt-5" role="alert">
        <h1 class="text-center text-primary">Estás en sitio 1</h1>
        <h4 class="text-center">Usuario registrado como <b class="text-dark"><?= $user ?></b></h4>
    </div>
</div>
<div class="container-fluid h-100 justify-content-center">
    <div class="row w-100 align-items-center h-75">
        <div class="col text-center">
            <a href="sitio2.php" role="button" class="btn btn-danger btn-lg">Ir a sitio 2</a>
        </div>
    </div>
    <form action="sitio1.php" method="post">
        <div class="row w-100 justify-content-center">
            <input value="Desconectar" name="desconectar" type="submit" style="position: fixed; bottom: 10px;" class="btn btn-outline-light btn-lg desconectar">
        </div>
    </form>
</div>
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.bundle.js"></script>
</body>
</html>
