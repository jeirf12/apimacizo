<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clsUsuario
 *
 * @author AdrianFelipe
 */
class clsUsuario {
      //atributos
    private $id;
    private $nombre;
    private $clave;
    private $correo;
    private $rol;
    
    //metodos
    public function __construct() {}
    public function __get($atr) {return $this->$atr;}
    public function __set($atr, $val) {return $this->$atr = $val;}
    
    
}