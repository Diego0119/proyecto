<?php
include('database.php');  // archivo de base de datos

function createPost($title, $content, $author_id)
{
    global $conexion;

    // $title = $title;
    // $content = $content;
    $author_id = (int) $author_id; // casteo para que sea un entero si o si

    $query = ""; // me deben pasar el query los de base de datos
    return mysqli_query($conexion, $query);
}
?>