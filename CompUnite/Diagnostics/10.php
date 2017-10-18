<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../resources/style.css"/> 
        <title>CompUnite</title>
    </head>
    <body>
        <div class="diagnosticForm">
            Does the computer say its restarting to install updates?           
            <form action="../index.php" method="post">
                <input type="radio" name="diagnostic" value="repairs/NormalBehavior" required>Yes<br>  
                <input type="radio" name="diagnostic" value="repairs/NotNormalBehavior" required>No<br><br>
                <input type="submit" name="submit"> 
            </form>
        </div>
    </body>
</html>