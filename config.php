<?php

    declare(strict_types = 1);
    require 'autoload.php';

    set_error_handler('ErrorHandler::handleError');
    set_exception_handler('ErrorHandler::handleException');

    header("Content-type: application/json; charset=UTF-8");

    // Database credentials
    define('DB_HOST', 'localhost');
    define('DB_DATABASE', 'pokeguesser');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    // Api Authorization
    define('API_KEY', "OTvMzrSE,IFgxClMfWFp:=gD~ICRI+ZSN+;vj,T'Lx");