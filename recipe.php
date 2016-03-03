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
    public function addRecipe($tempTitle, $tempMainIngredient,$tempUrl){
        if($tempTitle!==NULL &&  $tempMainIngredient !== NULL && $tempUrl !== NULL)
        {
            $this->connection = openConnection();
            $query = 'INSERT INTO recipe (title, mainIngredient,url) VALUES (?,?,?)';
            $recipes = $this->connection->prepare($query);
            $recipes->bind_param('sss',$tempTitle, $tempMainIngredient,$tempUrl);
            $recipes->execute(); 
            $recipes->close();
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