<?php
require '../db.php'; // Adatbázis kapcsolat betöltése

// Játékosok lekérése az adatbázisból
$sql = "SELECT PlayerID, Username, Email, Level, RegDate FROM players";
$stmt = $conn->prepare($sql);
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dungeon Master | Players</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @font-face {
            font-family: 'DungeonFont';
            src: url('../fonts/dungeon.otf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        * {
            font-family: 'DungeonFont', sans-serif;
            color: white;
        }
        .sidebar {
            background: #111;
            min-height: 100vh;
            position: fixed;
            width: 250px;
        }
        .card-header { background-color: #111; }
        .card-body { background-color: #222; }
        table { background-color: #222; }
        th, td {
            color: white !important;
            background-color: #222 !important;
        }
        tr { text-align: center; }
        .main-content, .navbar { background-color: #333; }
        body { background-color: #333; }
        h4 {
            color: #FFD700;
            font-size: 22px;
        }
        h5 { color: white; }
        .btn { color: white; }
        .modal-content { background-color: #222; }
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

    <!-- Táblázat -->
    <div class="card shadow" style="background-color: #222 !important;">
        <div class="card-header">
            <h5 class="mb-0">Players</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="usersTable">
                <thead>
                    <tr>
                        <th>PlayerID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Registration date</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?= htmlspecialchars($player['PlayerID']) ?></td>
                        <td><?= htmlspecialchars($player['Username']) ?></td>
                        <td><?= htmlspecialchars($player['Email']) ?></td>
                        <td><?= $player['RegDate'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                                    onclick="loadEditForm(<?= $player['PlayerID'] ?>, '<?= htmlspecialchars($player['Username']) ?>', '<?= htmlspecialchars($player['Email']) ?>', <?= $player['Level'] ?>, '<?= $player['RegDate'] ?>')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $player['PlayerID'] ?>)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Módosítás Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editing <span id="editUsernameLabel"></span></h5>
                <button type="button" class="btn-close" style="background-color: white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="update_player.php" method="POST">
                    <input type="hidden" name="PlayerID" id="editPlayerID">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <input type="number" class="form-control" id="editLevel" name="level">
                    </div>
                    <div class="mb-3">
                        <label for="registrationDate" class="form-label">Registration Date</label>
                        <input type="text" class="form-control" id="editRegDate" name="regDate" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(playerID) {
        if (confirm("Are you sure you want to delete this player?")) {
            window.location.href = `delete_player.php?PlayerID=${playerID}`;
        }
    }

    function loadEditForm(playerID, username, email, level, regDate) {
        document.getElementById('editPlayerID').value = playerID;
        document.getElementById('editUsername').value = username;
        document.getElementById('editEmail').value = email;
        document.getElementById('editLevel').value = level;
        document.getElementById('editRegDate').value = regDate;
        document.getElementById('editUsernameLabel').innerText = username;
    }
</script>
</body>
</html>