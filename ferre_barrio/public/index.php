<?php
namespace App;
session_start();

use App\Controller\AppController;
use App\Controller\ProductoController;
use App\Controller\UsuarioController;

//Asigno en sesion las rutas de las carpetas public y home
$_SESSION['public'] = '/ferre_barrio/public/';
$_SESSION['home'] = $_SESSION['public'].'index.php/';

//Funcion que auto-cargara todas las clases cuando se instancioen
spl_autoload_register('App\autoload');

function autoload($clase, $dir=null){

    //Dir raiz
    if (is_null($dir)) {
        $dirname = str_replace('/public','',dirname(__FILE__));
        $dir = realpath($dirname);

    }

    //Escaneo en busca de la clase de anera recursiva
    foreach (scandir($dir) as $file ) {

        //Si es directorio
        if ( is_dir($dir."/".$file) AND substr( $file, 0, 1 ) !== "." ) {
            autoload($clase,$dir."/".$file);
        }
        else if (is_file($dir."/".$file) AND $file == substr(strrchr($clase,"\\"),1).".php") {
            require ($dir."/".$file);
        }
    }
}

//OBTENER RUTA
////Quito la home a la ruta
$ruta = str_replace($_SESSION['home'],'',$_SERVER['REQUEST_URI']);

//Tomando la ruta, la hacemos array(quitando los elementos vacios)
$array_ruta = array_filter(explode("/",$ruta));

$numero = count($array_ruta);

/*ENRUTAMIENTOS

APP
    /
    /inicio
    /conocenos
    /productos
    /producto/slug

PANEL
    /panel
    /panel/entrar

    /panel/salir

    /panel/usuarios
        /panel/usuarios/crear
    /panel/usuarios/editar/id
        /panel/usuarios/activar/id
        /panel/usuarios/borrar/id

    /panel/productos
        /panel/productos/anadir
    /panel/productos/editar/id
        /panel/productos/activar/id
        /panel/productos/home/id
        /panel/productos/borrar/id
    /panel/productos/subir/id

 *
 */

switch ($numero) {
    case 0:
        echo "vamos  a inicio";
        break;

    case 1:
        //direccionamiento con 1 elemento en la url
        switch ($array_ruta[0]) {
            case "inicio":
                //Ir a inicio
                echo "vamos  a inicio";
                break;
            case "conocenos":
                //ir a conocenos
                echo "vamos  a conocenos";
                break;
            case "panel":
                //ir a panel->entrar
                echo "vamos  a panel->entrar";
                break;
            case "productos":
                //ir a roductos
                echo "vamos  a productos";
                break;
            default:
                //ir a inicio
                echo "vamos  a inicio default ".$_SERVER['REQUEST_URI'];
        }
        break;

    case 2:
        //direccionamientocon dos elementos:
        //Puede empezar por producto o panel
        if ($array_ruta[0] == "producto") {
            //Ir a producto->id
            echo "vamos  a producto->id";
        }else{
            //Aqui van los paneles
            switch ($array_ruta[0]."/".$array_ruta[1]) {
                case "panel/entrar":
                    //Ir a panel->entrar
                    echo "vamos  a panel->entrar";
                    break;
                case "panel/salir":
                    //Cerrar sesion
                    echo "vamos  a panel->salir";
                    break;
                case "panel/usuarios":
                    //Ir a usuarios->listar
                    echo "vamos  a usuario->lsitar";
                    break;
                case "panel/productos":
                    //Ir a productos->lista
                    echo "vamos  a products->listar";
                    break;
                default :
                    //ir a panel inicio
                    echo "vamos  a panel->inicio";
            }
        }
        break;

    case 3:
        //Llegando qui solo cabe la posibilidad de estar en el panel
        switch ($array_ruta[0]."/".$array_ruta[1]."/".$array_ruta[2]) {
            case "panel/usuarios/crear":
                //Solo puede ser la opcion de crear usuario
                //Ir a crear usuario
                echo "vamos  a usuarios->crear";
                break;
            case "panel/productos/crear":
                //Solo puede ser la opcion de anadir producto
                //Ir a crear producto
                echo "vamos  a productos->crear";
                break;
            default:
                echo "vamos  a inicio";
        }
        break;

    case 4:
        switch ($array_ruta[0]."/".$array_ruta[1]."/".$array_ruta[2]) {
            case "panel/usuarios/editar":
            case "panel/usuarios/activar":
            case "panel/usuarios/borrar":
            case "panel/productos/editar":
            case "panel/productos/activar":
            case "panel/productos/home":
            case "panel/productos/borrar":
            case "panel/productos/subir":
                //enrutamos relativamente segun la URL
                $accion = $array_ruta[2];

                //Escoge controlador
                //Ej: productos->editar(id)
                controlador($array_ruta[1])->$accion($array_ruta[3]);

            echo "vamos  a $array_ruta[0], $array_ruta[1],$array_ruta[2], $array_ruta[3]";
                break;
            default:
                //Ir a inicio
                echo "vamos  a inicio";
        }
        break;
    default:
        //Ir a inicio
        echo "vamos  a inicio";

}

//Invocarun controladorsegun el caso
function controlador($texto = null) {

    switch ($texto) {
        default: return new AppController;
        case "noticias": return new ProductoController;
        case "usuarios": return new UsuarioController;
    }
}