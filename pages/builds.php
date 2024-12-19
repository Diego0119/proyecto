<?php
// Ruta al archivo getcomps.php
$api_url = 'http://localhost/tft-project-main/src/functions/getcomps.php';

// Logica de busqueda
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Obtener todas las builds desde getcomps.php
if (!empty($busqueda)) {
    $api_url .= '?name=' . urlencode($busqueda);
}

$response = file_get_contents($api_url);
$builds = json_decode($response, true);

// Manejar errores de la API
if (isset($builds['error'])) {
    $mensaje = $builds['error'];
    $builds = [];
} elseif (!is_array($builds)) {
    $mensaje = "Error al obtener las builds. Verifica la conexión con el servidor.";
    $builds = [];
}

// Logica de paginacion
$builds_por_pagina = 5;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$total_builds = count($builds);
$total_paginas = ceil($total_builds / $builds_por_pagina);
$offset = ($pagina_actual - 1) * $builds_por_pagina;
$builds_paginadas = array_slice($builds, $offset, $builds_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUILDS META TFT TIER LIST</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function copiarBuild(buildId) {
            navigator.clipboard.writeText(buildId)
                .then(() => alert('Build copiada al portapapeles.'))
                .catch(() => alert('Error al copiar la build.'));
        }
    </script>
</head>
<body class="bg-black text-white font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Principal -->
    <main class="flex-1 container mx-auto px-4 mt-8">
        <h1 class="text-4xl font-bold text-center text-purple-300 mb-8">BUILDS META TFT TIER LIST</h1>

        <!-- Buscador -->
        <form method="GET" action="builds.php" class="mb-8">
            <div class="flex justify-center">
                <input 
                    type="text" 
                    name="busqueda" 
                    value="<?= htmlspecialchars($busqueda); ?>" 
                    placeholder="Buscar por nombre..." 
                    class="w-full md:w-1/2 bg-gray-800 text-white p-2 rounded-l-lg"
                >
                <button 
                    type="submit" 
                    class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-r-lg">
                    Buscar
                </button>
            </div>
        </form>

        <!-- Mensaje si no hay builds -->
        <?php if (!empty($mensaje)): ?>
            <div class="text-center text-purple-300"><?= htmlspecialchars($mensaje); ?></div>
        <?php else: ?>
            <!-- Mostrar las builds -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($builds_paginadas as $build): ?>
                    <div class="bg-purple-800 p-4 rounded-lg shadow-lg">
                        <h2 class="text-xl font-bold text-center text-purple-300 mt-4"><?= htmlspecialchars($build['compositionName']); ?></h2>
                        <p class="text-center text-purple-200">Dificultad: <?= htmlspecialchars($build['difficulty']); ?> | Rating: <?= htmlspecialchars($build['rating']); ?></p>

                        <!-- Campeones y sus items -->
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-purple-300 text-center">Campeones</h3>
                            <div class="flex flex-wrap justify-center">
                                <?php 
                                $champions = !empty($build['champions']) ? explode(',', $build['champions']) : [];
                                $items = !empty($build['items']) ? explode(',', $build['items']) : [];
                                foreach ($champions as $index => $champion): ?>
                                    <div class="m-2 text-center">
                                        <!-- Imagen del campeon -->
                                        <img 
                                            src="<?= htmlspecialchars($build['imagePath'][$champion] ?? 'default_champion_image.webp'); ?>" 
                                            alt="<?= htmlspecialchars($champion); ?>" 
                                            class="w-16 h-16 mx-auto rounded-full hover:opacity-80" 
                                            title="<?= htmlspecialchars($champion); ?>">
                                        <p class="text-sm font-bold mt-2"><?= htmlspecialchars($champion); ?></p>
                                        <ul class="mt-2">
                                            <!-- items asociados al campeon -->
                                            <?php foreach ($items as $item): ?>
                                                <li class="text-xs text-purple-200 flex items-center">
                                                    <img 
                                                        src="<?= htmlspecialchars($build['itemPaths'][$item] ?? 'default_item_image.webp'); ?>" 
                                                        alt="<?= htmlspecialchars($item); ?>" 
                                                        class="w-6 h-6 mr-2">
                                                    <?= htmlspecialchars($item); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (empty($champions)): ?>
                                    <p class="text-center text-gray-400">No hay campeones asignados.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Boton para copiar -->
                        <div class="flex justify-center mt-4">
                            <button onclick="copiarBuild('<?= htmlspecialchars($build['compositionName']); ?>')" class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-md">Copiar Build</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Paginacion -->
            <div class="flex justify-center mt-8">
                <nav class="pagination">
                    <?php if ($pagina_actual > 1): ?>
                        <a href="builds.php?pagina=<?= $pagina_actual - 1; ?>&busqueda=<?= urlencode($busqueda); ?>" class="px-4 py-2 text-white">Anterior</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="builds.php?pagina=<?= $i; ?>&busqueda=<?= urlencode($busqueda); ?>" class="px-4 py-2 <?= $i == $pagina_actual ? 'bg-purple-700' : 'bg-purple-600'; ?> text-white"><?= $i; ?></a>
                    <?php endfor; ?>
                    <?php if ($pagina_actual < $total_paginas): ?>
                        <a href="builds.php?pagina=<?= $pagina_actual + 1; ?>&busqueda=<?= urlencode($busqueda); ?>" class="px-4 py-2 text-white">Siguiente</a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>
</html>