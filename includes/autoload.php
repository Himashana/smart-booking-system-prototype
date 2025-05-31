<?php
// Uses spl_autoload_register() built-in PHP function to automatically load class files when a class is used
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../src/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});