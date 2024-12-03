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

    // validacion
    if (empty($email) || empty($password)) {
        return "El correo y la contraseña son obligatorios.";
    }

    // sanitizar
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "El formato del correo no es válido.";
    }

    //sql
    $query = "SELECT idUser, username, email, password, userType 
              FROM USERS 
              WHERE email = ? AND userType = 'admin'";
    $stmt = mysqli_prepare($conexion, $query);

    if (!$stmt) {
        return "Error en la preparación de la consulta: " . mysqli_error($conexion);
    }

    // enlazar paraemtros
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    // resultado
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return "Error al ejecutar la consulta: " . mysqli_error($conexion);
    }

    // validacion
    if ($row = mysqli_fetch_assoc($result)) {
        // verificar contraseña
        if (password_verify($password, $row['password'])) {
            session_start();
            if (isset($_SESSION['user_id'])) {
                return "Ya hay una sesión activa.";
            }
            $_SESSION['user_id'] = $row['idUser'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['userType'] = $row['userType'];
            return true;
        } else {
            return "La contraseña es incorrecta.";
        }
    } else {
        return "El correo no está registrado.";
    }
}

/**
 * Cierra la sesión del usuario.
 * 
 * @return string Retorna un mensaje dependiendo del estado de la sesión.
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