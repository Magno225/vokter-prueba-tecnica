<?php

class Factura {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearDireccion($usuarioId, $direccion, $ciudad, $departamento, $codigoPostal) {
        $query = "INSERT INTO direcciones_envio (usuario_id, direccion, ciudad, departamento, codigo_postal, es_principal) 
                   VALUES (:usuario_id, :direccion, :ciudad, :departamento, :codigo_postal, 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':codigo_postal', $codigoPostal);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function obtenerEstadoPorNombre($nombre) {
        $query = "SELECT id FROM estados_pedido WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? $fila['id'] : null;
    }

    public function crearFactura($usuarioId, $direccionId, $estadoId, $subtotal, $costoEnvio, $total) {
        $query = "INSERT INTO facturas (usuario_id, direccion_envio_id, estado_id, subtotal, costo_envio, total) 
                   VALUES (:usuario_id, :direccion_id, :estado_id, :subtotal, :costo_envio, :total)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':direccion_id', $direccionId, PDO::PARAM_INT);
        $stmt->bindParam(':estado_id', $estadoId, PDO::PARAM_INT);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':costo_envio', $costoEnvio);
        $stmt->bindParam(':total', $total);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function crearDetalle($facturaId, $varianteId, $cantidad, $precioUnitario) {
        $query = "INSERT INTO detalle_factura (factura_id, variante_id, cantidad, precio_unitario) 
                   VALUES (:factura_id, :variante_id, :cantidad, :precio_unitario)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':factura_id', $facturaId, PDO::PARAM_INT);
        $stmt->bindParam(':variante_id', $varianteId, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':precio_unitario', $precioUnitario);
        return $stmt->execute();
    }

    public function reducirStock($varianteId, $cantidad) {
        $query = "UPDATE variantes_producto SET stock = stock - :cantidad WHERE id = :id AND stock >= :cantidad2";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad2', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id', $varianteId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function vaciarCarrito($carritoId) {
        $query = "DELETE FROM items_carrito WHERE carrito_id = :carrito_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carrito_id', $carritoId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}