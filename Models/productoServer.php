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
    // Diccionario de sinónimos: la clave es lo que el usuario puede escribir,
    // el valor es la lista de palabras reales que existen en los nombres de productos.
    $sinonimos = [
        'zapatos'   => ['tenis', 'bota', 'botas'],        
        'calzado'   => ['tenis', 'bota', 'botas'],
        'sudadera'  => ['conjunto'],
        'ropa'  => ['conjunto'],
        'sudaderas' => ['conjunto'],
        'audifonos' => ['audifono', 'audífonos', 'audífono', 'diadema', 'diademas'],
        'celular'   => ['telefono', 'smartphone'],
        // Agrega aquí más equivalencias a medida que las identifiques
    ];

    $palabraNormalizada = strtolower(trim($palabra));

    // Empezamos con la palabra original que escribió el usuario
    $terminos = [$palabraNormalizada];

    // Si esa palabra tiene sinónimos registrados, los agregamos a la lista
    if (isset($sinonimos[$palabraNormalizada])) {
        $terminos = array_merge($terminos, $sinonimos[$palabraNormalizada]);
    }

    // Construimos dinámicamente: nombre LIKE :t0 OR nombre LIKE :t1 OR ...
    $condiciones = [];
    $parametros = [];
    foreach ($terminos as $indice => $termino) {
        $marcador = ':termino' . $indice;
        $condiciones[] = "nombre LIKE $marcador";
        $parametros[$marcador] = '%' . $termino . '%';
    }

    $query = "SELECT * FROM " . $this->table . "
              WHERE (" . implode(' OR ', $condiciones) . ")
              AND activo = 1";

    $stmt = $this->conn->prepare($query);

    foreach ($parametros as $marcador => $valor) {
        $stmt->bindValue($marcador, $valor, PDO::PARAM_STR);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
    



