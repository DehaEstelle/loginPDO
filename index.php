<?php
require_once './isLogg.php';

$currentUser = isLogg();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <title>Home</title>
</head>
<body>
    <nav>
        <ul class="navbar">
            <li><a href="/">Home</a></li>
            <?php if ($currentUser) :?>
            <li><a href="/Logout.php">Logout</a></li>
            <li><a href="/Profile.php">Profile</a></li>
            <?php else : ?>
                <li><a href="/Login.php">Login</a></li>
            <li><a href="/register.php">Register</a></li>
            <?php endif; ?>

        </ul>
    </nav>
    
    <div class="container">
        <h1>Home</h1>
        <p>Welcome to the home page!</p>
    </div>

</body>
</html>