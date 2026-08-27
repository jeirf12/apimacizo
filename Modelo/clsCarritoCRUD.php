<?php
require_once 'Modelo/clsCarrito.php';
require_once 'Modelo/clsProducto.php';

class clsCarritoCRUD {
    private $conexion;
    private $auxPDO;
    
    public function __construct($pconexion) {
        $this->conexion = $pconexion;
    }
    
    public function agregarAlCarrito($obj) {
        $resultado = false;
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = 'INSERT INTO `agregacarrito` (PRO_ID,USU_ID,CAR_CANTIDAD) VALUES (?,?,?)';
            $this->auxPDO->prepare($consulta)->execute(array($obj->proid, $obj->usuid, $obj->cantidad));
            $this->conexion->desconectar();
            $resultado = true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function editarCantidadProductoCarrito($obj) {
        $resultado = false;
         try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = 'UPDATE `agregacarrito` SET CAR_CANTIDAD=? WHERE USU_ID = ? AND PRO_ID =?';
            $this->auxPDO->prepare($consulta)->execute(array($obj->cantidad, $obj->usuid, $obj->proid));
            $this->conexion->desconectar();
            $resultado = true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function eliminarProductoCarrito($obj) {
        $resultado = false;
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = 'DELETE FROM `agregacarrito` WHERE USU_ID = ? AND PRO_ID =?';
            $this->auxPDO->prepare($consulta)->execute(array($obj->usuid, $obj->proid));
            $this->conexion->desconectar();
            $resultado = true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function obtenerProductosCarrito($id) {
        $resultado = array();
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = $this->auxPDO->prepare('SELECT P.PRO_ID, CC.USU_ID, P.PRO_NOMBRE,P.PRO_PRECIO,P.PRO_IMAGEN,P.PRO_DESCRIPCION,CC.CAR_CANTIDAD,CP.CATPRO_NOMBRE FROM `agregacarrito` CC INNER JOIN `producto` P ON CC.PRO_ID = P.PRO_ID INNER JOIN `categoriaproducto` CP ON P.CATPRO_ID = CP.CATPRO_ID WHERE USU_ID = ?');
            $consulta->execute(array($id));
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                $auxProducto = new clsProducto();
                $auxProducto->__SET('id', $obj->PRO_ID);
                $auxProducto->__SET('nombre', $obj->PRO_NOMBRE);
                $auxProducto->__SET('precio', $obj->PRO_PRECIO);
                $auxProducto->__SET('imagen', $obj->PRO_IMAGEN);
                $auxProducto->__SET('descripcion', $obj->PRO_DESCRIPCION);
                $auxProducto->__SET('cantidad', $obj->CAR_CANTIDAD);
                $auxProducto->__SET('categoria', $obj->CATPRO_NOMBRE);
                $auxProducto->__SET('usuid', $obj->USU_ID);
                $resultado [] = $auxProducto;
            }
            $this->conexion->desconectar();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }

    public function obtenerCantidadProductosCarritoPorProductoId($usuid, $proid) {
        $cantidad = 0;
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $cantidad;
            $consulta = $this->auxPDO->prepare('SELECT sum(CAR_CANTIDAD) as suma FROM `agregacarrito` WHERE PRO_ID = ? AND USU_ID = ?');
            $consulta->execute(array($proid, $usuid));
            if(($cantidad = $consulta->fetchALL()) != null) {
                $cantidad = intval($cantidad[0]['suma']);
            }
            $this->conexion->desconectar();
        } catch(Exception $ex) {
            die($ex->getMessage());
        }
        return $cantidad;
    }
}
?>
