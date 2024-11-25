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

function getAllPosts()
{
    global $conexion;

    $query = ""; // los de base  de datos me deben pasar el query para tener todos los posts
    return mysqli_query($conexion, $query); // aca se devuelve la data

}

function getPostById($author_id)
{
    global $conexion;

    $author_id = (int) $author_id; // se castea para que si o si sea un int
    $query = ""; // aca los de base de datos me deben pasar el query y yo coloco el id del usuario
    return mysqli_query($conexion, $query); // aca se devuelve la data
}

function updatePost($title, $content)
{
    global $conexion;

}

function deletePost()
{
}
?>