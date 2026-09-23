<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'wokterdb';//Me quivoque a escribir en nombre en phpMyAdmin. Lo arreglare luego.)=
    private $username = 'root';
    private $password = '';
    private $port = '3307'; 
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}