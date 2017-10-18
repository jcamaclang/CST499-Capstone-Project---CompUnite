<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../../resources/style.css">
        <title></title>
    </head>
    <body>
        <div class="repairPage">
            Based on your responses, we recommend a professional install and setup your software.
            <br><br>Click <a href="http://www.dummies.com/software/for-seniors-how-to-install-a-new-computer-program/">here</a> for more information or watch the video below.
            <br><br>
            <div style="text-align: center">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/nbFWKuLujq4" frameborder="0" allowfullscreen></iframe>
            </div>
            <?php
            require("../../dbConn/dbConn.php");
            include '../../resources/getServiceProviders.php';
            session_start();
            getServiceProviders($_SESSION['zip'], "AppInstall", $conn, 'RepairTable', 'RepairHeader', 'RepairTd');
           
            $conn = null;
            ?>
        </div>
    </body>
</html>
