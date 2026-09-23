<?php

class VarianteProducto {
    private $conn;
    private $table = 'variantes_producto';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Trae todas las variantes de un producto (para el selector de color)
    public function obtenerPorProducto($productoId) {
        $query = "SELECT * FROM " . $this->table . " WHERE producto_id = :producto_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Suma el stock de todas las variantes de un producto (para mostrar disponibilidad total)
    public function stockTotalPorProducto($productoId) {
        $query = "SELECT SUM(stock) as total FROM " . $this->table . " WHERE producto_id = :producto_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }
}   