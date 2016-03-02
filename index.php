<?php
require_once 'recipe.php';
/*
CREATE DATABASE recipes;
CREATE TABLE Recipe (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,title VARCHAR(256) NOT NULL, mainIngredient VARCHAR(256), url VARCHAR(256),dateModified TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
*/

$myRecipe = new recipe();
$recipes = $myRecipe->allRecipes();

?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <h1>Meals Cooked</h1>
        <a href="addMeal.php">Add meal</a>
        <ul>
            <?php
                if($recipes->num_rows>0){
                    while($recipe = $recipes->fetch_assoc()){
                        ?>
                        <li><a href="<?=$recipe['url']?>" target="_blank"><?=$recipe['title']?></a></li>
                        <?php
                    }
                }
            ?>
        </ul>
    </body>
</html>
<?php
$myRecipes->closeRecipes();
?>
