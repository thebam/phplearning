<?php
require_once "recipe.php";
/*
CREATE DATABASE recipes;
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON database.table TO 'user'@'localhost';
FLUSH PRIVILEGES;
CREATE TABLE Recipe (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,title VARCHAR(256) NOT NULL, mainIngredient VARCHAR(256), url VARCHAR(256),dateModified TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
*/

if(count($_POST)>0){
$myRecipe = new recipe();
$myRecipe->addRecipe($_POST['title'],$_POST['mainIngredient'],$_POST['url']);
header('Location: index.php');

}

?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <h1>Add Meals</h1>
        <form action="addMeal.php" method="post">
            <input type="text" name="title" placeholder="Title" required/>
            <input type="text" name="mainIngredient" placeholder="Main Ingredient" required/>
            <input type="text" name="url" placeholder="Recipe URL" required/>
            <input type="submit" />
        </form>
    </body>
</html>