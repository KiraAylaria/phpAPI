<?php

    abstract class Controller
    {

        protected Gateway $gateway;

        public function __construct(Gateway $gateway)
        {
            // Set the gateway
            $this->gateway = $gateway;
        }

        abstract public function processRequest(string $method, ?string $id) : void;

        abstract protected function processResourceRequest(string $method, string $id) : void;

        abstract protected function processCollectionRequest(string $method) : void;

        // Validate request
        abstract protected function getValidationErrors(array $data, bool $is_new = true) : array;

        public function routeOptions(?string $id)
        {
            if ($id) {
                $this->resourceOptions();
            } else {
                $this->collectionOptions();
            }
        }

        protected function resourceOptions()
        {
            // No Content
            http_response_code(204);
            header('Allow: OPTIONS, GET, PATCH');
            header('Accept: application/json');
            exit;
        }

        protected function collectionOptions()
        {
            // No Content
            http_response_code(204);
            header('Allow: OPTIONS, GET, POST');
            header('Accept: application/json');
            exit;
        }

    }