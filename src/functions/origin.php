<?php
include('database.php'); 

// Verificar si se pasó el parámetro 'championName' en la URL
if (isset($_GET['championName'])) {
    // Sanitizar el parámetro 'championName' para prevenir inyecciones SQL
    $championName = mysqli_real_escape_string($conexion, $_GET['championName']);

    // Consulta SQL para obtener el origen (sinergia) y la imagen del campeón
    $query = "
        SELECT 
            ch.name AS championName,        -- Nombre del campeón
            oc.name AS originName,          -- Nombre del origen/sinergia
            oc.imagePath AS originImage     -- Ruta de la imagen del origen
        FROM CHAMPIONS ch
        JOIN CHAMPIONS_ORIGINS_CLASSES coc ON ch.idChampion = coc.fkChampion -- Relación campeón-origen
        JOIN ORIGINS_CLASSES oc ON coc.fkOriginClass = oc.idOriginClass      -- Relación origen-clase
        WHERE ch.name = '$championName'; -- Filtrar por el nombre del campeón
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
            echo json_encode(['error' => 'Orígenes no encontrados para el campeón.']);
        }
    } else {
        // Si hubo un error en la consulta, enviar el mensaje de error
        echo json_encode(['error' => 'Error en la consulta: ' . mysqli_error($conexion)]);
    }
} else {
    // Si no se proporcionó el parámetro 'championName', enviar un mensaje de error
    echo json_encode(['error' => 'No se proporcionó el nombre del campeón.']);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
