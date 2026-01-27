<?php
    session_start();

    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Admin</title>
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
            height: 100vh;
            background: linear-gradient(135deg, #ffc0cb, #b3d9ff);
            justify-content: center;
            align-items: center;
            color: white;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
            color: black;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin-bottom: 20px;
            color: #ff69b4;
        }

        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus {
            border-color: #ff69b4;
            box-shadow: 0px 0px 5px rgba(255, 105, 180, 0.5);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #ff69b4;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #d14784;
        }

        .register-link {
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
            color: #ff69b4;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
        </style>
        <script>
            function redirectToDashboard(event) {
                event.preventDefault(); // Mencegah pengiriman form
                window.location.href = "dashboard.php"; // Pindah ke dashboard.php
            }
        </script>
    </head>
    <body>


        <!-- Main Content -->
        <div class="login-container">
        <h2>🚗 Login Admin</h2>
        <form onsubmit="redirectToDashboard(event)">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">

            <label for="password">Password</label>
            <input type="password" id="password" name="password">

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>