<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../resources/style.css"/>
        <title>CompUnite</title>
    </head>
    <body>
        <div class="diagnosticForm">
            Do the pop-ups happen on all web-sites, or just certain ones?         
            <form action="../index.php" method="post">
                <input type="radio" name="diagnostic" value="repairs/virusRemoval" required>All web-sites<br>  
                <input type="radio" name="diagnostic" value="repairs/virusRemovalSomeWebsites" required>Just some<br><br>
                <input type="submit" name="submit"> 
            </form>
        </div>
    </body>
</html>