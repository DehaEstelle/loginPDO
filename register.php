<?php
$pdo = require_once 'database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $input = filter_input_array(INPUT_POST, [
        'username' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'email' => FILTER_SANITIZE_EMAIL,
        'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ]);
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';
    $hashpass = password_hash($password, PASSWORD_ARGON2ID);
    $email = $input['email'] ?? '';

    if (!$username) {
        $error = 'erreur: username manquant';
    } elseif (!$password) {
        $error = 'erreur sur le mot de passe';
    } elseif (!$email) {
        $error = 'erreur sur l\'email';
    } else {
        $statement = $pdo->prepare('INSERT INTO user (username, password, email) VALUES (:username, :password, :email)');

        $statement->execute([
            'username' => $username,
            'password' => $hashpass,
            'email' => $email,
        ]);

        header('Location: /login.php');
    }
}
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <title>Register</title>
</head>
<body>
    <nav>
        <ul class="navbar">
            <li><a href="/">Home</a></li>
            <li><a href="/Login.php">Login</a></li>
            <li><a href="/register.php">Register</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h1>Register</h1>
        <p>Welcome to the Register page!</p>
        <div class="form-action">
            <form action="register.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Register">
                <?php if ($error) : ?>
                    <p style="color: red;">Error: <?= $error ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

</body>
</html>