<?php

$password = $_POST["password"];
$username = $_POST["username"];

$pdo = new PDO("pgsql:host=db;port=5432; dbname=mydb", 'user', 'pass');
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $username]);

$user = $stmt->fetch();

$errors = [];

if ($user === false) {
    $errors['username'] = 'Username or password incorrect';
}
else {
    $passwordDb = $user['password'];

    if (!password_verify($password, $passwordDb)) {
        $errors['password'] = "Username or password incorrect";
    } else {
        session_start();
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userName'] = $user['name'];
        header("Location: ./catalog");
    }
}

require_once "./login/login_form.php";
