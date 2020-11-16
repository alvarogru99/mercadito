<?php
require 'vendor/autoload.php';
require 'cargarconfig.php';
session_start(); 
use NoahBuscher\Macaw\Macaw;
use controller\ProductoController;

//listado
Macaw::get($URL_PATH . '/', "controller\ProductoController@listarProductos");
Macaw::get($URL_PATH . '/page/(:num)', "controller\ProductoController@listarProductos");


//ver cesta
Macaw::get($URL_PATH . '/api/cesta', "controller\ApiController@verCesta");

//compra
Macaw::get($URL_PATH . '/api/compra/(:num)', "controller\ApiController@compraProducto");

//incrementar
Macaw::get($URL_PATH . '/api/incrementar/(:num)', "controller\ApiController@incrementarProducto");
//decrementar
Macaw::get($URL_PATH . '/api/decrementar/(:num)', "controller\ApiController@decrementarProducto");

// registro
Macaw::get($URL_PATH . '/registro', "controller\UserController@formularioRegistro");
Macaw::post($URL_PATH . '/registro', "controller\UserController@procesarRegistro");

// login
Macaw::get($URL_PATH . '/login', "controller\UserController@formularioLogin");
Macaw::post($URL_PATH . '/login', "controller\UserController@procesarLogin");

// logout
Macaw::get($URL_PATH . '/logout', "controller\UserController@hacerLogout");

// ver perfil
Macaw::get($URL_PATH . '/perfil/(:any)', "controller\UserController@verPerfil");

//Realizar compra
Macaw::get($URL_PATH . '/realizarCompra', "controller\ProductoController@realizarCompra");
//Procesar compra logeado (parte final)
Macaw::post($URL_PATH . '/realizarCompra', "controller\ProductoController@procesarCompra");

//login usuario
Macaw::get($URL_PATH . '/login', "controller\UserController@formularioLogin");
Macaw::post($URL_PATH . '/login', "controller\UserController@procesarLogin");

//Eliminar Producto
Macaw::get($URL_PATH . '/eliminarProducto/(:num)', "controller\ProductoController@eliminarProducto");

//Eliminar Producto desde compra
Macaw::get($URL_PATH . '/eliminarProductoCompra/(:num)', "controller\ProductoController@eliminarProductoCompra");

//Eliminar datos 
Macaw::get($URL_PATH . '/eliminarDatos/(:num)', "controller\UserController@eliminarDatos");

//Vaciar cesta
Macaw::get($URL_PATH . '/vaciarCesta', "controller\ProductoController@vaciarCesta");

//pasarela informa
Macaw::get($URL_PATH . '/informa', "controller\ApiController@informa");

//pasarela retorno
Macaw::get($URL_PATH . '/retorno', "controller\UserController@retorno");

// nuevo comentario
Macaw::post($URL_PATH . '/post/(:num)/comentario/new', "controller\PostController@procesarNuevoComentario");

// API JSON
Macaw::get($URL_PATH . '/api/existe/(:any)', "controller\ApiController@existeLogin");

// Despachar rutas, con captura de Excepciones. Página de respuesta 500 personalizada.
try {
    Macaw::dispatch();
  } catch (Exception $ex) {
    (new \controller\ErrorController) -> gestionarExcepcion($ex);
  }