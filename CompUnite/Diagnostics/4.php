<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../resources/style.css"/>
        <title>CompUnite</title>
    </head>
    <body>
        <div class="diagnosticForm">
            Is the computer plugged into a wall socket or power bar/strip?            
            <form action="../index.php" method="post">
                <input type="radio" name="diagnostic" value="repairs/diagnosticWallSocket" required>Wall socket<br>  
                <input type="radio" name="diagnostic" value="repairs/diagnosticPowerStrip" required>Power strip<br><br>
                <input type="submit" name="submit"> 
            </form>
        </div>
    </body>
</html>