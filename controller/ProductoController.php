
<?php
namespace controller;
require_once ("funciones.php");
use \model\Orm;
use \dawfony\Ti;

class ProductoController extends Controller
{

    function listarProductos($pagina = 1) {
        global $config;
        global $URL_PATH;
        $orm = new Orm;
        $productos = $orm->obtenerProductosPagina($pagina);
        $cuenta = (new Orm)->contarProductos();
        $articulosCesta = (new Orm)->articulosEnCesta(session_id());
        $totalArticulos = $orm->sumaTotalArticulos(session_id());

        $sumaTotal =$totalArticulos->suma;
        
        $data = $articulosCesta->total;
        $numpaginas = ceil ($cuenta / $config["post_per_page"]);
        
        $ruta = "$URL_PATH/page/";
        echo Ti::render("view/listado.phtml",compact("productos", "numpaginas", "pagina", "ruta", "cuenta","data","sumaTotal"));
    }

    function realizarCompra(){

        $nombre = $_REQUEST["nombre"] ="";
        $password = $_REQUEST["password"] ="";

        $articulosCesta = (new Orm)->articulosEnCesta(session_id());
        $totalArticulos = (new Orm)->sumaTotalArticulos(session_id());
        $productos = (new Orm)->obternerProductos(); 
        $data = $articulosCesta->total;
        $sumaTotal =$totalArticulos->suma;
        echo Ti::render("view/compra.phtml",compact("data","sumaTotal","productos","nombre","password"));
    }

    function eliminarProducto($id){
        global $URL_PATH;
        (new Orm)->eliminarUnProducto($id);
        header("Location: " . $URL_PATH);
    }

    function eliminarProductoCompra($id){
        global $URL_PATH;
        (new Orm)->eliminarUnProductoDeCompra($id);
        header("Location: " . $URL_PATH."/realizarCompra");
    }

    function vaciarCesta(){
        global $URL_PATH;
        (new Orm)->vaciarCesta();
        header("Location: " . $URL_PATH);
    }
}