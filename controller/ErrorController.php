<?php
namespace controller;

class ErrorController {

    function gestionarNotFound() {
        http_response_code(404);
        echo "<h1>404 Not found</h1>";
    }

    function gestionarExcepcion($ex) {
        http_response_code(500);
        echo "<h1>500 Error interno (excepción descontrolada)</h1>";
        echo "<pre>$ex</pre>";
    }


}