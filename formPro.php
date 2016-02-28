<?php

print_r($_POST);
//make sure that the page has been posted
if(count($_POST)>0){
echo $_POST['txtFirstName'];
}
?>