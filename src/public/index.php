<?php

$autoload = function (string $className) {
    $className = str_replace('\\', '/', $className);
    $path = "../$className.php";

    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    echo $path;
    return false;
};

spl_autoload_register($autoload);

//require_once '../Core/App.php';
$app = new \Core\App();
$app->run();