<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LoginModel;
use App\Models\RegistroModel;

class LoginControlador extends BaseController
{
    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url']);
    }

    public function login()
    {
        $datos = [
            "titulo" => "Inserge :: Acceso al sistema"
        ];
        return view('acceso/login', $datos);
    }

    public function doVerify()
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
                    'required' => '(Contraseña) Es obligatorio',
                    'numeric' => '(Contraseña) Solo adminite datos numéricos',
                    'exact_length' => '(Contraseña) Requiere 6 caracteres'
                ]
            ],
        ]);

        if (!$proceso) {
            //error
            $respuesta['error'] = $validation->listErrors();
        } else {

            $request =  \Config\Services::request();
            $user = $request->getPostGet('usuario');
            $pass = $request->getPostGet('contrasenia');

            $modelo = new LoginModel();
            $resultado = $modelo->verificar($user);

            if (isset($resultado) && password_verify($pass, $resultado->v4)) {

                $_SESSION['id_usuario'] = $resultado->v1;
                $_SESSION['Nombres'] = $resultado->v2;
                $_SESSION['usuario'] = $resultado->v3;
                $_SESSION['ult_acceso'] = $resultado->v5;
                $_SESSION['status_usuario'] = $resultado->v6;
                $_SESSION['rol'] = $resultado->v8;
                $_SESSION['tema'] = $resultado->v9;

                /*
                    $newsession = [
                        'id_usuario' => $resultado->v1,
                        'Nombres' => $resultado->v2,
                        'usuario' => $resultado->v3,
                        'ult_acceso' => $resultado->v5,
                        'status_usuario' => $resultado->v6,
                        'titulo' => $resultado->v7,
                        'rol' => $resultado->v8
                    ];

                    $this->session->set($newsession);
                    
                */

                $dato = array($resultado->v1);
                $modelo->UpdateAcceso($dato);
                $modelo1 = new RegistroModel();
                $paginas = $modelo1->search_data($resultado->v7, 'sp_conceder_permisos', '?');

                for ($i = 0; $i < count($paginas); $i++) {
                    $_SESSION[$paginas[$i]['v2']] = $paginas[$i]['v3'];
                    /*
                        echo ($paginas[$i]['v2']);
                        echo ($paginas[$i]['v3']);
                    */
                }

                //Recopilamos de la base de datos				
                $respuesta['error'] = "";
                $respuesta['datos'] = $resultado;
                $respuesta['datos1'] =  $paginas;

            } else {
                $respuesta['error'] = "Usuario y/o contraseña incorrecta";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta, JSON_UNESCAPED_UNICODE));
    }

    public function salir()
    {
        $modelo = new LoginModel();
        $modelo->UpdateCierreAcceso($_SESSION['id_usuario']);
        return view('acceso/salir');
    }

    public function doList()
    {
        $respuesta = array();
        $modelo = new LoginModel();
        $respuesta['datos'] = $modelo->listarAll();

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
}
