<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "recipe.php";
$error = '';
if(count($_GET)>0){
        $myRecipe = new Cooking\recipe();
        $myRecipe->getRecipeByName(urldecode($_GET['name']));
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        </head>
    <body>
        <style>
            header{
                
            }
            .hero{
                background-image:url('<?=$myRecipe->imageUrl?>');
                background-size: cover;
                background-repeat: no-repeat;
                background-color: #000;
                padding:15px;
            }
            
            .hero h1{
                color:#fff;
            }
            
            .hero p{
                color:#ccc;
            }
            
            .hero a{
                color:#fff;
            }
            
            .hero .mainImage{
                width:100%;
            }
        </style>
        <header>PAPER PLATE DAD</header>
        <div class="hero" >
           
                <div class="col-md-4">
            <h1><?=$myRecipe->title?></h1>
            <p>Recipe Source : <a href='<?=$myRecipe->url?>' target='_blank'><?=$myRecipe->url?></a></p>
            <p>Cuisine :<?=$myRecipe->cuisineName?></p>
            <p>Servings :<?=$myRecipe->servings?></p>
            <hr/>
            <p>TASTE</p>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$myRecipe->tasteRating?>" aria-valuemin="0" aria-valuemax="5" style="width: <?=(intval($myRecipe->tasteRating)/5)*100?>%">
                    <?=$myRecipe->tasteRating?>
                </div>
            </div>
            <p>PREPARATION</p>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$myRecipe->prepRating?>" aria-valuemin="0" aria-valuemax="5" style="width: <?=(intval($myRecipe->prepRating)/5)*100?>%">
                    <?=$myRecipe->prepRating?>
                </div>
            </div>
            <p>CLEAN UP</p>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$myRecipe->cleanRating?>" aria-valuemin="0" aria-valuemax="5" style="width: <?=(intval($myRecipe->cleanRating)/5)*100?>%">
                    <?=$myRecipe->cleanRating?>
                </div>
            </div>
            </div>
             <div class="col-md-4">
                <img class="mainImage" src="<?=$myRecipe->imageUrl?>"/>
                </div>
            <div class="col-md-4">
                <div class="bs-example" data-example-id="responsive-embed-16by9-iframe-youtube"> 
                <div class="embed-responsive embed-responsive-16by9"> 
                    <iframe class="embed-responsive-item" src="<?=$myRecipe->videoUrl?>" allowfullscreen=""></iframe> 
                    </div> 
                    </div>
                </div>
            <div class="clearfix">
            </div>
        </div>
        
        
            
            
            <label>Ingredients:</label>
            <ul>
                <?php
                for ($x=0;$x<count($myRecipe->ingredients);$x++) {
                ?>
                <li><?=$myRecipe->ingredients[$x]." - ".$myRecipe->quantities[$x]?></li>
                <?php
                }
                ?>
                </ul>
<label>Cooking Instructions:</label>
            <ul>
                <?php
                foreach ($myRecipe->instructions as $instruction) {
                ?>
                <li><?=$instruction?></li>
                <?php
                }
                ?>
                </ul>
            
            
            

            
            
            
            
            
            
            
            <p><?=$myRecipe->notes?></p>
            
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
    </body>
</html>