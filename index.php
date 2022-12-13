<?php
    
    require 'config.php';

    // Authorization
    if (isset($_SERVER['HTTP_X_API_KEY']) && $_SERVER['HTTP_X_API_KEY'] == API_KEY || $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

        $routes = new Routes();

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

            $routes->options();

        } else {

            // process the request
            $routes->processRequest();

        }

    } else {

        // Unauthorized
        http_response_code(401);
        exit;

    }
