<?php
namespace controller;
require_once ("funciones.php");
use \model\Orm;
use \model\Usuario;
use \dawfony\Ti;

class UserController extends Controller
{

  


        public function formularioLogin()
    {
        $title = "Login";
        $usuario = new Usuario;
        $usuario->login_usu = "";
        $usuario->password = "";
        $usuario->direccion = "";
        $usuario->email = "";
        $tarjeta =  "";
        $cvv = "";
        $error_msg = "";
        $login = "";
        $articulosCesta = (new Orm)->articulosEnCesta(session_id());
        $totalArticulos = (new Orm)->sumaTotalArticulos(session_id());
        $data = $articulosCesta->total;
        $sumaTotal =$totalArticulos->suma;
        echo Ti::render("view/formLogin.phtml", compact("title", "usuario","data", "sumaTotal","error_msg", "login","tarjeta","cvv"));

    }

    //hay que retocar para que el usuario se registre en vez de meterlo a pincho a la BD
    public function procesarLogin()
    {
        global $URL_PATH;

        $usuario = new Usuario;
        $usuario->login_usu = strtolower(sanitizar($_REQUEST["cliente"]));
        $usuario->password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
        $usuario->email = sanitizar($_REQUEST["email"]);
        $usuario->direccion = sanitizar($_REQUEST["direccion"]);

        $totalArticulos =(new Orm)->sumaTotalArticulos(session_id());
        $sumaTotal =$totalArticulos->suma;

            (new Orm)->insertarUsuario($usuario);
        
            $_SESSION['login'] = $usuario->login_usu;
            $cesta = (new Orm)->sacarProductosDeUnCliente(session_id());
            (new Orm)->guardarPedido($_SESSION['login']);
            $id_pedido = (new Orm)->idPedido($_SESSION['login']);

            //sacamos la id y la cantidad de la cesta uno a uno y lo vamos insertando en la tabla de producto que ha comprado el cliente.
            foreach($cesta as $sacarProductos){
             (new Orm)->guardarProductos($id_pedido["id"],$sacarProductos->id_producto,$sacarProductos->cantidad);
            }
            sleep(3);
            $cod_comercio = 2222;
            $cod_pedido = $id_pedido["id"];
            $concepto = "Sketchi Snowboard";
            header("Location: http://localhost/pasarela/index.php?cod_comercio=$cod_comercio&cod_pedido=$cod_pedido&importe=$sumaTotal&concepto=$concepto");
        
    }

    //devolvemos el retorno de la pasarela
    public function retorno(){

        $cod_pedido = $_REQUEST["cod_pedido"];
        $sacarDatosPedido =  (new Orm)->sacarDatosPedidoPasarela($cod_pedido);
        $data=0;
        echo Ti::render("view/pedido.phtml", compact( "sacarDatosPedido", "data","cod_pedido"));

     }

     //eliminar datos
     public function eliminarDatos($cod_pedido){
        global $URL_PATH;
        (new Orm)->eliminarDatosUsuarioCompra($cod_pedido,$_SESSION["login"],session_id());
        header("Location: $URL_PATH/");
     }
     public function formularioRegistro()
    {
        echo \dawfony\Ti::render("view/formregistro.phtml");
    }

    public function procesarRegistro()
    {
        // TO DO: Faltan comprobaciones, de seguridad

        // hacer la grabación
        $user = new Usuario();
        $user->login = sanitizar(strtolower($_REQUEST["login"]));
        $user->password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
        $user->email = sanitizar($_REQUEST["email"]);
        $user->nombre = sanitizar($_REQUEST["nombre"]);
        (new Orm) -> crearUsuario($user);
        // generar la vista
        $msg = "Ok, <strong>$user->login</strong>. Se ha procesado tu solicitud de registro."
            ." Ahora puedes hacer login";
        echo \dawfony\Ti::render("view/msg-success.phtml", compact("msg"));
    }

    public function formularioLogin()
    {
        echo \dawfony\Ti::render("view/formlogin.phtml");
    }

    public function procesarLogin()
    {
        
        $login = strtolower(sanitizar($_REQUEST["login"]));
        $password = $_REQUEST["password"];
        $user = (new Orm) -> obtenerUsuario($login);
        if (!$user) {
            $user = new Usuario;
        }
        if (!password_verify($password, $user->password))  {
            $msg = "login o contraseña incorrecto";
            echo \dawfony\Ti::render("view/formlogin.phtml", compact("msg", "login"));
        } else {
            //GUARDAR CREDENCIALES
            $_SESSION["login"] = $login;
            $_SESSION["rol_id"] = $user->rol_id;
            global $URL_PATH;
            header("Location: $URL_PATH/"); // Mandar al cliente al inicio
        }

    }
    public function hacerLogout()
    {
        global $URL_PATH;
        session_destroy();
        header("Location: $URL_PATH/");
    }

    


}