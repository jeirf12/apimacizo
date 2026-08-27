<?php
require_once 'Modelo/clsConexion.php'; 
require_once 'Modelo/clsUsuario.php'; 

abstract class Controlador {
    protected $conexion;
    protected $usuario;
    protected $nombrePagina;
    protected $existeSesion;
    protected $message;
    protected $action;
    protected $vistaEnvoltura;
    
    public function isSesion() {
        return isset($_SESSION['nombre']);
    }

    public function validaSesion() {
        if(!empty($this->existeSesion)) {
            return;
        }

        $this->existeSesion = $this->isSesion();
        if($this->existeSesion){
            $this->usuario = new clsUsuario();
            $this->usuario->__set('id', $_SESSION['id']);
            $this->usuario->__set('nombre', $_SESSION['nombre']);
            $this->usuario->__set('rol', $_SESSION['rol']);
        }
    }

    public function validaImagen() {
        $data_img = '';
        if(!isset($_FILES['imagen']) && !$_FILES['imagen']['error'] == UPLOAD_ERR_OK) { 
            return $data_img; 
        }
        $size = $_FILES['imagen']['size'];
        if ($size > 0){
            $data =  fopen($_FILES['imagen']['tmp_name'],'r');
            $data_img = fread($data, $size);
            fclose($data);
        } 
        return $data_img;
    }

    public function hasConnection() {
        $request = curl_init('https://www.google.com');
        curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($request);
        $result = curl_getinfo($request, CURLINFO_HTTP_CODE);
        curl_close($request);
        return ($result >= 200 && $result < 300);
    }

    public function getConnection() {
        if(!empty($this->conexion))
            return;

        $this->conexion = new clsConexion();
    }
}
?>
