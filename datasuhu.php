<?php
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "";
            $dbname = "esp32";

            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            // if(!$conn){
            //     die("Could not connect: " .mysqli_error());
            // }

            $sql = mysqli_query($conn,"SELECT * FROM datasensor order by id desc");
            // $result = mysqli_query($conn, $sql);
            // if (!$result) {
            //     die("Query gagal: " . mysqli_error($conn));
            // }

            $data = mysqli_fetch_array($sql);
            $suhu = $data['suhu'];

            if($suhu == "") $suhu = 0;

            echo $suhu;


?>