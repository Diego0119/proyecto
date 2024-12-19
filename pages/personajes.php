<?php
include('../header.php');
include('../src/functions/database.php');
include('../src/functions/comps.php');
include('../src/functions/search.php');
include('../src/functions/champions_origins.php');

// Variables iniciales
$origin = $_POST['origin'] ?? 'cualquiera';
$gold = $_POST['gold'] ?? 'cualquiera';
$name_of_champion = $_POST['name_of_champion'] ?? '%';

$selected_origin = 'cualquiera';
$champions = [];
$origins = [];
$query = "SELECT DISTINCT name FROM ORIGINS_CLASSES";
$result = mysqli_query($conexion, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $origins[] = $row['name'];
    }
}

// Obtener campeones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_of_champion = isset($_POST['name_of_champion']) && !empty($_POST['name_of_champion']) ? $_POST['name_of_champion'] : 'cualquiera';
    $champions = search($origin, $gold, $name_of_champion);
} else {
    $champions = getAllChampions();
}

?>

<body>
    <div class="w-full flex flex-col sm:flex-row flex-wrap sm:flex-nowrap py-0 flex-grow bg-black text-white border-t border-purple-500">
        <!-- Columna izquierda -->
        <div class="w-fixed w-1/4 flex-shrink flex-grow-0 px-3 py-3 text-center">
            <a href="#">
                <img id="imgbetano" src="../img/monster.webp" alt="Publicidad" class="mx-auto">
            </a>
        </div>

        <main role="main" class="w-full flex-grow pt-3 px-3" >
            <h1 class="text-center text-2xl font-bold mb-4 pt-4 py-4">TFT CHAMPION LIST</h1>
            
            <!-- Formulario de búsqueda                                                                                         Intente implementar la busqueda
            <form method="POST" action="" class="form flex justify-center mb-8 gap-4">                                          pero no pude, ya que hacia la busqueda
                <input name="name_of_champion"                                                                                  pero al buscar no se mostraba las variables        
                    class="rounded-full px-8 py-3 border-2 text-black placeholder-gray-400 shadow-md w-1/3"                     y tampoco sabiamos si era error del back, base de datos
                    placeholder="Ingresa el nombre del campeón..." type="text" />                                               o front.

                 Filtro de Origins 
                <select name="origin" class="rounded-full px-4 py-3 text-black shadow-md">
                    <option value="cualquiera">Todos los Origins</option>
                    <?php foreach ($origins as $origin): ?>
                        <option value="<?php echo htmlspecialchars($origin); ?>" 
                            <?php echo ($selected_origin === $origin) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($origin); ?>
                        </option>
                    <?php endforeach; ?>
                </select> 

                <button type="submit" class="px-4 py-3 bg-purple-500 text-white rounded-full">
                    Search
                </button>
            </form> -->

            <!-- Resultados de búsqueda -->
            <div class="flex flex-wrap justify-center gap-4 pb-6">
                <?php if (!empty($champions)): ?>
                    <?php foreach ($champions as $champion): ?>
                        <?php 
                        $imagen = isset($champion['imagePath']) ? htmlspecialchars($champion['imagePath']) : 'img/placeholder.jpg';
                        $nombre = isset($champion['name']) ? htmlspecialchars($champion['name']) : 'Unknown';
                        $cost = isset($champion['cost']) ? htmlspecialchars($champion['cost']) : 'N/A';
                        $habilidad = isset($champion['ability']) ? htmlspecialchars($champion['ability']) : 'Unknown';

                        // Obtener los orígenes del campeón
                        $championOrigins = getChampionOrigins($nombre);
                        ?>
                        <div class="relative p-4 bg-gray-800 rounded-lg text-center shadow-md w-40 transform transition-transform duration-300 hover:scale-105 hover:shadow-lg hover:bg-gray-700">
                            <img src="<?php echo $imagen; ?>" 
                                alt="<?php echo $nombre; ?>" 
                                class="h-32 w-32 rounded-lg object-cover mb-2" />
                            <p class="text-purple-400 font-bold">Nombre:</p>
                            <p><?php echo $nombre; ?></p>

                            <!-- Hover -->
                            <div class="absolute top-0 left-0 w-full h-full bg-gray-900 bg-opacity-90 rounded-lg flex flex-col items-center justify-center text-white opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <p class="text-purple-400 font-bold">Costo:</p>
                                <div class="flex items-center">
                                    <img src="../img/cost.webp" alt="Gold Icon" class="h-6 w-6 mr-2">
                                    <p><?php echo $cost;?></p>
                                </div>
                                <p class="text-purple-400 font-bold mt-2">Habilidad:</p>
                                <p><?php echo $habilidad; ?></p>
                                
                                <!-- Orígenes -->
                                <p class="text-purple-400 font-bold mt-4">Orígenes:</p>
                                <div class="flex flex-wrap justify-center gap-2">
                                    <?php foreach ($championOrigins as $origin): ?>
                                        <div class="flex flex-col items-center text-center">
                                            <img src="<?php echo htmlspecialchars($origin['originImage']); ?>" 
                                                 alt="<?php echo htmlspecialchars($origin['originName']); ?>" 
                                                 class="h-8 w-8 rounded-full object-cover">
                                            <p class="text-xs mt-1 text-white"><?php echo htmlspecialchars($origin['originName']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-400 mt-8">No se encontraron campeones.</p>
                <?php endif; ?>
            </div>
        </main>

        <!-- Columna derecha -->
        <div class="w-fixed w-1/4 flex-shrink flex-grow-0 px-2">
            <div class="flex sm:flex-col px-2 py-3">
                <a href="#">
                    <img src="../img/nvidia.webp" alt="Publicidad" />
                </a>
                <a href="#">
                    <img src="../img/betano.webp" alt="Publicidad" />
                </a>
            </div>
        </div>
    </div>
</body>

<?php include('../footer.php'); ?>
