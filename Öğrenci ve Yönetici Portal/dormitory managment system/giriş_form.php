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
      <form class="form" action="giris.php" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details"><?php echo $lang['username']; ?></span>
            <input type="text" name="kullaniciAdi" placeholder="Kullanıcı Adınızı Giriniz" required>
          </div>
          <div class="input-box">
            <span class="details"><?php echo $lang['password']; ?></span>
            <input type="password" name="sifre" placeholder="Şifrenizi Giriniz" required>
          </div>
          <div class="signup-link">
            <?php echo $lang['back2']; ?>  <a href="kayit_form.php?lang=<?php echo $_SESSION['selected_language']; ?>"><?php echo $lang['register']; ?></a>
         </div>
        </div>

        <div class="g-recaptcha" data-sitekey="6LfcvdApAAAAAI8tp2iTPxczIGuQXUstHHfOrVVu"></div>
        
          <div class="button">
            <input type="submit" name="submit" value="<?php echo $lang['login']; ?>">
          </div>    
      </form>
    </div>
  </div>
  <form class="sagust" action="giriş_form.php" method="POST">
        <select name="language">
            <option value="turkish" <?php echo $_SESSION['selected_language'] == 'turkish' ? 'selected' : ''; ?>>Türkçe</option>
            <option value="english" <?php echo $_SESSION['selected_language'] == 'english' ? 'selected' : ''; ?>>English</option>
        </select>
        <input type="submit" value="Select Language">
</form>

</body>
</html>
