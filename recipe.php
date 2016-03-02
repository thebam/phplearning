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
    
    
    public function addRecipe($tempTitle, $tempMainIngredient,$tempUrl){
        $this->connection = openConnection();
        
        $query = 'INSERT INTO recipe (title, mainIngredient,url) VALUES (?,?,?)';
        $recipes = $this->connection->prepare($query);
        $recipes->bind_param('sss',$tempTitle, $tempMainIngredient,$tempUrl);
        $recipes->execute();
        //echo "new id is ".$connection->insert_id;
        // 
        $recipes->close();
        $this->connection->close();
    }
    
    public function allRecipes(){
        $this->connection = openConnection();
        $query = 'SELECT * FROM recipe ORDER BY title';
        $this->recipes = $this->connection->query($query);
        return ($this->recipes);
    }
    
    public function closeRecipes(){
         $this->recipes->close();
          $this->connection->close();
    }
}
?>