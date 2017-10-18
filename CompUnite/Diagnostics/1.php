<?php
/*
 * Author: Gregory Gonzalez
 * 1.php
 * This is the first diagnostic page. If no zip code is set for the session, then the user is first asked for a zip code
 * (if logged in, the user's zip code is automatically used. The user is able to choose a different zip code if no service
 * providers are found for their current zip code.
 */


session_start();

//Variables used to define application routes
$target = "current";
$makeNull = "NotNull";


//This is used to allow the user to select a new zip code, and return the page they were currently at
//in the diganostic process
if (isset($_GET['makenull']))
{
    $makeNull = null;
}

//If no session zip variable is set, or makeNull is set to null
//then the form to select a new zip code is shown, and upon submission
//the session zip variable is set to the new value
if (!isset($_SESSION['zip']) || $makeNull === null)
{
    ?>
    <html>
        <head>
            <meta>        
            <link rel="stylesheet" type="text/css" href="../resources/style.css"/> 
            <title>CompUnite</title>
        </head>
        <body>
             <div class="zipCodeForm">
    <?php
    ////Used to set the session zip variable and return the user
    //to the last page they were on in the diagnostic process
    if (isset($_POST['newZip']))
    {
        $_SESSION['zip'] = filter_input(INPUT_POST, 'zip');
        $lastUrl = filter_input(INPUT_POST, 'newZip');
        die(header("Location: $lastUrl"));
    }
    
    //Used to display the form where the user can input their zip code
    if (!isset($_POST['zip']))
    {
        //Displays in an iframe on any repair page where no service providers are found for the current zip
        if (isset($_GET['noresults']))
        {
            $zip = filter_input(INPUT_GET, 'zip');
            $lastUrl = filter_input(INPUT_GET, 'lastUrl');
             $target = "_parent";                                          
            echo "No service providers available for $zip at this time";
        }
       
    ?>    
                 <br><br>To get started, please enter a 5 digit zip code:<br>
                (currently servicing most zip codes in New York,<br>
                 Los Angeles, Chicago, Houston, Philadelphia, Phoenix,<br> 
                 San Antonio, San Diego, Dallas, and San Jose)<br>
                <?php                
                    //The first form is displayed when the user starts diagnostics, and there is no zip code set for the session
                    if ($target == "current") 
                    {
                ?>
                        <form action="http://localhost/compunite/diagnostics/1.php" method="post">
                <?php                
                    } 
                    else 
                    {
                        //The second form is displayed when the user needs to select a different zip, because no service providers were returned for their current zip
                    ?>
                           <form action="http://localhost/compunite/diagnostics/1.php?makenull=true" method="post" target="_parent">   
                            <input type="hidden" name="newZip" value="<?php echo $lastUrl; ?>"/>
                    <?php
                                        
                    }
                    ?>
                    <input type="number" name="zip" required/>
                    <input type="submit" name="submit" value="Submit"/>
                </form>
            </div>
        </body>
    </html>
    <?php 
    }
    else
    {
        //Sets the session zip variable when no zip is set, and the user is not logged in
        $_SESSION['zip'] = filter_input(INPUT_POST, 'zip');
        header("location: 1.php");
    }
}
else
{   //The first set of diagnostic questions are displayed when the session zip variable is set
    ?>
        <html>
            <head>
                <meta charset="UTF-8">     
                <link rel="stylesheet" type="text/css" href="../resources/style.css"/> 
                <title>CompUnite</title>
            </head>
            <body>                
                <div class="diagnosticForm">
                    What Happened?            
                    <form action="../index.php" method="post">
                        <input type="radio" name="diagnostic" value="3" required>My computer won't turn on (no power)<br>  
                        <input type="radio" name="diagnostic" value="5" required>My computer turns on, but keeps restarting<br>                
                        <input type="radio" name="diagnostic" value="7" required>My computer turns on, but shuts down/crashes while using it<br>  
                        <input type="radio" name="diagnostic" value="13" required>My computer turns on, but I can’t use it<br>  
                        <input type="radio" name="diagnostic" value="repairs/dataRecovery" required>I can’t get to my data on my external or internal hard drive when I plug it in<br>  
                        <input type="radio" name="diagnostic" value="repairsList" required>I know what is wrong with my computer and the service I need<br><br>
                        <input type="submit" name="submit" value="Next"> 
                    </form>
                </div>
            </body>
        </html>
    <?php
}
?>
