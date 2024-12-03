<?php
include('database.php');  // archivo de base de datos


function search($source, $gold, $name_of_champion)
{
    // conexion
    global $conexion;

    // si el nombre del campeón es 'cualquiera', lo convertimos en un comodín
    $name_of_champion = ($name_of_champion === 'cualquiera') ? '%' : "%$name_of_champion%";

    // consulta
    $sql = "
        SELECT 
            CHAMPIONS.name AS ChampionName, 
            CHAMPIONS.cost AS Cost, 
            ORIGINS_CLASSES.name AS Origin
        FROM 
            CHAMPIONS
        INNER JOIN 
            CHAMPIONS_ORIGINS_CLASSES ON CHAMPIONS.idChampion = CHAMPIONS_ORIGINS_CLASSES.fkChampion
        INNER JOIN 
            ORIGINS_CLASSES ON CHAMPIONS_ORIGINS_CLASSES.fkOriginClass = ORIGINS_CLASSES.idOriginClass
        WHERE 
            (? = 'cualquiera' OR ORIGINS_CLASSES.name = ?)
            AND (? = 'cualquiera' OR CHAMPIONS.cost = ?)
            AND (? = 'cualquiera' OR CHAMPIONS.name LIKE ?);
    ";

    // preparar
    $stmt = mysqli_prepare($conexion, $sql);

    // manejo de errores
    if (!$stmt) {
        die("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    // Bind de parámetros
    mysqli_stmt_bind_param(
        $stmt,
        'sssds', // tipos de datos: s = string, d = double (o int)
        $source,
        $source,
        $gold,
        $gold,
        $name_of_champion,
        $name_of_champion
    );

    // ejecutar consulta
    mysqli_stmt_execute($stmt);

    // obtener los resultados
    $result = mysqli_stmt_get_result($stmt);

    // procesar los resultados
    $champions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $champions[] = $row;
    }

    // cerrar la consulta
    mysqli_stmt_close($stmt);

    // retornar los resultados
    return $champions;
}

?>