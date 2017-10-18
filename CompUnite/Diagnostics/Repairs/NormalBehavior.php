<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../../resources/style.css">
        <title></title>
    </head>
    <body>
        <div class="repairPage">
            Restarting to install updates is normal behavior for the computer. 
            <br>It sounds like your computer is okay, but if you're still having issues
            <br>you can contact the following service providers for a diagnostic, or see the video
            <br>below for information on how to disable automatic updates.
            <br><br>Click <a href="https://www.howtogeek.com/224471/how-to-prevent-windows-10-from-automatically-downloading-updates/">here</a> for more information or watch the video below.
            <br><br>
            <div style="text-align: center">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/m-bmRe0VEeQ" frameborder="0" allowfullscreen></iframe>
            </div>
            <?php
            
            require("../../dbConn/dbConn.php");
            include '../../resources/getServiceProviders.php';
            session_start();
            getServiceProviders($_SESSION['zip'], "Diagnostic", $conn, 'RepairTable', 'RepairHeader', 'RepairTd');
           
            $conn = null;
            ?>
            
        </div>
    </body>
</html>