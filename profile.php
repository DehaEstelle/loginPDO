<?php

require_once './isLogg.php';

$currentUser = isLogg();

if (!$currentUser) {
    header('Location: /login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <title>Profile</title>
</head>
<body>
    <nav>
        <ul class="navbar">
            <li><a href="/">Home</a></li>
            <li><a href="/Logout.php">Logout</a></li>
            <li><a href="/Profile.php">Profile</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h1>Profile</h1>
        <p>Welcome to the <?= $currentUser['username']?> profile page!</p>
    </div>

</body>
</html>