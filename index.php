<?php
//comments
require "Person.php";

define('GENDER', 'male');
$name = 'jason';
$age = 36;
$alive = 'true';

//returns 1 if true and nothing if false
echo is_string($name);
// echo is_string($age);
// 
// echo $age;
echo GENDER;
$strAge = (string)$age;
echo $strAge;

doSomething($name,returnSomething());
doSomething($name,returnSomething($age));

echo $alive;
setGlobal();
echo $alive;

$uppercase = 'this began lowercase';
$lowercase = 'THIS BEGAN UPPERCASE';

$uppercase = strtoupper($uppercase);
$lowercase = strtolower($lowercase);

echo $uppercase;
echo $lowercase;

$authors = array('Jason','La Shan', 'Elana');
array_push($authors, 'Janet');
//this is preferred because it will create an array if it doesn't exists
$authors[] = 'Janet';
sort($authors);

print_r($authors);
foreach($authors as $author){
    echo($author);
}


$members = array('dad'=>'Jason', 'mom'=>'La Shan','baby'=>'Elana'); 
if (array_key_exists('dad',$members)){ 
    echo $members['dad'];
}
asort($members);
print_r($members);

ksort($members);
print_r($members);

foreach($members as $key => $member){ 
    echo($key); 
    echo($member); 
}




function doSomething($myName, $myAge){
    echo "$myName will be ". $myAge ." in 5 years.";
    echo "\n";
}

function returnSomething($myAge=5){
    
    return ($myAge + 5);
}

function setGlobal(){
    global $alive;
    $alive = 'false';
}



class Author extends Person
{
    public $penName = "Special D";
    
    public function getPenName(){
        return $this->penName;
        
    }
}

$myObject = new Author('Jason','Saunders',1979);
$myObject->setFirstName('Jay');
echo $myObject->getFirstName();
echo $myObject->getPenName();
echo $myObject::AVGLIFESPAN;
?>