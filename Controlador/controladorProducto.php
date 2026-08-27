<?php
require_once 'Modelo/clsProductoCRUD.php';
require_once 'Modelo/clsProducto.php'; 
require_once 'Utilities/controlador.php';

class ControladorProducto extends Controlador {
    private $crud;
    private $productos;
    private $datosSesion;
    private $categorias;

    public function __construct() {
        $this->getConnection();
        $this->crud = new clsProductoCRUD($this->conexion);
        $this->validaSesion();
    }

    public function index() {
        if(!empty($this->message)) {
            $this->listar();
        } else {
            header('Location: index.php');
        }
    }
    
    public function listar() {
        $this->nombrePagina = 'Listado Productos';
        $this->productos = $this->crud->listarProductos();
        $this->categorias = $this->crud->obtenerCategoriasProductos();
        setcookie('msg', '', time() - 60);
        setcookie('act', '', time() - 60);
        $this->message = (isset($_COOKIE['msg'])) ? $_COOKIE['msg'] : $this->message;
        $this->action = isset($_COOKIE['act']) ? $_COOKIE['act'] : $this->action;
        if(isset($_SESSION['rol']) && ($_SESSION['rol'] == 'admin')) {
            $this->vistaEnvoltura = 'Vista/componentes/paginas/principaladmin.php';
            require 'Vista/componentes/paginas/envoltura.php';
        } else {
            $isForm = false;
            $this->vistaEnvoltura = 'Vista/componentes/paginas/principalusuario.php';
            require 'Vista/componentes/paginas/envoltura.php';
        }
    }

    public function buscarProducto() {
        $this->nombrePagina = 'Buscar Productos';
        $this->productos = $this->crud->buscarProductoPorPalabras($_REQUEST['word_search']);
        $this->categorias = $this->crud->obtenerCategoriasProductos();
        setcookie('msg', '', time() - 60);
        setcookie('act', '', time() - 60);
        $this->message = (isset($_COOKIE['msg'])) ? $_COOKIE['msg'] : $this->message;
        $this->action = isset($_COOKIE['act']) ? $_COOKIE['act'] : $this->action;
        if(isset($_SESSION['rol']) && ($_SESSION['rol'] == 'admin')) {
            $this->vistaEnvoltura = 'Vista/componentes/paginas/principaladmin.php';
            require 'Vista/componentes/paginas/envoltura.php';
        } else {
            $isForm = false;
            $this->vistaEnvoltura = 'Vista/componentes/paginas/principalusuario.php';
            require 'Vista/componentes/paginas/envoltura.php';
        }
    }
    
    public function crearEditar() {
        $this->nombrePagina = 'Registrar Producto';
        $isForm = false;
        if($this->existeSesion && $this->usuario->__get('rol') == 'admin') {
            if(isset($_REQUEST['proid'])) {
                $this->nombrePagina = 'Editar Producto';
                $producto = $this->crud->obtenerProductosPorCategoria($_REQUEST['proid']);
            }
            $this->categorias = $this->crud->obtenerCategoriasProductos();
            $this->vistaEnvoltura = 'Vista/componentes/paginas/guardarproducto.php';
            require 'Vista/componentes/paginas/envoltura.php';
        } else if($this->existeSesion && $this->usuario->__get('rol') == 'noadmin') {
            $this->message = 'El usuario actual no tiene permitido hacer esta acción';
            $this->action = 'warning';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            header('Location: ?c=sesion&a=inicio');
        } else {
            $this->index();
        }
    }
    
    public function crear() {
        if($this->existeSesion && $this->usuario->__get('rol') == 'admin') {
            $resultado = false;
            $auxProducto = new clsProducto();
            $auxProducto->__set('nombre',$_REQUEST['nombre']);
            $auxProducto->__set('precio',$_REQUEST['precio']);
            $imagen = $this->validaImagen();
            $auxProducto->__set('imagen',$imagen);
            $auxProducto->__set('descripcion',$_REQUEST['descripcion']);
            $auxProducto->__set('cantidad',$_REQUEST['cantidad']);
            $auxProducto->__set('categoria',$_REQUEST['categoria']);
            if(empty($auxProducto->__get('nombre')) || empty($auxProducto->__get('precio')) || empty($auxProducto->__get('imagen')) || empty($auxProducto->__get('descripcion')) || empty($auxProducto->__get('cantidad')) || empty($auxProducto->__get('categoria'))) {
                $this->message = 'El producto no puede llevar campos vacios, verifique e intenta nuevamente';
                $this->action = 'warning';
                $this->crearEditar();
            }
       
            if($_REQUEST['id'] != " ") {
                $auxProducto ->__set('id',$_REQUEST['id']);
                $auxMessage = 'editado';
                $resultado = $this->crud->editarProducto($auxProducto);
            } else {
                $auxMessage = 'creado';
                $resultado = $this->crud->crearProducto($auxProducto);
            }
    
            if($resultado) {
                $this->message = 'El producto se ha '.$auxMessage.' correctamente.';
                $this->action = 'success';
            } else {
                $this->message = 'No se ha '.$auxMessage.' el producto correctamente.';
                $this->action = 'error';
            }
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            $this->index();
        } else if($this->existeSesion && $this->usuario->__get('rol') == 'noadmin') {
            $this->message = 'El usuario actual no tiene permitido hacer esta acción';
            $this->action = 'warning';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            header('Location: ?c=sesion&a=inicio');
        } else {
            $this->message = 'Debe iniciar sesión como administrador para hacer esta acción';
            $this->action = 'warning';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            header('Location: ?c=sesion&a=iniciarSesion');
        }
    }
    
    public function eliminar() {
        if($this->existeSesion && $this->usuario->__get('rol') == 'admin') {
            $this->crud->eliminarProducto($_REQUEST['id']);
            $this->message = 'El producto fue eliminado con exito.';
            $this->action = 'success';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            $this->index();
        } else if($this->existeSesion && $this->usuario->__get('rol') == 'noadmin') {
            $this->message = 'El usuario actual no tiene permitido hacer esta acción';
            $this->action = 'warning';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            header('Location: ?c=sesion&a=inicio');
        } else {
            $this->message = 'Debe iniciar sesión como administrador para hacer esta acción';
            $this->action = 'warning';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            header('Location: ?c=sesion&a=iniciarSesion');
        }
    }
}
?>
