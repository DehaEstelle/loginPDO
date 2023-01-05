<?php

function isLogg()
{
    $pdo = require __DIR__ . './database.php';


    $sessionId = $_COOKIE['session'] ?? null;
    $signature = $_COOKIE['signature'] ?? null;

    if ($sessionId && $signature) {
        $hash = hash_hmac('sha256', $sessionId, 'quatre petits chats');
        $match = hash_equals($hash, $signature);
        if ($match) {
            $sessionStatement = $pdo->prepare('SELECT * FROM session WHERE idsession = :id');
            $sessionStatement->execute([
        ':id' => $sessionId,
    ]);
            $session = $sessionStatement->fetch();
            if ($session) {
                $userStatement = $pdo->prepare('SELECT * FROM user WHERE iduser = :id');
                $userStatement->bindValue(':id', $session['user_id']);
                $userStatement->execute();
                $user = $userStatement->fetch();
            }
        }
    }
    return $user ?? null;
}
