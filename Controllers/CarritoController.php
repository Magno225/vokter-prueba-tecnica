<?php
require_once __DIR__ . '/../Models/carritoServer.php';

class CarritoController {
    private $carritoModel;

    public function __construct($db) {
        $this->carritoModel = new Carrito($db);
    }

    public function agregarProducto($usuarioId, $varianteId, $cantidad, $precioUnitario) {
        $carritoId = $this->carritoModel->obtenerOCrearCarrito($usuarioId);
        return $this->carritoModel->agregarItem($carritoId, $varianteId, $cantidad, $precioUnitario);
    }

    public function obtenerCarrito($usuarioId) {
        $carritoId = $this->carritoModel->obtenerOCrearCarrito($usuarioId);
        $items = $this->carritoModel->obtenerItems($carritoId);

        $total = 0;
        foreach ($items as $item) {
            $total += $item['precio_unitario'] * $item['cantidad'];
        }

        return ['items' => $items, 'total' => $total];
    }

    public function incrementar($itemId, $cantidadActual) {
        $stock = $this->carritoModel->obtenerStockDeItem($itemId);
        if ($cantidadActual < $stock) {
            $this->carritoModel->actualizarCantidad($itemId, $cantidadActual + 1);
        }
    }

    public function decrementar($itemId, $cantidadActual) {
        if ($cantidadActual > 1) {
            $this->carritoModel->actualizarCantidad($itemId, $cantidadActual - 1);
        } else {
            $this->carritoModel->eliminarItem($itemId);
        }
    }

    public function eliminar($itemId) {
        $this->carritoModel->eliminarItem($itemId);
    }
    
    public function contarItems($usuarioId) {
    return $this->carritoModel->contarItems($usuarioId);
}
}