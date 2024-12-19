<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/tft-project-main/'); // cambiar esto
}
?>

<footer class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 text-white">
  <div class="mx-auto max-w-screen-xl px-4 pb-8 pt-16 sm:px-6 lg:px-8">
    <!-- Titulo y formulario -->
    <div class="mx-auto max-w-md text-center animate-fadeInUp">
      <strong class="block text-xl font-bold text-purple-300 sm:text-3xl">
        ¿Quieres enterarte de las últimas noticias en TFT? Contáctanos
      </strong>

      <form class="mt-6">
        <div class="relative max-w-lg mx-auto">
          <label class="sr-only" for="email">Email</label>

          <input
            class="w-full rounded-full border-purple-600 bg-purple-700 p-4 pe-32 text-sm font-medium focus:ring-2 focus:ring-purple-500 transition"
            id="email"
            type="email"
            placeholder="tft@guia.cl"
          />

          <button
            class="absolute end-1 top-1/2 -translate-y-1/2 rounded-full bg-purple-600 px-5 py-3 text-sm font-medium text-white transition transform hover:bg-purple-700 hover:scale-105"
          >
            Subscríbete
          </button>
        </div>
      </form>
    </div>

    <!-- Contenido principal -->
    <div class="mt-16 grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-32 animate-fadeInUp delay-300">
      <div class="mx-auto max-w-sm lg:max-w-none">
        <p class="mt-4 text-center text-purple-200 lg:text-left lg:text-lg">
          ¡Bienvenido a la mejor página de builds de TFT! Aquí podrás encontrar guías actualizadas para mejorar tu juego y competir al más alto nivel.
        </p>

        <div class="mt-6 flex justify-center gap-4 lg:justify-start">

        </div>
      </div>

      <!-- Derechos de autor -->
      <div class="text-center lg:text-left">
        <p class="text-purple-300">© 2024 Builds de TFT. Todos los derechos reservados.</p>
        <p class="text-purple-200 text-sm">
          Este sitio no está afiliado, patrocinado ni respaldado por Riot Games. TFT y League of Legends son marcas registradas de Riot Games, Inc.
        </p>
        <div class="flex justify-center lg:justify-start mt-4">
          <a href="https://www.riotgames.com/" target="_blank" rel="noopener noreferrer" class="hover:scale-105 transition">
            <img src="<?php echo BASE_URL; ?>img/logo-riot.webp" alt="Riot Games Logo" class="w-20 mt-2">
          </a>
        </div>
      </div>
    </div>
  </div>
</footer>

<style>
  /* Animaciones personalizadas */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fadeInUp {
    animation: fadeInUp 0.8s ease-out;
  }

  .delay-300 {
    animation-delay: 0.3s;
  }
</style>