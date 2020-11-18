<?php
namespace model;
class Post
{
    public $id;
    public $fecha;
    public $resumen;
    public $texto;
    public $foto;
    public $categoria_post_id;
    public $categoria = "";
    public $numComments = 0;
    public $comentarios =[];
}