<?php

//function validate(array $data)
//{
//    $errors = [];
//
//    if (isset($data['name'])) {
//        $name = $data['name'];
//
//        if (strlen($name) < 2) {
//            $errors['name'] = 'name must be more than 2 characters';
//        }
//    } else {
//        $errors['name'] = 'name is required';
//    }
//
//    if (isset($data['email'])) {
//        $email = $data['email'];
//
//        if (strlen($email) < 2) {
//            $errors['email'] = 'email must be more than 2 characters';
//        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
//            $errors['email'] = 'email must have an @';
//        }
//    } else {
//        $errors['email'] = 'email is required';
//    }
//
//    if (isset($data['psw'])) {
//        $password = $data['psw'];
//
//        if (strlen($password) < 4) {
//            $errors['password'] = 'password must be at least 4 characters';
//        } elseif (isset($data['psw-repeat'])) {
//            $passwordRep = $data['psw-repeat'];
//
//            if ($password !== $passwordRep) {
//                $errors['passwordRep'] = 'passwords do not match';
//            }
//        } else {
//            $errors['passwordRep'] = 'password is required';
//        }
//    } else {
//        $errors['password'] = 'password is required';
//    }
//
//    if (empty($errors)) {
//        $pdo = new PDO("pgsql:host=db; port=5432; dbname=mydb", 'user', 'pass');
//
//        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
//        $stmt->execute(['email' => $email]);
//
//        $data1 = $stmt->fetch();
//        if (empty($data1)) {
//            $password = password_hash($password, PASSWORD_DEFAULT);
//
//            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
//            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
//
//            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
//            $stmt->execute(['email' => $email]);
//
//            $data1 = $stmt->fetch();
//
//            print_r($data1);
//        } else {
//            $errors['email'] = 'email already registered';
//        }
//    }
//    return $errors;
//}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
} else {
    $errors['product_id'] = 'name is required';
}

if (isset($_POST['amount'])) {
    $amount = $_POST['amount'];

    if (strlen($amount) < 1) {
        $errors['amount'] = 'amount must be more than 1';
    }
} else {
    $errors['amount'] = 'amount is required';
}

$errors = [];

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=mydb", 'user', 'pass');

    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $product_id]);

    $data1 = $stmt->fetch();
    if (empty($data1)) {
        $user_id = 1;

        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);

        $data1 = $stmt->fetch();

        print_r($data1);
    } else {
        $user_id = 1;

        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);

        $data1 = $stmt->fetch();

        $amount = $data1['amount'] + $amount;

        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);

        $data1 = $stmt->fetch();

        print_r($data1);
    }
}

print_r($errors);

require_once './add_product/add_product_form.php';
