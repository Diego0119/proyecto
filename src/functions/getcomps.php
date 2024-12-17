<?php
header('Content-Type: application/json');
include('database.php');

// Recuperar el nombre de la composición desde la URL
if (isset($_GET['name'])) {
    $compositionName = mysqli_real_escape_string($conexion, $_GET['name']);

    $query = "
        SELECT 
            c.name AS compositionName,
            c.difficulty,
            c.rating,
            ch.name AS championName,
            GROUP_CONCAT(DISTINCT i.name SEPARATOR ', ') AS items,
            GROUP_CONCAT(DISTINCT oc.name SEPARATOR ', ') AS synergies
        FROM COMPOSITIONS c
        JOIN COMPOSITIONS_CHAMPIONS cc ON c.idComposition = cc.fkComposition
        JOIN CHAMPIONS ch ON cc.fkChampion = ch.idChampion
        LEFT JOIN COMPOSITION_CHAMPION_ITEM cci ON c.idComposition = cci.fkComposition AND ch.idChampion = cci.fkChampion
        LEFT JOIN ITEMS i ON cci.fkItem = i.idItem
        LEFT JOIN CHAMPIONS_ORIGINS_CLASSES coc ON ch.idChampion = coc.fkChampion
        LEFT JOIN ORIGINS_CLASSES oc ON coc.fkOriginClass = oc.idOriginClass
        WHERE c.name = '$compositionName'
        GROUP BY ch.idChampion, c.idComposition;
    ";

    $result = mysqli_query($conexion, $query);

    if ($result) {
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        if (count($data) > 0) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Composición no encontrada.']);
        }
    } else {
        echo json_encode(['error' => 'Error en la consulta: ' . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó el nombre de la composición.']);
}

// Cerrar conexión
mysqli_close($conexion);
?>
