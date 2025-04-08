<?php

class CartController
{

}

//private function validateAddProducts($data)
//{
//
//    $errors = [];
//
//    if (!isset($data['product_id'])) {
//        $errors['product_id'] = 'name is required';
//    }
//
//    if (isset($data['amount'])) {
//        if ($data['amount'] < 1) {
//            $errors['amount'] = 'amount must be more than 1';
//        }
//    } else {
//        $errors['amount'] = 'amount is required';
//    }
//    return $errors;
//}
//
//public function addProductToCart()
//{
//    if (session_status() !== PHP_SESSION_ACTIVE) {
//        session_start();
//    }
//
//    $errors = $this->validateAddProducts($_POST);
//
//    if (empty($errors)) {
//        $product_id = $_POST['product_id'];
//        $amount = $_POST['amount'];
//        $user_id = $_SESSION['userId'];
//
//        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
//        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
//
//        $data1 = $stmt->fetch();
//        if (empty($data1)) {
//
//            $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
//            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
//
//            $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
//            $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
//
//            $data1 = $stmt->fetch();
//        } else {
//
//            $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
//            $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
//
//            $data1 = $stmt->fetch();
//
//            $amount = $data1['amount'] + $amount;
//
//            $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id AND user_id = :user_id");
//            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
//
//            $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
//            $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
//
//            $data1 = $stmt->fetch();
//        }
//
//        print_r($data1);
//    }
//
//    print_r($errors);
//
//    $this->getAddProductForm();
//}
//
//public function getAddProductForm()
//{
//    if (session_status() !== PHP_SESSION_ACTIVE) {
//        session_start();
//    }
//
//    if (!isset($_SESSION['userId'])) {
//        header('Location: /login');
//        exit;
//    }
//
//    require_once '../Views/add_product_form.php';
//}
