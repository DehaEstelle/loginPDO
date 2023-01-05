<?php
$pdo = require_once './database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $input = filter_input_array(INPUT_POST, [
        'email' => FILTER_SANITIZE_EMAIL,
    ]);
    $password = $_POST['password'] ?? '';
    $email = $input['email'] ?? '';

    if (!$password || !$email) {
        $error = 'erreur';
    } else {
        $statementUser = $pdo->prepare('SELECT * FROM user WHERE email = ?');
        $statementUser->execute([$email]);
        $user = $statementUser->fetch();

        if (password_verify($password, $user['password'])) {
            $sessionid = bin2hex(random_bytes(32));
            $statementSession = $pdo->prepare('INSERT INTO session VALUES (:idsession, :user_id)');
            $statementSession->execute([
                ':idsession' => $sessionid,
                ':user_id' => $user['iduser'],
            ]);
            $signature = hash_hmac('sha256', $sessionid, 'quatre petits chats');
            setcookie('session', $sessionid, time() + (86400 * 30), "/", "", false, true);
            setcookie('signature', $signature, time() + (86400 * 30), "/", "", false, true);
        
            header('Location: /profile.php');
        } else {
            $error = 'erreur mot de passe';
        }
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
    <title>Login</title>
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
        <h1>Login</h1>
        <p>Welcome to the Login page!</p>
        <div class="form-action">
            <form action="/login.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
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