<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp32";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil nilai 'limit' dari URL (default 10 jika tidak diberikan)
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// Validasi input limit (hanya izinkan nilai tertentu: 10, 100, 1000)
$validLimits = [10, 100, 1000];
if (!in_array($limit, $validLimits)) {
    $limit = 10; // Default ke 10 jika tidak valid
}

// Query untuk mengambil data
$sql = "SELECT waktu_baca, suhu, ph, tds, ketinggianAir FROM datasensor ORDER BY id DESC LIMIT $limit";
// Query untuk mengambil data
// $sql = "SELECT waktu_baca,suhu,ph,tds,ketinggianAir FROM datasensor ORDER BY id DESC LIMIt 10"; // Misalnya hanya mengambil 10 data terakhir
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Tambahkan setiap baris data ke array
    }
}

$conn->close();

// Ubah data ke format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
