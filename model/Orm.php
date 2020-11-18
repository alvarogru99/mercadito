<?php

namespace model;

use dawfony\Klasto;

class Orm
{
        /*******contar los productos****/
        public function contarProductos(){
            return Klasto::getInstance()->queryOne("SELECT count(*) as cuenta FROM `producto`")["cuenta"];
        }
        public function obtenerProductosPagina($pagina = 1)
    {
        global $config;
        $limite = $config["post_per_page"];
        $offset = ($pagina -1) * $limite;
        $bd = Klasto::getInstance();
        $sql = "SELECT `id`, `nombre`, `precio`, `img`, `descripcion`,`flex` FROM `producto` LIMIT $limite OFFSET $offset";
        $productos = $bd->query($sql, [], "model\Producto");
        return $productos;
    }
        /********eliminar Un producto de la cesta****/
        public function eliminarUnProducto($id){
            return Klasto::getInstance()->execute(
                "DELETE FROM `cesta` Where id_producto=?",
                [$id]
            );
        }
        /********eliminar Un producto de la compra****/
        public function eliminarUnProductoDeCompra($id){
            return Klasto::getInstance()->execute(
                "DELETE FROM `cesta` Where id_producto=?",
                [$id]
            );
        }
    
        /********vaciar Cesta****/
        public function vaciarCesta(){
            return Klasto::getInstance()->execute(
                "DELETE FROM `cesta`",
                []
            );
        }
            /****sacamos la id del pedido****/
        public function idPedido($id_usuario){
            return Klasto::getInstance()->queryOne(
                "SELECT id FROM `pedido` WHERE Usuario_login_usu=?",
                [$id_usuario]
            );
        }
            /****sacar datos del cod_pedido****/
        public function sacarDatosPedidoPasarela($cod_pedido){
            return Klasto::getInstance()->queryOne(
                "SELECT pago, cod_operacion, importe FROM pedido where id=?",
                [$cod_pedido], "model\Pedido"
            );
        }
        /****eliminar datos del usuario de su compra****/
        public function eliminarDatosUsuarioCompra($idPedido,$login,$cookie){

            Klasto::getInstance()->startTransaction();

            (new Orm)->borrarProductoHasComprado($idPedido);
            (new Orm)->borrarPedido($idPedido);
            (new Orm)->borrarUsuario($login);
            (new Orm)->borrarCesta($cookie);
            
            Klasto::getInstance()->commit();
        }
        /****Borrar los productos que ya hayas pedido****/
        public function borrarProductoHasComprado($idPedido){
            return Klasto::getInstance()->execute(
                "DELETE FROM `producto_has_pedido` WHERE Pedido_id=?",
                [$idPedido]
            );
        }
        /****Borrar pedido si ya está entregado****/
        public function borrarPedido($idPedido){
            return Klasto::getInstance()->execute(
                "DELETE FROM `pedido` WHERE id=?",
                [$idPedido]
            );
        }
        /****Borrar Usuario****/
        public function borrarUsuario($login){
            return Klasto::getInstance()->execute(
                "DELETE FROM `usuario` WHERE login_usu=?",
                [$login]
            );
        }
        /****Borrar Cesta****/
        public function borrarCesta($cookie){
            return Klasto::getInstance()->execute(
                "DELETE FROM `cesta` WHERE id_visitante=?",
                [$cookie]
            );
        }

        /****insertamos un Usuario si todo está correctamente****/
        public function insertarUsuario($usuario){
            $bd = Klasto::getInstance();
            $sql = "INSERT INTO `usuario`(`login_usu`, `email`, `password`, `direccion`) VALUES (?,?,?,?);";
            return $bd->execute($sql, [$usuario->login_usu,$usuario->email,$usuario->password,$usuario->direccion]);
        }
        /*****Vemos si hay login existente, sino no entra *****/
        public function loginExistente($login)
        {
            return Klasto::getInstance()->queryOne(
                "SELECT login FROM `usuario` WHERE email=?",
                [$login]
            );
        }
}