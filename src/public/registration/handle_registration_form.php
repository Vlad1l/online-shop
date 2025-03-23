<?php

function validate(array $data)
{
    $errors = [];

    if (isset($data['name'])) {
        $name = $data['name'];

        if (strlen($name) < 2) {
            $errors['name'] = 'name must be more than 2 characters';
        }
    } else {
        $errors['name'] = 'name is required';
    }

    if (isset($data['email'])) {
        $email = $data['email'];

        if (strlen($email) < 2) {
            $errors['email'] = 'email must be more than 2 characters';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'email must have an @';
        }
    } else {
        $errors['email'] = 'email is required';
    }

    if (isset($data['psw'])) {
        $password = $data['psw'];

        if (strlen($password) < 4) {
            $errors['password'] = 'password must be at least 4 characters';
        } elseif (isset($data['psw-repeat'])) {
            $passwordRep = $data['psw-repeat'];

            if ($password !== $passwordRep) {
                $errors['passwordRep'] = 'passwords do not match';
            }
        } else {
            $errors['passwordRep'] = 'password is required';
        }
    } else {
        $errors['password'] = 'password is required';
    }

    if (empty($errors)) {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=mydb", 'user', 'pass');

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $data1 = $stmt->fetch();
        if (empty($data1)) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            $data1 = $stmt->fetch();

            print_r($data1);
        } else {
            $errors['email'] = 'email already registered';
        }
    }
    return $errors;
}

$errors = validate($_POST);

print_r($errors);

require_once './registration/registration_form.php';
