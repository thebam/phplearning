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
                
                    foreach($recipes as $recipe){
                        ?>
                        <li><a href="showRecipe.php?name=<?=urlencode($recipe['Title'])?>"><?=$recipe['Title']?></a> <?=$recipe['TasteRating']?> out of 5 <a href="editMeal.php?name=<?=urlencode($recipe['Title'])?>">edit</a> - <a href="deleteMeal.php?id=<?=$recipe['Id']?>">delete</a></li>
                        <?php
                    }
                
            ?>
        </ul>
    </body>
</html>