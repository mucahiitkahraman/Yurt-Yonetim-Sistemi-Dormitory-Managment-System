<?php
include("auth_session2.php");
require('db2.php');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yurt Yönetim Sistemi - Ana Sayfa</title>
    <link rel="stylesheet" href="anasayfa.css?v=<?php echo time()?>">
    <style> 
    @import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
  html{   
    background-size: cover;
    height:100%;
  }

  #feedback-page{
    text-align:center;
  }

  #form-main{
    width:100%;
    float:left;
    padding-top:0px;
  }

  #form-div {
    background-color:rgba(72,72,72,0.4);
    padding-left:35px;
    padding-right:35px;
    padding-top:35px;
    padding-bottom:50px;
    width: 450px;
    float: left;
    left: 50%;
    position: absolute;
    margin-top:30px;
    margin-left: -260px;
    -moz-border-radius: 7px;
    -webkit-border-radius: 7px;
  }

  .feedback-input {
    color:#3c3c3c;
    font-family: Helvetica, Arial, sans-serif;
    font-weight:500;
    font-size: 18px;
    border-radius: 0;
    line-height: 22px;
    background-color: #fbfbfb;
    padding: 13px 13px 13px 54px;
    margin-bottom: 10px;
    width:100%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    box-sizing: border-box;
    border: 3px solid rgba(0,0,0,0);
  }

  .feedback-input:focus{
    background: #fff;
    box-shadow: 0;
    border: 3px solid #3498db;
    color: #3498db;
    outline: none;
    padding: 13px 13px 13px 54px;
  }

  .focused{
    color:#30aed6;
    border:#30aed6 solid 3px;
  }


  #name{
    background-image: url(http://rexkirby.com/kirbyandson/images/name.svg);
    background-size: 30px 30px;
    background-position: 11px 8px;
    background-repeat: no-repeat;
  }

  #name:focus{
    background-image: url(http://rexkirby.com/kirbyandson/images/name.svg);
    background-size: 30px 30px;
    background-position: 8px 5px;
    background-position: 11px 8px;
    background-repeat: no-repeat;
  }

  #email{
    background-image: url(http://rexkirby.com/kirbyandson/images/email.svg);
    background-size: 30px 30px;
    background-position: 11px 8px;
    background-repeat: no-repeat;
  }

  #email:focus{
    background-image: url(http://rexkirby.com/kirbyandson/images/email.svg);
    background-size: 30px 30px;
    background-position: 11px 8px;
    background-repeat: no-repeat;
  }

  #comment{
    background-image: url(http://rexkirby.com/kirbyandson/images/comment.svg);
    background-size: 30px 30px;
    background-position: 11px 8px;
    background-repeat: no-repeat;
  }

  textarea {
      width: 100%;
      height: 150px;
      line-height: 150%;
      resize:vertical;
  }

  input:hover, textarea:hover,
  input:focus, textarea:focus {
    background-color:white;
  }

  #button-blue{
    font-family: 'Montserrat', Arial, Helvetica, sans-serif;
    float:left;
    width: 100%;
    border: #fbfbfb solid 4px;
    cursor:pointer;
    background-color: #3498db;
    color:white;
    font-size:24px;
    padding-top:22px;
    padding-bottom:22px;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
    margin-top:-4px;
    font-weight:700;
  }

  #button-blue:hover{
    background-color: rgba(0,0,0,0);
    color: #0493bd;
  }
    
  .submit:hover {
    color: #3498db;
  }
    
  .ease {
    width: 0px;
    height: 74px;
    background-color: #fbfbfb;
    -webkit-transition: .3s ease;
    -moz-transition: .3s ease;
    -o-transition: .3s ease;
    -ms-transition: .3s ease;
    transition: .3s ease;
  }

  .submit:hover .ease{
    width:100%;
    background-color:white;
  }

  @media only screen and (max-width: 580px) {
    #form-div{
      left: 3%;
      margin-right: 3%;
      width: 88%;
      margin-left: 0;
      padding-left: 3%;
      padding-right: 3%;
    }
  } 
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            
            <header>
                    <img src="resimler/354637.png" alt="Yurt Öğrenci Portalı" style="width:150px; display: block; margin: 0 auto;">
            </header>
            <nav class="menu">
                <a href="anasayfa.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-houses" viewBox="-1 -1 16 16">
                <path d="M5.793 1a1 1 0 0 1 1.414 0l.647.646a.5.5 0 1 1-.708.708L6.5 1.707 2 6.207V12.5a.5.5 0 0 0 .5.5.5.5 0 0 1 0 1A1.5 1.5 0 0 1 1 12.5V7.207l-.146.147a.5.5 0 0 1-.708-.708zm3 1a1 1 0 0 1 1.414 0L12 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l1.854 1.853a.5.5 0 0 1-.708.708L15 8.207V13.5a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 4 13.5V8.207l-.146.147a.5.5 0 1 1-.708-.708zm.707.707L5 7.207V13.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5V7.207z"/>
                </svg>    
                Ana Sayfa</a>

                <a href="yurt.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="-1 -2 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>    
                Yurt Arama</a>

                <a href="hizmet.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-collapse-vertical" viewBox="0 -1 16 16">
                <path d="M8 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M0 8a.5.5 0 0 1 .5-.5h3.793L3.146 6.354a.5.5 0 1 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8.5H.5A.5.5 0 0 1 0 8m11.707.5 1.147 1.146a.5.5 0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2a.5.5 0 0 1 .708.708L11.707 7.5H15.5a.5.5 0 0 1 0 1z"/>
                </svg>    
                Hizmet Karşılaştırması</a>

                <a href="mesaj.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chat-right-text" viewBox="0 -2 16 16">
                <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                </svg>    
                Öğrenci Eşleştirme (CHAT)</a>

                <a href="derecelendirme.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                </svg>
                Derecelendirme</a>

                <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-envelope-plus" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
                <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5"/>
                </svg>    
                Geri Bildirim</a>

                <a href="dauakademiktakvim.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-calendar-date-fill" viewBox="0 -2 16 16">
                <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2"/>
                <path d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z"/>
                </svg>    
                Akademik Takvim</a>

                <a href="ogrencibilgileri.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 -2 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
                </svg>
                Öğrenci Bilgilerim</a>
                
                <a href="cikis.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 12">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                </svg> 
                Çıkış Yap</a>
            </nav>
        </div> 
        
        <div class="content">
            
            <div id="form-main">
        <div id="form-div">
        <form class="form" id="form1">
        
        <p class="name">
            <input name="name" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Name" id="name" />
        </p>
        
        <p class="email">
            <input name="email" type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Email" />
        </p>
        
        <p class="text">
            <textarea name="text" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="Comment"></textarea>
        </p>
        
        <div class="submit">
            <input type="submit" value="SEND" id="button-blue"/>
            <div class="ease"></div>
        </div>
        </form>
    </div>
</div>
</body>
</html>

