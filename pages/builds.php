<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUILDS META TFT TIER LIST</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Animacion personalizada */
        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .hover-zoom img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-zoom img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }
    </style>
    <script>
        function copiarBuild(buildName) {
            navigator.clipboard.writeText(buildName)
                .then(() => alert('Build copiada al portapapeles.'))
                .catch(() => alert('Error al copiar la build.'));
        }

        function toggleBuild(id) {
            const buildDetails = document.getElementById(`build-${id}`);
            buildDetails.classList.toggle('hidden');
            buildDetails.classList.toggle('slide-in');
        }
    </script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-black to-gray-900 text-white font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <?php include '../header.php'; ?>

    <!-- Principal -->
    <main class="flex-1 container mx-auto px-4 mt-8">
        <h1 class="text-4xl font-extrabold text-center text-purple-400 fade mb-8">BUILDS META TFT TIER LIST</h1>

        <!-- Buscador -->
        <form method="GET" action="" class="mb-8">
            <div class="flex justify-center">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por nombre de la build..." 
                    class="w-full md:w-1/2 bg-gray-800 text-white p-2 rounded-l-lg focus:ring-2 focus:ring-purple-500 transition duration-300"
                >
                <button 
                    type="submit" 
                    class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-r-lg transition duration-300">
                    Buscar
                </button>
            </div>
        </form>

        <!-- Lista de builds -->
        <div class="bg-gradient-to-br from-purple-700 to-purple-800 p-6 rounded-lg shadow-lg mb-8 transform transition duration-500 hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-purple-300">Shadow Assassins</h2>
                    <p class="text-purple-200">Tier: B | Dificultad: 3 | Rating: 4.5</p>
                </div>
                <button 
                    onclick="toggleBuild(1)" 
                    class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-md transition duration-300">
                    Expandir/Contraer
                </button>
            </div>

            <!-- Detalles de la build -->
            <div id="build-1" class="hidden mt-4">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr class="bg-purple-700">
                                <th class="p-3">Campeón</th>
                                <th class="p-3">Costo (Monedas)</th>
                                <th class="p-3">Ítems</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $champions = [
                                ['name' => 'Akali', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Akali_0.jpg', 'cost' => 3],
                                ['name' => 'Ekko', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Ekko_0.jpg', 'cost' => 4],
                                ['name' => 'Corki', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Corki_0.jpg', 'cost' => 4],
                                ['name' => 'Gangplank', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Gangplank_0.jpg', 'cost' => 3],
                                ['name' => 'Ziggs', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Ziggs_0.jpg', 'cost' => 2],
                                ['name' => 'Zoe', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Zoe_0.jpg', 'cost' => 5],
                                ['name' => 'Irelia', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Irelia_0.jpg', 'cost' => 4],
                                ['name' => 'Ezreal', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Ezreal_0.jpg', 'cost' => 3],
                                ['name' => 'Leona', 'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/Leona_0.jpg', 'cost' => 1]
                            ];

                            $item = [
                                'name' => 'Armadura de Warmog',
                                'imagePath' => 'https://ddragon.leagueoflegends.com/cdn/13.20.1/img/item/3083.png'
                            ];

                            foreach ($champions as $champion): ?>
                                <tr class="bg-gray-900 hover:bg-gray-800 transform transition duration-300 hover:scale-105">
                                    <td class="p-3 flex items-center hover-zoom">
                                        <img src="<?= htmlspecialchars($champion['imagePath']); ?>" alt="<?= htmlspecialchars($champion['name']); ?>" class="w-16 h-16 rounded-full mr-4">
                                        <span class="font-bold text-purple-300"><?= htmlspecialchars($champion['name']); ?></span>
                                    </td>
                                    <td class="p-3 text-purple-200"><?= htmlspecialchars($champion['cost']); ?></td>
                                    <td class="p-3">
                                        <div class="flex space-x-4 hover-zoom">
                                            <?php for ($i = 0; $i < 3; $i++): ?>
                                                <div class="text-center">
                                                    <img src="<?= htmlspecialchars($item['imagePath']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" class="w-10 h-10 mx-auto">
                                                    <p class="text-xs mt-1 text-white"><?= htmlspecialchars($item['name']); ?></p>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include '../footer.php'; ?>

</body>
</html>