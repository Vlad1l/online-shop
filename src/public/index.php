<?php

$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './registration/registration_form.php';
    } else if ($requestMethod === 'POST') {
        require_once './registration/handle_registration_form.php';
    }
} elseif ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './login/login_form.php';
    } else if ($requestMethod === 'POST') {
        require_once './login/handle_login.php';
    }
} elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog/catalog.php';
    }
} elseif ($requestUri === '/add-product') {
    if ($requestMethod === 'GET') {
        require_once './add_product/add_product_form.php';
    }
    if ($requestMethod === 'POST') {
        require_once './add_product/handle_add_product.php';
    }
}
else {
    require_once './404.php';
}