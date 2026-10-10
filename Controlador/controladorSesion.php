<?php
require_once 'Modelo/clsSesion.php';
require_once 'Utilities/controlador.php';

class ControladorSesion extends Controlador {
    private $sesion;

    public function __construct() {
        $this->getConnection();
        $this->sesion = new clsSesion($this->conexion);
        $this->validaSesion();
    }

    public function index() {
        if(!empty($this->message)) {
            $this->inicio();
        } else {
            header('Location: index.php');
        }
    }
    
    public function iniciarSesion() {
        if(!$this->existeSesion) {
            $this->nombrePagina = 'Iniciar Sesión';
            $isForm = false;
            setcookie('msg', '', time() - 60);
            setcookie('act', '', time() - 60);
            $this->message = isset($_COOKIE['msg']) ? $_COOKIE['msg'] : $this->message;
            $this->action = isset($_COOKIE['act']) ? $_COOKIE['act'] : $this->action;
            $this->existeSesion = $this->isSesion();
            $this->vistaEnvoltura = 'Vista/componentes/paginas/iniciarsesion.php';
            require_once 'Vista/componentes/paginas/envoltura.php';
        } else {
            $this->index();
        }
    }
    
    public function existeUsuario() {
        if(!$this->existeSesion) {
            $correo = isset($_REQUEST['correo']) ? $_REQUEST['correo'] : " ";
            $clave = isset($_REQUEST['contrasenia']) ? $_REQUEST['contrasenia'] : " ";
            if (empty($correo) && empty($clave)) {
                $this->message = 'El correo o la contraseña no es correcta, inténtelo nuevamente';
                $this->action = 'warning';
                $this->iniciarSesion();
            } else {
                $this->usuario = $this->sesion->existeUsuario($correo, $clave);
                $this->existeSesion = $this->isSesion();
                if($this->usuario->__get('rol')=='admin' || $this->usuario->__get('rol') == 'noadmin') {
                    $this->message = 'Inicio sesión correctamente!';
                    $this->action = 'success';
                    setcookie('msg', $this->message);
                    setcookie('act', $this->action);
                    $this->index();
                } else {
                    $this->message = 'Usuario no encontrado verifique sus datos e intente nuevamente';
                    $this->action = 'error';
                    setcookie('msg', $this->message);
                    setcookie('act', $this->action);
                    $this->iniciarSesion();
                }
            }
        } else {
            $this->index();
        }
    }
    
    public function cerrarSesion() {
        if(!$this->existeSesion) {
            $this->index();
            return;
        }
        include('Utilities/config.php');
        if(isset($_SESSION['access_token'])) {
            if(!$this->hasConnection()) { 
                $this->message = 'No se puede cerrar sesión, verifique su conexión a internet';
                $this->action = 'warning';
                $this->index();
            }
            $google_client->revokeToken();
            unset($_SESSION['access_token']);
        }
        $this->usuario = null;
        $this->sesion->cerrarSesion();
        $this->existeSesion = $this->isSesion();
        $this->message = 'Cerró sesión correctamente!';
        $this->action = 'success';
        setcookie('msg', $this->message);
        setcookie('act', $this->action);
        $this->index();
    }

    public function registrarUsuario() {
        if(!$this->existeSesion) {
            $this->nombrePagina = 'Registrar Usuario';
            $this->vistaEnvoltura = 'Vista/componentes/paginas/registrarusuario.php';
            require 'Vista/componentes/paginas/envoltura.php';
        } else {
            $this->index();
        }
    }

    public function registroUsuario() {
        if($this->existeSesion) {
            $this->index();
            return;
        }

        $nombre = $_REQUEST['nombre'];
        $correo = $_REQUEST['correo'];
        $clave = $_REQUEST['contrasenia'];
        if(empty($nombre) || empty($correo) || empty($clave)) { 
            $this->message = 'ERROR: Usuario no registrado. Los campos no pueden ser vacios';
            $this->action = 'error';
            $this->RegistrarUsuario();
            return;
        }

        $usuario = new clsUsuario();
        $usuario->__SET('nombre',$nombre);
        $usuario->__SET('clave',$clave);
        $usuario->__SET('correo',$correo);
        $resultado = $this->sesion->registrarUsuario($usuario);
        if($resultado) {
            $this->message = 'Usuario registrado correctamente. Inicie sesion.';
            $this->action = 'success';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            $this->iniciarSesion();
        } else {
            $this->message = 'ERROR: Usuario no registrado. Favor comunicarse con el administrador';
            $this->action = 'error';
            $this->RegistrarUsuario();
        }
    }

