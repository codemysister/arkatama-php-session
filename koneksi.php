<?php

$server = 'localhost';
$database = 'arkatama_store';
$username = 'root';
$password = '';

$conn = mysqli_connect($server, $username, $password, $database);

if(!$conn){
    die("Connection failed: ". mysqli_connect_error());
}

// mysqli_close($conn);

?>