<?php
/*
 * Author: Gregory Gonzalez
 * Test Yelp api functionality
 * 
 */
require_once "dbConn.php";

$zipCodes = getZipCodes($conn);

$CLIENT_ID = "zuJ43u_QIi5Pb4JPr3-Yfw";
$CLIENT_SECRET = "IxV0gsplCLxv3nnvBvhOx9vSGeFG9V51IWUrfwm7ZPHM0pKZpDpWPVIl7HQRLkxS";
$API_HOST = "https://api.yelp.com";
$SEARCH_PATH = "/v3/businesses/search";
$BUSINESS_PATH = "/v3/businesses/";  // Business ID will come after slash.
$TOKEN_PATH = "/oauth2/token";
$GRANT_TYPE = "client_credentials";
// Defaults for our simple example.
$DEFAULT_TERM = "computer repair";
//$DEFAULT_LOCATION = "85003";
$SEARCH_LIMIT = 10;

/**
 * User input is handled here 
 */
$longopts  = array(
    "term::",
    "location::",
);
    
$options = getopt("", $longopts);
$term = $options['term'] ?: $GLOBALS['DEFAULT_TERM'];
//$location = $options['location'] ?: $GLOBALS['DEFAULT_LOCATION'];
//query_api($term, $location);
foreach ($zipCodes as $zip)
{
    set_time_limit(120);
    query_api($term, $zip['zipcode'], $conn);
}


getToken();

require_once "dbClose.php";

//Returns a valid access token
function getToken()
{
    //If "access_token.txt" exists, token and expiration are pulled from it
    if (file_exists("access_token.txt"))
    {
        $access_token_text = file("access_token.txt");
    }
    else
    {
        //Requests a new token using obtain_bearer_token() and creates "access_token.txt", then recursively sets access token
        $access_token_text = obtain_bearer_token();
        $expiration = time() + $access_token_text['expires_in'];
        $file = fopen("access_token.txt", "w");        
        fwrite($file, $access_token_text['access_token']);
        fwrite($file, "\n".$expiration);
        fclose($file);
        return getToken();
    }
    
    //Checks if token has expired, and deletes current token file if it has and creates a new one
    if (time() >= $access_token_text[1])
    {
        unlink("access_token.txt");
        return getToken();
    }
    
    $access_token = $access_token_text[0];
    
    return $access_token;
}


function obtain_bearer_token() {
    try {
        $curl = curl_init();
        if (FALSE === $curl)
            throw new Exception('Failed to initialize');
        $postfields = "client_id=" . $GLOBALS['CLIENT_ID'] .
            "&client_secret=" . $GLOBALS['CLIENT_SECRET'] .
            "&grant_type=" . $GLOBALS['GRANT_TYPE'];
        curl_setopt_array($curl, array(
            CURLOPT_URL => $GLOBALS['API_HOST'] . $GLOBALS['TOKEN_PATH'],
            CURLOPT_RETURNTRANSFER => true,  // Capture response.
            CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
            ),
        ));
        $response = curl_exec($curl);
        if (FALSE === $response)
            throw new Exception(curl_error($curl), curl_errno($curl));
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($response, $http_status);
        curl_close($curl);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }
    
    return json_decode($response, true);
}

function request($bearer_token, $host, $path, $url_params = array()) {
    // Send Yelp API Call
    try {
        $curl = curl_init();
        if (FALSE === $curl)
            throw new Exception('Failed to initialize');
        $url = $host . $path . "?" . http_build_query($url_params);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,  // Capture response.
            CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $bearer_token,
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        if (FALSE === $response)
            throw new Exception(curl_error($curl), curl_errno($curl));
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($response, $http_status);
        curl_close($curl);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }
    return $response;
}

function search($bearer_token, $term, $location) {
    $url_params = array();
    
    $url_params['term'] = $term;
    $url_params['location'] = $location;
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    
    return request($bearer_token, $GLOBALS['API_HOST'], $GLOBALS['SEARCH_PATH'], $url_params);
}

function get_business($bearer_token, $business_id) {
    $business_path = $GLOBALS['BUSINESS_PATH'] . urlencode($business_id);
    
    return request($bearer_token, $GLOBALS['API_HOST'], $business_path);
}

function query_api($term, $location, $conn) {     
    $bearer_token = getToken();
    $response = json_decode(search($bearer_token, $term, $location), true);
    
    $subArrays = array("categories", "coordinates", "transactions", "location");
    foreach ($response['businesses'] as $business)
    {
        insertRecord($business, $conn);
    }
}

function getZipCodes($conn)
{
    
    $sql = "SELECT
                zipcode
            FROM
                uszipcodes
            WHERE
                city = 'new york' OR
                city = 'los angeles' OR
                city = 'chicago' OR
                city = 'houston' OR
                city = 'philadelphia' OR
                city = 'phoenix' OR
                city = 'san antonio' OR
                city = 'san diego' OR
                city = 'dallas' OR
                city = 'san jose'";
    try
    {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) 
    {
        die($sql . "<br/>" . $e->getMessage() . "<br/>");
    }    
}

function insertRecord($record, $conn)
{
    //var_dump($record);
    //echo "<br/><br/>";
    $tempRecord = array();
    $tempRecord['yelp_id'] = $record['id'];   
    $tempRecord['name'] = $record['name'];   
    $tempRecord['image_url'] = $record['image_url'];   
    $tempRecord['url'] = $record['url'];   
    $tempRecord['review_count'] = $record['review_count'];
    $tempRecord['rating'] = $record['rating'];   
    $tempRecord['phone'] = $record['phone'];
    $tempRecord['latitude'] = $record['coordinates']['latitude'];
    $tempRecord['longitude'] = $record['coordinates']['longitude'];
    $tempRecord['address1'] = $record['location']['address1'];
    $tempRecord['address2'] = $record['location']['address2'];
    $tempRecord['address3'] = $record['location']['address3'];
    $tempRecord['city'] = $record['location']['city'];
    $tempRecord['state'] = $record['location']['state'];
    $tempRecord['zip_code'] = $record['location']['zip_code'];
    
    $sql = "INSERT INTO serviceproviders
            (yelp_id, name, image_url, url, review_count, rating, latitude, longitude, address1, address2, address3, city, state, zip_code, phone)
            VALUES (:yelp_id, :name, :image_url, :url, :review_count, :rating, :latitude, :longitude, :address1, :address2, :address3, :city, :state, :zip_code, :phone)";
    
    try
    {
        $stmt = $conn->prepare($sql);
        $stmt->execute($tempRecord);
        return true;
    } 
    catch (PDOException $e) 
    {
        $error = $e->getMessage();
        if ($error = "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'affordable-computer-services-bakersfield' for key 'yelp_id_UNIQUE'")
        {
            //echo "Record with yelp_id " . $tempRecord['yelp_id'] . " already exists"
        }
        else
        {
           die($sql . "<br/>" . $e->getMessage() . "<br/>");        
           return false;           
        }
    }
}
?>