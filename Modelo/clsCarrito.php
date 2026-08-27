<?php

class clsCarrito {
    private $carid;
    private $proid;
    private $usuid;
    private $cantidad;
    
    public function __construct() {}
    public function __get($atr) {return $this->$atr;}
    public function __set($atr, $val) {return $this->$atr = $val;}
}
?>
