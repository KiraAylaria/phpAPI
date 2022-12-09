<?php

    declare(strict_types = 1);

    require 'autoload.php';

    set_error_handler('ErrorHandler::handleError');
    set_exception_handler('ErrorHandler::handleException');

    header("Content-type: application/json; charset=UTF-8");
    
    $parts = explode('/', $_SERVER['REQUEST_URI']);

    if ($parts[1] != 'products') {
        // Not Found
        http_response_code(404);
        exit;
    }

    $id = $parts[2] ?? null;
    
    $db = new Database('localhost', 'pokeguesser', 'root', '');
    $db->getConnection();

    $gateway = new ProductGateway($db);

    $controller = new ProductController($gateway);

    $controller->processRequest($_SERVER['REQUEST_METHOD'], $id);