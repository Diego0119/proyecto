<?php
// include('database.php');
include('comps.php');


// // $name_of_composition = "Composición de prueba";
// // $difficulty = 5;
// // $rating = 4.2;
// // $champions = ["Ahri", "Yasuo", "Garen", "Zed", "Teemo", "Lux"];
// // $items = ["Espada de Rúnica", "Cloak of Agility"];


// // echo createComps($name_of_composition, $difficulty, $rating, $champions, $items);
echo "<br><br>";
$compositions = getAllComps();
if (is_array($compositions)) {
    echo "Composiciones obtenidas: <br>";
    foreach ($compositions as $comp) {
        echo "Composición: " . $comp['name'] . " - Dificultad: " . $comp['difficulty'] . " - Rating: " . $comp['rating'] . "<br>";
    }
} else {
    echo $compositions;
}
echo "<br><br>";

$champions = getAllChampions();
if (is_array($champions)) {
    echo "Campeones obtenidos: <br>";
    foreach ($champions as $champion) {
        echo "Campeón: " . $champion['imagePath'] . "<br>";
        echo "Costo: " . $champion['cost'] . "<br>";
        echo "Habilidad: " . $champion['ability'] . "<br>";
        echo "<img src='{$champion["imagePath"]}'>";
    }
} else {
    echo $champions;
}
echo "<br><br>";

$items = getAllItems();
if (is_array($items)) {
    echo "Ítems obtenidos: <br>";
    foreach ($items as $item) {
        echo "Ítem: " . $item['name'] . "<br>";
    }
} else {
    echo $items;
}
?>