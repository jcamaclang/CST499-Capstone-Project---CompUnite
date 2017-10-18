<?php

if(isset($_POST['submit'])){
    
    include_once 'C:\xampp\htdocs\CompUnite\dbConn\dbConn.php';
    
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $email = filter_input(INPUT_POST, 'email');
    $zip = filter_input(INPUT_POST, 'zip');
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');    
  
    if(empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($password)) {
        header("Location: ../register.php?register=empty");
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: ../index.php?invalidEmail=true");
            exit();
        } else {
            $sql = "SELECT COUNT(username) AS number FROM users WHERE username=:username";
            $statement = $conn->prepare($sql);
              
            $statement->bindValue(':username', $username);
              
            $statement->execute();
               
            $row = $statement ->fetch(PDO::FETCH_ASSOC);
                
            if ($row['number'] > 0){
                header("Location: ../index.php?userExist=true");
                exit();
            } else {
                $sql ="INSERT INTO users (firstName, lastName, email, zipCode, username, password) VALUES (:firstName, :lastName, :email, :zipCode, :username, :password)";
                $statement = $conn->prepare($sql);
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    
                $statement->bindValue(':firstName', $firstName);
                $statement->bindValue(':lastName', $lastName);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':zipCode', $zip);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':password', $hashedPassword);
                    
                $result = $statement->execute();
                    
                if ($result){
                    header("Location: ../index.php?register=true");
                    exit();
                } else {
                    header("Location: ../index.php?dbFail=true");
                    exit();
                } 
            }
        }
    } 
    
} else {
    header("Location: ../register.php");
    exit();
}


