<?php
require_once "recipe.php";
$error = '';
if(count($_POST)>0){
    $result = Recipe::addRecipe($_POST['title'],$_POST['mainIngredient'],$_POST['cuisine'],$_POST['url'],$_POST['rating']);
    if($result==='success'){
        header('Location: index.php');
    }else{
        $error=$result;
    }
}else{
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
        <h1>Add Meals</h1>
        <p><?=$error?></p>
        <form action="addMeal.php" method="post">
            <input type="text" name="title" placeholder="Title" required/>
            <select name="mainIngredient">
            <?php
            foreach($ingredients as $ingredient){
                ?>
                <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                <?php
            }
            ?>    
            </select>
            <select name="cuisine">
            <?php
            foreach($cuisines as $cuisine){
                ?>
                <option value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                <?php
            }
            ?>    
            </select>
            <input type="text" name="url" placeholder="Recipe URL" required/>
            <select name="rating">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
            <input type="submit" />
        </form>
    </body>
</html>