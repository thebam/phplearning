<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "recipe.php";

if(count($_POST)>0){
    
    Cooking\Recipe::editRecipe($_POST['id'],$_POST['title'],$_POST['mainIngredient'],$_POST['cuisine'],$_POST['url'],$_POST['tasteRating'],$_POST['notes'],$_POST['imageUrl'],$_POST['videoUrl'],$_POST['preparationRating'],$_POST['cleanUpRating'],$_POST['ingredients'],$_POST['quantities'],$_POST['instructions'],$_POST['servings']);
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
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        </head>
    <body>
        <h1>Edit Meal</h1>

        <form action="editMeal.php" method="post" role="form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" value="<?=$myRecipe->title?>"  required/>
            </div>
            <div class="form-group">
                <label for="url">Url:</label>
                <input type="text" name="url" class="form-control" value="<?=$myRecipe->url?>"  required/>
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
            <select name="cuisine" class="form-control">
            <?php
            foreach($cuisines as $cuisine){
                if($cuisine['Id'] == intval($myRecipe->cuisineId)){?>
                    <option selected value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                <?php
                }else{
                    ?>
                    <option value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                    <?php
                }
            }
            ?>    
            </select>
            </div>

            <div class="form-group">
                <label for="mainIngredient">Main Ingredient:</label>
                <select name="mainIngredient" class="form-control">
                    <?php
                    foreach($ingredients as $ingredient){
                        if($ingredient['Id'] == intval($myRecipe->mainIngredientId)){?>
                    <option selected value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                <?php
                }else{
                    ?>
                    <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
            </div>
            
            
            <div class="form-group">
                <label for="servings">Servings:</label>
            <select name="servings" class="form-control">
                <?php
                    for($servingCnt=1;$servingCnt<13; $servingCnt++){
                        if($servingCnt == intval($myRecipe->servings)){?>
                    <option selected><?=$servingCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$servingCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
            
            
            
            <label>All Ingredients:</label>
            <div id="ingredientsContainer" class="controls form-inline">
                
                
                 <?php
                     for ($ingredientCnt=0;$ingredientCnt<count($myRecipe->ingredients);$ingredientCnt++) {
                        ?>
            <div class="ingredient controls form-inline">
                <div class="form-group">
                    <label>Ingredient:</label>
                    <select name="ingredients[]" class="form-control">
                        <?php
                        foreach($ingredients as $ingredient){
                        if($ingredient['Title'] == $myRecipe->ingredients[$ingredientCnt]){?>
                    <option selected value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                <?php
                }else{
                    ?>
                    <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                    <?php
                }
                    }
                    ?>       
                    </select>
                    <label>Quantity:</label>
                    <input type="text" name="quantities[]" value="<?=$myRecipe->quantities[$ingredientCnt]?>" required/>
                    <div class="addIngredient btn btn-default form-control">+</div>
                    <div class="removeIngredient btn btn-default form-control">-</div>
                </div>
            </div>
            
            <?php
            }
            ?>
            
            
            </div>
            
            <label>Cooking Instructions:</label>
            <div id="instructionsContainer" class="controls form-inline">
                <?php
                foreach ($myRecipe->instructions as $instruction) {
                ?>
            <div class="instruction controls form-inline">
                <div class="form-group">
                    <label>Step:</label>
                    <textarea name="instructions[]" class="form-group"><?=$instruction?></textarea>
                    <div class="addStep btn btn-default form-control">+</div>
                    <div class="removeStep btn btn-default form-control">-</div>
                </div>
            </div>
             <?php
                }
                ?>
            
            </div>
            
            
            
            
            <div class="form-group">
                <label for="imageUrl">Image:</label>
            <input type="text" name="imageUrl" class="form-control" value="<?=$myRecipe->imageUrl?>" />
                </div>
                <div class="form-group">
                <label for="videoUrl">Video:</label>
            <input type="text" name="videoUrl" class="form-control" value="<?=$myRecipe->videoUrl?>" />
                </div>
            
            <div class="form-group">
                <label for="tasteRating">Taste Rating:</label>
            <select name="tasteRating" class="form-control">
                <?php
                    for($tasteCnt=0;$tasteCnt<6; $tasteCnt++){
                        if($tasteCnt == intval($myRecipe->tasteRating)){?>
                    <option selected><?=$tasteCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$tasteCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
                <div class="form-group">
                <label for="preparationRating">Preparation Difficulty:</label>
            <select name="preparationRating" class="form-control">
                <?php
                    for($prepCnt=0;$prepCnt<6; $prepCnt++){
                        if($prepCnt == intval($myRecipe->prepRating)){?>
                    <option selected><?=$prepCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$prepCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
                <div class="form-group">
                <label for="cleanUpRating">Clean Up Rating:</label>
            <select name="cleanUpRating" class="form-control">
                <?php
                    for($cleanCnt=0;$cleanCnt<6; $cleanCnt++){
                        if($cleanCnt == intval($myRecipe->cleanRating)){?>
                    <option selected><?=$cleanCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$cleanCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
                <div class="form-group">
                <label for="notes">Comments:</label>
                <textarea name="notes" class="form-control"><?=$myRecipe->notes?></textarea>
                </div>
                
                <input type="hidden" name="id" value="<?=$myRecipe->id?>" />
            <input type="submit" class="btn btn-default" />
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script>
        $("#ingredientsContainer").on('click','.addIngredient', function(){
            $(".ingredient").first().clone().appendTo("#ingredientsContainer");
        });
         $("#ingredientsContainer").on('click','.removeIngredient', function(){
            $(this).parent().parent().remove();
        });
        
        $("#instructionsContainer").on('click','.addStep', function(){
            $(".instruction").first().clone().appendTo("#instructionsContainer");
        });
         $("#instructionsContainer").on('click','.removeStep', function(){
            $(this).parent().parent().remove();
        });
        </script>
    </body>
</html>