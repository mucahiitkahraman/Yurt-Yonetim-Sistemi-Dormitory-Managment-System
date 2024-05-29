<?php
session_start();
include 'db.php';

// Giriş kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: giris.html");
    exit();
}

$sql = "SELECT * FROM ogrenci";
$result = $conn->query($sql);

if (!$result) {
    die("Veritabanı sorgu hatası: " . $conn->error);
}

// HTML dosyasını oku
$html = file_get_contents('kayitliogrenci.html');

// Verileri tabloya yerleştir
$rows = '';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Base64 formatındaki resmi img etiketi içinde kullan
        $resim = !empty($row['ogrenci_resmi']) ? "<img src='data:image/webp;base64," . base64_encode($row['ogrenci_resmi']) . "' alt='Resim'>" : "";
        $rows .= "<tr>";
        $rows .= "<td>" . $row['ogrenci_ID'] . "</td>";
        $rows .= "<td>" . $row['isim'] . "</td>";
        $rows .= "<td>" . $row['soyisim'] . "</td>";
        $rows .= "<td>" . $row['cinsiyet'] . "</td>";
        $rows .= "<td>" . $row['kimlikNo'] . "</td>";
        $rows .= "<td>" . $row['ogrenciNo'] . "</td>";
        $rows .= "<td>" . $row['adres'] . "</td>";
        $rows .= "<td>" . $row['telefon'] . "</td>";
        $rows .= "<td>" . $row['email'] . "</td>";
        $rows .= "<td>" . $row['dogumTarihi'] . "</td>";
        $rows .= "<td>" . $row['yurt_ID'] . "</td>";
        $rows .= "<td>" . $row['oda_ID'] . "</td>";
        $rows .= "<td class='image-cell'>" . $resim . "</td>";
        $rows .= "</tr>";
    }
} else {
    $rows = "<tr><td colspan='13'>Kayıt bulunamadı</td></tr>";
}
$conn->close();

// Tablonun gövdesine (tbody) verileri yerleştir
$html = str_replace('<!-- Veri satırları PHP tarafından doldurulacak -->', $rows, $html);

// Güncellenmiş HTML içeriğini göster
echo $html;
?>
