<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp32";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

if(!empty($_POST['sensor1']) || !empty($_POST['sensor2']) || !empty($_POST['sensor3']) || !empty($_POST['sensor4'])){
    $sensorData1 = $_POST['sensor1'];
    $sensorData2 = $_POST['sensor2'];
    $sensorData3 = $_POST['sensor3'];
    $sensorData4 = $_POST['sensor4'];

    $sql = "INSERT INTO datasensor (suhu,ph,tds,ketinggianAir) VALUES ('".$sensorData1."', '".$sensorData2."', '".$sensorData3."', '".$sensorData4."')";
    
    if($conn->query($sql) === TRUE) {
        echo "OK";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

    $conn->close();
?>