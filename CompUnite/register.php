<?php
    session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <link rel="stylesheet" type="text/css" href="resources/style.css">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <base target="_parent">
    </head>
    <body>
        <div class="registerDiv">
            <h2>Register Below</h2>            
            <form action="resources/dbregister.php" method="POST"> 
                <input type="text" name="firstName" placeholder="First Name" required><br><br>
                <input type="text" name="lastName" placeholder="Last Name" required><br><br>
                <input type="text" name="email" placeholder="Email" required><br><br>
                <input type="number" name="zip" placeholder="Zip Code" required><br><br>
                <input type="text" name="username" placeholder="Username" required><br><br>
                <input type="password" name="password" placeholder="Password" required><br><br>
                <button type="submit" name="submit">Register</button>
            </form>
        </div>
    </body>
</html>

