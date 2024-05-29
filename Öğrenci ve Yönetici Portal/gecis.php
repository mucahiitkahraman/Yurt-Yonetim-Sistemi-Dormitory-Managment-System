<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YYS - GEÇİŞ SAYFASI</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            background-attachment: fixed;
            overflow: hidden;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
            position: relative;
            z-index: 1;
        }

        .button {
            flex: 1;
            padding: 20px 40px;
            margin: 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 1);
            text-decoration: none;
            font-size: 1.5em;
            font-weight: bold;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            transition: transform 0.4s, background 0.4s, color 0.4s;
            border: 2px solid rgba(0, 0, 0, 0.8);
        }

        .button:hover {
            background: rgba(255, 255, 255, 0.7);
            color: #333;
            transform: scale(1.1) translateY(-10px);
        }

        .divider {
            height: 200px;
            width: 2px;
            background-color: rgba(255, 255, 255, 0.8);
            margin: 0 50px;
            border-radius: 2px;
        }

        @media (max-width: 800px) {
            .container {
                flex-direction: column;
                padding: 20px;
            }

            .divider {
                height: 2px;
                width: 80%;
                margin: 20px 0;
            }

            .button {
                margin: 10px 0;
            }
        }

        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .background-animation .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            animation: move 20s infinite linear;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        }

        .background-animation .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 15%;
        }

        .background-animation .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 25%;
            animation-duration: 25s;
        }

        .background-animation .shape:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 80%;
            left: 70%;
            animation-duration: 30s;
        }

        @keyframes move {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
            }
            100% {
                transform: translateY(-1000px) translateX(1000px) rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="background-animation">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="container">
        <a href="PhpProject1/anasayfa.php" class="button">Yönetici</a>
        <div class="divider"></div>
        <a href="dormitory managment system/anasayfa.php" class="button">Öğrenci</a>
    </div>
</body>
</html>
