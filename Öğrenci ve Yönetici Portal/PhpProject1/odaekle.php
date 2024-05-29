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
$yurtID = $_POST['yurt_ID'];
$odaNumarasi = $_POST['odaNumarası'];
$odaKapasitesi = $_POST['odaKapasitesi'];
$odaTipi = $_POST['odaTipi'];
$doluluk = $_POST['doluluk'];
$odaBilgisi = $_POST['oda_Bilgisi'];
$fiyat = $_POST['fiyat'];

// Yurt ID'sinin geçerli olup olmadığını kontrol et
$sql = "SELECT yurt_ID FROM yurtlar WHERE yurt_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $yurtID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Geçersiz Yurt ID. Lütfen geçerli bir Yurt ID girin.");
}

// Resmi al ve base64'e dönüştür
$odaResmi = $_FILES['oda_resmi']['tmp_name'];
$resimMimeType = mime_content_type($odaResmi);

$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

if (in_array($resimMimeType, $allowedMimeTypes)) {
    $resimData = file_get_contents($odaResmi);
    $resimBase64 = base64_encode($resimData);

    // Veritabanına ekle
    $sql = "INSERT INTO odalar (yurt_ID, odaNumarası, odaKapasitesi, odaTipi, doluluk, oda_Bilgisi, oda_resmi, fiyat)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisisis", $yurtID, $odaNumarasi, $odaKapasitesi, $odaTipi, $doluluk, $odaBilgisi, $resimBase64, $fiyat);

    if ($stmt->execute()) {
        echo "Yeni oda başarıyla eklendi";
        header("Location: yurtyonetimi.php"); // Yönlendirme
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Geçersiz dosya türü. Lütfen sadece JPEG, PNG veya WEBP formatında bir resim yükleyin.";
}

$stmt->close();
$conn->close();
?>
