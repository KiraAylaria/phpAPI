<?php

    abstract class Gateway
    {

        protected PDO $conn;

        public function __construct()
        {
            // Create database
            $db = new Database(DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
            $this->conn = $db->getConnection();
        }

        // Get collection
        abstract public function getAll() : array;

        // Post
        abstract public function create(array $data) : string;

        // Get ressource
        abstract public function get(string $id) : array | bool;

        // Patch
        abstract public function update(array $current, array $new) : int;

        // Delete
        abstract public function delete(string $id) : int;

    }