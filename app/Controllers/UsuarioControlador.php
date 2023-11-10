<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegistroModel;
use App\Models\clbM_administracion;

class UsuarioControlador extends BaseController
{
    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url', 'funciones']);
    }

    public function index()
    {
        $ruta = base_url();

        $datos = [
            "titulo" => "Inserge :: Usuarios"
        ];

        $modelo = new RegistroModel();
        $dato['comboRoles'] = generarcombo($modelo->listar_data('sp_listar_roles'), "-- Selecciona un rol --");

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view('settings_system/usuarios', $dato) .
            view('dashboard/footer_main') .
            '<script src="' . $ruta . '/resources/js/configuracion/informacion.js"></script>' .
            '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

        return $vista;
    }

    public function roles()
    {
        $ruta = base_url();

        $datos = [
            "titulo" => "Inserge :: Roles del sistema"
        ];

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view('settings_system/roles') .
            view('dashboard/footer_main') .
            '<script src="' . $ruta . '/resources/js/configuracion/roles.js"></script>';

        return $vista;
    }

    public function register_user()
    {
        $ruta = base_url();

        $datos = [
            "titulo" => "Inserge :: Usuarios"
        ];

        $modelo = new RegistroModel();
        $dato['comboRoles'] = generarcombo($modelo->listar_data('sp_listar_roles'), "-- Selecciona un rol --");

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view('settings_system/Registro_usuario', $dato) .
            view('dashboard/footer_main') .
            '<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>' .
            '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>' .
            '<script src="' . $ruta . '/resources/js/configuracion/informacion_empleado.js"></script>';

        return $vista;
    }

    public function search_empleado()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'identificacion' => [
                'rules' => 'required|numeric|max_length[12]|min_length[8]',
                'errors' => [
                    'required' => '(Identificación) Es obligatoria',
                    'numeric' => '(Identificación) Debe ser de caracter numérico',
                    'max_length' => '(Identificación) No debe superar los 12 caracteres',
                    'min_length' => '(Identificación) No debe ser inferior de los 8 caracteres'
                ]
            ]
        ]);

        if (!$proceso) {
            //error
            $respuesta['error'] = $validation->listErrors();
        } else {

            $request =  \Config\Services::request();
            $identif = $request->getPostGet('identificacion');
            $data = array($identif);

            $modelo = new RegistroModel();
            
            //* Realizamos la busqueda según la identificacion ingresada

            $resultado = $modelo->search_data($data, 'sp_search_empleado', '?');

            //* Si se encuentra se muestra relizamos el proceso de validacion caso contrario manda mensaje de error

            if (count($resultado) == 1) {

                //* Validamos si este ya tiene un usuario

                $data1 = array($resultado[0]['v1']);
                $respuesta['error'] = "";
                $encontrado =  $modelo->search_data($data1, 'sp_validar_empleado', '?');

                //* Si se encuentra se realiza lo siguiente caso contrario se manda la informacion
                
                if (count($encontrado) == 1) {
                    $respuesta['encontrado'] = "Este empleado ya cuenta con un usuario asignado";
                } else {
                    $respuesta['datos'] = $resultado;
                }                

            } else {
                $respuesta['error'] = "";
                $respuesta['noDatos'] = "No se encontraron datos registrados";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta, JSON_UNESCAPED_UNICODE));
    }

    public function doListUsuario()
    {
        $respuesta = array();
        $modelo = new RegistroModel();
        $respuesta['datos'] = $modelo->listar_data('sp_listar_usuarios');

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListRoles()
    {
        $respuesta = array();
        $modelo = new RegistroModel();
        $respuesta = $modelo->listar_data('sp_listar_permisos');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doSaveUsuario()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo usuario es obligatorio'
                ]
            ],

            'contrasenia' => [
                'rules' => 'required|numeric|exact_length[6]',
                'errors' => [
                    'required' => 'El campo contraseña es obligatorio',
                    'numeric' => 'Debe asignarse una contraseña de caracteres numéricos',
                    'exact_length' => 'El campo contraseña requiere 6 caracteres'
                ]
            ],

            'codRol' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'El campo cargo es obligatorio',
                    'numeric' => 'El dato ingresado debe ser de caracter numérico'
                ]
            ],

            'id_pers' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'La persona es requerida',
                    'numeric' => 'El dato ingresado debe ser de caracter numérico'
                ]
            ]

        ]);

        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $id = $request->getPost('id_pers');
            $user = $request->getPostGet('usuario');
            $pass = $request->getPostGet('contrasenia');
            $cargo = $request->getPostGet('codRol');
            $regis = $_SESSION['id_usuario'];
            $data = array($id,  $user, password_hash($pass, PASSWORD_DEFAULT), $cargo, $regis);

            $modelo = new RegistroModel();
            if ($modelo->register_data($data, 'sp_registrar_usuario', '?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doUpdateUser()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El estado del usuario es obligatorio'
                ]
            ],

            'codRol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El estado del usuario es obligatorio'
                ]
            ]
            
        ]);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $id_usuario = $request->getPost('id_us');
            $status = $request->getPostGet('status');
            $id_rol = $request->getPostGet('codRol');

            $data = array($id_rol, $status, $id_usuario);

            $modelo = new RegistroModel();

            if ($modelo->update_data($data, 'sp_editar_usuario', '?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doUpdatePass()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'passw' => [
                'rules' => 'required|numeric|exact_length[6]',
                'errors' => [
                    'required' => 'El campo contraseña es obligatorio',
                    'numeric' => 'El campo contraseña solo adminite datos numéricos',
                    'exact_length' => 'El campo contraseña requiere 6 caracteres'
                ]
            ]
        ]);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $id_usuario = $request->getPost('id_us');
            $pass = $request->getPostGet('passw');

            $data = array($id_usuario, password_hash($pass, PASSWORD_DEFAULT));
            $modelo = new RegistroModel();

            if ($modelo->update_data($data, 'sp_update_password', '?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
                $respuesta['data'] = $data;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }


    public function doListResumenUsuarios()
    {
        $respuesta = array();
        $modelo = new RegistroModel();
        $respuesta['datos'] = $modelo->listar_data('sp_resumen_usuarios');

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doSearchUsuarios()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'id_usu' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'El usuario es obligatorio',
                    'numeric' => 'El dato usuario debe ser de caracter numérico'
                ]
            ]
        ]);

        if (!$proceso) {
            //error
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $id_usuario = $request->getPostGet('id_usu');

            $data = array($id_usuario);
            $modelo = new RegistroModel();

            if ($modelo->search_data($data, 'sp_search_usuario', '?')) {
                //Recopilamos de la base de datos				
                $respuesta['error'] = "";
                $respuesta['datos'] = $modelo->search_data($data, 'sp_search_usuario', '?');
            } else {
                $respuesta['error'] = "";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta, JSON_UNESCAPED_UNICODE));
    }

    public function doListTheme()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $id = $_SESSION['id_usuario'];
        $data = array($id);
        $respuesta['datos'] = $modelo->consultaMultiple($data, "sp_listtheme", '?');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doUpdateTheme()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $id = $_SESSION['id_usuario'];
        $data = array($id);
        $respuesta['datos'] = $modelo->consultaMultiple($data, "sp_updatetheme", '?');
        $_SESSION['tema'] = $respuesta['datos'][0]['teme'];
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
}
