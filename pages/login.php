<?php
session_start();
include_once '../src/functions/user.php'; // Incluir funciones de usuario

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Elimina espacios en blanco
    $password = trim($_POST['password']); // Elimina espacios en blanco

    // Validar credenciales usando loginUser
    $login_result = loginUser($username, $password);

    if ($login_result === true) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username; // Guarda el nombre de usuario en la sesión
        header('Location: admin.php'); // Redirigir al panel de administración
        exit();
    } else {
        $error_message = $login_result; // Mostrar mensaje de error
    }
}

// Manejar cierre de sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white flex items-center justify-center h-screen">

    <div class="bg-gray-800 p-6 rounded shadow-md w-96">
        <h1 class="text-2xl font-bold mb-4 text-center">Login Administrador</h1>

        <?php if (isset($error_message)): ?>
            <p class="text-red-500 mb-4"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Usuario</label>
                <input type="text" name="username" id="username" class="w-full p-2 bg-gray-700 rounded" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full p-2 bg-gray-700 rounded" required>
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-2 rounded">Iniciar Sesión</button>
        </form>

        <p class="text-center text-gray-400 text-sm mt-4">
            © 2024 Administrador TFT. Todos los derechos reservados.
        </p>
    </div>

</body>
</html>