<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "recipe.php";

if(count($_POST)>0){
    
    Cooking\Recipe::editRecipe($_POST['id'],$_POST['title'],$_POST['mainIngredient'],$_POST['url'],$_POST['cuisine'],$_POST['rating'],$_POST['notes']);
    header('Location: index.php');
}else{
    if(count($_GET)>0){
        $myRecipe = new Cooking\recipe();
        $myRecipe->getRecipeByName(urldecode($_GET['name']));
    }
    
    $connection = openConnection();
    $query = "SELECT * FROM Ingredients ORDER BY Title";
    $ingredients = array();
    $results = $connection->query($query);
    while ($row = $results->fetch_assoc()){
        $ingredients[]=$row;
    }

    $query = "SELECT * FROM Cuisines ORDER BY Title";
    $cuisines = array();
    $results = $connection->query($query);
    while ($row = $results->fetch_assoc()){
        $cuisines[]=$row;
    }
    $connection->close();
    
}

?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <h1>Edit Meals</h1>
        <form action="editMeal.php" method="post">
            <input type="text" name="title" placeholder="Title" required value="<?=$myRecipe->title?>" />
           
            <select name="mainIngredient">
            <?php
            foreach($ingredients as $ingredient){
                if($ingredient['Id']==$myRecipe->mainIngredientId){?>
                <option value="<?=$ingredient['Id']?>" selected><?=$ingredient['Title']?></option>
                <?php
            }else {
                    ?>
                    <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                    <?php
                }
            }
            ?>    
            </select>
            <select name="cuisine">
            <?php
            foreach($cuisines as $cuisine){
                if($cuisine['Id']==$myRecipe->cuisineId){?>
                <option value="<?=$cuisine['Id']?>" selected><?=$cuisine['Title']?></option>
                <?php
                }else{
                    ?>
                    <option value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                    <?php
                }
            }
            ?>    
            </select>
            
            <input type="text" name="url" placeholder="Recipe URL" required value="<?=$myRecipe->url?>"/>
            <select name="rating">
                <?php
                for($rateCnt=0;$rateCnt<6;$rateCnt++){
                    if($rateCnt==$myRecipe->rating){?>
                    <option selected><?=$rateCnt?></option>
                    <?php
                    }else{
                        ?>
                    <option><?=$rateCnt?></option>
                    <?php
                    }
                }
                ?>
                </select>
                <textarea name="notes"><?=$myRecipe->notes?></textarea>
            <input type="hidden" name="id" value="<?=$myRecipe->id?>"/>
            <input type="submit" />
        </form>
    </body>
</html>