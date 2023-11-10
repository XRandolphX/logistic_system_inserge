<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegistroModel;

class DashboardControlador extends BaseController
{
    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url']);
    }

    public function index()
    {

        $ruta = base_url();

        $datos = [
            "titulo" => "Inserge :: Dashboard"
        ];

        $vista = view('dashboard/header_main', $datos) .
            view('dashboard/navegacion_main') .
            view('contenido/principal') .
            view('dashboard/footer_main') .
            '<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        return $vista;

    }

    public function doUpdatePass()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'passw' => [
                'rules' => 'required|numeric|exact_length[6]',
                'errors' => [
                    'required' => '(Contraseña) Es obligatorio',
                    'numeric' => '(Contraseña) Solo admite datos numéricos',
                    'exact_length' => '(Contraseña) Requiere 6 caracteres'
                ]
            ]
        ]);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $id_usuario = $_SESSION['id_usuario'];
            $pass = $request->getPostGet('passw');

            $data = array($id_usuario, password_hash($pass, PASSWORD_DEFAULT));
            $modelo = new RegistroModel();

            if ($modelo->update_data($data, 'sp_update_password', '?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operacion realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operacion!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }



}
