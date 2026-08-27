<?php
require_once 'Modelo/clsProducto.php';

class clsProductoCRUD {
    private $conexion;
    private $auxPDO;
    
    public function __construct($pconexion) {
        $this->conexion = $pconexion;
    }

    public function listarProductos() {
        $resultado = array();
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = $this->auxPDO->prepare('SELECT * FROM `producto` P INNER JOIN `categoriaproducto` C ON P.CATPRO_ID = C.CATPRO_ID');
            $consulta->execute();
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                $auxProducto = new clsProducto();
                $auxProducto->__SET('id', $obj->PRO_ID);
                $auxProducto->__SET('nombre', $obj->PRO_NOMBRE);
                $auxProducto->__SET('precio', $obj->PRO_PRECIO);
                $auxProducto->__SET('imagen', $obj->PRO_IMAGEN);
                $auxProducto->__SET('descripcion', $obj->PRO_DESCRIPCION);
                $auxProducto->__SET('cantidad', $obj->PRO_CANTIDAD);
                $auxProducto->__SET('categoria', $obj->CATPRO_NOMBRE);
                $resultado [] = $auxProducto;
            }
            $this->conexion->desconectar();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function buscarProductoPorPalabras($palabra) {
        $resultado = array();
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $palabra = $this->auxPDO->quote("%".$palabra."%");
            $consulta = $this->auxPDO->prepare("SELECT * FROM `producto` P INNER JOIN `categoriaproducto` C ON P.CATPRO_ID = C.CATPRO_ID WHERE `pro_nombre` LIKE $palabra OR `catpro_nombre` LIKE $palabra");
            $consulta->execute();
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                $auxProducto = new clsProducto();
                $auxProducto->__SET('id', $obj->PRO_ID);
                $auxProducto->__SET('nombre', $obj->PRO_NOMBRE);
                $auxProducto->__SET('precio', $obj->PRO_PRECIO);
                $auxProducto->__SET('imagen', $obj->PRO_IMAGEN);
                $auxProducto->__SET('descripcion', $obj->PRO_DESCRIPCION);
                $auxProducto->__SET('cantidad', $obj->PRO_CANTIDAD);
                $auxProducto->__SET('categoria', $obj->CATPRO_NOMBRE);
                $resultado [] = $auxProducto;
            }
            $this->conexion->desconectar();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function crearProducto($obj) {
        $resultado = false;
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = 'INSERT INTO `producto` (PRO_NOMBRE,PRO_PRECIO,PRO_IMAGEN,PRO_DESCRIPCION,PRO_CANTIDAD, CATPRO_ID) VALUES (?,?,?,?,?,?)';
            $this->auxPDO->prepare($consulta)->execute(array($obj->nombre, $obj->precio,$obj->imagen, $obj->descripcion, $obj->cantidad, $obj->categoria));
            $this->conexion->desconectar();
            $resultado = true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function editarProducto($obj) {
        $resultado = false;
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = 'UPDATE `producto` SET PRO_NOMBRE=?, PRO_PRECIO=?, PRO_IMAGEN=?, PRO_DESCRIPCION=?, PRO_CANTIDAD=?, CATPRO_ID=?  WHERE PRO_ID =?';
            $this->auxPDO->prepare($consulta)->execute(array($obj->nombre, $obj->precio, $obj->imagen, $obj->descripcion, $obj->cantidad, $obj->categoria, $obj->id));
            $this->conexion->desconectar();
            $resultado = true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function eliminarProducto($codigo) {
        $resultado = false;
        try { 
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = 'DELETE FROM `producto` WHERE PRO_ID=?';
            $this->auxPDO->prepare($consulta)->execute(array($codigo));
            $this->conexion->desconectar();
            $resultado = true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }
    
    public function obtenerProductosPorCategoria($codigo) {
        $auxProducto = null;
         try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $auxProducto;
            $consulta = $this->auxPDO->prepare('SELECT * FROM `producto` P INNER JOIN `categoriaproducto` CP ON P.CATPRO_ID = CP.CATPRO_ID WHERE PRO_ID = ?');
            $consulta->execute(array($codigo));
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                $auxProducto = new clsProducto();
                $auxProducto->__set('id', $obj->PRO_ID);
                $auxProducto->__set('nombre', $obj->PRO_NOMBRE);
                $auxProducto->__set('precio', $obj->PRO_PRECIO);
                $auxProducto->__set('imagen', $obj->PRO_IMAGEN);
                $auxProducto->__set('descripcion', $obj->PRO_DESCRIPCION);
                $auxProducto->__set('cantidad', $obj->PRO_CANTIDAD);
                $auxProducto->__set('categoria', $obj->CATPRO_NOMBRE);
            }
            $this->conexion->desconectar();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $auxProducto;
    }

    public function obtenerCategoriasProductos() {
        $resultado = array();
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = $this->auxPDO->prepare('SELECT * FROM `categoriaproducto`');
            $consulta->execute();
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                $row = array();
                $row ['CATPRO_ID'] = $obj->CATPRO_ID;
                $row ['CATPRO_NOMBRE'] = $obj->CATPRO_NOMBRE;
                $resultado [] = $row;
            }
            $this->conexion->desconectar();
        } catch(Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }
}
?>
