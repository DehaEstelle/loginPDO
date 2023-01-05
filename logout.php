<?php
$pdo = require __DIR__ . './database.php';

$sessionId = $_COOKIE['session'] ?? null;
if ($sessionId) {
    $statement = $pdo->prepare('DELETE FROM session WHERE idsession = :id');
    $statement->execute([
        ':id' => $sessionId,
    ]);
    setcookie('session', '', time() - 1);
    header('Location: /');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <title>Logout</title>
</head>
<body>
    <nav>
        <ul class="navbar">
            <li><a href="/">Home</a></li>
            <li><a href="/Login.php">Login</a></li>
            <li><a href="/Logout.php">Logout</a></li>
            <li><a href="/Profile.php">Profile</a></li>
            <li><a href="/register.php">Register</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h1>Logout</h1>
        <p>Welcome to the Logout page!</p>
    </div>

</body>
</html>