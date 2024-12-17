<?php

class Database {
    public $pdo;

    public function __construct($config) {
        // Ensure all necessary config fields are present
        if (!isset($config['host'], $config['dbname'], $config['user'], $config['password'])) {
            throw new InvalidArgumentException('Missing necessary configuration parameters.');
        }

        // Build the DSN
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
        
        try {
            // Establish PDO connection with exception mode for error handling
            $this->pdo = new PDO($dsn, $config['user'], $config['password']);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Throw exceptions on errors
        } catch (PDOException $e) {
            // Handle connection error
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        // Prepare the SQL statement
        $statement = $this->pdo->prepare($sql);

        // Bind parameters if any
        if ($params) {
            foreach ($params as $key => $value) {
                $statement->bindValue($key, $value);
            }
        }

        try {
            // Execute the statement
            $statement->execute();
            return $statement;
        } catch (PDOException $e) {
            // Handle query error
            die("Query failed: " . $e->getMessage());
        }
    }

    // Fetch all results from a query
    public function fetchAll($sql, $params = []) {
        $statement = $this->query($sql, $params);
        return $statement->fetchAll();
    }

    // Fetch a single result from a query
    public function fetch($sql, $params = []) {
        $statement = $this->query($sql, $params);
        return $statement->fetch();
    }
};


