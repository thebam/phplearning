<?php
require_once "recipeConnection.php";
class Recipe
{
    private $id;
    private $title;
    private $mainIngredient;
    private $url;
    private $dateModified;
    private $connection;
    private $recipes;
    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getMainIngredient(){
        return $this->mainIngredient;
    }
    public function getUrl(){
        return $this->url;
    }
    public function getDateModified(){
        return $this->dateModified;
    }
    public static function addRecipe($tempTitle, $tempMainIngredientId,$tempCuisineId,$tempUrl,$tempRating){
        $output="";
        if($tempTitle!==NULL &&  $tempMainIngredientId !== NULL && $tempCuisineId !== NULL && $tempUrl !== NULL&& $tempRating !== NULL)
        {
            $connection = openConnection();
            $query = 'INSERT INTO recipes (Title, MainIngredientId,CuisineId,Url,Rating) VALUES (?,?,?,?,?)';
            $recipes = $connection->prepare($query);
            $recipes->bind_param('siisi',$tempTitle, intval($tempMainIngredientId),intval($tempCuisineId),$tempUrl,intval($tempRating));
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
    
    public function editRecipe($id,$tempTitle, $tempMainIngredient,$tempUrl){
        if($id!==NULL &&$tempTitle!==NULL &&  $tempMainIngredient !== NULL && $tempUrl !== NULL)
        {
            $this->connection = openConnection();
            $query = 'UPDATE recipe SET title=?, mainIngredient=?, url=? WHERE id=?';
            $recipes = $this->connection->prepare($query);
            $recipes->bind_param('sssi',$tempTitle, $tempMainIngredient,$tempUrl,$id);
            $recipes->execute(); 
            $recipes->close();
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
        $query = 'SELECT * FROM recipe WHERE title = ?';
        $recipe = $connection->prepare($query);
        $recipe->bind_param('s',$recipeName);
        $recipe->execute();
        $recipe->bind_result($id,$title,$mainIngredient,$url,$dateCreated);
        $recipe->store_result();
        if ($recipe->num_rows>0) {
            while($recipe->fetch()){
                $this->id = $id;
$this->title = $title;
$this->mainIngredient = $mainIngredient;
$this->url = $url;
$this->dateModified = $dateModified;
            }
        }
        $recipe->close();
        $connection->close();
    }
}
?>