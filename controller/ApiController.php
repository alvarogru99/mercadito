<?php

namespace controller;

use \model\Orm;
use SplObjectStorage;

require_once("funciones.php");

class ApiController extends Controller
{


   //comprar producto con el modal (listado)
   public function compraProducto($id)
   {
      header('Content-type: application/json');

      $orm = new Orm;
      $producto = $orm->obtenerProducto($id);
      $existe = (new Orm)->existeProductoCesta($id, session_id());
      if (!$existe) {
         $orm->productoComprado($id, session_id());
      } else {
         (new Orm)->incrementProductos($id, session_id());
      }
      $cantidadProducto = $orm->cantidadProductoComprado($id);
      $totalArticulos = $orm->sumaTotalArticulos(session_id());

      $data["totalArticulos"] = $totalArticulos->suma;
      $data["cantidad"] = $cantidadProducto->cantidad;
      $data["nombre"] = $producto->nombre;
      $data["precio"] = $producto->precio;
      $data["img"] = $producto->img;


      echo json_encode($data);
   }


   //vemos lo que tiene el carrito (main)
   public function verCesta()
   {
      header('Content-type: application/json');

      $orm = new Orm;

      $producto = $orm->obternerProductos();

      echo json_encode($producto);
   }

   //incrementar producto desde compra
   public function incrementarProducto($id)
   {
      header('Content-type: application/json');

      $orm = new Orm;

      $orm->incrementProductosPorInput($id, session_id());

      $incrementar = (new Orm)->actualizarCantidad($id, session_id());
      $totalArticulos = $orm->sumaTotalArticulos(session_id());

      $data["totalArticulos"] = $totalArticulos->suma;
      $data["incrementar"] = $incrementar["cantidad"];


      echo json_encode($data);
   }

   //decrementar producto desde compra
   public function decrementarProducto($id)
   {
      header('Content-type: application/json');

      $orm = new Orm;

      (new Orm)->decrementProductos($id, session_id());
      $decrementar = $orm->actualizarCantidad($id, session_id());
      $totalArticulos = $orm->sumaTotalArticulos(session_id());

      $data["totalArticulos"] = $totalArticulos->suma;
      $data["decrementar"] = $decrementar["cantidad"];


      if ($decrementar["cantidad"] < 1) {
         $orm->igualarAUnproducto($id, session_id());
         echo json_encode($data);
      } else {
         echo json_encode($data);
      }
   }

   public function informa()
   {
       header('Content-type: application/json');  

      $cod_pedido = $_REQUEST["cod_pedido"];
      $importe = $_REQUEST["importe"];
      $estado = $_REQUEST["estado"];
      $cod_operacion = $_REQUEST["cod_operacion"];

      (new Orm)->informacionPasarela($estado, $cod_pedido,$cod_operacion,$importe);
      $msg = "Servidor de la tienda informado";

       echo json_encode($msg);  
   }

   
}