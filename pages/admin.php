<?php
session_start();
include_once '../src/functions/comps.php'; // Funciones del backend

// Verificar si el administrador está autenticado
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Inicializar variables para evitar errores
$message = "";
$builds = [];
$champions = [];
$items = [];

// Obtener listas de campeones e ítems desde el backend
try {
    $champions = getAllChampions();
    $items = getAllItems();
} catch (Exception $e) {
    $message = "Error al cargar los datos: " . $e->getMessage();
}

// Función para guardar las builds en un archivo JSON
function saveBuildsToJson($builds)
{
    $file_path = '../builds.json';
    $builds_data = [];

    foreach ($builds as $build) {
        $builds_data[] = [
            'name' => $build['name'] ?? 'Sin nombre',
            'tier' => $build['tier'] ?? 'N/A', // Asignar tier si está disponible
            'difficulty' => $build['difficulty'] ?? 0,
            'rating' => $build['rating'] ?? 0,
            'champions' => json_decode($build['champions'] ?? '[]', true),
            'items' => json_decode($build['items'] ?? '[]', true),
        ];
    }

    $json_data = json_encode($builds_data, JSON_PRETTY_PRINT);

    if (file_put_contents($file_path, $json_data) === false) {
        throw new Exception("Error al guardar las builds en el archivo JSON.");
    }
}

// Manejar las acciones de CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'create') {
        $name = $_POST['name'];
        $tier = $_POST['tier'];
        $difficulty = $_POST['difficulty'];
        $rating = $_POST['rating'];
        $champions_selected = $_POST['champions'];
        $items_selected = $_POST['items'];

        // Validar que cada campeón tenga máximo 3 ítems
        foreach ($items_selected as $champion => $itemArray) {
            if (count($itemArray) > 3) {
                $message = "Cada campeón puede tener hasta 3 ítems.";
                break;
            }
        }

        if (!$message) {
            $message = createComps($name, $difficulty, $rating, $champions_selected, $items_selected);
            if ($message === "Composición creada exitosamente.") {
                $message .= " (Tier: " . htmlspecialchars($tier) . ")";
                try {
                    $builds = getAllComps();
                    saveBuildsToJson($builds); // Guardar en JSON
                } catch (Exception $e) {
                    $message = "Error al actualizar el archivo JSON: " . $e->getMessage();
                }
            }
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $message = deleteComp($id);
        if ($message === "Composición eliminada exitosamente.") {
            try {
                $builds = getAllComps();
                saveBuildsToJson($builds); // Guardar en JSON
            } catch (Exception $e) {
                $message = "Error al actualizar el archivo JSON: " . $e->getMessage();
            }
        }
    }
}

// Obtener todas las builds desde el backend
try {
    $builds = getAllComps();
} catch (Exception $e) {
    $message = "Error al cargar las builds: " . $e->getMessage();
}
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

    <?php if (!empty($message)): ?>
        <div class="bg-green-500 text-white p-4 rounded mb-4"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- Formulario para Crear una Nueva Build -->
    <h2 class="text-2xl font-bold mb-4">Crear Nueva Build</h2>
    <form method="POST" class="bg-gray-700 p-4 rounded">
        <input type="hidden" name="action" value="create">

        <div class="mb-4">
            <label for="name" class="block">Nombre de la Build</label>
            <input type="text" name="name" id="name" class="w-full bg-gray-800 p-2 rounded text-white" required>
        </div>

        <div class="mb-4">
            <label for="tier" class="block">Tier de la Build</label>
            <select name="tier" id="tier" class="w-full bg-gray-800 p-2 rounded text-white" required>
                <option value="S">S</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="difficulty" class="block">Dificultad</label>
            <input type="number" name="difficulty" id="difficulty" class="w-full bg-gray-800 p-2 rounded text-white" required>
        </div>

        <div class="mb-4">
            <label for="rating" class="block">Rating</label>
            <input type="number" step="0.1" name="rating" id="rating" class="w-full bg-gray-800 p-2 rounded text-white" required>
        </div>

        <div class="mb-4">
            <label class="block">Seleccionar Campeones y Objetos (Máx 9 campeones, 3 objetos por campeón)</label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <div class="bg-gray-600 p-4 rounded">
                        <label for="champion_<?= $i; ?>" class="block font-bold">Campeón <?= $i; ?></label>
                        <select name="champions[<?= $i; ?>]" id="champion_<?= $i; ?>" class="w-full bg-gray-800 p-2 rounded text-white">
                            <option value="" disabled selected>Selecciona un campeón</option>
                            <?php foreach ($champions as $champ): ?>
                                <option value="<?= htmlspecialchars($champ['name']); ?>"><?= htmlspecialchars($champ['name']); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label class="block mt-2 font-bold">Ítems para Campeón <?= $i; ?></label>
                        <?php for ($j = 1; $j <= 3; $j++): ?>
                            <select name="items[<?= $i; ?>][<?= $j; ?>]" class="w-full bg-gray-800 p-2 rounded text-white mt-2">
                                <option value="" disabled selected>Selecciona un ítem</option>
                                <?php foreach ($items as $item): ?>
                                    <option value="<?= htmlspecialchars($item['name']); ?>"><?= htmlspecialchars($item['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endfor; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <button type="submit" class="bg-green-500 px-4 py-2 rounded mt-4">Crear Build</button>
    </form>
</div>

</body>
</html>