<?php

$dsn = 'mysql:host=localhost;dbname=compunite';
$username = 'root';
$password = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 

try
{    
    $conn = new PDO($dsn, $username, $password, $options);
    //echo "Connection successful";
} 
catch (Exception $e) 
{
    echo "Connection failed: " . $e->getMessage();
    die();
}


?>

