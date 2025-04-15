<?php
require '../db.php';

$playerID = $_POST['PlayerID'];
$username = $_POST['username'];
$email = $_POST['email'];
$level = $_POST['level'];

$sql = "UPDATE players SET Username = :username, Email = :email, Level = :level WHERE PlayerID = :playerID";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':username' => $username,
    ':email' => $email,
    ':level' => $level,
    ':playerID' => $playerID
]);

header("Location: users.php");
exit();
?>