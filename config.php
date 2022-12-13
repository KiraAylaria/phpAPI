<?php

    // Load classes automatically and use types
    declare(strict_types = 1);
    require 'autoload.php';

    // Custom error and exception handlers
    set_error_handler('ErrorHandler::handleError');
    set_exception_handler('ErrorHandler::handleException');

    // Content type of response
    header("Content-type: application/json; charset=UTF-8");

    // Database credentials
    define('DB_HOST', 'localhost');
    define('DB_DATABASE', 'phpapi');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    // API authorization key
    define('API_KEY', "OTvMzrSE,IFgxClMfWFp:=gD~ICRI+ZSN+;vj,T'Lx");