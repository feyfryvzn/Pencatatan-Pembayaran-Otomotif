<?php
session_start();
require 'koneksi.php'; // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feyfey - Pembelian Sparepart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff69b4, #b3d9ff);
            overflow: hidden;
        }

        /* Floating Particles */
        .particles, .icons {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: float 8s infinite ease-in-out;
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-100px) translateX(50px); }
            100% { transform: translateY(0) translateX(0); }
        }

        /* Floating Icons */
        .icon {
            position: absolute;
            font-size: 30px;
            opacity: 0.5;
            animation: moveIcon 12s infinite ease-in-out;
        }

        @keyframes moveIcon {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: glow 2s infinite alternate ease-in-out;
            position: relative;
        }

        @keyframes glow {
            from { box-shadow: 0 0 10px rgba(255, 105, 180, 0.5); }
            to { box-shadow: 0 0 20px rgba(255, 105, 180, 0.8); }
        }

        h1 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
        }

        p {
            font-size: 16px;
            margin-bottom: 25px;
            color: rgba(255, 255, 255, 0.9);
        }

        .login-link {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff69b4, #b3d9ff);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-link::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
        }

        .login-link:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .login-link:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

    <!-- Floating Particles -->
    <div class="particles">
        <?php for ($i = 0; $i < 15; $i++): ?>
            <div class="particle" style="top: <?= rand(10, 90) ?>vh; left: <?= rand(10, 90) ?>vw; animation-duration: <?= rand(5, 15) ?>s;"></div>
        <?php endfor; ?>
    </div>

    <!-- Floating Icons -->
    <div class="icons">
        <?php
            $icons = ["⚙️", "🚀", "💡", "🔧", "🛠️"];
            for ($i = 0; $i < 5; $i++): ?>
            <div class="icon" style="top: <?= rand(5, 95) ?>vh; left: <?= rand(5, 95) ?>vw; animation-duration: <?= rand(6, 14) ?>s;">
                <?= $icons[array_rand($icons)] ?>
            </div>
        <?php endfor; ?>
    </div>

    <div class="container">
        <h1>🚀 Selamat Datang di SAKURA KOREA PARTS ⚙️</h1>
        <p>Silakan login untuk mengakses sistem.</p>
        <a href="login.php" class="login-link">🔑 Login</a>
    </div>

</body>
</html>
