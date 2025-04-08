<?php

class ProductController
{
    public function getCatalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            exit;
        } else {
            $pdo = new PDO("pgsql:host=db;port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->query("SELECT * FROM products");
            $products = $stmt->fetchAll();
            require_once '../Views/catalog.php';
        }
    }
}