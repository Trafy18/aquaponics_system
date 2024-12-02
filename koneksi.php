<?php
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "";
            $dbname = "esp32";

            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            
            $sql = "SELECT * FROM datasensor ORDER BY ID DESC";

            $suhu = mysqli_query($conn, "SELECT suhu FROM datasensor ORDER BY ID ASC");
            $ph = mysqli_query($conn, "SELECT ph FROM datasensor ORDER BY ID ASC");
            $tds = mysqli_query($conn, "SELECT tds FROM datasensor ORDER BY ID ASC");
            $ketinggian = mysqli_query($conn, "SELECT ketinggianAir  FROM datasensor ORDER BY ID ASC");

            if(!$conn){
                echo "koneksi gagal :";
            }

?>