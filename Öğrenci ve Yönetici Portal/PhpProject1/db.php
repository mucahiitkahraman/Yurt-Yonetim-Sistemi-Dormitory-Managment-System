<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dormitory managment system";

// Veritabanı bağlantısı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
