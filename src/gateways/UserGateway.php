<?php

    class UserGateway extends Gateway
    {

        public function __construct()
        {
            parent::__construct();
        }

        // Get all users
        public function getAll() : array
        {
            $sql = "SELECT * FROM users";
            $stmt = $this->conn->query($sql);
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }

        // Create a user
        public function create(array $data) : string
        {
            $sql = "INSERT INTO users (username, mail, password) VALUES (:username, :mail, :password)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
            $stmt->bindValue(':mail', $data['mail'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
            
            $stmt->execute();

            return $this->conn->lastInsertId();
        }

        // Get a specific user
        public function get(string $id) : array | bool
        {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data;
        }

        // Update a user
        public function update(array $current, array $new) : int
        {
            $sql = "UPDATE users SET username = :username, mail = :mail, password = :password WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':username', $new['username'] ?? $current['username'], PDO::PARAM_STR);
            $stmt->bindValue(':mail', $new['mail'] ?? $current['mail'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $new['password'] ?? $current['password'], PDO::PARAM_STR);
            $stmt->bindValue(':id', $current['id'], PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        }

        // Delete a user
        public function delete(string $id) : int
        {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        }

    }