<?php

class clsSesion {

    private $conexion;
    private $auxPDO;

    public function __construct($pconexion) {
        $this->conexion = $pconexion;
        $this->conexion->conectar();
        $this->auxPDO = $this->conexion->conexionPDO;
        session_start();
    }

  
    public function fijarSesion($usuario) {
        $_SESSION['nombre'] = $usuario->USU_NOMBRE;
        $_SESSION['email'] = $usuario->USU_EMAIL;
        $_SESSION['clave'] = $usuario->USU_PASSWORD;
        $_SESSION['rol'] = $usuario->USU_ROL;
    }
    public function obtenerUsuario($id){
        
        try{ 
            $consulta = "SELECT * FROM USUARIO WHERE USU_ID=?";
            $consulta=$this->auxPDO->prepare($consulta);
            
            $consulta->execute(array($id));
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj){
                $auxUsuario = new clsUsuario();
                $auxUsuario->__SET('id',$obj->usu_id);
                $auxUsuario->__SET('carid',$obj->carr_id);
                $auxUsuario->__SET('nombre',$obj->usu_nombre);
                $auxUsuario->__SET('clave',$obj->usu_password);
                $auxUsuario->__SET('correo',$obj->usu_email);
                $auxUsuario->__SET('rol',$obj->usu_rol);
 
            }          
        }
        catch (Exception $ex){
            die($ex->getMessage());
        }
         return $auxUsuario;
    }
    public function datoUsuario() {
        return $_SESSION['nombre'];
    }

    public function existeSesion() {
        return isset($_SESSION['nombre']);
    }

    public function datosSesion() {
        return $_SESSION;
    }

    public function cerrarSesion() {
        session_unset();
        session_destroy();
    }

    public function registrarUsuario($obj){
        $resultado= false;
        try{ $consulta = "INSERT INTO USUARIO (USU_NOMBRE,USU_PASSWORD,USU_EMAIL,USU_ROL) VALUES (?,?,?,'noadmin')";
            $consulta=$this->auxPDO->prepare($consulta);
            $consulta->execute(array($obj->nombre,$obj->clave,$obj->correo));
            $resultado=true;
        }
        catch (Exception $ex){
            die($ex->getMessage());
        }
        return $resultado;
    }
    
     public function existeUsuario($usuario, $clave) {
        $resultado = '';
        try {

             $consulta = "SELECT * FROM USUARIO WHERE USU_EMAIL = ? AND USU_PASSWORD = ? ";
            $consulta=$this->auxPDO->prepare($consulta);
            $consulta->execute(array($usuario,$clave));
        
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $fila){
              //  var_dump($fila);
                 $auxpass=password_hash($fila->USU_PASSWORD, PASSWORD_DEFAULT);//proteccion de inyeccion
                if (password_verify($clave, $auxpass)) {
                    $this->fijarSesion($fila);
                    $resultado = $fila->USU_ROL;
                }
            }
            
 
        } catch (Exception $ex) {
            echo "Ocurrio un error " . $ex;
        }
        return $resultado;
    }

}
