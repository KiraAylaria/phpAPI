<?php

    class ErrorHandler
    {
        public static function handleException(Throwable $exception) : void
        {
            // Internal Server Error
            http_response_code(500);

            // Response in JSON format
            echo json_encode([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ]);
        }

        public static function handleError(int $errno, string $errstr, string $errfile, int $errline) : bool
        {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        }
    }