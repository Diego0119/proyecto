<?php
//lgica de paginación
$builds_por_pagina = 5;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $builds_por_pagina;

try {
    //conexion a la base de datos
    $pdo = new PDO("mysql:host=localhost;dbname=tft_db", "usuario", "contraseña");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //obtener las builds desde la base de datos
    $query = "SELECT * FROM builds LIMIT :offset, :limit";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $builds_por_pagina, PDO::PARAM_INT);
    $stmt->execute();

    //traer las builds de la base de datos
    $builds = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //si no hay builds
    if (empty($builds)) {
        $mensaje = "No hay builds disponibles en este momento.";
    }

    //obtener el total de builds para la paginacion
    $total_builds_query = "SELECT COUNT(*) FROM builds";
    $total_builds_stmt = $pdo->query($total_builds_query);
    $total_builds = $total_builds_stmt->fetchColumn();
    
    //calcular el total de páginas
    $total_paginas = ceil($total_builds / $builds_por_pagina);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUILDS META TFT TIER LIST</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="bg-black text-white font-sans flex flex-col min-h-screen">

    <!--header-->
    <?php include 'header.php'; ?>

    <!--principal-->
    <main class="flex-1 container mx-auto px-4 mt-8">
        <h1 class="text-4xl font-bold text-center text-purple-300 mb-8">BUILDS META TFT TIER LIST</h1>

        <!--si no hay builds disponibles-->
        <?php if (isset($mensaje)): ?>
            <div class="text-center text-purple-300"><?= $mensaje ?></div>
        <?php else: ?>
            <!--mostrar las builds-->
            <div class="flex flex-wrap gap-6 justify-center">
                <?php foreach ($builds as $build): ?>
                    <div class="w-60 p-4 bg-purple-800 rounded-lg shadow-md">
                        <img src="../img/<?= htmlspecialchars($build['tier_image']) ?>" alt="Tier de la Build" class="w-full h-32 object-cover rounded-md">
                        <h2 class="text-xl font-bold text-center text-purple-300 mt-4"><?= htmlspecialchars($build['name']) ?></h2>
                        <p class="text-center text-purple-200"><?= htmlspecialchars($build['category']) ?></p>
                        
                        <!--imagenes de campeones-->
                        <div class="flex justify-center mt-4">
                            <?php
                            $champions = explode(',', $build['champions']);
                            foreach ($champions as $champion): ?>
                                <img src="../img/<?= htmlspecialchars($champion) ?>.webp" alt="Campeón" class="w-12 h-12 mx-1 rounded-full hover:opacity-80" title="<?= ucfirst($champion) ?>">
                            <?php endforeach; ?>
                        </div>

                        <!--botones para copiar y ver detalles-->
                        <div class="flex justify-between mt-4">
                            <button class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-md">Copiar Build</button>
                            <a href="#" class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-md" data-toggle="modal" data-target="#modalBuild">Ver detalles</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!--paginacion-->
            <div class="flex justify-center mt-8">
                <nav class="pagination">
                    <?php if ($pagina_actual > 1): ?>
                        <a href="builds.php?pagina=<?= $pagina_actual - 1 ?>" class="px-4 py-2 text-white">Anterior</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="builds.php?pagina=<?= $i ?>" class="px-4 py-2 text-white <?= $i == $pagina_actual ? 'bg-purple-700' : 'bg-purple-600' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($pagina_actual < $total_paginas): ?>
                        <a href="builds.php?pagina=<?= $pagina_actual + 1 ?>" class="px-4 py-2 text-white">Siguiente</a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </main>

    <!--footer-->
    <?php include 'footer.php'; ?>

</body>
</html>