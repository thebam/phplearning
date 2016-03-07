<?php
require_once "recipe.php";
$error = '';
if(count($_POST)>0){
    $result = Recipe::addRecipe($_POST['title'],$_POST['mainIngredient'],$_POST['url']);
    if($result==='success'){
        header('Location: index.php');
    }else{
        $error=$result;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <h1>Add Meals</h1>
        <p><?=$error?></p>
        <form action="addMeal.php" method="post">
            <input type="text" name="title" placeholder="Title" required/>
            <input type="text" name="mainIngredient" placeholder="Main Ingredient" required/>
            <input type="text" name="url" placeholder="Recipe URL" required/>
            <input type="submit" />
        </form>
    </body>
</html>