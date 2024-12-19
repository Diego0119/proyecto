<?php 
define('BASE_URL', '/tft-project-main/'); // cambiar esto
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>

        @keyframes titleFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title-animate {
            animation: titleFadeIn 0.8s ease-out;
        }

        .hover-bright {
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .hover-bright:hover {
            transform: scale(1.1);
            color: #ffffff;
        }
    </style>
</head>
</html>

<header class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 text-white shadow-lg">
    <!-- Titulo de la pagina -->
    <div class="text-center py-6">
        <h1 class="text-5xl font-extrabold text-purple-200 title-animate">Guía del Táctico</h1>
        <img 
            src="<?php echo BASE_URL; ?>img/logo.webp" 
            alt="Logo de la página" 
            class="mx-auto mt-4 w-20 h-20 hover:scale-110 transition-transform duration-300 ease-in-out"
        >
    </div>
    <!-- Barra de navegacion -->
    <nav class="bg-purple-800 py-3">
        <ul class="flex justify-center space-x-6">
            <li>
                <a 
                    href="<?php echo BASE_URL; ?>index.php" 
                    class="text-purple-200 hover-bright font-medium px-4 py-2 transition-all duration-300">
                    INICIO
                </a>
            </li>
            <li>
                <a 
                    href="<?php echo BASE_URL; ?>pages/builds.php" 
                    class="text-purple-200 hover-bright font-medium px-4 py-2 transition-all duration-300">
                    BUILDS
                </a>
            </li>
            <li>
                <a 
                    href="<?php echo BASE_URL; ?>pages/personajes.php" 
                    class="text-purple-200 hover-bright font-medium px-4 py-2 transition-all duration-300">
                    CAMPEONES
                </a>
            </li>
            <li>
                <a 
                    href="<?php echo BASE_URL; ?>pages/databases.php" 
                    class="text-purple-200 hover-bright font-medium px-4 py-2 transition-all duration-300">
                    DATABASE
                </a>
            </li>
        </ul>
    </nav>
</header>