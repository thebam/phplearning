<?php
class Recipe
{
    private $id;
    private $title;
    private $mainIngredient;
    private $url;
    private $dateModified;
    
    public function addRecipe($tempTitle, $tempMainIngredient,$tempUrl){
        $connection = openConnection();
        
        $query = 'INSERT INTO recipes (title, mainIngredient,url) VALUES (?,?,?)';
        $recipes = $connection->prepare($query);
        $recipes->bind_param('sss',$tempTitle, $tempMainIngredient,$tempUrl);
        $recipes->execute();
        //echo "new id is ".$connection->insert_id;
        
        $recipes.close();
        $connection.close();
    }
}
?>