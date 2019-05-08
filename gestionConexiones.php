<?php
// require_once "gestionConexiones.php";
// $conexion = crearConexion();

function crearConexion($usuario, $nombre_bd) {
    $direccionIP = '127.0.0.1';
    $pass = '422919';
    $conexion = new mysqli($direccionIP, $usuario, $pass, $nombre_bd);

    if ($conexion->connect_errno || $conexion->connect_error) {
        echo 'Error';
        echo '<br>Error: ' .$conexion->connect_errno;
        echo '<br>Error: ' .$conexion->connect_error;
    }
    return $conexion;
}