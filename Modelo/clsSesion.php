<?php

class clsSesion {
    private $conexion;
    private $auxPDO;

    public function __construct($pconexion) {
        $this->conexion = $pconexion;
    }

    public function fijarSesion($usuario) {
        $_SESSION['id'] = $usuario->USU_ID;
        $_SESSION['nombre'] = $usuario->USU_NOMBRE;
        $_SESSION['rol'] = $usuario->USU_ROL;
    }

    public function obtenerUsuarioPorId($id) {
        $auxUsuario = new clsUsuario();
        try { 
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $auxUsuario;
            $consulta = 'SELECT * FROM `usuario` WHERE USU_ID=?';
            $consulta = $this->auxPDO->prepare($consulta);
            $consulta->execute(array($id));
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                $auxUsuario->__SET('id', $obj->USU_ID);
                $auxUsuario->__SET('nombre', $obj->USU_NOMBRE);
                $auxUsuario->__SET('clave', $obj->USU_PASSWORD);
                $auxUsuario->__SET('correo', $obj->USU_EMAIL);
                $auxUsuario->__SET('rol', $obj->USU_ROL);
            }          
            $this->conexion->desconectar();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $auxUsuario;
    }

    public function obtenerUsuarioPorEmail($email) {
        $auxUsuario = new clsUsuario();
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $auxUsuario;
            $consulta = 'SELECT * FROM `usuario` WHERE USU_EMAIL=?';
            $consulta = $this->auxPDO->prepare($consulta);
            $consulta->execute(array($email));
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                $auxUsuario->__SET('id', $obj->USU_ID);
                $auxUsuario->__SET('nombre', $obj->USU_NOMBRE);
                $auxUsuario->__SET('clave', $obj->USU_PASSWORD);
                $auxUsuario->__SET('correo', $obj->USU_EMAIL);
                $auxUsuario->__SET('rol', $obj->USU_ROL);
            }          
            $this->conexion->desconectar();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $auxUsuario;
    }

    public function nombreUsuarioEnSession() {
        return $_SESSION['nombre'];
    }

    public function existeSesion() {
        return isset($_SESSION['nombre']);
    }

    public function obtenerDatosSesion() {
        return $_SESSION;
    }

    public function cerrarSesion() {
        session_unset();
        session_destroy();
    }

    public function registrarUsuario($obj) {
        $resultado = false;
        try { 
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $resultado;
            $consulta = 'INSERT INTO `usuario` (USU_NOMBRE,USU_PASSWORD,USU_EMAIL,USU_ROL) VALUES (?,?,?,"noadmin")';
            $consulta = $this->auxPDO->prepare($consulta);
            $consulta->execute(array($obj->nombre, password_hash($obj->clave, PASSWORD_BCRYPT, [ 'cost' => 10 ]), $obj->correo));
            $this->conexion->desconectar();
            $resultado = true;
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $resultado;
    }
    
    public function existeUsuario($usuario, $clave) {
        $auxUsuario = new clsUsuario();
        try {
            $this->auxPDO = $this->conexion->conectar();
            if($this->auxPDO == null) return $auxUsuario;
            $consulta = 'SELECT * FROM `usuario` WHERE USU_EMAIL = ?';
            $consulta = $this->auxPDO->prepare($consulta);
            $consulta->execute(array($usuario));
            foreach ($consulta->fetchALL(PDO::FETCH_OBJ) as $obj) {
                if (password_verify($clave, $obj->USU_PASSWORD)) {
                    $this->fijarSesion($obj);
                    $auxUsuario->__set('id', $obj->USU_ID);
                    $auxUsuario->__set('nombre', $obj->USU_NOMBRE);
                    $auxUsuario->__set('clave', $obj->USU_PASSWORD);
                    $auxUsuario->__set('correo', $obj->USU_EMAIL);
                    $auxUsuario->__set('rol', $obj->USU_ROL);
                }
            }
            $this->conexion->desconectar();
        } catch (Exception $ex) {
            echo 'Ocurrio un error'.$ex;
        }
        return $auxUsuario;
    }
}
?>
