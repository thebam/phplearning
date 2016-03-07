<?php
require_once "recipe.php";

if(count($_GET)>0){
    $id=$_GET['id'];
    $id = intval($id);
        Recipe::deleteRecipe($id);
        header('Location: index.php');
    
}

?>