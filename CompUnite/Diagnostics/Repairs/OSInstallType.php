<html>
    <head>        
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../../resources/style.css"> 
        <title>CompUnite</title>
    </head>
    <body>
        <div class="diagnosticForm">
            It sounds like you need to re-install your operating system.
            <br>Do you have a lot of data on your computer(pictures, music, documents etc.)?
            <br>(Programs/Applications will not be recovered when the operating system is re-installed,
            <br>and have to be manually re-installed)
            <form action="../../index.php" method="post">
                <input type="radio" name="diagnostic" value="Repairs/OSInstallWithData" required>Yes<br>  
                <input type="radio" name="diagnostic" value="Repairs/OSInstallNoData" required>No<br>
                <input type="submit" name="submit"> 
            </form>
        </div>
    </body>
</html>