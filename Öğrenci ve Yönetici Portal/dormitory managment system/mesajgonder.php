<?php
include("auth_session.php");
require('db.php');

$ogrenci_ID = $_SESSION["ogrenci_ID"];
$oda_ID_sorgu = "SELECT oda_ID FROM ogrenci WHERE ogrenci_ID = :ogrenci_ID";
$oda_ID_sorgu_stmt = $pdo->prepare($oda_ID_sorgu);
$oda_ID_sorgu_stmt->bindParam(':ogrenci_ID', $ogrenci_ID, PDO::PARAM_INT);
$oda_ID_sorgu_stmt->execute();
$oda_ID_sonuc = $oda_ID_sorgu_stmt->fetch(PDO::FETCH_ASSOC);
$oda_ID = $oda_ID_sonuc['oda_ID'];

$ogrenciListesiSorgu = "SELECT ogrenci_ID, isim FROM ogrenci WHERE oda_ID = :oda_ID AND ogrenci_ID != :ogrenci_ID ORDER BY isim ASC";
$ogrenciListesi_stmt = $pdo->prepare($ogrenciListesiSorgu);
$ogrenciListesi_stmt->bindParam(':oda_ID', $oda_ID, PDO::PARAM_INT);
$ogrenciListesi_stmt->bindParam(':ogrenci_ID', $ogrenci_ID, PDO::PARAM_INT);
$ogrenciListesi_stmt->execute();
$ogrenciListesi = $ogrenciListesi_stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['alanOgrenci_ID'])){
    try {
        
        $mesajlarSorgu = "SELECT chat.metin, chat.tarih_zaman, chat.gonderen_isim FROM chat WHERE (chat.gonderenOgrenci_ID = :gonderenOgrenci_ID AND chat.alanOgrenci_ID = :alanOgrenci_ID) OR (chat.gonderenOgrenci_ID = :alanOgrenci_ID AND chat.alanOgrenci_ID = :gonderenOgrenci_ID) ORDER BY chat.tarih_zaman DESC"; // Tarihe göre azalan sıralama
        $mesajlar_stmt = $pdo->prepare($mesajlarSorgu);
        $mesajlar_stmt->bindParam(':gonderenOgrenci_ID', $ogrenci_ID, PDO::PARAM_INT);
        $mesajlar_stmt->bindParam(':alanOgrenci_ID', $_GET['alanOgrenci_ID'], PDO::PARAM_INT);
        $mesajlar_stmt->execute();
        $mesajlar = $mesajlar_stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($mesajlar)) {
            echo "<p>Mesaj bulunamadı.</p>";
        } else {
            foreach ($mesajlar as $mesaj) {
                echo "<div class='message'>";
                echo "<span class='sender'>" . htmlspecialchars($mesaj['gonderen_isim']) . ":</span> " . htmlspecialchars($mesaj['metin']);
                echo "<span class='time'>". " " . date('H:i:s d.m.Y', strtotime($mesaj['tarih_zaman'])) . "</span>";
                echo "</div>";
            }
        }
    } catch(PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
    exit; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $alanOgrenci_ID = $_POST['alanOgrenci_ID'];
    $mesaj = trim($_POST['mesaj']); 
    $gonderenOgrenci_ID = $_SESSION["ogrenci_ID"];

    $kufurluKelimeler = array('mal', 'salak');
    $mesajTemiz = str_ireplace($kufurluKelimeler, '***', $mesaj);


    if(empty($mesajTemiz)) {
        echo "<script type='text/javascript'>alert('Mesaj boş bırakılamaz!'); window.history.go(-1);</script>";
        exit;
    }

    
    if($alanOgrenci_ID == $gonderenOgrenci_ID) {
        echo "Kendinize mesaj gönderemezsiniz!";
        exit;
    }

    try {
      
        $odaKontrolSorgu = "SELECT oda_ID FROM ogrenci WHERE ogrenci_ID = :gonderenOgrenci_ID OR ogrenci_ID = :alanOgrenci_ID";
        $odaKontrol_stmt = $pdo->prepare($odaKontrolSorgu);
        $odaKontrol_stmt->execute(array(':gonderenOgrenci_ID' => $gonderenOgrenci_ID, ':alanOgrenci_ID' => $alanOgrenci_ID));
        $odaKontrol_sonuclar = $odaKontrol_stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($odaKontrol_sonuclar) == 2 && $odaKontrol_sonuclar[0]['oda_ID'] == $odaKontrol_sonuclar[1]['oda_ID']) {
            
            $sql = "INSERT INTO chat (gonderenOgrenci_ID, alanOgrenci_ID, gonderen_isim, alan_isim, metin, tarih_zaman) VALUES (:gonderenOgrenci_ID, :alanOgrenci_ID, :gonderen_isim, :alan_isim, :mesaj, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':gonderenOgrenci_ID', $gonderenOgrenci_ID, PDO::PARAM_INT);
            $stmt->bindParam(':alanOgrenci_ID', $alanOgrenci_ID, PDO::PARAM_INT);

            
            $gonderenOgrenciSorgu = "SELECT isim FROM ogrenci WHERE ogrenci_ID = :gonderenOgrenci_ID";
            $gonderenOgrenci_stmt = $pdo->prepare($gonderenOgrenciSorgu);
            $gonderenOgrenci_stmt->bindParam(':gonderenOgrenci_ID', $gonderenOgrenci_ID, PDO::PARAM_INT);
            $gonderenOgrenci_stmt->execute();
            $gonderenOgrenci_isim = $gonderenOgrenci_stmt->fetchColumn();

            
            $alanOgrenciSorgu = "SELECT isim FROM ogrenci WHERE ogrenci_ID = :alanOgrenci_ID";
            $alanOgrenci_stmt = $pdo->prepare($alanOgrenciSorgu);
            $alanOgrenci_stmt->bindParam(':alanOgrenci_ID', $alanOgrenci_ID, PDO::PARAM_INT);
            $alanOgrenci_stmt->execute();
            $alanOgrenci_isim = $alanOgrenci_stmt->fetchColumn();

            $stmt->bindParam(':gonderen_isim', $gonderenOgrenci_isim, PDO::PARAM_STR);
            $stmt->bindParam(':alan_isim', $alanOgrenci_isim, PDO::PARAM_STR);
            $stmt->bindParam(':mesaj', $mesajTemiz, PDO::PARAM_STR);
            $stmt->execute();

            echo "Mesaj başarıyla gönderildi!";
        } else {
            echo "Sadece aynı oda ID'sine sahip öğrenciler birbirlerine mesaj gönderebilir.";
        }
    } catch(PDOException $e) {
        echo "Bir hata oluştu, lütfen daha sonra tekrar deneyin.";
    }
}
?>