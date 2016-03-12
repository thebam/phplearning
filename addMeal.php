<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "recipe.php";
$error = '';
if(count($_POST)>0){
     $result = Cooking\Recipe::addRecipe($_POST['title'],$_POST['mainIngredient'],$_POST['cuisine'],$_POST['url'],$_POST['tasteRating'],$_POST['notes'],$_POST['imageUrl'],$_POST['videoUrl'],$_POST['preparationRating'],$_POST['cleanUpRating'],$_POST['ingredients'],$_POST['quantities'],$_POST['instructions'],$_POST['servings']);
     if($result==='success'){
         header('Location: index.php');
     }else{
         $error=$result;
     }
}else{
    $connection = openConnection();
    $query = "SELECT Id,Title FROM Ingredients ORDER BY Title";
    $ingredients = array();
    $results = $connection->query($query);
    while ($row = $results->fetch_assoc()){
        $ingredients[]=$row;
    }

    $query = "SELECT Id,Title FROM Cuisines ORDER BY Title";
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
        <h1>Add Meals</h1>
        <p><?=$error?></p>
        <form action="addMeal.php" method="post" role="form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control"  required/>
            </div>
            <div class="form-group">
                <label for="url">Url:</label>
                <input type="text" name="url" class="form-control"  required/>
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
            <select name="cuisine" class="form-control">
            <?php
            foreach($cuisines as $cuisine){
                ?>
                <option value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                <?php
            }
            ?>    
            </select>
            </div>
            
            <div class="form-group">
                <label for="servings">Taste Rating:</label>
            <select name="servings" class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                </select>
                </div>
            
            
            <div class="form-group">
                <label for="mainIngredient">Main Ingredient:</label>
                <select name="mainIngredient" class="form-control">
                    <?php
                    foreach($ingredients as $ingredient){
                        ?>
                        <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                        <?php
                    }
                    ?>    
                </select>
            </div>
            <label>All Ingredients:</label>
            <div id="ingredientsContainer" class="controls form-inline">
            <div class="ingredient controls form-inline">
                <div class="form-group">
                    <label>Ingredient:</label>
                    <select name="ingredients[]" class="form-control">
                        <?php
                        foreach($ingredients as $ingredient){
                            ?>
                            <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                            <?php
                        }
                        ?>    
                    </select>
                    <label>Quantity:</label>
                    <input type="text" name="quantities[]" required/>
                    <div class="addIngredient btn btn-default form-control">+</div>
                    <div class="removeIngredient btn btn-default form-control">-</div>
                </div>
            </div>
            </div>
            
            <label>Cooking Instructions:</label>
            <div id="instructionsContainer" class="controls form-inline">
            <div class="instruction controls form-inline">
                <div class="form-group">
                    <label>Step:</label>
                    <textarea name="instructions[]" class="form-group"></textarea>
                    <div class="addStep btn btn-default form-control">+</div>
                    <div class="removeStep btn btn-default form-control">-</div>
                </div>
            </div>
            </div>
            
            
            
            
            <div class="form-group">
                <label for="imageUrl">Image:</label>
            <input type="text" name="imageUrl" class="form-control" />
                </div>
                <div class="form-group">
                <label for="videoUrl">Video:</label>
            <input type="text" name="videoUrl" class="form-control" />
                </div>
            
            <div class="form-group">
                <label for="tasteRating">Taste Rating:</label>
            <select name="tasteRating" class="form-control">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
                </div>
                <div class="form-group">
                <label for="preparationRating">Preparation Difficulty:</label>
            <select name="preparationRating" class="form-control">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
                </div>
                <div class="form-group">
                <label for="cleanUpRating">Clean Up Rating:</label>
            <select name="cleanUpRating" class="form-control">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
                </div>
                <div class="form-group">
                <label for="notes">Comments:</label>
                <textarea name="notes" class="form-control"></textarea>
                </div>
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