<?php
require_once 'Modelo/clsCarritoCRUD.php';
require_once 'Modelo/clsCarrito.php';
require_once 'Utilities/controlador.php';

class ControladorCarrito extends Controlador {
    private $crud;

    public function __construct() {
        $this->getConnection();
        $this->crud = new clsCarritoCRUD($this->conexion);
        $this->validaSesion();
    }

    public function listar() {
        if($this->existeSesion) {
           $compras = $this->crud->obtenerProductosCarrito($this->usuario->__get('id'));
           $this->nombrePagina = 'Lista de Compras';
           $isForm = false;
           setcookie('msg', '', time() - 60);
           setcookie('act', '', time() - 60);
           $this->message = (isset($_COOKIE['msg'])) ? $_COOKIE['msg'] : $this->message;
           $this->action = (isset($_COOKIE['act'])) ? $_COOKIE['act'] : $this->action;
           $this->vistaEnvoltura = 'Vista/componentes/paginas/carritocompras.php';
           require 'Vista/componentes/paginas/envoltura.php';
        } else {
            header('Location: index.php');
        }
    }
       
    public function crearEditar() {
        if($this->existeSesion) {
            $resultado = false;
            $auxOp = '';
            $cant = 0;
            $auxCarrito = $this->obtenerInfoVistaCarrito();
            $compras = $this->crud->obtenerProductosCarrito($_REQUEST['usuid']);
            if(!empty($compras)) {
                $cant = $this->crud->obtenerCantidadProductosCarritoPorProductoId($this->usuario->__get('id'), $auxCarrito->__get('proid'));
                $auxCarrito->__set('cantidad', $auxCarrito->__get('cantidad') + $cant);

            }
            if ($auxCarrito->__get('usuid') == $this->usuario->__get('id') && $this->usuario->__get('rol') == 'noadmin') {
                if($auxCarrito->__get('usuid') > 0 && $cant > 0) {
                    $auxOp = 'agregado';
                    $resultado = $this->crud->editarCantidadProductoCarrito($auxCarrito);
                } else {
                    $auxOp = 'agregado';
                    $resultado = $this->crud->agregarAlCarrito($auxCarrito);
                }
                if($resultado) {
                    $this->message = 'El producto se ha '.$auxOp.' al carrito correctamente.';     
                    $this->action = 'success';
                } else {
                    $this->action = 'error';
                    $this->message = 'ERROR: No se ha '.$auxOp.' el producto.';
                }
                setcookie('msg', $this->message);
                setcookie('act', $this->action);
                header('Location: ?c=producto&a=listar');
            } else {
                $this->message = 'La acción no corresponde al usuario actual';
                $this->action = 'warning';
                setcookie('msg', $this->message);
                setcookie('act', $this->action);
                header('Location: ?c=producto&a=listar');
            }   
        } else if(!$this->existeSesion && isset($_REQUEST['proid']) && isset($_REQUEST['usuid']) && !empty($_REQUEST['usuid'])) {
            header('Location: index.php');
        } else { 
            $this->message = 'Debe iniciar sesión para agregar al carrito';
            $this->action = 'warning';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            header('Location: ?c=sesion&a=iniciarSesion');
        }
    }
    
    public function eliminar() {
        $auxCarrito = $this->obtenerInfoVistaCarrito();
        if($this->existeSesion) {
            if ($auxCarrito->__get('usuid') == $this->usuario->__get('id') && $this->usuario->__get('rol') == 'noadmin') {
                $this->crud->eliminarProductoCarrito($auxCarrito);
                $this->message = 'Producto eliminado del carrito de compras correctamente';
                $this->action = 'success';
                $this->listar();
            } else {
                $this->message = 'La acción no corresponde al usuario actual';
                $this->action = 'warning';
                setcookie('msg', $this->message);
                setcookie('act', $this->action);
                header('Location: ?c=producto&a=listar');
            }
        } else {
            $this->message = 'Debe iniciar sesión para eliminar del carrito';
            $this->action = 'warning';
            setcookie('msg', $this->message);
            setcookie('act', $this->action);
            header('Location: ?c=sesion&a=iniciarSesion');
        }
    }
    
    public function obtenerInfoVistaCarrito(){
        if(!$this->existeSesion) {
            header('Location: index');
            return;
        }
        $auxCarrito = new clsCarrito();
        $auxCarrito->__SET('carid', isset($_REQUEST['carid']) ? $_REQUEST['carid'] : 0);
        $auxCarrito->__SET('proid', $_REQUEST['proid']);
        $auxCarrito->__SET('usuid', isset($_REQUEST['usuid']) ? $_REQUEST['usuid'] : 0);
        $auxCarrito->__SET('cantidad', 1);
        return $auxCarrito;
    }
}
?>
