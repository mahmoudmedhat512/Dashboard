<?php 
$Email="Mahmoud@bal7.com";
$password="ay7agaw5las";
if($_POST["e-mail"] == $Email && $_POST["PassWord"] == $password){ }

else{
    header('Location: https://docs.google.com/spreadsheets/d/1iJZWP2nS_OB3kCTjq8L6TrJJ4o-5lhxDOyTaocSYc-k/edit#gid=1778914663');}
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


</head>
<body>

<div id="charts">
    <div id="piechart">
        
    </div>
    <div id="columnchart_values">
        
    </div>
</div>
<div class="table">
    <table>
        <thead>
            <tr>
                <th>Fist Name</th>
                <th>Last name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>university</th>
                <th>Faculty</th>
                <th>Academic</th>
                <th>Workshop1</th>
                <th>Workshop2</th>
                <th>Message</th>
            </tr>
        </thead>
        <?php
    $DBUrl = "https://fekratest-8ba7c.firebaseio.com/"; //The url of your database. Lamma btdoos 3ala database fy Firebase hatla2eeh fy el nos fo2.

    //Enter the user data and convert it to JSON
    $userData = array("email" => "Mahmoud@yahoo.com",
                     "password" => "something",
                     "returnSecureToken" => true); //Enter the user data

    $userData = json_encode($userData); //Converting it to JSON
    
    //Send a POST request to the Google authentication servers to get the ID Token
    $DBKey = "AIzaSyAjbr-uq3sCx4-PJmNOFpDa3YRKK08HHPw"; 
    $curlInst = curl_init("https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPassword?key=" . $DBKey); //
    curl_setopt_array($curlInst, array(CURLOPT_RETURNTRANSFER => 1, 
                                      CURLOPT_POST => 1, //Bet3arafo enak hate3ml POST request msh GET
                                      CURLOPT_POSTFIELDS => $userData, 
                                      CURLOPT_HTTPHEADER => array("Content-Type: application/json"))); //Bet3araf el server bta3 Google enak bteb3ato raw JSON data 3shan ye2balo

    $result = json_decode(curl_exec($curlInst), true); //Execute the CURL and decode it to an array

    curl_close($curlInst); //Close the CURL 3shan tefado el memory
    
    $token = $result["idToken"];
        $path = ""; 
    $curlInst = curl_init($DBUrl . $path . ".json?auth=" . $token);
    curl_setopt_array($curlInst, array(CURLOPT_RETURNTRANSFER => 1));
    $result = json_decode(curl_exec($curlInst), true); //Et3amlo m3 $result dah ka2eno array be key w values ba2a

    curl_close($curlInst);
    ?>
    <?php
    $Counterw = [0, 0, 0];
    $levels = [0, 0, 0, 0, 0, 0];

    foreach ($result as $z) {
        if ($z["workshop1"] == "Web") {
            $Counterw[0]++;
        }
        else if ($z["workshop1"] == "Java") {
            $Counterw[1]++;
        }
        else if ($z["workshop1"] == "Android") {
            $Counterw[2]++;
        }

        if ($z["Academic"] == "1") {
            $levels[0]++;
        }
        else if ($z["Academic"] == "2") {
            $levels[1]++;
        }
        else if ($z["Academic"] == "3") {
            $levels[2]++;
        }
        else if ($z["Academic"] == "4") {
            $levels[3]++;
        }
        else if ($z["Academic"] == "5") {
            $levels[4]++;
        }
        else if ($z["Academic"] == "6") {
            $levels[5]++;
        }
    } 
    ?>
        <tbody id="table-body">
            <?php 

                foreach($result as $x)
                echo "
                    <tr>
                        
                        <td>".$x["firstname"]."</td>
                        <td>".$x["lastname"]."</td>
                        <td>".$x["phone"]."</td>
                        <td>".$x["email"]."</td>
                        <td>".$x["university"]."</td>
                        <td>".$x["faculty"]."</td>
                        <td>".$x["Academic"]."</td>
                        <td>".$x["workshop1"]."</td>
                        <td>".$x["workshop2"]."</td>
                        <td>".$x["message"]."</td>
                    </tr>"




            ?>
        </tbody>
    </table>
</div> 
       <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawHisto);
    
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Workshop', 'Number of Submissions'],
            ['Java', parseInt(<?php echo $Counterw[1]; ?>)],
            ['Android', parseInt(<?php echo $Counterw[2]; ?>)],
            ['Web', parseInt(<?php echo $Counterw[0]; ?>)]
        ]);
        var options = {'title': 'Workshops', colors: ['green', 'red', 'lightblue']};
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

    function drawHisto() {
        var data = google.visualization.arrayToDataTable([
            ['Level', 'Counter'],
            ['Level 1', parseInt(<?php echo $levels[0]; ?>)],
            ['Level 2', parseInt(<?php echo $levels[1]; ?>)],
            ['Level 3', parseInt(<?php echo $levels[2]; ?>)],
            ['Level 4', parseInt(<?php echo $levels[3]; ?>)],
            ['Level 5', parseInt(<?php echo $levels[4]; ?>)]
        ]);
        var options = {
            title: 'Academic Level',
            legend: {position: 'none'},
            colors: ['red'],
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values'));
        chart.draw(data, options);
    }
        </script>
        
</body>
</html>
