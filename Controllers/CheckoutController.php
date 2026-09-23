<?php
require_once __DIR__ . '/../Models/facturaServer.php';
require_once __DIR__ . '/../Models/carritoServer.php';

class CheckoutController {
    private $facturaModel;
    private $carritoModel;

    public function __construct($db) {
        $this->facturaModel = new Factura($db);
        $this->carritoModel = new Carrito($db);
    }

    public function confirmarPedido($usuarioId, $direccion, $ciudad, $departamento, $codigoPostal) {
        $carritoId = $this->carritoModel->obtenerOCrearCarrito($usuarioId);
        $items = $this->carritoModel->obtenerItems($carritoId);

        if (empty($items)) {
            return ['exito' => false, 'mensaje' => 'Tu carrito está vacío.'];
        }

        // Verificamos que haya stock suficiente para TODO antes de confirmar nada
        foreach ($items as $item) {
            if ($item['cantidad'] > $item['stock']) {
                return ['exito' => false, 'mensaje' => 'No hay stock suficiente para "' . $item['nombre'] . '".'];
            }
        }

        $direccionId = $this->facturaModel->crearDireccion($usuarioId, $direccion, $ciudad, $departamento, $codigoPostal);
        $estadoId = $this->facturaModel->obtenerEstadoPorNombre('Confirmado');

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['precio_unitario'] * $item['cantidad'];
        }
        $costoEnvio = 0; // envío gratis, según tu trust-bar
        $total = $subtotal + $costoEnvio;

        $facturaId = $this->facturaModel->crearFactura($usuarioId, $direccionId, $estadoId, $subtotal, $costoEnvio, $total);

        foreach ($items as $item) {
            $this->facturaModel->crearDetalle($facturaId, $item['variante_id'], $item['cantidad'], $item['precio_unitario']);
            $this->facturaModel->reducirStock($item['variante_id'], $item['cantidad']);
        }

        $this->facturaModel->vaciarCarrito($carritoId);

        return ['exito' => true, 'factura_id' => $facturaId, 'total' => $total];
    }
}