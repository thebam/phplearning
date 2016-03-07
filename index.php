<?php
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
                        <li><a href="<?=$recipe['url']?>" target="_blank"><?=$recipe['title']?></a> - <a href="editMeal.php?name=<?=urlencode($recipe['title'])?>">edit</a> - <a href="deleteMeal.php?id=<?=$recipe['id']?>">delete</a></li>
                        <?php
                    }
                
            ?>
        </ul>
    </body>
</html>