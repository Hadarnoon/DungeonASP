<?php
// Adatbázis kapcsolat
$servername = "localhost";
$username = "root"; // Csere a valós adatokra
$password = "";
$dbname = "dungeonmaster";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Játékosok száma
    $stmt = $conn->query("SELECT COUNT(*) FROM players");
    $playerCount = $stmt->fetchColumn();

    // Mai regisztrációk
    $stmt = $conn->query("SELECT COUNT(*) FROM players WHERE DATE(RegDate) = CURDATE()");
    $newRegs = $stmt->fetchColumn();

    // Lejátszott meccsek
    $stmt = $conn->query("SELECT COUNT(*) FROM matchlogs");
    $matchesPlayed = $stmt->fetchColumn();

    // Recent match-logs lekérése
    $stmt = $conn->query("
        SELECT m.PlayerID, p.Username, m.Kills, m.MatchDuration, m.Win 
        FROM matchlogs m
        JOIN players p ON m.PlayerID = p.PlayerID
        ORDER BY m.MatchID DESC
        LIMIT 10
    ");
    $matchLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Hiba: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dungeon Master | Dashboard</title>
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
        .sidebar {
            background: #111;
            min-height: 100vh;
            position: fixed;
            width: 250px;
        }
        .card-header{background-color: #111;}
        .card-body{background-color: #222;}
        table {background-color: #222;}
        th, td
        {
            color: white !important;
            background-color: #222 !important;
        }
        tr {text-align: center;}
        .main-content, .navbar
        {
            background-color: #333;
        }
        body {background-color: #333;}
        h4
        {
            color: #FFD700;
            font-size: 22px;
        }
        h5{color: white;}
        .sidebar-header {
            padding: 20px;
            color: #ecf0f1;
            border-bottom: 1px solid #34495e;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li a {
            color: #bdc3c7;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
            transition: 0.3s;
        }
        
        .sidebar-menu li a:hover {
            background: #34495e;
            color: #ecf0f1;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            position: relative; /* Hozzáadva */
        }
        
        .stat-icon {
            font-size: 2.5rem;
            position: absolute; /* Hozzáadva */
            top: 20px; /* Hozzáadva */
            right: 20px; /* Hozzáadva */
            opacity: 0.7;
        }
    </style>
</head>
<body>

<!-- Oldalsáv -->
<div class="sidebar">
    <div class="sidebar-header">
        <h4>Dungeon Master</h4>
    </div>
    <ul class="sidebar-menu">
        <li><a href="mainPanel.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
        <li><a href="users.php"><i class="fas fa-users me-2"></i>Players</a></li>
    </ul>
</div>

<!-- Fő tartalom -->
<div class="main-content">
    <!-- Fejléc -->
    <nav class="navbar mb-4">
        <div class="container-fluid">
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Username or PlayerID">
            </form>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user me-2"></i>Admin
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Statisztikai kártyák -->
    <div class="row">
        <div class="col-md-4">
            <div class="stat-card bg-primary text-white">
                <h5>Player count</h5>
                <h2><?= htmlspecialchars($playerCount) ?></h2>
                <i class="fas fa-users stat-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-success text-white">
                <h5>Matches played</h5>
                <h2><?= htmlspecialchars($matchesPlayed) ?></h2>
                <i class="fas fa-gamepad stat-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-info text-white">
                <h5>New regs</h5>
                <h2><?= htmlspecialchars($newRegs) ?></h2>
                <i class="fas fa-chart-line stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Táblázat -->
    <div class="card shadow" style="background-color: #222 !important;">
        <div class="card-header">
            <h5 class="mb-0">Recent match-logs</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>PlayerID</th>
                        <th>Username</th>
                        <th>Kills</th>
                        <th>Match duration</th>
                        <th>Win</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matchLogs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['PlayerID']) ?></td>
                            <td><?= htmlspecialchars($log['Username']) ?></td>
                            <td><?= htmlspecialchars($log['Kills']) ?></td>
                            <td><?= htmlspecialchars($log['MatchDuration']) ?> min</td>
                            <td><?= $log['Win'] ? 'true' : 'false' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>