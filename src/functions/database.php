<?php
$databaseHost = '127.0.0.1';
$databaseName = 'tft';
$databaseUsername = 'root';
$databasePassword = '';

$conexion = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if ($conexion) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error en la conexión: " . mysqli_connect_error();
}
?>