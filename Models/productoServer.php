<?php

class Producto {
    private $conn;
    private $table = 'productos';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM " . $this->table . " WHERE activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCategoria($categoriaId) {
        $query = "SELECT * FROM " . $this->table . " WHERE categoria_id = :categoria_id AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEnPromocion() {
        $query = "SELECT * FROM " . $this->table . " WHERE en_promocion = 1 AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }  
    
    public function obtenerNovedades() {
        $query = "SELECT * FROM " . $this->table . " WHERE activo = 1 ORDER BY id DESC LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buscarPorPalabra($palabra) {
        $query = "SELECT * FROM " . $this->table . " WHERE nombre LIKE :palabra AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $busqueda = '%' . $palabra . '%';
        $stmt->bindParam(':palabra', $busqueda, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
    



