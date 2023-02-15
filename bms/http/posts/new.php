<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title         = $_POST['title'];
    $content       = $_POST['content'];
    $slug          = $_POST['slug'];
    $date          = $_POST['date'];
    $author        = $_POST['author'];
    $categories    = $_POST['categories'];
    $tags          = $_POST['items'];
    $tagsNew       = $_POST['items_new'];
    $featuredImage = $_POST['featured-image'];

    var_dump($_POST);
}
