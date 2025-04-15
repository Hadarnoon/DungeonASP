<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dungeon Master | Bejelentkezés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @font-face {
            font-family: 'DungeonFont';
            src: url('../fonts/dungeon.otf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        *
        {
            font-family: 'DungeonFont', sans-serif;
            color: white;
        }
        h2
        {
            font-family: 'DungeonFont', sans-serif;
            background-color: #111;
            color: #FFD700 !important;
            font-weight: bold;
        }
        .login-btn
        {
            color: #222;
            background-color: #FFD700;

        }
        body {
            background-color: #222;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            transition: background-color 0.3s, color 0.3s;
        }
        .login-card {
            background: #111;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            transition: background-color 0.3s, color 0.3s;
        }
        .login-card h2 {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .login-card .form-control {
            margin-bottom: 1rem;
        }

        .login-card .btn {
            width: 100%;
        }
    </style>
</head>
<body class="light-theme">

<!-- Bejelentkezési kártya -->
<div class="login-card">
    <h2>Dungeon Master</h2>
    <form id="loginForm">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" placeholder="" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="" required>
        </div>
        <button type="submit" class="btn login-btn">Log in</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Itt lehetne backend hívás, de most csak egy üzenetet jelenítünk meg
        alert(`Bejelentkezés: ${username}\nJelszó: ${password}`);
    });
</script>
</body>
</html>