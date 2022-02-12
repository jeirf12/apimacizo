<?php
require 'Modelo/clsConexion.php';
require 'Modelo/clsProducto.php';

class clsProductoCRUD {
    //atributos
    private $conexion;
    private $auxPDO;
    
    //metodos
    public function __construct($pconexion) {
        $this->conexion = $pconexion;
        $this->conexion->conectar();
        $this->auxPDO = $this->conexion->conexionPDO;
    }
    public function Listar(){
       
        try{
            $consulta = $this->auxPDO->prepare("SELECT * FROM PRODUCTO");
            $consulta->execute();

            $resultado = array();
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj){
                $auxProducto = new clsProducto();
                $auxProducto->__SET('id',$obj->pro_id);
                $auxProducto->__SET('nombre',$obj->pro_nombre);
                $auxProducto->__SET('precio',$obj->pro_precio);
                $auxProducto->__SET('imagen',$obj->pro_imagen);
                $auxProducto->__SET('descripcion',$obj->pro_descripcion);
                $auxProducto->__SET('cantidad',$obj->pro_cantidad);
                $auxProducto->__SET('categoria',$obj->pro_categoria);
                $resultado [] = $auxProducto;
            }
        }
        catch (Exception $ex){
            die($ex->getMessage());
        }
        
        return $resultado;
    }
    public function Crear($obj){
        $resultado = false;
        try{
            $consulta = "INSERT INTO PRODUCTO (PRO_NOMBRE,PRO_PRECIO,PRO_IMAGEN,PRO_DESCRIPCION,PRO_CANTIDAD,PRO_CATEGORIA) VALUES (?,?,?,?,?,?)";
            $this->auxPDO->prepare($consulta)->execute(array($obj->nombre,$obj->precio,$obj->imagen,$obj->descripcion,$obj->cantidad,$obj->categoria));
            $resultado = true;
        }
        catch (Exception $ex){
            die($ex->getMessage());
        }
        return $resultado;
    }
    public function Editar($obj){
        $resultado = false;
         try{
            $consulta = "UPDATE PRODUCTO SET PRO_NOMBRE=?, PRO_PRECIO=?, PRO_IMAGEN=?, PRO_DESCRIPCION=?, PRO_CANTIDAD=?, PRO_CATEGORIA=?  WHERE codigo =?";
            $this->auxPDO->prepare($consulta)->execute(array($obj->nombre,$obj->precio,$obj->imagen,$obj->descripcion,$obj->cantidad,$obj->categoria,$obj->id));
            $resultado = true;
        }
        catch (Exception $ex){
            die($ex->getMessage());
        }
         return $resultado;
    }
    public function Eliminar($codigo){
         try{
            $consulta = "DELETE FROM producto WHERE codigo=?";
            $this->auxPDO->prepare($consulta)->execute(array($codigo));
        }
        catch (Exception $ex){
            die($ex->getMessage());
        }
    }
    
    public function Obtener($codigo){
         try{
            $consulta = $this->auxPDO->prepare("SELECT * FROM producto WHERE codigo=?");
            $consulta->execute(array($codigo));
            
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj){
                $auxProducto = new clsProducto();
                $auxProducto->__SET('id',$obj->pro_id);
                $auxProducto->__SET('nombre',$obj->pro_nombre);
                $auxProducto->__SET('precio',$obj->pro_precio);
                $auxProducto->__SET('imagen',$obj->pro_imagen);
                $auxProducto->__SET('descripcion',$obj->pro_descripcion);
                $auxProducto->__SET('cantidad',$obj->pro_cantidad);
                $auxProducto->__SET('categoria',$obj->pro_categoria);
            }
            return $auxProducto;
        }
        catch (Exception $ex){
            die($ex->getMessage());
        }
    }
}
