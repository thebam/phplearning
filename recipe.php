<?php
namespace Cooking;
require_once "recipeConnection.php";
class Recipe
{
    public $id;
    public $title;
    public $mainIngredientId;
    public $cuisineId;
    public $url;
    public $rating;
    public $notes;
    public $dateModified;

    public static function addRecipe($tempTitle, $tempMainIngredientId,$tempCuisineId,$tempUrl,$tempTaste,$tempNotes,$tempImage,$tempVideo,$tempPrep,$tempClean,$tempIngredients,$tempSteps){
        $output="";
        if($tempTitle!==NULL &&  $tempMainIngredientId !== NULL && $tempCuisineId !== NULL && $tempUrl !== NULL&& $tempTaste !== NULL)
        {
            $connection = openConnection();
            $query = 'INSERT INTO recipes (Title, MainIngredientId,CuisineId,Url,TasteRating,Notes,ImageUrl,VideoUrl,PrepRating,CleanRating) VALUES (?,?,?,?,?,?,?,?,?,?)';
            $recipes = $connection->prepare($query);
            $recipes->bind_param('siisisssii',$tempTitle, intval($tempMainIngredientId),intval($tempCuisineId),$tempUrl,intval($tempTaste),$tempNotes,$tempImage,$tempVideo,intval($tempPrep),intval($tempClean));
            
            //TODO add $query->erroe_list
            $recipes->execute();
            if($connection->insert_id){
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
            $query = "DELETE FROM recipes WHERE Id = ?";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',$id);
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
        $recipe->bind_result($id,$title,$mainIngredientId,$cuisineId,$url,$rating,$notes,$dateCreated);
        $recipe->store_result();
        if ($recipe->num_rows>0) {
            while($recipe->fetch()){
                $this->id = $id;
                $this->title = $title;
                $this->mainIngredientId = $mainIngredientId;
                $this->cuisineId = $cuisineId;
                $this->rating = $rating;
                $this->notes = $notes;
                $this->url = $url;
                $this->dateModified = $dateCreated;
            }
        }
        $recipe->close();
        $connection->close();
    }
}
?>