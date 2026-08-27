<?php

class clsProducto {
    private $id;
    private $nombre;
    private $precio;
    private $imagen;
    private $descripcion;
    private $cantidad;
    private $categoria;
    private $carid;
    private $usuid;
    
    public function __construct() {}
    public function __get($atr){return $this->$atr;}
    public function __set($atr, $val) {return $this->$atr = $val;}
}
?>
