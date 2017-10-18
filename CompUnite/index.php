<?php

session_start();
include ("resources/setBody.php");
require 'C:\xampp\htdocs\CompUnite\dbConn\dbConn.php';

    if (isset($_POST['diagnostic']))
    {
        $diagnostic = filter_input(INPUT_POST, 'diagnostic');
        header("location: diagnostics/".$diagnostic.".php");
    }
    else
    {
        $loginBool = false;
        if (isset($_SESSION['id']))
            $loginBool = true;
        setBody($loginBool);   
        
    }            
?>