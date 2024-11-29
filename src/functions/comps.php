<?php
include('database.php');  // archivo de base de datos

function createComps($name_of_composition, $difilcuty, $rating, $champions, $items)
{
    // minimo 6 campeones
    global $conexion;

    // casteo para que sea un entero si o si

    $query = ""; // me deben pasar el query los de base de datos
    return mysqli_query($conexion, $query);
}

function getAllComps()
{
    global $conexion;

    $query = ""; // los de base  de datos me deben pasar el query para tener todos los posts
    return mysqli_query($conexion, $query); // aca se devuelve la data

}

function getAllChampions()
{


}

function getAllItems()
{


}




?>