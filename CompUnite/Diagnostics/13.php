<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../resources/style.css"/>
        <title>CompUnite</title>
    </head>
    <body>
        <div class="diagnosticForm">
            Do you think your computer may be infected, or are there any indications of a computer virus or ransomware (pop-ups, lock-screen with message pretending to be from “Microsoft” or law-enforcement)?         
            <form action="../index.php" method="post">
                <input type="radio" name="diagnostic" value="15" required>Yes<br>  
                <input type="radio" name="diagnostic" value="repairs/diagnosticOther" required>No<br><br>
                <input type="submit" name="submit"> 
            </form>
        </div>
    </body>
</html>