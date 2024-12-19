<?php
include('../src/functions/database.php'); // Asegúrate de que se incluya la conexión a la base de datos

function getChampionOrigins($championName)
{
    global $conexion;

    // Consulta para obtener los orígenes del campeón
    $query = "
        SELECT 
            oc.name AS originName,
            oc.imagePath AS originImage
        FROM CHAMPIONS ch
        JOIN CHAMPIONS_ORIGINS_CLASSES coc ON ch.idChampion = coc.fkChampion
        JOIN ORIGINS_CLASSES oc ON coc.fkOriginClass = oc.idOriginClass
        WHERE ch.name = '" . mysqli_real_escape_string($conexion, $championName) . "';
    ";

    $result = mysqli_query($conexion, $query);
    $origins = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $origins[] = $row;
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }

    return $origins;
}

?>
