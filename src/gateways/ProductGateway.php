<?php

    class ProductGateway extends Gateway
    {

        public function __construct()
        {
            parent::__construct();
        }

        // Get all products
        public function getAll() : array
        {
            $sql = "SELECT * FROM products";
            $stmt = $this->conn->query($sql);
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $row['is_available'] = (bool) $row['is_available'];
                $data[] = $row;
            }
            return $data;
        }

        // Create a product
        public function create(array $data) : string
        {
            $sql = "INSERT INTO products (name, size, is_available) VALUES (:name, :size, :is_available)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':size', $data['size'], PDO::PARAM_INT);
            $stmt->bindValue(':is_available', (bool) ($data['is_available'] ?? false), PDO::PARAM_BOOL);
            
            $stmt->execute();

            return $this->conn->lastInsertId();
        }

        // Get a specific product
        public function get(string $id) : array | bool
        {
            $sql = "SELECT * FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data !== false) {
                $data['is_available'] = (bool) $data['is_available'];
            }

            return $data;
        }

        // Update a product
        public function update(array $current, array $new) : int
        {
            $sql = "UPDATE products SET name = :name, size = :size, is_available = :is_available WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':name', $new['name'] ?? $current['name'], PDO::PARAM_STR);
            $stmt->bindValue(':size', $new['size'] ?? $current['size'], PDO::PARAM_INT);
            $stmt->bindValue(':is_available', $new['is_available'] ?? $current['is_available'], PDO::PARAM_BOOL);
            $stmt->bindValue(':id', $current['id'], PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        }

        // Delete a product
        public function delete(string $id) : int
        {
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        }

    }