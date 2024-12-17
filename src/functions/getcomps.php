<?php
// Configuración para que el contenido que se envíe sea JSON
header('Content-Type: application/json');

// Incluir el archivo donde está la conexión a la base de datos
include('database.php');

// Verificar si se proporcionó el parámetro 'name' en la URL
if (isset($_GET['name'])) {
    // Sanitizar el parámetro 'name' para prevenir inyecciones SQL
    $compositionName = mysqli_real_escape_string($conexion, $_GET['name']);

    // Consulta SQL para obtener la información de la composición
    $query = "
        SELECT 
            c.name AS compositionName, -- Nombre de la composición
            c.difficulty,             -- Dificultad de la composición
            c.rating,                 -- Calificación de la composición
            ch.name AS championName,  -- Nombre del campeón
            GROUP_CONCAT(DISTINCT i.name SEPARATOR ', ') AS items, -- Objetos clave agrupados
            GROUP_CONCAT(DISTINCT oc.name SEPARATOR ', ') AS synergies -- Sinergias agrupadas
        FROM COMPOSITIONS c
        JOIN COMPOSITIONS_CHAMPIONS cc ON c.idComposition = cc.fkComposition -- Relación composición-campeones
        JOIN CHAMPIONS ch ON cc.fkChampion = ch.idChampion -- Relación campeones
        LEFT JOIN COMPOSITION_CHAMPION_ITEM cci ON c.idComposition = cci.fkComposition AND ch.idChampion = cci.fkChampion
        LEFT JOIN ITEMS i ON cci.fkItem = i.idItem -- Relación ítems
        LEFT JOIN CHAMPIONS_ORIGINS_CLASSES coc ON ch.idChampion = coc.fkChampion -- Relación campeones-orígenes/clases
        LEFT JOIN ORIGINS_CLASSES oc ON coc.fkOriginClass = oc.idOriginClass -- Relación sinergias
        WHERE c.name = '$compositionName' -- Filtrar por el nombre de la composición
        GROUP BY ch.idChampion, c.idComposition; -- Agrupar por campeón y composición
    ";

    // Ejecutar la consulta
    $result = mysqli_query($conexion, $query);

    // Verificar si la consulta se ejecutó correctamente
    if ($result) {
        $data = []; // Array para almacenar los resultados

        // Recorrer los resultados de la consulta
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Agregar cada fila al array
        }

        // Si hay datos, devolverlos en formato JSON
        if (count($data) > 0) {
            echo json_encode($data);
        } else {
            // Si no se encontraron resultados, enviar un mensaje de error
            echo json_encode(['error' => 'Composición no encontrada.']);
        }
    } else {
        // Si hubo un error en la consulta, enviar el mensaje de error
        echo json_encode(['error' => 'Error en la consulta: ' . mysqli_error($conexion)]);
    }
} else {
    // Si no se proporcionó el parámetro 'name', enviar un mensaje de error
    echo json_encode(['error' => 'No se proporcionó el nombre de la composición.']);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
