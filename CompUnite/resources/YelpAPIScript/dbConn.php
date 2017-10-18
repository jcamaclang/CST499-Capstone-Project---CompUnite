<?php
/*
 * Author: Gregory Gonzalez
 * dbConn.php
 * Date Created: 9/6/2017
 * Last Updated: 10/3/2017
 * Establishes a connection to a MySQL database
 */
$servername = "localhost";
$username = "root";
$password = "";
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 
try {
    $conn = new PDO("mysql:host=$servername;dbname=compunite", $username, $password, $options);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully<br/>"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage() . "<br/>";
    }

?>