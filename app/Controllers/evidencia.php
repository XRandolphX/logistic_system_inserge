<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\clbM_administracion;

class evidencia extends BaseController
{

    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url']);
    }

    public $Evidencia = [
        'desc' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Descripción) Es obligatorio.',
                'max_length' => '(Descripción) El número de carateres no debe ser mayor de 50.',
            ]
        ],
        'foto' => [
            'uploaded[foto]',
            'mime_in[foto,image/jpg,image/jpeg,image/png]',
            'max_size[foto,2048]',
            'errors' => [
                'uploaded' => '(Imagen) No se envio una imagen',
                'mime_in' => '(Imagen) No se envio un formato aceptado(jpg,jpeg,png)',
                'max_size' => '(Imagen) La imagen no debe exceder de 1Mb'
            ]
        ],
        'tipo'  => [
            'rules' => 'required|in_list[0,1,2,3,4,5]',
            'errors' => [
                'required' => '(Tipo de Imagen) Es obligatorio.',
                'in_list' => '(Tipo de Imagen) Solo se aceptan tipos válidos.'
            ]
        ],
        'fecha' => [
            'rules' => 'required|valid_date',
            'errors' => [
                'required' => '(Fecha) Es obligatorio.',
                'valid_date' => '(Fecha) No se asemeja al formato.'
            ]
        ],
        'modulo' => [
            'rules' => 'permit_empty|numeric',
            'errors' => [
                'numeric' => '(Módulo) No se encuentra registrado.',
            ]
        ],
        'person' => [
            'rules' => 'permit_empty|numeric',
            'errors' => [
                'numeric' => '(Persona) No se encuentra registrado.',
            ]
        ],
        'proyct' => [
            'rules' => 'permit_empty|numeric',
            'errors' => [
                'numeric' => '(Proyecto) No se encuentra registrado.',
            ]
        ],
        'Conv' => [
            'rules' => 'permit_empty|numeric',
            'errors' => [
                'numeric' => '(Convocatoria) No se encuentra registrado.',
            ]
        ],
        'Prodc' => [
            'rules' => 'permit_empty|numeric',
            'errors' => [
                'numeric' => '(Producto) No se encuentra registrado.',
            ]
        ],
        'Prov' => [
            'rules' => 'permit_empty|numeric',
            'errors' => [
                'numeric' => '(Proveedor) No se encuentra registrado.',
            ]
        ]
    ];

    public $Id = [
        'gatou' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '(ID) Es obligatorio.',
                'numeric' => '(ID) El número de carateres no debe ser mayor de 50.',
            ]
        ]
    ];

    public function doSaveImagen()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Evidencia);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $desc = $request->getPostGet('desc');
            $tipo = $request->getPostGet('tipo');
            $fecha = $request->getPostGet('fecha');
            $modulo = $request->getPostGet('modulo');
            $person = $request->getPostGet('person');
            $proyct = $request->getPostGet('proyct');
            $Conv = $request->getPostGet('Conv');
            $Prodc = $request->getPostGet('Prodc');
            $Prov = $request->getPostGet('Prov');
            if ($modulo == '') {
                $modulo = null;
            }
            if ($person == '') {
                $person = null;
            }
            if ($proyct == '') {
                $proyct = null;
            }
            if ($Conv == '') {
                $Conv = null;
            }
            if ($Prodc == '') {
                $Prodc = null;
            }
            if ($Prov == '') {
                $Prov = null;
            }
            $user = $_SESSION['id_usuario'];
            $img = $this->request->getFile('foto');
            $fot = $img->getRandomName();
            $data = array($desc, $fot, $tipo, $fecha, $modulo, $person, $proyct, $Conv, $Prodc, $Prov, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_foto_insert", '?,?,?,?,?,?,?,?,?,?,?')) {
                $img->move(ROOTPATH . 'resources/files', $fot);
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operacion realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operacion!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListImagen()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_foto_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doDropImage()
    {
        $respuesta = array();
        $request =  \Config\Services::request();
        $id = $request->getPostGet('gatou');
        $file = $request->getPostGet('file');
        if ($id == '') {
            $respuesta['error'] = "Envia un Id!";
        } else {
            $data = array($id);

            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_foto_drop", '?')) {
                if (unlink(ROOTPATH . 'resources/files/'.$file)) {
                    $respuesta['error'] = "";
                    $respuesta['ok'] = "¡Evidencia Borrada con Éxito!";
                } else {
                    $respuesta['error'] = "No se encontró el archivo!!";
                }
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doResumeImage()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_foto_resume');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
}
