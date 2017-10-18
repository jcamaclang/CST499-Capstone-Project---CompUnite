<?php

session_start(); 

if (isset($_POST['signin'])){
    
    include 'C:\xampp\htdocs\CompUnite\dbConn\dbConn.php';
    
    $user = filter_input(INPUT_POST, 'user');
    $password = filter_input(INPUT_POST, 'password');
    
    if (empty($user) || empty($password)){
        header("Location: ../index.php?login=empty");
        exit();
    } else { 
        $sql = "SELECT * FROM users WHERE username=:user OR email=:user";
        $statement = $conn->prepare($sql);
                
        $statement->bindValue(':user', $user);   
        $statement->execute();
         
        $row = $statement ->fetch(PDO::FETCH_ASSOC);
        
        if ($row === false){
            header("Location: ../index.php?login=error");
            exit();
        } else {
            $checkPassword = password_verify($password, $row['password']);
            if (!$checkPassword){
                header("Location: ../index.php?login=error");
                exit();
            } else {
                $_SESSION['id'] = $row['id'];
                $_SESSION['zip'] = $row['zipCode'];
                $_SESSION['firstName'] = $row['firstName'];
                $_SESSION['lastName'] = $row['lastName'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username']; 
                header("Location: ../index.php?login=success");
                exit();
            }
        }
                
    }
    
} else {
    header("Location: ../index.php?login=error");
    exit();
}
