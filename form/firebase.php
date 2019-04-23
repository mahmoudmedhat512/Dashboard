<?php
    $DBUrl = "https://fekratest-8ba7c.firebaseio.com/"; //The url of your database. Lamma btdoos 3ala database fy Firebase hatla2eeh fy el nos fo2.

    //Enter the user data and convert it to JSON
    $userData = array("email" => "Mahmoud@yahoo.com",
                     "password" => "something",
                     "returnSecureToken" => true); //Enter the user data

    $userData = json_encode($userData); //Converting it to JSON
    
    //Send a POST request to the Google authentication servers to get the ID Token
    $DBKey = "AIzaSyAjbr-uq3sCx4-PJmNOFpDa3YRKK08HHPw"; //Get it from Firebase. Fy 3alamet el settings fy Firebase 3ala el shmal fo2. Dooso 3aleiha w ba3d kda project settings; hatla2o Web API Key howa dah.

    $curlInst = curl_init("https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPassword?key=" . $DBKey); //Initialize CURL
    
    //Setting the options
    curl_setopt_array($curlInst, array(CURLOPT_RETURNTRANSFER => 1, //Betraga3 ay data ka return value badal mate3redo lel user 3ala tool
                                      CURLOPT_POST => 1, //Bet3arafo enak hate3ml POST request msh GET
                                      CURLOPT_POSTFIELDS => $userData, //El body bta3 el POST request aw be ma3na 2asa7 el data elly hatet7at
                                      CURLOPT_HTTPHEADER => array("Content-Type: application/json"))); //Bet3araf el server bta3 Google enak bteb3ato raw JSON data 3shan ye2balo

    $result = json_decode(curl_exec($curlInst), true); //Execute the CURL and decode it to an array

    curl_close($curlInst); //Close the CURL 3shan tefado el memory
    
    $token = $result["idToken"];
$path = "";

    $data = json_encode(array("workshop1" =>$_POST["workshop1"],
    "workshop2" =>$_POST["workshop2"],
    "firstname" =>$_POST["fname"],
    "lastname" =>$_POST["fname"],
    "email" =>$_POST["email"],
    "faculty" =>$_POST["faculty"],
    "university" =>$_POST["university"],
    "message" =>$_POST["message"],
    "Academic"=>$_POST["Academic"],
    "phone"=>$_POST["phone"])); //Data to be added

    $curlInst = curl_init($DBUrl . $path . ".json?auth=" . $token);

    curl_setopt_array($curlInst, array(CURLOPT_RETURNTRANSFER => 1,
                                      CURLOPT_POST => 1,
                                      CURLOPT_POSTFIELDS => $data,
                                      CURLOPT_HTTPHEADER => array("Content-Type: application/json")));
    
    $name = curl_exec($curlInst); //Hayraga3 el randomly generated name bta3 el object el gdeeda dih

    curl_close($curlInst);
?>