<!doctype html>
<html lang="en">
    <head>
        <title>Data Sensor Aquaponic</title>
        <!--Required meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="
        sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <body>
            <?php
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "";
            $dbname = "esp32";

            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

            // if(!$conn){
            //     die("Could not connect: " .mysqli_error());
            // }
            // echo "Connected succesfully<br>";

            echo "<center>";
        echo
        '<div class = "jumbotron">
        <h3 class = "display-6">DATA SENSOR AKUAPONIK</h3>
        </div>';

        $sql = "SELECT id,waktu_baca,suhu,ph,tds,ketinggianAir FROM datasensor";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query gagal: " . mysqli_error($conn));
        }
        echo "<h6>";
            if (mysqli_num_rows($result) > 0){
                echo "<table border=1>";
                echo "<tr>";
                    echo "<th align = center>No. id</th>";
                    echo "<th align = center>Waktu dan Tanggal</th>";
                    echo "<th align = center>Data Suhu(C)</th>";
                    echo "<th align = center>Ph Air(pH)</th>";
		            echo "<th align = center>TDS Air(ppm)</th>";
                    echo "<th align = center>Jarak Air(cm)</th>";
                echo "</tr>";

            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td align = center>".$row['id']."</td>";
                echo "<td align = center>".$row['waktu_baca']."</td>";
                echo "<td align = center>".$row['suhu']."</td>";
                echo "<td align = center>".$row['ph']."</td>";
		        echo "<td align = center>".$row['tds']."</td>";
                echo "<td align = center>".$row['ketinggianAir']."</td>";
                echo "</tr>";
            }
            echo "</table>";
            } else {
                echo "0 results";
            }
            mysqli_close($conn);
            ?>

        <!--Optional JavaScript-->
        
        <!-- jQuery first, then Popper.js, then Bootstrap JS-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="
        sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="
        sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="
        sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        </body>
</html>