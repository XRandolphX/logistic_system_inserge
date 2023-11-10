<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Redireccionamiento extends BaseController
{
    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url']);
    }
	
    public function ViewTableProperties($Vista, $Script, $titulo)
    {
        $ruta = base_url();

        $datos = [
            "titulo" => "Inserge :: " . $titulo
        ];

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view($Vista) .
            view('dashboard/footer_main') .
            '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>' .
            '<script src="' . $ruta . '/resources/js/' . $Script . '"></script>';

        return $vista;
    }

    public function ViewGestionProperties($Vista, $titulo)
    {
        $ruta = base_url();

        $datos = [
            "titulo" => "Inserge :: " . $titulo
        ];

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view($Vista) .
            view('dashboard/footer_main') .
            '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>' .
            '<script src="' . $ruta . '/resources/js/invent.js"></script>';

        return $vista;
    }

    public function ViewProperties($Vista, $titulo)
    {
        $datos = [
            "titulo" => "Inserge :: " . $titulo
        ];

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view($Vista) .
            view('dashboard/footer_main');

        return $vista;
    }

    public function ViewMovimientos($Vista, $titulo)
    {
        $ruta = base_url();

        $datos = [
            "titulo" => "Inserge :: " . $titulo
        ];

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view($Vista) .
            view('dashboard/footer_main') .
            '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>' .
            '<script src="' . $ruta . '/resources/js/produccion/movimientos.js"></script>';

        return $vista;
    }

    /*
		Seccion Gerencia 
	*/

    public function proovedor()
    {
        return $this->ViewTableProperties('gestion/proveedor', 'gestion/proveedor.js', 'Proveedores');
    }

    public function register_firebase()
    {
        return $this->ViewProperties('settings_system/registerFirebase', 'Registro Firebase');
    }

    public function talento()
    {
        return $this->ViewTableProperties('gestion/personas', 'gestion/talento.js', 'Talento');
    }

    public function modulos()
    {
        return $this->ViewTableProperties('gestion/modulos', 'gestion/modulos.js', 'Modulos');
    }

    public function convocatoria()
    {
        return $this->ViewTableProperties('gestion/convocatoria', 'gestion/convocatoria.js', 'Convocatoria');
    }

    public function categoria()
    {
        return $this->ViewTableProperties('gestion/categoria', 'gestion/categoria.js', 'Categorias');
    }

    public function medida()
    {
        return $this->ViewTableProperties('gestion/unidmedidas', 'gestion/medida.js', 'Medidas');
    }

    public function fotito()
    {
        return $this->ViewTableProperties('gestion/evidencia', 'gestion/evidencia.js', 'Archivos');
    }

    /*
		Botones del Menu Principal
		Seccion Logistica
	*/

    public function Proyectos()
    {
        return $this->ViewTableProperties('produccion/registro', 'produccion/proyect.js','Proyecto');
    }

    public function Inventario()
    {
        return $this->ViewTableProperties('produccion/inventario', 'produccion/invent.js' ,'Inventario');
    }

    public function Movimientos()
    {
        return $this->ViewTableProperties('produccion/movimiento', 'produccion/movimientos.js', 'Movimientos');
    }

    /*
		Botones del Menu Principal
		Seccion Logistica
	*/

    public function Empresa()
    {
        return $this->ViewProperties('empresa', 'Empresa');
    }

    /*
		Botones del Menu Principal
		Seccion Proyecto
	*/
}
