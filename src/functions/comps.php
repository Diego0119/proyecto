<?php
include('database.php');  // archivo de base de datos

/**
 * @param mixed $name_of_composition nombre de la composicion
 * @param mixed $difficulty dificultad 
 * @param mixed $rating rating 
 * @param mixed $champions campeones enviados
 * @param mixed $items items de los campeones
 * @return string
 */
function createComps($name_of_composition, $difficulty, $rating, $champions, $items)
{
    global $conexion;

    // validar que nada venga vacio
    if (empty($name_of_composition) || empty($difficulty) || empty($rating) || empty($champions) || empty($items)) {
        return "Todos los campos son obligatorios.";
    }

    // validar que la dificultad sea un numero y el rating tambien
    $difficulty = filter_var($difficulty, FILTER_VALIDATE_INT);
    $rating = filter_var($rating, FILTER_VALIDATE_FLOAT);

    if ($difficulty === false || $rating === false) {
        return "La dificultad debe ser un número entero y el rating debe ser un número decimal.";
    }

    // validar que el array de campeones tenga minimo 6
    if (!is_array($champions) || count($champions) < 6) {
        return "Debes seleccionar al menos 6 campeones.";
    }

    // validar que los items no vengan vacios
    if (!is_array($items) || empty($items)) {
        return "Debes proporcionar al menos un item.";
    }

    // sanitizar el nombre de la composicion
    $name_of_composition = htmlspecialchars(strip_tags($name_of_composition));

    // consulta
    $query = "";
    // preparar consulta
    $stmt = mysqli_prepare($conexion, $query);

    if (!$stmt) {
        return "Error al preparar la consulta: " . mysqli_error($conexion);
    }

    // convertir los arrays en un json para la base de datos
    $champions_json = json_encode($champions);
    $items_json = json_encode($items);

    // enlazar parametros, s =string, d= flotante
    mysqli_stmt_bind_param($stmt, "sddss", $name_of_composition, $difficulty, $rating, $champions_json, $items_json);

    // ejecutar
    if (mysqli_stmt_execute($stmt)) {
        return "Composición creada exitosamente.";
    } else {
        return "Error al crear la composición: " . mysqli_error($conexion);
    }
}

/**
 * 
 * @return array|string retorna las composiciones
 */
function getAllComps()
{
    global $conexion;

    $query = "SELECT * FROM COMPOSITIONS;"; // consulta
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        return "Error al obtener las composiciones: " . mysqli_error($conexion);
    }

    // armado de los datos
    $compositions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['champions'] = json_decode($row['champions'], true);
        $row['items'] = json_decode($row['items'], true);
        $compositions[] = $row;
    }

    return $compositions;
}

function getAllChampions()
{
    global $conexion;

    $query = "SELECT * FROM CHAMPIONS;"; // consulta
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        return "Error al obtener los campeones: " . mysqli_error($conexion);
    }

    $champions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $champions[] = $row;
    }

    return $champions;
}

function getAllItems()
{
    global $conexion;

    $query = "SELECT * FROM ITEMS;"; // consulta
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        return "Error al obtener los ítems: " . mysqli_error($conexion);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}


?>