<?php

session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: /login_form.php');
}
else {
    $pdo = new PDO("pgsql:host=db;port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
    require_once './catalog_page.php';
}
