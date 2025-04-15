<?php
require '../db.php';

if (isset($_GET['PlayerID'])) {
    $playerID = $_GET['PlayerID'];

    $sql = "DELETE FROM players WHERE PlayerID = :playerID";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':playerID' => $playerID]);

    header('Location: users.php');
    exit;
}
?>