<?php

class Carrito {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Cada usuario tiene un solo carrito. Si no existe, lo crea.
    public function obtenerOCrearCarrito($usuarioId) {
        $query = "SELECT id FROM carritos WHERE usuario_id = :usuario_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return $fila['id'];
        }

        $query = "INSERT INTO carritos (usuario_id) VALUES (:usuario_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Si la variante ya está en el carrito, suma la cantidad; si no, la agrega
    public function agregarItem($carritoId, $varianteId, $cantidad, $precioUnitario) {
        $query = "SELECT id, cantidad FROM items_carrito WHERE carrito_id = :carrito_id AND variante_id = :variante_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carrito_id', $carritoId, PDO::PARAM_INT);
        $stmt->bindParam(':variante_id', $varianteId, PDO::PARAM_INT);
        $stmt->execute();
        $existente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existente) {
            $nuevaCantidad = $existente['cantidad'] + $cantidad;
            $query = "UPDATE items_carrito SET cantidad = :cantidad WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cantidad', $nuevaCantidad, PDO::PARAM_INT);
            $stmt->bindParam(':id', $existente['id'], PDO::PARAM_INT);
            return $stmt->execute();
        }

        $query = "INSERT INTO items_carrito (carrito_id, variante_id, cantidad, precio_unitario) 
                   VALUES (:carrito_id, :variante_id, :cantidad, :precio_unitario)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carrito_id', $carritoId, PDO::PARAM_INT);
        $stmt->bindParam(':variante_id', $varianteId, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':precio_unitario', $precioUnitario);
        return $stmt->execute();
    }

    // Trae los items del carrito con todos los datos necesarios para mostrarlos
    public function obtenerItems($carritoId) {
        $query = "SELECT 
                    ic.id as item_id, ic.cantidad, ic.precio_unitario,
                    v.id as variante_id, v.color, v.talla, v.stock,
                    p.id as producto_id, p.nombre
                  FROM items_carrito ic
                  JOIN variantes_producto v ON v.id = ic.variante_id
                  JOIN productos p ON p.id = v.producto_id
                  WHERE ic.carrito_id = :carrito_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carrito_id', $carritoId, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Para cada item, buscamos su imagen (la de la variante, o la principal del producto)
        foreach ($items as &$item) {
            $query = "SELECT url FROM imagenes_producto WHERE variante_id = :variante_id LIMIT 1";
            $stmt2 = $this->conn->prepare($query);
            $stmt2->bindParam(':variante_id', $item['variante_id'], PDO::PARAM_INT);
            $stmt2->execute();
            $img = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (!$img) {
                $query = "SELECT url FROM imagenes_producto WHERE producto_id = :producto_id LIMIT 1";
                $stmt2 = $this->conn->prepare($query);
                $stmt2->bindParam(':producto_id', $item['producto_id'], PDO::PARAM_INT);
                $stmt2->execute();
                $img = $stmt2->fetch(PDO::FETCH_ASSOC);
            }
            $item['imagen_url'] = $img ? $img['url'] : null;
        }
        unset($item);

        return $items;
    }

    public function actualizarCantidad($itemId, $cantidad) {
        $query = "UPDATE items_carrito SET cantidad = :cantidad WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminarItem($itemId) {
        $query = "DELETE FROM items_carrito WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerStockDeItem($itemId) {
        $query = "SELECT v.stock FROM items_carrito ic 
                   JOIN variantes_producto v ON v.id = ic.variante_id 
                   WHERE ic.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? (int) $fila['stock'] : 0;
    }

    public function contarItems($usuarioId) {
    $query = "SELECT SUM(ic.cantidad) as total 
               FROM items_carrito ic
               JOIN carritos c ON c.id = ic.carrito_id
               WHERE c.usuario_id = :usuario_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
    $stmt->execute();
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fila['total'] ? (int) $fila['total'] : 0;
    
    }

}