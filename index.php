<?php
//comments

define('GENDER', 'male');
$name = 'jason';
$age = 36;
$alive = 'true';

//returns 1 if true and nothing if false
// echo is_string($name);
// echo is_string($age);
// 
// echo $age;
// echo GENDER;

doSomething($name,returnSomething());
doSomething($name,returnSomething($age ));

echo $alive;
setGlobal();
echo $alive;


function doSomething($myName, $myAge){
    echo $myName ;
    echo "\n";
    echo ($myAge);
    echo "\n";
}

function returnSomething($myAge=5){
    
    return ($myAge + 5);
}

function setGlobal(){
    global $alive;
    $alive = 'false';
}

?>