<?php
class Person{
    const AVGLIFESPAN = 70;
    protected $firstName;
    protected $lastName;
    protected $yearBorn;
    
    function __construct($fname="",$lname="",$year=""){
        $this->firstName = $fname;
        $this->lastName = $lname;
        $this->yearBorn = $year;
    }
    
    public function getFirstName(){
        return $this->firstName;
    }
    public function setFirstName($name){
        $this->firstName = $name;
    }
}
?>