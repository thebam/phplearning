<?php
namespace Cooking;
require_once "recipeConnection.php";
class Recipe
{
    public $id;
    public $title;
    public $mainIngredientId;
    public $cuisineId;
    public $cuisineName;
    public $url;
    public $tasteRating;
    public $notes;
    public $dateModified;
    
    public $imageUrl;
    public $videoUrl;
    public $prepRating;
    public $cleanRating;
    public $servings;
    
    public $ingredients = array();
    public $quantities = array();
    public $instructions = array();

    public static function addRecipe($tempTitle, $tempMainIngredientId,$tempCuisineId,$tempUrl,$tempTaste,$tempNotes,$tempImage,$tempVideo,$tempPrep,$tempClean,$tempIngredients,$tempQuantities,$tempSteps,$tempServings){
        $output="";
        if($tempTitle!==NULL &&  $tempMainIngredientId !== NULL && $tempCuisineId !== NULL && $tempUrl !== NULL&& $tempTaste !== NULL)
        {
            $connection = openConnection();
            $query = 'INSERT INTO recipes (Title, MainIngredientId,CuisineId,Url,TasteRating,Notes,ImageUrl,VideoUrl,PrepRating,CleanRating,Servings) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
            $recipes = $connection->prepare($query);
            $recipes->bind_param('siisisssiii',$tempTitle, intval($tempMainIngredientId),intval($tempCuisineId),$tempUrl,intval($tempTaste),$tempNotes,$tempImage,$tempVideo,intval($tempPrep),intval($tempClean),intval($tempServings));
            
            //TODO add $query->erroe_list
            $recipes->execute();
            if($connection->insert_id){
                $recipeId = $connection->insert_id;
                if(count($tempIngredients) > 0){
                    if(count($tempIngredients) == count($tempQuantities)){
                        for ($x=0;$x<count($tempIngredients);$x++) {
                            $query = 'INSERT INTO recipeIngredients (RecipeId, IngredientId,Quantity) VALUES (?,?,?)';
                            $recipes = $connection->prepare($query);
                            $recipes->bind_param('iis',$recipeId, intval($tempIngredients[$x]),$tempQuantities[$x]);
                            $recipes->execute();
                        }
                    }
                }
                if(count($tempSteps) > 0){
                    for ($x=0;$x<count($tempSteps);$x++) {
                        $query = 'INSERT INTO steps (RecipeId, Description ,DisplayOrder) VALUES (?,?,?)';
                        $recipes = $connection->prepare($query);
                        $recipes->bind_param('isi',$recipeId,$tempSteps[$x],intval($x));
                        $recipes->execute();
                    }
                }
                $output ="success";
            }else{
                $output ="failed";
            }
            $recipes->close();
            $connection->close();
        }
        return $output;
    }
    public static function deleteRecipe($id){
        if($id!==NULL)
        {
            $connection = openConnection();
            $query = "DELETE FROM steps WHERE RecipeId = ?";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            
            $query = "DELETE FROM recipeIngredients WHERE RecipeId = ?";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            
            $query = "DELETE FROM recipes WHERE Id = ?;";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            $recipe->close();
            $connection->close();
        }
    }
    
    public static function editRecipe($id,$tempTitle, $tempMainIngredientId,$tempUrl,$tempCuisineId,$tempRating,$tempNotes){
        if($id!==NULL &&$tempTitle!==NULL &&  $tempMainIngredientId !== NULL && $tempUrl !== NULL)
        {
            $connection = openConnection();
            $query = 'UPDATE recipes SET Title=?, MainIngredientId=?,CuisineId=?, Url=?, Rating=?, Notes=? WHERE id=?';
            $recipes = $connection->prepare($query);
            $recipes->bind_param('siisisi',$tempTitle, intval($tempMainIngredientId),intval($tempCuisineId),$tempUrl,intval($tempRating),$tempNotes,intval($id));
            $recipes->execute(); 
            $recipes->close();
            $connection->close();
        }
    }
    
    public static function allRecipes(){
        $connection = openConnection();
        $recipes=array();
        $query = 'SELECT * FROM recipes ORDER BY Title';
        $results = $connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $recipes[]=$row;
        }
        $connection->close();
        return ($recipes);
    }
    
    
    public function getRecipeById(){}
    
    public function getRecipeByName($recipeName){
        $connection = openConnection();
        $query = 'SELECT * FROM recipes WHERE title = ?';
        $recipe = $connection->prepare($query);
        $recipe->bind_param('s',$recipeName);
        $recipe->execute();
        $recipe->bind_result($id,$title,$mainIngredientId,$cuisineId,$url,$tasteRating,$notes,$dateCreated,$imageUrl,$videoUrl,$prepRating,$cleanRating,$servings);
        $recipe->store_result();
        if ($recipe->num_rows>0) {
            while($recipe->fetch()){
                $this->id = $id;
                $this->title = $title;
                $this->mainIngredientId = $mainIngredientId;
                $this->cuisineId = $cuisineId;
                $this->tasteRating = $tasteRating;
                $this->notes = $notes;
                $this->url = $url;
                $this->dateModified = $dateCreated;
                
                $this->imageUrl = $imageUrl;
                $this->videoUrl = $videoUrl;
                $this->prepRating = $prepRating;
                $this->cleanRating = $cleanRating;
                $this->servings = $servings;
            }
        }
        $recipe->close();
        $connection->close();
        
        $this->getRecipeInstructions();
        $this->getRecipeIngredients();
        $this->cuisineName = $this->getCuisineNameById($this->cuisineId);
    }
     
    private function getRecipeInstructions(){
        $connection = openConnection();
        $recipeId = intval($this->id);
        $query = 'SELECT Description FROM steps WHERE RecipeId = ? ORDER BY DisplayOrder';
        $recipe = $connection->prepare($query);
        $recipe->bind_param('i',$recipeId);
        $recipe->execute();
        $recipe->bind_result($description);
        $recipe->store_result();
        if ($recipe->num_rows>0) {
            while($recipe->fetch()){
                array_push($this->instructions,$description);
            }
        }
        $recipe->close();
        $connection->close();
    }

    private function getRecipeIngredients(){
        $connection = openConnection();
        $recipeId = intval($this->id);
        $query = 'SELECT i.Title,r.Quantity FROM recipeIngredients r, ingredients i WHERE r.IngredientId = i.Id AND r.RecipeId = ?';
        $recipe = $connection->prepare($query);
        $recipe->bind_param('i',$recipeId);
        $recipe->execute();
        $recipe->bind_result($ingredient,$quantity);
        $recipe->store_result();
        if ($recipe->num_rows>0) {
            while($recipe->fetch()){
                array_push($this->ingredients,$ingredient);
                array_push($this->quantities,$quantity);
            }
        }
        $recipe->close();
        $connection->close();
    }
    
    public function getCuisineNameById($cuisineId){
        $connection = openConnection();
        $cuisineId = intval($cuisineId);
        $cuisineName = "";
        $query = 'SELECT Title FROM cuisines WHERE Id = ?';
        $recipe = $connection->prepare($query);
        $recipe->bind_param('i',$cuisineId);
        $recipe->execute();
        $recipe->bind_result($title);
        $recipe->store_result();
        if ($recipe->num_rows>0) {
            while($recipe->fetch()){
                $cuisineName = $title;
            }
        }
        $recipe->close();
        $connection->close();
        return $cuisineName;
    }
    
}
?>