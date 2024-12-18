<?php
// Incluir las funciones del backend desde la carpeta src
$comps_path = realpath(dirname(__FILE__) . '/../src/functions/comps.php');
if (!file_exists($comps_path)) {
    die('El archivo comps.php no existe en la ruta especificada: ' . $comps_path);
}
include_once $comps_path;

// Lógica de paginación
$builds_por_pagina = 5;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $builds_por_pagina;

// Obtener las builds utilizando la función del backend
$builds = getAllComps();

// Verificar si hay builds
if (empty($builds)) {
    $mensaje = "No hay builds disponibles en este momento.";
} else {
    // Dividir las builds para la paginación
    $total_builds = count($builds);
    $total_paginas = ceil($total_builds / $builds_por_pagina);
    $builds_paginadas = array_slice($builds, $offset, $builds_por_pagina);
}
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

        <!-- Mensaje si no hay builds -->
        <?php if (isset($mensaje)): ?>
            <div class="text-center text-purple-300"><?= htmlspecialchars($mensaje); ?></div>
        <?php else: ?>
            <!-- Mostrar las builds -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($builds_paginadas as $build): ?>
                    <div class="bg-purple-800 p-4 rounded-lg shadow-lg">
                        <h2 class="text-xl font-bold text-center text-purple-300 mt-4"><?= htmlspecialchars($build['name']); ?></h2>
                        <p class="text-center text-purple-200">Dificultad: <?= htmlspecialchars($build['difficulty']); ?> | Rating: <?= htmlspecialchars($build['rating']); ?></p>

                        <!-- Campeones y sus ítems -->
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-purple-300 text-center">Campeones</h3>
                            <?php if (!empty($build['champions']) && is_array($build['champions'])): ?>
                                <div class="flex flex-wrap justify-center">
                                    <?php foreach ($build['champions'] as $index => $champion): ?>
                                        <div class="m-2 text-center">
                                            <img src="../img/<?= htmlspecialchars($champion); ?>.webp" alt="<?= htmlspecialchars($champion); ?>" class="w-16 h-16 mx-auto rounded-full hover:opacity-80" title="<?= ucfirst($champion); ?>">
                                            <p class="text-sm font-bold mt-2"><?= htmlspecialchars($champion); ?></p>
                                            <ul class="mt-2">
                                                <?php if (!empty($build['items'][$index]) && is_array($build['items'][$index])): ?>
                                                    <?php foreach ($build['items'][$index] as $item): ?>
                                                        <li class="text-xs text-purple-200"><?= htmlspecialchars($item); ?></li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li class="text-xs text-gray-400">Sin ítems</li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-gray-400">No hay campeones asignados.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Botón para copiar -->
                        <div class="flex justify-center mt-4">
                            <button onclick="copiarBuild('<?= htmlspecialchars($build['name']); ?>')" class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-md">Copiar Build</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Paginación -->
            <div class="flex justify-center mt-8">
                <nav class="pagination">
                    <?php if ($pagina_actual > 1): ?>
                        <a href="builds.php?pagina=<?= $pagina_actual - 1; ?>" class="px-4 py-2 text-white">Anterior</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="builds.php?pagina=<?= $i; ?>" class="px-4 py-2 <?= $i == $pagina_actual ? 'bg-purple-700' : 'bg-purple-600'; ?> text-white"><?= $i; ?></a>
                    <?php endfor; ?>
                    <?php if ($pagina_actual < $total_paginas): ?>
                        <a href="builds.php?pagina=<?= $pagina_actual + 1; ?>" class="px-4 py-2 text-white">Siguiente</a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>
</html>