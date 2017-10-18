<?php
/*
 * Author: Gregory Gonzalez
 * getServiceProviders.php
 * This function retrieves a set of active service providers from the database based on the type of repair,
 * and the session zip code (passed as parameters), and prints a table with the service provider information using CSS styling parameters.
 * Also handles situations where no service providers are returned for the session zip code.
 */
    function getServiceProviders($zip, $repair, $conn, $cssRepairTable, $cssRepairHeader, $cssRepairTd){
        $sqlSelect = "SELECT
                        name,
                        image_url,
                        url,
                        review_count,
                        rating,
                        address1,
                        address2,
                        address3,
                        city,
                        state,
                        zip_code,
                        country,
                        phone,
                        $repair
                    FROM 
                        serviceproviders 
                    WHERE
                        $repair!='NULL' AND
                        zip_code = '$zip' AND
                        zip_code <> 'null' AND
                        Active = 'true'";
        try
        {
            //Executes query and returns rows as $result
            $stmt = $conn->prepare($sqlSelect);
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //If no records are returned, the session zip is set to null, and the select zip code form is displayed within an iframe on the current page
            //When the user submits a new zip, then the current page reloads using the new zip code.
            if (count($records) === 0)
            {
                $_SESSION['zip'] = null; 
                echo "<iframe class=\"noResultsFrame\" src=\"http://localhost/compunite/diagnostics/1.php?noresults=true&zip=$zip&lastUrl=http://localhost".$_SERVER['REQUEST_URI']."\"/>";
            }
            //Displays the service provider information and repair pricing in a table structure
            else
            {
                $displayFields = array("name", "phone", "review_count", "rating", "address1", "address2", "address3", "city", "state", "zip_code", "country");
                
                echo "<table class='$cssRepairTable'><tr>";
                echo "<td class='$cssRepairHeader' colspan=\"2\">Service Provider(s)</td>";
                echo "<td class='$cssRepairHeader'>Service Cost</td>";
                echo "</tr>";


                foreach ($records as $row)
                {
                    echo "<tr><td  class=\"$cssRepairTd\"><img  style=\" max-height: 150px; max-width: 150px;\" src='" . $row['image_url'] . "' alt=\"No Image Available\"/></td>";
                    echo "<td  class=\"$cssRepairTd\"><table style=\"text-align: left; width:100%;\">";
                    
                    foreach ($displayFields as $field)
                    {
                        if ($row[$field] != null)
                        {
                            if ($field === "name")
                            {
                                echo "<tr><td><a href=\"". $row['url'] . "\" target=\"_blank\">" . $row[$field] . "</a></td></tr>";

                            }
                            else if ($field === "review_count")
                            {
                                echo "<tr><td>" . $row[$field] . " review(s)</td></tr>";
                            }
                            else if ($field === "rating")
                            {
                                echo "<tr><td>" . $row[$field] . " star(s) average rating</td></tr>";
                            }
                            else if ($field === "city")
                            {
                                echo "<tr><td>" . $row[$field] . ", " . $row['state'] . " " . $row['zip_code'] . "</td></tr>";
                            }
                            else if ($field === "state")
                            {
                                //do nothing
                            }
                            else if ($field === "zip_code")
                            {
                                //do nothing
                            }
                            else if ($field === "phone")
                            {
                                //Converts number in +########### format to ###-###-####
                                if(preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $row[$field],  $matches ))
                                {
                                    $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
                                    echo "<tr><td>" . $result . "</td></tr>";
                                }
                            }
                            else
                            {
                                echo "<tr><td>" . $row[$field] . "</td></tr>";
                            }            
                        }
                                    
                    }
                    
                    echo "</table></td>";
                    echo "<td class=\"$cssRepairTd\">$".$row[$repair]."</td>";    
                    echo "</tr>";
                }
            }
            
        }

        catch(PDOException $e)
        {
            echo $sqlSelect . "<br/>" . $e->getMessage() . "<br/>";            
            return null;
        }
    }
?>