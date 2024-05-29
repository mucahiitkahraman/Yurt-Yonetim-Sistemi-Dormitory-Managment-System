<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
</html>

<?php
include 'db.php';
include("auth_session.php");

if (isset($_POST['basvuruYap'])) {
    $ogrenci_ID = $_SESSION['ogrenci_ID']; 

    try {
        $query = "SELECT oda_ID, basvuruDurumu FROM ogrenci WHERE ogrenci_ID = :ogrenci_ID";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['ogrenci_ID' => $ogrenci_ID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (!is_null($result['oda_ID'])) {
                echo "<script> Swal.fire({
                    icon: 'info',
                    title: 'Oda nız mevcut, başvuru yapamazsınız.',
                    text: 'Anasayfaya yönlendiriliyorsun',
                    }); 
                    setTimeout(function(){
                        window.location.href = 'anasayfa.php';
                    }, 2000); 
                    </script>";
            } else if ($result['basvuruDurumu'] == 'Başvurusu var') {
                echo "<script> Swal.fire({
                    icon: 'info',
                    title: 'Başvurunuz mevcut. Başvuru yapamazsınız.',
                    text: 'Anasayfaya yönlendiriliyorsun',
                    }); 
                    setTimeout(function(){
                        window.location.href = 'anasayfa.php';
                    }, 2000); 
                    </script>";
            } else {
                
                $oda_ID = $_POST['oda_ID']; 
                $sql = "UPDATE ogrenci SET basvuruDurumu = 'Başvurusu var', basvuruOda_ID = :oda_ID WHERE ogrenci_ID = :ogrenci_ID";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['ogrenci_ID' => $ogrenci_ID, 'oda_ID' => $oda_ID]);

                echo "<script> Swal.fire({
                    icon: 'info',
                    title: 'Başvurunuz alınmıştır.',
                    text: 'Anasayfaya yönlendiriliyorsun',
                    }); 
                    setTimeout(function(){
                        window.location.href = 'anasayfa.php';
                    }, 2000); 
                    </script>";
            }
        } else {
            echo "<p>Öğrenci bilgileri bulunamadı.</p>";
        }
    } catch (PDOException $e) {
        echo "Sorgu sırasında bir hata oluştu. ";
    }
}
?>
