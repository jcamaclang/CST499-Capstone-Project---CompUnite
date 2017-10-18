<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../resources/style.css"/>
        <title>CompUnite</title>
    </head>
    <body>
        <div class="diagnosticForm">
            Select a repair         
            <form action="../index.php" method="post">
                <input type="radio" name="diagnostic" value="repairs/virusRemoval" required>Virus removal/tune-up<br>  
                <input type="radio" name="diagnostic" value="repairs/hardwareRepair" required>Hardware repair/replacement<br>                
                <input type="radio" name="diagnostic" value="repairs/OSInstallNoData" required>Operating system installation<br>  
                <input type="radio" name="diagnostic" value="repairs/OSInstallWithData" required>Operating system installation with data recovery<br>  
                <input type="radio" name="diagnostic" value="repairs/applicationInstall" required>Application installation<br>  
                <input type="radio" name="diagnostic" value="repairs/diagnosticOther" required>Diagnostic<br>
                <input type="radio" name="diagnostic" value="repairs/dataRecovery" required>Data recovery<br><br>
                <input type="submit" name="submit"> 
            </form>
        </div>
    </body>
</html>