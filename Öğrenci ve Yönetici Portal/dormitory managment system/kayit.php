<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>

<?php
require('db.php'); 

if (isset($_POST['submit'])) {

    $response = $_POST['g-recaptcha-response'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6LfcvdApAAAAAHZBHAFUgAF9ffPw-k9KdU2POuTH',
        'response' => $response
    );
    $options = array(
        'http' => array (
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    if ($captcha_success->success == false) {
        echo "<script> Swal.fire({
            icon: 'error',
            title: 'Doğrulama yapılmadı!',
            text: 'Ben robot değilim doğrulaması yapmalısın.',
        }); 
        setTimeout(function(){
            window.location.href = 'kayit_form.php';
        }, 2000); 
        </script>";
        return;
    }

    $kullaniciAdi = $_POST['kullaniciAdi'];
    $sifre = $_POST['sifre'];
    $sifreDogrulama = $_POST['sifre_dogrulama'];

    if ($sifre !== $sifreDogrulama) {
        echo "<script> Swal.fire({
            icon: 'error',
            title: 'Şifreler eşleşmiyor. Lütfen aynı şifreyi girin.',
            text: 'Tekrar kayıt ol',
        }); 
        setTimeout(function(){
            window.location.href = 'kayit_form.php';
        }, 2000); 
        </script>";
        return;
    }

    
    $sifreHash = password_hash($sifre, PASSWORD_ARGON2ID);

    $sorgu = $pdo->prepare("SELECT kullaniciAdi FROM kullanicilar WHERE kullaniciAdi = :kullaniciAdi");
    $sorgu->execute(['kullaniciAdi' => $kullaniciAdi]);
    $kullaniciSayisi = $sorgu->rowCount();

    if ($kullaniciSayisi > 0) {
        echo "<script> Swal.fire({
            icon: 'info',
            title: 'Kullanıcı adı kullanılıyor!',
            text: 'Lütfen farklı kullanıcı adı deneyin.',
        }); 
        setTimeout(function(){
            window.location.href = 'kayit_form.php';
        }, 2000); 
        </script>";
        return;
    }

    $isim = $_POST['isim'];
    $soyisim = $_POST['soyisim'];
    $cinsiyet = $_POST['cinsiyet'];
    $kimlikNo = $_POST['kimlikNo'];

    if (strlen($kimlikNo) < 6 || strlen($kimlikNo) > 20) {
        echo "<script> Swal.fire({
            icon: 'error',
            title: 'Kimlik numarası 6 ile 20 karakter arasında olmalıdır.',
            text: 'Tekrar kayıt ol',
        }); 
        setTimeout(function(){
            window.location.href = 'kayit_form.php';
        }, 2000); 
        </script>";
        return;
    }

    $ogrenciNo = $_POST['ogrenciNo'];
    $adres = $_POST['adres'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $dogumtarihi = $_POST['dogumtarihi'];
    $ogrenci_resmi = file_get_contents($_FILES['ogrenci_resmi']['tmp_name']);

    if (!preg_match("/^[0-9]+@emu.edu.tr$/", $email)) {
        echo "<script> Swal.fire({
            icon: 'error',
            title: 'E-posta adresi yalnızca rakam ve '@emu.edu.tr' ile sonlanmalıdır.',
            text: 'Tekrar kayıt ol',
        }); 
        setTimeout(function(){
            window.location.href = 'kayit_form.php';
        }, 2000); 
        </script>";
        return;
    }

    $sorgu = $pdo->prepare("SELECT kimlikNo, ogrenciNo, email, telefon FROM ogrenci WHERE kimlikNo = :kimlikNo OR ogrenciNo = :ogrenciNo OR email = :email OR telefon = :telefon");
    $sorgu->execute(['kimlikNo' => $kimlikNo, 'ogrenciNo' => $ogrenciNo, 'email' => $email, 'telefon' => $telefon]);

    if ($sorgu->rowCount() > 0) {
        echo "<script> Swal.fire({
            icon: 'info',
            title: 'Kimlik numarası, öğrenci numarası, e-posta veya telefon numarası kullanılıyor.',
            text: 'Lütfen yönetim ile iletişime geçin.',
        }); 
        setTimeout(function(){
            window.location.href = 'kayit_form.php';
        }, 2000); 
        </script>";
        return;
    }

    $pdo->beginTransaction();

    try {
        $sorgu = $pdo->prepare("INSERT INTO kullanicilar (kullaniciAdi, sifre) VALUES (:kullaniciAdi, :sifre)");
        $sorgu->execute(['kullaniciAdi' => $kullaniciAdi, 'sifre' => $sifreHash]);
        $kullaniciID = $pdo->lastInsertId();

        $sorgu = $pdo->prepare("INSERT INTO ogrenci (isim, soyisim, cinsiyet, kimlikNo, ogrenciNo, adres, telefon, email, dogumTarihi, ogrenci_resmi) VALUES (:isim, :soyisim, :cinsiyet, :kimlikNo, :ogrenciNo, :adres, :telefon, :email, :dogumTarihi, :ogrenci_resmi)");
        $sorgu->execute([
            'isim' => $isim,
            'soyisim' => $soyisim,
            'cinsiyet' => $cinsiyet,
            'kimlikNo' => $kimlikNo,
            'ogrenciNo' => $ogrenciNo,
            'adres' => $adres,
            'telefon' => $telefon,
            'email' => $email,
            'dogumTarihi' => $dogumtarihi,
            'ogrenci_resmi' => $ogrenci_resmi,
        ]);
        $ogrenciID = $pdo->lastInsertId();

        $sorgu = $pdo->prepare("UPDATE kullanicilar SET ogrenci_ID = :ogrenciID WHERE kullanici_ID = :kullaniciID");
        $sorgu->execute(['ogrenciID' => $ogrenciID, 'kullaniciID' => $kullaniciID]);

        $pdo->commit();

        echo "<script> Swal.fire({
            icon: 'success',
            title: 'Başarılı şekilde kayıt oldun, $kullaniciAdi!.',
            text: 'giriş yapmaya yönlendiriliyorsun.',
            }); 
            setTimeout(function(){
                window.location.href = 'giriş_form.php';
            }, 2000); 
            </script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script> Swal.fire({
            icon: 'success',
            title: 'İşlem sırasında bir hata oluştu.',
            text: 'Lütfen daha sonra tekrar deneyin.',
        }); 
        setTimeout(function(){
            window.location.href = 'kayit_form.php';
        }, 2000); 
        </script>";
    }
}
