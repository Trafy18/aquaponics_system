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
            if (!$sql) {
                die("Query gagal: " . mysqli_error($conn));
            }
            if ($row = mysqli_fetch_assoc($sql)) {
                // Mengembalikan data dalam format JSON
                echo json_encode([
                    'suhu' => $row['suhu'],
                    'ph' => $row['ph'],
                    'tds' => $row['tds'],
                    'ketinggian' => $row['ketinggianAir']
                ]);
            } else {
                // Jika tidak ada data, mengembalikan nilai default
                echo json_encode([
                    'suhu' => 0,
                    'ph' => 0,
                    'tds' => 0,
                    'ketinggian' => 0
                ]);
            }
            mysqli_close($conn);


?>