<?php

    class Routes
    {

        private Gateway $gateway;
        private Controller $controller;

        private $requestId;
        private $requestRoute;

        public function __construct()
        {

            // Get the requested ressources from the url
            $urlParts = explode('/', $_SERVER['REQUEST_URI']);
            $this->requestRoute = $urlParts[1];
            $this->requestId = $urlParts[2] ?? null;

            // Create gateway and controllers for available routes
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
                    // Route not found
                    http_response_code(404);
                    exit;
            }

        }

        public function processRequest()
        {
            // Process the request
            $this->controller->processRequest($_SERVER['REQUEST_METHOD'], $this->requestId);
        }

        public function options() 
        {
            $this->controller->routeOptions($this->requestId);
        }

    }