<?php

$errors = [];

if (isset($_POST['name']))
{
    $name = $_POST['name'];

    if (strlen($name) < 2) {
        $errors['name'] = 'name must be more than 2 characters';
    }
}
else {
    $errors['name'] = 'name is required';
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (strlen($email) < 2) {
        $errors['email'] = 'email must be more than 2 characters';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'email must have an @';
    }
}
else {
    $errors['email'] = 'email is required';
}

if (isset($_POST['psw'])) {
    $password = $_POST['psw'];

    if (strlen($password) < 6) {
        $errors['password'] = 'password must be at least 6 characters';
    }
    elseif (isset($_POST['psw-repeat'])) {
        $passwordRep = $_POST['psw-repeat'];

        if ($password !== $passwordRep) {
            $errors['passwordRep'] = 'passwords do not match';
        }
    }
    else {
        $errors['passwordRep'] = 'password is required';
    }
}
else {
    $errors['password'] = 'password is required';
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=mydb", 'user', 'pass');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $data = $stmt->fetch();
    if (empty($data)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $data = $stmt->fetch();

        print_r($data);
    }
    else {
        $errors['email'] = 'email already registered';
    }
}
else {
    print_r($errors);
}

require_once './registration_form.php';
