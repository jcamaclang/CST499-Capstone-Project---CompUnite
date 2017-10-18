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
            Based on your responses, we think you may just be seeing a pop-up meant to trick you into thinking your computer is infected.
            <br>Please try the following (for Windows users only):
            <br>1.	Right click the task bar at the bottom of the screen
            <br>2.	Open “Task Manager”
            <br>3.	Right click on your Internet browser (Google Chrome, Internet Explorer, Firefox) and select “End Task” (click yes to any confirmation messages).
            <br>4.	Re-open the browser, and DO NOT restore any web-pages or tabs.
            <br>5.	Try going to different web-pages. 
            <br>
            <br>If the pop-ups return when browsing different web pages, you may need a virus removal, otherwise, if the computer seems fine, no action is probably necessary.
            <br><br>Click <a href="https://www.howtogeek.com/126911/what-to-do-if-you-get-a-virus-on-your-computer/">here</a> for more information or watch the video below.
            <br><br>
            <div style="text-align: center">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/J66pjLEaMWk" frameborder="0" allowfullscreen></iframe>
            </div>
            <?php
            require("../../dbConn/dbConn.php");
            include '../../resources/getServiceProviders.php';
            session_start();
            getServiceProviders($_SESSION['zip'], "VirusRemoval", $conn, 'RepairTable', 'RepairHeader', 'RepairTd');
           
            $conn = null;
            ?>
        </div>
    </body>
</html>
