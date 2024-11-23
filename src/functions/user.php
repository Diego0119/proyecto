<?php
include('database.php');

function registerUser($username, $email, $password)
{
    global $conexion; // variable de conexion en el archivo database.php 
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // se cifra la contraseña
    $query = ""; // aca me deben pasar el query los de base de datos
    return mysqli_query($conexion, $query); // con $conexion se hace la consulta
}

function loginUser($email, $password)
{
    global $conexion;
    $query = ""; // me deben pasar el query los de base de datos
    $result = mysqli_query($conexion, $query); // resultado del query

    if ($row = mysqli_fetch_assoc($result)) { // funcion que obtiene las filas de resultados de la base de datos, lo devuelve como un array asociativo
        if (password_verify($password, $row['password'])) { // se verifica que la contraseña este bien
            session_start();
            $_SESSION['user_id'] = $row['id'];
            return true;
        }
    }
    return false;
}

// se hace el logout del usuario
function logoutUser()
{
    session_start();
    session_unset();
    session_destroy();
}

// funcion para saber si el usuario esta autenticado
function isAuthenticated()
{
    session_start();
    return isset($_SESSION['user_id']);
}

?>