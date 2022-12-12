<?php
    
    require 'config.php';

    // Authorization
    if (isset($_SERVER['HTTP_X_API_KEY']) && $_SERVER['HTTP_X_API_KEY'] == API_KEY) {

        $routes = new Routes();
        $routes->processRequest();

    } else {

        // Unauthorized
        http_response_code(401);
        exit;

    }
