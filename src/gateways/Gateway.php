<?php

    abstract class Gateway
    {

        protected PDO $conn;

        public function __construct()
        {
            $db = new Database(DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
            $this->conn = $db->getConnection();
        }

        abstract public function getAll() : array;

        abstract public function create(array $data) : string;

        abstract public function get(string $id) : array | bool;

        abstract public function update(array $current, array $new) : int;

        abstract public function delete(string $id) : int;

    }