<?php
$dbPassword='pass';
$dbUser='testUser';
$dbServer='localhost';
$dbName='testdb';

$connection = new mysqli($dbServer,$dbUser, $dbPassword, $dbName);
print_r($connection);

if($connection->connect_errno){
    exit('Database connection failed due to:' .$connection->connect_error);
}
//$query = 'DELETE FROM Authors WHERE id = 4';
//$query = 'UPDATE Authors SET first_name = \'Jason\' WHERE id = 4';
//$query = 'INSERT INTO Authors (first_name,last_name,pen_name) VALUES (\'Jason\',\'Saunders\',\'Special D\')';
//$connection->query($query);

//This is the id of the newly created record
//echo "new id is ".$connection->insert_id;
$tempId = 1;
$query = 'SELECT first_name,last_name,pen_name FROM Authors WHERE id = ?';

$authors = $connection->prepare($query);
$authors->bind_param('i',$tempId);
$authors->execute();
$authors->bind_result($firstname,$lastname,$penname);
$authors->store_result();

 if($authors->num_rows>0){
     while($authors->fetch()){
         echo $firstname;
     }
}

//$authors= $connection->query($query);

// if($authors->num_rows>0){
//     while($author = $authors->fetch_assoc()){
//         echo $author['first_name'];
//     }
// }
$authors->close();
$connection->close();
?>