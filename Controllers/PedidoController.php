<?php
require_once __DIR__ . '/../Models/pedidoServer.php';

class PedidoController {
    private $pedidoModel;

    public function __construct($db) {
        $this->pedidoModel = new Pedido($db);
    }

    public function listarPedidos($usuarioId) {
        return $this->pedidoModel->obtenerPorUsuario($usuarioId);
    }

    // Devuelve null si la factura no existe o no pertenece a este usuario
    public function obtenerFacturaParaPDF($facturaId, $usuarioId) {
        if (!$this->pedidoModel->perteneceAUsuario($facturaId, $usuarioId)) {
            return null;
        }
        return [
            'factura' => $this->pedidoModel->obtenerFacturaCompleta($facturaId),
            'detalle' => $this->pedidoModel->obtenerDetalleFactura($facturaId),
        ];
    }
}