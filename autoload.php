<?php

    // Register custom autoloader
    spl_autoload_register('autoloader');

    // Load classes automatically if the class file exists in a directory
    function autoloader($class) {
        if (file_exists(__DIR__ . "/src/gateways/$class.php") || file_exists(__DIR__ . "/src/controllers/$class.php")) {
            if (file_exists(__DIR__ . "/src/gateways/$class.php")) {
                require __DIR__ . "/src/gateways/$class.php";
            }
            if (file_exists(__DIR__ . "/src/controllers/$class.php")) {
                require __DIR__ . "/src/controllers/$class.php";
            }
        } else {
            require __DIR__ . "/src/$class.php";
        }
    }