    public function google() {
        if($this->existeSesion) {
            $this->index();
            return;
        }
        if(!$this->hasConnection()) {
            $this->message = 'No se puede iniciar sesión con Google, verifique su conexión a internet';
            $this->action = 'warning';
            $this->iniciarSesion();
        } else {
            include 'Utilities/config.php';
            header('Location: '.$google_client->createAuthUrl());
        }
    }

    public function apiGoogle() {
        if($this->existeSesion) {
            $this->index();
            return;
        }
        if(isset($_GET['code'])) {
            include 'Utilities/config.php';
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
            if(!isset($token['error'])) {
                $google_client->setAccessToken($token['access_token']);
                $google_service = new Google_Service_Oauth2($google_client);
                $data = $google_service->userinfo->get();
                if(!empty($data)) {
                    $_SESSION['access_token'] = $token['access_token'];
                    $user = new clsUsuario();
                    $user->__set('nombre', $data['given_name']);
                    $user->__set('correo', $data['email']);
                    $this->usuario = $this->sesion->obtenerUsuarioPorEmail($user->__get('correo'));
                    $user->__set('clave', $this->usuario->__get('clave'));
                    if($this->usuario->__get('rol') == NULL) {
                        $user->__set('clave', $data['given_name'].rand(1, 9999));
                        $result = $this->sesion->registrarUsuario($user);
                    }
                    $this->usuario = $this->sesion->existeUsuario($user->__get('correo'), $user->__get('clave'));
                    if($this->usuario->__get('rol') == 'admin' || $this->usuario->__get('rol') == 'noadmin') {
                        $this->message = 'Inicio sesión correctamente!';
                        $this->action = 'success';
                        setcookie('msg', $this->message);
                        setcookie('act', $this->action);
                        $this->index();
                    } else {
                        $this->message = 'Usuario no encontrado verifique sus datos e intente nuevamente';
                        $this->action = 'error';
                        setcookie('msg', $this->message);
                        setcookie('act', $this->action);
                        $this->iniciarSesion();
                    }
                }
            } else {
                $this->message = 'Intente iniciar sesión nuevamente más tarde';
                $this->action = 'warning';
                setcookie('msg', $this->message);
                setcookie('act', $this->action);
                $this->iniciarSesion();
            }
        } else {
            $this->iniciarSesion();
        }
    }

    public function apiContacto() {
        if(isset($this->usuario) && $this->usuario->__get('rol') == 'admin') {
            $this->index();
            return;
        }
        if($this->hasConnection()) {
            require 'Utilities/configApiContacto.php';
            if($mail->ErrorInfo != "") {
                $this->message = 'Mensaje no se pudo enviar correctamente '.$mail->ErrorInfo;
                $this->action = 'error';
            } else {
                $this->message = 'Mensaje enviado correctamente';
                $this->action = 'success';
            }
        } else {
            $this->message = 'Fallo al enviar el menasje, revise su conexión';
            $this->action = 'warning';
        }
        setcookie('msg', $this->message);
        setcookie('act', $this->action);
        $this->inicio();
    }

    public function inicio() {
        $this->nombrePagina = 'Inicio';
        setcookie('msg', '', time() - 60);
        setcookie('act', '', time() - 60);
        $this->message = isset($_COOKIE['msg']) ? $_COOKIE['msg'] : $this->message;
        $this->action = isset($_COOKIE['act']) ? $_COOKIE['act'] : $this->action;
        $this->vistaEnvoltura = 'Vista/componentes/paginas/inicio.php';
        require 'Vista/componentes/paginas/envoltura.php';
    }

    public function contacto() {
        if(isset($this->usuario) && $this->usuario->__get('rol') == 'admin') {
            $this->index();
            return;
        }
        $this->nombrePagina = 'Contacto';
        $this->vistaEnvoltura = 'Vista/componentes/paginas/contacto.php';
        require 'Vista/componentes/paginas/envoltura.php';
    }

    public function sobreNosotros() {
        $this->nombrePagina = 'Sobre Nosotros';
        $this->vistaEnvoltura = 'Vista/componentes/paginas/sobreNosotros.php';
        require 'Vista/componentes/paginas/envoltura.php';
    }
}
?>
