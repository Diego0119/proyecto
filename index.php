<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Builds de TFT</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-black text-white font-sans flex flex-col min-h-screen">
    <?php include 'pages/header.php'; ?>

    <main class="flex-1 container mx-auto flex mt-4 mb-16">
        <!--publicidad izquierda-->
        <aside class="hidden md:block w-1/6 flex items-center justify-center">
            <img src="img/banner-izquierda.webp" alt="Publicidad izquierda" class="w-auto max-h-96 rounded shadow-md">
        </aside>

        <!--contenido principal-->
        <section class="flex-1 px-4">
            <h2 class="text-2xl font-bold text-center text-purple-300 mb-4">Bienvenido a Builds de TFT</h2>
            <p class="text-center text-purple-200 mb-6">
                TFT (Teamfight Tactics) es un juego estratégico de Riot Games en el que debes construir un equipo
                con campeones únicos para competir contra otros jugadores. Esta página te ayudará a conocer las mejores
                estrategias, builds, y campeones para mejorar tu desempeño en TFT.
            </p>

            <!--botones-->
            <div class="flex justify-center space-x-4 mb-6">
                <a href="pages/builds.php" class="bg-purple-700 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">BUILDS</a>
                <a href="pages/campeones.php" class="bg-purple-700 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">CAMPEONES</a>
                <a href="pages/database.php" class="bg-purple-700 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">DATABASE</a>
            </div>

            <!--introduccion y video-->
            <div class="text-center">
                <h3 class="text-xl font-bold text-purple-300 mb-2">¿Qué es TFT?</h3>
                <p class="text-purple-200 mb-4">
                    Teamfight Tactics es un juego de estrategia en el que cada decisión cuenta. 
                    Aprende cómo jugar, domina las mecánicas y sube en la clasificación.
                </p>
                <iframe 
                    class="mx-auto w-full max-w-lg h-64"
                    src="https://www.youtube.com/embed/bjpaD29_hQY" 
                    title="Cómo jugar TFT"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </section>

        <!--publicidad derecha-->
        <aside class="hidden md:block w-1/6 flex items-center justify-center">
            <img src="img/banner-derecha.webp" alt="Publicidad derecha" class="w-auto max-h-96 rounded shadow-md">
        </aside>
    </main>

    <?php include 'pages/footer.php'; ?>
</body>
</html>