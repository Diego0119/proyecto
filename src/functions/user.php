<?php
include('database.php'); // archivo de base de datos

/**
 * 
 * @param mixed $email se le debe enviar el correo del usuario
 * @param mixed $password se le debe enviar la contraseña del usuario
 * @return bool|string retornara un true si se pudo iniciar sesion o un false si no se pudo
 */
function loginUser($email, $password)
{
    global $conexion;

    // validacion de las entradas
    if (empty($email) || empty($password)) {
        return "El correo y la contraseña son obligatorios.";
    }

    // "sanitizar email"
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "El formato del correo no es válido.";
    }

    $query = ""; // consulta
    // prepara la consulta
    $stmt = mysqli_prepare($conexion, $query);

    if (!$stmt) {
        return "Error en la preparación de la consulta: " . mysqli_error($conexion);
    }

    // esto permite evitar sql inyection,  el parametro "s" es para indicar cadena de texto
    // sql inyection: SELECT * FROM usuarios WHERE email = '' OR 1=1 --; -> se mostraran todos los usuarios porque siempre se cumplira OR 1=1
    // haciendo esto se trata a lo enviado por el usuario como datos literales y no como algo ejecutable
    mysqli_stmt_bind_param($stmt, "s", $email);
    // ejecuta la consulta
    mysqli_stmt_execute($stmt);

    // obtiene al consulta
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return "Error al ejecutar la consulta: " . mysqli_error($conexion);
    }

    // se tendra la consulta como un arreglo asociativo (llave-valor)
    if ($row = mysqli_fetch_assoc($result)) {
        // verificar contraseña
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            return true;
        } else {
            return "La contraseña es incorrecta.";
        }
    } else {
        return "El correo no está registrado.";
    }
}

/**
 * 
 * @return string retornara una cadena de texto dependiendo si se cerro sesión o si no habia una sesión iniciada
 */
function logoutUser()
{
    session_start();

    if (isset($_SESSION['user_id'])) {
        session_unset();
        session_destroy();
        return "Sesión cerrada con éxito.";
    } else {
        return "No hay una sesión activa.";
    }
}
?>