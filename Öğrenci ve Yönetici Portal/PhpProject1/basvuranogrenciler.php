<?php
session_start();
include 'db.php';

// Giriş kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: giris.html");
    exit();
}

// Onayla isteğini kontrol et
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve_id'])) {
    $approve_id = intval($_POST['approve_id']);
    
    // Başvuru durumunu "Onaylandı" olarak güncelle
    $approve_sql = "UPDATE ogrenci SET basvuruDurumu = 'Onaylandı' WHERE ogrenci_ID = $approve_id";
    if ($conn->query($approve_sql) === TRUE) {
        // Öğrencinin başvuru yaptığı oda ID'sini al
        $oda_sql = "SELECT basvuruOda_ID FROM ogrenci WHERE ogrenci_ID = $approve_id";
        $oda_result = $conn->query($oda_sql);
        if ($oda_result && $oda_result->num_rows > 0) {
            $oda_row = $oda_result->fetch_assoc();
            $oda_id = intval($oda_row['basvuruOda_ID']);

            // Odanın doluluk oranını 1 artır
            $doluluk_sql = "UPDATE odalar SET doluluk = doluluk + 1 WHERE oda_ID = $oda_id";
            $conn->query($doluluk_sql);

            // Odanın bağlı olduğu yurt ID'sini al
            $yurt_sql = "SELECT yurt_ID FROM odalar WHERE oda_ID = $oda_id";
            $yurt_result = $conn->query($yurt_sql);
            if ($yurt_result && $yurt_result->num_rows > 0) {
                $yurt_row = $yurt_result->fetch_assoc();
                $yurt_id = intval($yurt_row['yurt_ID']);

                // Öğrenci tablosunda oda_ID ve yurt_ID'yi güncelle
                $ogrenci_update_sql = "UPDATE ogrenci SET oda_ID = $oda_id, yurt_ID = $yurt_id WHERE ogrenci_ID = $approve_id";
                $conn->query($ogrenci_update_sql);
            }
        }

        header("Location: basvuranogrenciler.php");
        exit();
    } else {
        echo "Hata: " . $conn->error;
    }
}

// Reddet isteğini kontrol et
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reject_id'])) {
    $reject_id = intval($_POST['reject_id']);
    
    // Öğrencinin başvuru yaptığı oda ID'sini al
    $oda_sql = "SELECT basvuruOda_ID FROM ogrenci WHERE ogrenci_ID = $reject_id";
    $oda_result = $conn->query($oda_sql);
    if ($oda_result && $oda_result->num_rows > 0) {
        $oda_row = $oda_result->fetch_assoc();
        $oda_id = intval($oda_row['basvuruOda_ID']);

        // Başvuru durumunu "Reddedildi" olarak güncelle ve başvuru oda ID'yi kaldır
        $reject_sql = "UPDATE ogrenci SET basvuruDurumu = 'Reddedildi', oda_ID = NULL, basvuruOda_ID = NULL WHERE ogrenci_ID = $reject_id";
        if ($conn->query($reject_sql) === TRUE) {
            // Odanın mevcut doluluk oranını al
            $doluluk_kontrol_sql = "SELECT doluluk FROM odalar WHERE oda_ID = $oda_id";
            $doluluk_kontrol_result = $conn->query($doluluk_kontrol_sql);
            if ($doluluk_kontrol_result && $doluluk_kontrol_result->num_rows > 0) {
                $doluluk_row = $doluluk_kontrol_result->fetch_assoc();
                $mevcut_doluluk = intval($doluluk_row['doluluk']);
                
                // Doluluk oranını 1 azalt ve sıfırdan küçük olmamasını sağla
                $yeni_doluluk = max(0, $mevcut_doluluk - 1);
                $doluluk_sql = "UPDATE odalar SET doluluk = $yeni_doluluk WHERE oda_ID = $oda_id";
                $conn->query($doluluk_sql);
            }

            header("Location: basvuranogrenciler.php");
            exit();
        } else {
            echo "Hata: " . $conn->error;
        }
    } else {
        echo "Hata: Oda ID'si bulunamadı";
    }
}

// Sadece basvuruOda_ID sütununda veri olan öğrencileri çek
$sql = "SELECT * FROM ogrenci WHERE basvuruOda_ID IS NOT NULL";
$result = $conn->query($sql);

if (!$result) {
    die("Veritabanı sorgu hatası: " . $conn->error);
}

// HTML dosyasını oku
$html = file_get_contents('basvuranogrenciler.html');

// Verileri tabloya yerleştir
$rows = '';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Base64 formatındaki resmi img etiketi içinde kullan
        $resim = !empty($row['ogrenci_resmi']) ? "<img src='data:image/webp;base64," . base64_encode($row['ogrenci_resmi']) . "' alt='Resim'>" : "";
        $rows .= "<tr>";
        $rows .= "<td>" . htmlspecialchars($row['ogrenci_ID']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['isim']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['soyisim']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['cinsiyet']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['kimlikNo']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['ogrenciNo']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['adres']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['telefon']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['email']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['dogumTarihi']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['yurt_ID']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['oda_ID']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['basvuruOda_ID']) . "</td>"; // Yeni Sütun Verisi
        $rows .= "<td class='image-cell'>" . $resim . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['basvuruDurumu']) . "</td>";
        $rows .= "<td>";
        if ($row['basvuruDurumu'] == 'Onaylandı') {
            $rows .= "<form method='POST' onsubmit='return confirm(\"Bu başvuruyu reddetmek istediğinize emin misiniz?\");'>
                        <input type='hidden' name='reject_id' value='" . htmlspecialchars($row['ogrenci_ID']) . "'>
                        <button type='submit' class='reject-btn'>Reddet</button>
                      </form>";
        } else {
            $rows .= "<form method='POST' onsubmit='return confirm(\"Bu başvuruyu onaylamak istediğinize emin misiniz?\");'>
                        <input type='hidden' name='approve_id' value='" . htmlspecialchars($row['ogrenci_ID']) . "'>
                        <button type='submit' class='approve-btn'>Onayla</button>
                      </form>";
        }
        $rows .= "</td>";
        $rows .= "</tr>";
    }
} else {
    $rows = "<tr><td colspan='15'>Kayıt bulunamadı</td></tr>";
}
$conn->close();

// Tablonun gövdesine (tbody) verileri yerleştir
$html = str_replace('<!-- Veri satırları PHP tarafından doldurulacak -->', $rows, $html);

// Güncellenmiş HTML içeriğini göster
echo $html;
?>
