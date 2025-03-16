<?php
$pdo = new PDO("pgsql:host=db; port=5432; dbname=mydb", 'user', 'pass');

echo "Hello World!";

if ($pdo) {
    echo "Connected to PostgresSQL successfully!";
} else {
    echo "Connection failed.";
}

echo "check222";
?>