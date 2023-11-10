<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\clbM_administracion;
class ubigeo extends BaseController
{
    public function doListDepart()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_departamento_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListProvin()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->consultar('sp_provincia_list',$_COOKIE["departamento"]);
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListDistrito()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->consultar('sp_distrito_list', $_COOKIE["provincia"]);
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
}
