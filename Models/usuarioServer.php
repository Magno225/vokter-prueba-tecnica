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

    public function obtenerPorId($id) {
    $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function actualizarDatos($id, $nombre, $apellido, $correo, $telefono) {
    $query = "UPDATE " . $this->table . "
              SET nombre = :nombre, apellido = :apellido, correo = :correo, telefono = :telefono
              WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

public function actualizarPassword($id, $passwordHash) {
    $query = "UPDATE " . $this->table . " SET password_hash = :password_hash WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':password_hash', $passwordHash);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

}