<?php
require_once "recipe.php";
if(count($_POST)>0){
    $myRecipe = new recipe();
    $myRecipe->editRecipe($_POST['id'],$_POST['title'],$_POST['mainIngredient'],$_POST['url']);
    header('Location: index.php');
}else{
    if(count($_GET)>0){
        $myRecipe = new recipe();
        $myRecipe->getRecipeByName($_GET['name']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <h1>Edit Meals</h1>
        <form action="editMeal.php" method="post">
            <input type="text" name="title" placeholder="Title" required value="<?=$myRecipe->getTitle()?>" />
            <input type="text" name="mainIngredient" placeholder="Main Ingredient" required value="<?=$myRecipe->getMainIngredient()?>"/>
            <input type="text" name="url" placeholder="Recipe URL" required value="<?=$myRecipe->getUrl()?>"/>
            <input type="hidden" name="id" value="<?=$myRecipe->getId()?>"/>
            <input type="submit" />
        </form>
    </body>
</html>