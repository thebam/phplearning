<?php
namespace Cooking;
require_once 'recipe.php';
$recipes = Recipe::allRecipes();
?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <h1>Meals Cooked</h1>
        <a href="addMeal.php">Add meal</a>
        <ul>
            <?php
            $id = 0;
            $title = '';
            $tasteRating = 0;
            foreach($recipes as $recipe){
            if (array_key_exists('Id',$recipe)){ 
                $id =  $recipe['Id'];
            }
            if (array_key_exists('Title',$recipe)){ 
                $title =  $recipe['Title'];
            }
            if (array_key_exists('TasteRating',$recipe)){ 
                $tasteRating =  $recipe['TasteRating'];
            }
            ?>
                <li><a href="showRecipe.php?name=<?=urlencode($title)?>"><?=$title?></a> <?=$tasteRating?> out of 5 <a href="editMeal.php?name=<?=urlencode($title)?>">edit</a> - <a href="deleteMeal.php?id=<?=$id?>">delete</a></li>
            <?php
            }    
            ?>
        </ul>
    </body>
</html>