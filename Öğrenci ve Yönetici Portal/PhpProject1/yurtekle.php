<?php
session_start();
include 'db.php';

// Giriş kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: giris.html");
    exit();
}

// max_allowed_packet değerini artırma
$conn->query("SET GLOBAL max_allowed_packet = 64 * 1024 * 1024");

// PHP bellek limitini ve maksimum yürütme süresini artırma
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300); // 300 saniye = 5 dakika

// Form verilerini al
$yurtAdi = $_POST['yurtAdi'];
$adres = $_POST['adres'];
$yurtKapasitesi = $_POST['yurtKapasitesi'];
$odaTipi = $_POST['odaTipi'];
$telefon = $_POST['telefon'];
$odaSayisi = $_POST['odaSayisi'];
$fiyatlar = $_POST['fiyatlar'];
$gecmisFiyatlar = $_POST['gecmisFiyatlar'];
$konum = $_POST['konum'];
$hizmet = $_POST['hizmet'];

// Resmi al ve base64'e dönüştür
$yurtresmi = $_FILES['yurtresmi']['tmp_name'];
$resimMimeType = mime_content_type($yurtresmi);

$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

if (in_array($resimMimeType, $allowedMimeTypes)) {
    $resimData = file_get_contents($yurtresmi);
    $resimBase64 = base64_encode($resimData);

    // Veritabanına ekle
    $sql = "INSERT INTO yurtlar (yurtAdi, adres, yurtKapasitesi, odaTipi, telefon, odaSayisi, fiyatlar, gecmisFiyatlar, yurtresmi, konum, hizmet)
            VALUES ('$yurtAdi', '$adres', $yurtKapasitesi, '$odaTipi', '$telefon', $odaSayisi, '$fiyatlar', '$gecmisFiyatlar', '$resimBase64', '$konum', '$hizmet')";

    if ($conn->query($sql) === TRUE) {
        echo "Yeni yurt başarıyla eklendi";
        header("Location: yurtyonetimi.php"); // Yönlendirme
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Geçersiz dosya türü. Lütfen sadece JPEG, PNG veya WEBP formatında bir resim yükleyin.";
}

$conn->close();
?>
