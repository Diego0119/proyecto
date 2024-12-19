<?php 
define('BASE_URL', '/tft-project/'); // cambiar esto
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
</html>

<header class="bg-purple-900 text-white">
    <!-- titulo de la pagina -->
    <div class="text-center py-4">
        <h1 class="text-4xl font-bold text-purple-300">Guía del Táctico</h1>
        <img src="<?php echo BASE_URL; ?>img/logo.webp" alt="Logo de la pagina" class="mx-auto mt-2 w-16 h-16">
    </div>
    <!--barra de navegacion -->
    <nav class="bg-purple-800">
        <ul class="flex justify-center space-x-4 py-2">
            <li>
                <a href="<?php echo BASE_URL; ?>index.php" class="text-purple-200 hover:text-purple-100 font-medium px-4 py-2">INICIO</a>
            </li>
            <li>
                <a href="<?php echo BASE_URL; ?>pages/builds.php" class="text-purple-200 hover:text-purple-100 font-medium px-4 py-2">BUILDS</a>
            </li>
            <li>
                <a href="<?php echo BASE_URL; ?>pages/personajes.php" class="text-purple-200 hover:text-purple-100 font-medium px-4 py-2">CAMPEONES</a>
            </li>
            <li>
                <a href="<?php echo BASE_URL; ?>pages/database.php" class="text-purple-200 hover:text-purple-100 font-medium px-4 py-2">DATABASE</a>
            </li>
        </ul>
    </nav>
</header>
