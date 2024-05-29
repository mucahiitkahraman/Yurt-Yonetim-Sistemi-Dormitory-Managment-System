<?php
session_start();

if (!isset($_SESSION['selected_language'])) {
  $_SESSION['selected_language'] = 'turkish'; 
}

if (isset($_POST['language'])) {
  $_SESSION['selected_language'] = $_POST['language'];
}

if ($_SESSION['selected_language'] == 'turkish') {
  include 'turkce.php';
} elseif ($_SESSION['selected_language'] == 'english') {
  include 'ingilizce.php';
} else {
  include 'turkce.php';
}
?>

?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="girisvekayit3.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <title><?php echo $lang['title']; ?></title>
     <style>.sagust {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    background-color: #fff;
    padding: 5px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.sagust select {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 14px;
}

.sagust input[type="submit"] {
    padding: 5px 10px;
    margin-left: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #f0f0f0;
    cursor: pointer;
}
</style>
   </head>
<body>
  <div class="container">
    <div class="title"><?php echo $lang['title']; ?></div>
    <div class="content">
      <form class="form" action="kayit.php" method="post" enctype="multipart/form-data" id="kayitFormu">
        <div class="user-details">
            
          <div class="input-box">
            <span class="details"><?php echo $lang['name']; ?></span>
            <input type="text" name="isim" placeholder="İsminizi Giriniz" pattern="[A-Za-zÇçĞğİıÖöŞşÜü]+" title="Sadece alfabetik karakterler kabul edilir" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['surname']; ?></span>
            <input type="text" name="soyisim" placeholder="Soyisminizi Giriniz" pattern="[A-Za-zÇçĞğİıÖöŞşÜü]+" title="Sadece alfabetik karakterler kabul edilir" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['username']; ?></span>
            <input type="text" name="kullaniciAdi" placeholder="Kullanıcı Adınızı Giriniz" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['id_number']; ?></span>
            <input type="number" name="kimlikNo" placeholder="Kimlik No Giriniz" minlength="6" maxlength="20" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['address']; ?></span>
            <input type="text" name="adres" placeholder="Adres Giriniz" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['email']; ?></span>
            <input type="text" name="email" placeholder="Email adresizi Giriniz" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['student_number']; ?></span>
            <input type="number" name="ogrenciNo" placeholder="Öğrenci Numarasını Giriniz" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['password']; ?></span>
            <input type="password" name="sifre" placeholder="Şifrenizi Giriniz" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['password']; ?></span>
            <input type="password" name="sifre_dogrulama" placeholder="Şifre Onaylama" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['birth_date']; ?></span>
            <input type="date" id="dogumtarihi" name="dogumtarihi">
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['phone_number']; ?></span>
            <input type="tel" name="telefon" placeholder="Telefon Numaranızı Giriniz" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['picture']; ?></span>
            <input type="file" name="ogrenci_resmi" accept="image/*" required>
          </div>
        </div>

        <div class="gender-details">
          <input type="radio" name="cinsiyet" value="Erkek" id="dot-1">
          <input type="radio" name="cinsiyet" value="Kadın" id="dot-2">
          <span class="gender-title"><?php echo $lang['gender']; ?></span>
          <div class="category">
            <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender"><?php echo $lang['male']; ?></span>
          </label>
          <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender"><?php echo $lang['female']; ?></span>
          </label>
        </div>
        <div class="g-recaptcha" data-sitekey="6LfcvdApAAAAAI8tp2iTPxczIGuQXUstHHfOrVVu"></div>
        <div class="button">
          <input type="submit" name="submit" value="<?php echo $lang['register']; ?>">
        </div>
        <div class="signin-link">
          <?php echo $lang['back']; ?>  <a href="giriş_form.php?lang=<?php echo $_SESSION['selected_language']; ?>"><?php echo $lang['login']; ?></a>
       </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById("kayitFormu").onsubmit = function(event) {
        const cinsiyet = document.querySelector('input[name="cinsiyet"]:checked');
        if (!cinsiyet) {
            event.preventDefault(); 
            alert("Cinsiyet seçin"); 
        }
    };
</script>
  
<script>
    const dogumTarihi = document.getElementById('dogumtarihi');
    dogumTarihi.setAttribute('min', '1997-01-01');
    dogumTarihi.setAttribute('max', '2005-12-31');
</script>

<form class="sagust" action="kayit_form.php" method="POST">
        <select name="language">
            <option value="turkish" <?php echo $_SESSION['selected_language'] == 'turkish' ? 'selected' : ''; ?>>Türkçe</option>
            <option value="english" <?php echo $_SESSION['selected_language'] == 'english' ? 'selected' : ''; ?>>English</option>
        </select>
        <input type="submit" value="Select Language">
</form>
</body>
</html>