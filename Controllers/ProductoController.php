<?php
require_once __DIR__ . '/../Models/productoServer.php';
require_once __DIR__ . '/../Models/ImagenProductoServer.php';
require_once __DIR__ . '/../Models/varianteProductoServer.php';

class ProductoController {
    private $productoModel;
    private $imagenModel;
    private $varianteModel;

    public function __construct($db) {
        $this->productoModel = new Producto($db);
        $this->imagenModel = new ImagenProducto($db);
        $this->varianteModel = new VarianteProducto($db);
    }

    public function listarTodos() {
        $productos = $this->productoModel->obtenerTodos();

        foreach ($productos as &$producto) {
            $imagenes = $this->imagenModel->obtenerPorProducto($producto['id']);
            $producto['imagenes'] = $imagenes;
            $producto['imagen_url'] = !empty($imagenes) ? $imagenes[0]['url'] : null;
        }
        unset($producto);

        return $productos;
    }

    public function listarPorCategoria($categoriaId) {
        $productos = $this->productoModel->obtenerPorCategoria($categoriaId);

        foreach ($productos as &$producto) {
            $imagenes = $this->imagenModel->obtenerPorProducto($producto['id']);
            $producto['imagenes'] = $imagenes;
            $producto['imagen_url'] = !empty($imagenes) ? $imagenes[0]['url'] : null;
        }
        unset($producto);

        return $productos;
        
    }

    public function listarPromociones() {
        $productos = $this->productoModel->obtenerEnPromocion();
        $this->agregarImagenesYCalificacion($productos);
    return $productos;
}

    public function obtenerDetalle($id) {
        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            return null;
        }

        $producto['imagenes'] = $this->imagenModel->obtenerPorProducto($id);
        $producto['variantes'] = $this->varianteModel->obtenerPorProducto($id);
        $producto['stock_total'] = $this->varianteModel->stockTotalPorProducto($id);

        return $producto;
    }

   private function agregarImagenesYCalificacion(&$productos) {
        foreach ($productos as &$producto) {
            $imagenes = $this->imagenModel->obtenerPorProducto($producto['id']);
            $producto['imagenes'] = $imagenes;
            $producto['imagen_url'] = !empty($imagenes) ? $imagenes[0]['url'] : null;
        }
        unset($producto);
    }

    public function listarNovedades() {
        $productos = $this->productoModel->obtenerNovedades();
        $this->agregarImagenesYCalificacion($productos);
    return $productos;

    }

    public function buscarPorPalabra($palabra) {
        $productos = $this->productoModel->buscarPorPalabra($palabra);
        $this->agregarImagenesYCalificacion($productos);
    return $productos;
}

    
}