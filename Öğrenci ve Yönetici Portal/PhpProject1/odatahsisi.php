<?php
session_start();
include 'db.php';

// Giriş kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: giris.html");
    exit();
}

$sql = "SELECT * FROM odalar";
$result = $conn->query($sql);

if (!$result) {
    die("Veritabanı sorgu hatası: " . $conn->error);
}

// HTML dosyasını oku
$html = file_get_contents('odatahsisi.html');

// Verileri tabloya yerleştir
$rows = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Base64 formatındaki resmi img etiketi içinde kullan
        $resim = !empty($row['oda_resmi']) ? "<img src='data:image/webp;base64," . $row['oda_resmi'] . "' alt='Resim'>" : "";
        $rows .= "<tr>";
        $rows .= "<td>" . htmlspecialchars($row['oda_ID']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['yurt_ID']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['odaNumarası']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['odaKapasitesi']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['odaTipi']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['doluluk']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['oda_Bilgisi']) . "</td>";
        $rows .= "<td class='image-cell'>" . $resim . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['fiyat']) . "</td>"; // Yeni sütun eklendi
        $rows .= "</tr>";
    }
} else {
    $rows = "<tr><td colspan='9'>Kayıt bulunamadı</td></tr>";
}
$conn->close();

// Tablonun gövdesine (tbody) verileri yerleştir
$html = str_replace('<!-- Veri satırları PHP tarafından doldurulacak -->', $rows, $html);

// Güncellenmiş HTML içeriğini göster
echo $html;
?>
