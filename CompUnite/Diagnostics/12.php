<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../resources/style.css"/>
        <title>CompUnite</title>
    </head>
    <body>
        <div class="diagnosticForm">
            Have you tried shutting the computer down completely, removing the side cover, and, while holding the fans for the CPU and case in place, air dusting the inside?            
            <form action="../index.php" method="post">
                <input type="radio" name="diagnostic" value="problemSolved" required>That solved my problem<br>  
                <input type="radio" name="diagnostic" value="11" required>I'm still having issues<br><br>
                <input type="submit" name="submit"> 
            </form>
        </div>
    </body>
</html>