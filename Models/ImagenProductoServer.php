<?php

class ImagenProducto {
    private $conn;
    private $table = 'imagenes_producto';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Trae todas las imágenes de un producto, ordenadas
    public function obtenerPorProducto($productoId) {
        $query = "SELECT * FROM " . $this->table . " WHERE producto_id = :producto_id ORDER BY orden ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Trae SOLO la imagen principal de un producto (útil para catálogos con muchas tarjetas)
    public function obtenerPrincipal($productoId) {
        $query = "SELECT * FROM " . $this->table . " WHERE producto_id = :producto_id AND es_principal = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}