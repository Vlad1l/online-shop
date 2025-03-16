<?php
$pdo = new PDO("pgsql:host=db; port=5432; dbname=mydb", 'user', 'pass');

$statement = $pdo->query("SELECT * FROM users");

$data = $statement->fetchAll();

echo "<pre>";
print_r($data);
echo "<pre>";