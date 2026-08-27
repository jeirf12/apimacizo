<?php

class Factory {
    private static $instance = [];

    private function __construct() {}
    
    public static function getInstance() {
        $cls = static::class;
        if(!isset(self::$instance[$cls])){
            self::$instance[$cls] = new static();
            session_start();
        }
        return self::$instance[$cls];
    }

    public function getController($controller) {
        $result = null;
        $type = strtolower($controller);
        $entities = array(
            'producto' => function() {
                require_once 'Controlador/controladorProducto.php';
                return new ControladorProducto();
            },
            'sesion' => function() {
                require_once 'Controlador/controladorSesion.php';
                return new ControladorSesion();
            },
            'carrito' => function() {
                require_once 'Controlador/controladorCarrito.php';
                return new ControladorCarrito();
            }
        );
        if(array_key_exists($type, $entities)) {
            $result = $entities[$type]();
        }
        return $result;
    }
}
?>
