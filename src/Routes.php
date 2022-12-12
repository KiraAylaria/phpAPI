<?php

    class Routes
    {

        private Gateway $gateway;
        private Controller $controller;

        private $requestId;
        private $requestRoute;

        public function __construct()
        {

            $urlParts = explode('/', $_SERVER['REQUEST_URI']);
            $this->requestRoute = $urlParts[1];
            $this->requestId = $parts[2] ?? null;

            // Available routes
            switch ($this->requestRoute) {
                case 'products':
                    $this->gateway = new ProductGateway();
                    $this->controller = new ProductController($this->gateway);
                    break;

                case 'users':
                    $this->gateway = new UserGateway();
                    $this->controller = new UserController($this->gateway);
                    break;

                default:
                    // Not Found
                    http_response_code(404);
                    exit;
            }

        }

        public function processRequest()
        {
            $this->controller->processRequest($_SERVER['REQUEST_METHOD'], $this->requestId);
        }

    }