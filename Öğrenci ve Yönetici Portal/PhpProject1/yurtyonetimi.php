<?php
session_start();
include 'db.php';

// Giriş kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: giris.html");
    exit();
}

$sql = "SELECT yurt_ID, yurtAdi, adres, yurtKapasitesi, odaTipi, telefon, odaSayisi, fiyatlar, gecmisFiyatlar, yurtresmi, konum, hizmet FROM yurtlar";
$result = $conn->query($sql);

if (!$result) {
    die("Veritabanı sorgu hatası: " . $conn->error);
}

// HTML dosyasını oku
$html = file_get_contents('yurtyonetimi.html');

// Verileri tabloya yerleştir
$rows = '';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Resmin veritabanında base64 formatında saklanıp saklanmadığını kontrol et
        $resim = "";
        if (!empty($row['yurtresmi'])) {
            // Base64 olup olmadığını kontrol edin
            if (base64_encode(base64_decode($row['yurtresmi'], true)) === $row['yurtresmi']) {
                $resim = "<img src='data:image/webp;base64," . $row['yurtresmi'] . "' alt='Resim'>";
            } else {
                $resim = "<img src='" . $row['yurtresmi'] . "' alt='Resim'>";
            }
        }
        $rows .= "<tr>";
        $rows .= "<td>" . $row['yurt_ID'] . "</td>";
        $rows .= "<td>" . $row['yurtAdi'] . "</td>";
        $rows .= "<td>" . $row['adres'] . "</td>";
        $rows .= "<td>" . $row['yurtKapasitesi'] . "</td>";
        $rows .= "<td>" . $row['odaTipi'] . "</td>";
        $rows .= "<td>" . $row['telefon'] . "</td>";
        $rows .= "<td>" . $row['odaSayisi'] . "</td>";
        $rows .= "<td>" . $row['fiyatlar'] . "</td>";
        $rows .= "<td>" . $row['gecmisFiyatlar'] . "</td>";
        $rows .= "<td class='image-cell'>" . $resim . "</td>";
        $rows .= "<td>" . $row['konum'] . "</td>";
        $rows .= "<td>" . $row['hizmet'] . "</td>";
        $rows .= "<td><button class='delete-btn' data-id='" . $row['yurt_ID'] . "'>Sil</button></td>";
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
