<?php

    abstract class Controller
    {

        protected Gateway $gateway;

        public function __construct(Gateway $gateway)
        {
            $this->gateway = $gateway;
        }

        abstract public function processRequest(string $method, ?string $id) : void;

        abstract protected function processResourceRequest(string $method, string $id) : void;

        abstract protected function processCollectionRequest(string $method) : void;

        abstract protected function getValidationErrors(array $data, bool $is_new = true) : array;

    }