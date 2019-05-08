<?php
/*
 * phpmyadmin pass: root
 *
 * Se trata de hacer un formulario de login en el index.php
 * Luego habrá 2 páginas más
 *
 * Si hacemos el login correctamente (se tendrá que conectar a una bbdd y comprobar los datos proporcionados)
 * iremos a sitio1.php, si no metemos los datos bien, aparecerá un error en la página de advertencia
 *
 * En sitio1.php:
 * aparecerán los datos del usuario en la parte de arriba
 * conectado como: USER,
 * un mensaje en la parte central que indique el nombre de la página
 * en la parte inferior un botón donde pondrá DESCONECTARSE
 * y también un botón que será un link que nos llevará a sitio2.php (ir a sitio2).
 * Si escribimos en la url sitio1.php, y no nos hemos logueado, nos mandará a index.php
 *
 * En sitio2.php:
 * también aparecerán los datos del usuario,
 * el botón de desconectar,
 * y un mensaje que diga donde estamos,
 * y un botón que nos llevará a sitio1.php
 */

require_once 'gestionConexiones.php';

// recogemos el GET de la url en el caso de que el usuario haya ido a sitio1 sin loguearse
$msjError = isset($_GET['msj']) ? $_GET['msj'] : null;
// mostramos en pantalla el mensaje de error, pero ya con nuestro estilo
if ($msjError !== null) {
    $msjError = '<div class="d-flex row justify-content-center align-items-center w-100">
                        <div class="col-12 mx-auto">
                            <div class="alert alert-danger mx-auto text-center" role="alert">
                            <b>Debes loguearte para acceder!</b>
                            </div>
                        </div>
                    </div>';
}

if (isset($_POST['login'])) {
    session_start();
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $conexion = crearConexion('root', 'dwes');

    $consulta = "SELECT * FROM usuarios WHERE nombre = '$user' AND pass = md5('$pass')";
    $resultado = $conexion->query($consulta);

    // PARA EVITAR INYECCION SQL...
    $stmt = $conexion->stmt_init();
    $stmt->prepare("SELECT * FROM usuarios WHERE nombre = ? AND pass ?");
    $pass = md5($pass);
    $stmt->bind_param('s', $user, $pass);
    $stmt->execute();

    $msj = '';
    if ($resultado) {
        // SI LAS FILAS DEVUELTAS SON = 0
        if ($resultado->num_rows === 0) {
            $msj = '<div class="d-flex row justify-content-center align-items-center w-100">
                        <div class="col-12 mx-auto">
                            <div class="alert alert-danger mx-auto text-center" role="alert">
                            El nombre de usuario y/o la contraseña son incorrectos
                            </div>
                        </div>
                    </div>';
        } else {
            // SI LA CONUSLTA NOS DEVUELVE ALGUNA FILA, es que ha ingresado correctamente el user y el pass
            $_SESSION['user'] = $user; // guardamos el usuario en la variable de sesion user
            header('Location:sitio1.php'); // nos redirecciona a sitio1
        }

    }
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
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Acceso usuarios</h5>
                    <form class="form-login" method="post" action="index.php">
                        <div class="form-label-group">
                            <input type="text" id="inputUser" class="form-control" placeholder="Nombre de usuario" name="user" required autofocus>
                            <label for="inputUser">Usuario</label>
                        </div>

                        <div class="form-label-group">
                            <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" name="pass" required>
                            <label for="inputPassword">Contraseña</label>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Recordar password</label>
                        </div>
                        <button name="login" class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
            <?php echo $msj ?>
            <?php echo $msjError ?>
</div>
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.bundle.js"></script>
</body>
</html>
