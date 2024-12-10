<?php
session_start();
include('database.php'); //conexion a la base de datos
include('comps.php');    //funciones de gestion de builds

//verificar si el administrador esta autenticado
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php'); //redirigir al formulario de inicio de sesion si no esta autenticado
    exit();
}

// Manejar las acciones de CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'create') {
            $name = $_POST['name'];
            $difficulty = $_POST['difficulty'];
            $rating = $_POST['rating'];
            $champions = explode(',', $_POST['champions']); //convertir a array
            $items = explode(',', $_POST['items']);         //convertir a array
            $message = createComps($name, $difficulty, $rating, $champions, $items);
        } elseif ($action === 'delete') {
            $id = $_POST['id'];
            $message = deleteComp($id);
        } elseif ($action === 'edit') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $difficulty = $_POST['difficulty'];
            $rating = $_POST['rating'];
            $champions = explode(',', $_POST['champions']); //convertir a array
            $items = explode(',', $_POST['items']);         //convertir a array
            $message = editComp($id, $name, $difficulty, $rating, $champions, $items);
        }
    }
}

//obtener todas las builds
$builds = getAllComps();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Gestión de Builds</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-800 text-white">

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Administrador - Gestión de Builds</h1>

        <!--mensaje-->
        <?php if (isset($message)): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!--formulario para crear una nueva build-->
        <h2 class="text-2xl font-bold mb-4">Crear Nueva Build</h2>
        <form method="POST" class="bg-gray-700 p-4 rounded">
            <input type="hidden" name="action" value="create">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Nombre de la Build</label>
                <input type="text" name="name" id="name" class="w-full bg-gray-800 p-2 rounded text-white" required>
            </div>
            <div class="mb-4">
                <label for="difficulty" class="block text-sm font-medium">Dificultad</label>
                <input type="number" name="difficulty" id="difficulty" class="w-full bg-gray-800 p-2 rounded text-white" required>
            </div>
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium">Rating</label>
                <input type="number" step="0.1" name="rating" id="rating" class="w-full bg-gray-800 p-2 rounded text-white" required>
            </div>
            <div class="mb-4">
                <label for="champions" class="block text-sm font-medium">Campeones (separados por coma)</label>
                <input type="text" name="champions" id="champions" class="w-full bg-gray-800 p-2 rounded text-white" required>
            </div>
            <div class="mb-4">
                <label for="items" class="block text-sm font-medium">Items (separados por coma)</label>
                <input type="text" name="items" id="items" class="w-full bg-gray-800 p-2 rounded text-white" required>
            </div>
            <button type="submit" class="bg-green-500 px-4 py-2 rounded">Crear Build</button>
        </form>

        <!--listar todas las builds-->
        <h2 class="text-2xl font-bold mt-8 mb-4">Listado de Builds</h2>
        <table class="w-full bg-gray-700 rounded">
            <thead>
                <tr>
                    <th class="p-2">ID</th>
                    <th class="p-2">Nombre</th>
                    <th class="p-2">Dificultad</th>
                    <th class="p-2">Rating</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($builds as $build): ?>
                    <tr>
                        <td class="p-2"><?= htmlspecialchars($build['id']); ?></td>
                        <td class="p-2"><?= htmlspecialchars($build['name']); ?></td>
                        <td class="p-2"><?= htmlspecialchars($build['difficulty']); ?></td>
                        <td class="p-2"><?= htmlspecialchars($build['rating']); ?></td>
                        <td class="p-2">
                            <!--boton para eliminar-->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $build['id']; ?>">
                                <button type="submit" class="bg-red-500 px-2 py-1 rounded">Eliminar</button>
                            </form>
                            <!--boton para editar-->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $build['id']; ?>">
                                <button type="submit" class="bg-blue-500 px-2 py-1 rounded">Editar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>