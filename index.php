<?php
require 'Utilities/factory.php';
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$controlador = (isset($_REQUEST['c'])) ? $_REQUEST['c'] : 'sesion';
$accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'inicio';

$controlador = Factory::getInstance()->getController($controlador);

if ($controlador == null || !method_exists($controlador, $accion)) {
	$errorController = true;
	require_once 'Vista/componentes/paginas/error.php';
	return;
}

call_user_func(array($controlador, $accion));
