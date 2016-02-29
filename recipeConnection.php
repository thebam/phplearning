<?php
$dbPassword='pass';
$dbUser='testUser';
$dbServer='localhost';
$dbName='recipes';
$connection;

function openConnection()
{
   global $connection;
   $connection = new mysqli($dbServer,$dbUser, $dbPassword, $dbName);
   if($connection->connect_errno){
    exit('Database connection failed due to:' .$connection->connect_error);
   }
   return $connection;
}


?>