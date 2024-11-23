<?php
$databaseHost = 'localhost';
$databaseName = 'tft';
$databaseUsername = 'root';
$databasePassword = '';

$conexion = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>