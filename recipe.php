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
        if($tempTitle!==NULL &&  $tempMainIngredient !== NULL && $tempUrl !== NULL)
        {
            $this->connection = openConnection();
            $query = 'INSERT INTO recipe (title, mainIngredient,url) VALUES (?,?,?)';
            $recipes = $this->connection->prepare($query);
            $recipes->bind_param('sss',$tempTitle, $tempMainIngredient,$tempUrl);
            $recipes->execute(); 
            $recipes->close();
            
            if($this->connection->insert_id > 0){
                $this->connection->close();
                header('Location index.php');   
            }else{
                $this->connection->close();
                header('Location error.php');
            }
        }
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
    
    public function getRecipeById(){}
    
    public function getRecipeByName($recipeName){
        $connection = openConnection();
        $query = 'SELECT TOP 1 * FROM recipe WHERE title = ?';
        $receipe = $connection->query($query);
        if ($recipe->num_rows>0) {
            while($meal = $recipe->fetch_assoc()){
                $this->id = $meal['id'];
$this->title = $meal['title'];
$this->mainIngredient = $meal['mainIngredient'];
$this->url = $meal['url'];
$this->dateModified = $meal['dateModified'];
            }
        }
        $recipe->close();
        $connection->close();
        return $this;
    }
}
?>