<?php
$HOSTNAME= 'localhost';
$USERNAME= 'rakib';
$PASSWORD= 'new_password';
$DATABASE= 'signupforms';

$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(!$con){
   
    die(mysqli_error($con));
}

?>