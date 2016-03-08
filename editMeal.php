<?php
require_once "recipe.php";
if(count($_POST)>0){
    
    Recipe::editRecipe($_POST['id'],$_POST['title'],$_POST['mainIngredient'],$_POST['url'],$_POST['cuisine'],$_POST['rating'],$_POST['notes']);
    header('Location: index.php');
}else{
    if(count($_GET)>0){
        $myRecipe = new recipe();
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
            <input type="text" name="title" placeholder="Title" required value="<?=$myRecipe->getTitle()?>" />
           
            <select name="mainIngredient">
            <?php
            foreach($ingredients as $ingredient){
                if($ingredient['Id']==$myRecipe->getMainIngredientId()){?>
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
                if($cuisine['Id']==$myRecipe->getCuisineId()){?>
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
            
            <input type="text" name="url" placeholder="Recipe URL" required value="<?=$myRecipe->getUrl()?>"/>
            <select name="rating">
                <?php
                for($rateCnt=0;$rateCnt<6;$rateCnt++){
                    if($rateCnt==$myRecipe->getRating()){?>
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
                <textarea name="notes"><?=$myRecipe->getNotes()?></textarea>
            <input type="hidden" name="id" value="<?=$myRecipe->getId()?>"/>
            <input type="submit" />
        </form>
    </body>
</html>