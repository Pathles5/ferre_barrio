<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 01/02/2019
 * Time: 16:38
 */

class Producto
{
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $cod_barras;
    public $fech_alta;
    public $fech_actualizacion;
    public $foto;

    function __construct($id=null,$nombre=null,$descripcion=null,$precio=null,$stock=null,$cod_barras=null,$fech_alta=null,$fech_actualizacion=null,$foto=null)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->descripcion=$descripcion;
        $this->precio=$precio;
        $this->stock=$stock;
        $this->cod_barras=$cod_barras;
        $this->fech_alta=$fech_alta;
        $this->fech_actualizacion=$fech_actualizacion;
        $this->foto=$foto;
    }
}