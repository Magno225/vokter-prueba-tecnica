<?php
class Pedido {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lista todos los pedidos de un usuario, del más reciente al más antiguo
    public function obtenerPorUsuario($usuarioId) {
        $query = "SELECT f.id, f.fecha_pedido, f.subtotal, f.costo_envio, f.total, ep.nombre AS estado
                  FROM facturas f
                  JOIN estados_pedido ep ON f.estado_id = ep.id
                  WHERE f.usuario_id = :usuarioId
                  ORDER BY f.fecha_pedido DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verifica que una factura sea realmente del usuario que la pide (seguridad)
    public function perteneceAUsuario($facturaId, $usuarioId) {
        $query = "SELECT COUNT(*) AS total FROM facturas WHERE id = :facturaId AND usuario_id = :usuarioId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':facturaId', $facturaId);
        $stmt->bindParam(':usuarioId', $usuarioId);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila['total'] > 0;
    }

    // Datos generales de la factura + dirección + datos del cliente
    public function obtenerFacturaCompleta($facturaId) {
        $query = "SELECT f.id, f.fecha_pedido, f.subtotal, f.costo_envio, f.total, ep.nombre AS estado,
                         d.direccion, d.ciudad, d.departamento, d.codigo_postal,
                         u.nombre, u.apellido, u.correo
                  FROM facturas f
                  JOIN estados_pedido ep ON f.estado_id = ep.id
                  JOIN direcciones_envio d ON f.direccion_envio_id = d.id
                  JOIN usuarios u ON f.usuario_id = u.id
                  WHERE f.id = :facturaId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':facturaId', $facturaId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Productos que componen esa factura
    public function obtenerDetalleFactura($facturaId) {
        $query = "SELECT p.nombre, vp.color, vp.talla, df.cantidad, df.precio_unitario,
                         (df.cantidad * df.precio_unitario) AS subtotal_linea
                  FROM detalle_factura df
                  JOIN variantes_producto vp ON df.variante_id = vp.id
                  JOIN productos p ON vp.producto_id = p.id
                  WHERE df.factura_id = :facturaId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':facturaId', $facturaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}