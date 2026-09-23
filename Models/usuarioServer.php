<?php

class Usuario {
    private $conn;
    private $table = 'usuarios';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerPorCorreo($correo) {
        $query = "SELECT * FROM " . $this->table . " WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($cedula, $nombre, $apellido, $correo, $passwordHash, $telefono) {
        $query = "INSERT INTO " . $this->table . " (cedula, nombre, apellido, correo, password_hash, telefono) 
                   VALUES (:cedula, :nombre, :apellido, :correo, :password_hash, :telefono)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':password_hash', $passwordHash);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }
}