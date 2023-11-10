<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\clbM_administracion;
use LengthException;

class proyectos extends BaseController
{
    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url']);
    }

    public $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function addDir($path)
    {
        return (!mkdir($path, 0755) && !is_dir($path));
    }
    
    public function rmDir_rf($carpeta)
    {
        foreach (glob($carpeta . "/*") as $archivos_carpeta) {
            if (is_dir($archivos_carpeta)) {
                $this->rmDir_rf($archivos_carpeta);
            } else {
                unlink($archivos_carpeta);
            }
        }
        rmdir($carpeta);
    }
    //IDs Registro del Proyecto
    public $ProyectReg = [
        'Codigo' => [
            'rules' => 'required|exact_length[10]',
            'errors' => [
                'required' => '(Código) Es obligatoria.',
                'exact_length' => '(Código) El número de carateres deben ser 11.'
            ]
        ],
        'NContrato' => [
            'rules' => 'required|exact_length[10]',
            'errors' => [
                'required' => '(Número de Contrato) Es obligatoria.',
                'exact_length' => '(Número de Contrato) El número de carateres deben ser 11.'
            ]
        ],
        'Conv' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Convocatoria) Es obligatoria.',
                'numeric' => '(Convocatoria) No es una Convocatoria Válida.',
                'max_length' => '(Convocatoria) No es una Convocatoria Válida.'
            ]
        ],
        'Persona' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Beneficiario) Es obligatorio.',
                'numeric' => '(Beneficiario) No es una Convocatoria Válida.',
                'max_length' => '(Beneficiario) No es una Convocatoria Válida.'
            ]
        ],
        'dist' => [
            'rules' => 'required|numeric|exact_length[6]',
            'errors' => [
                'required' => '(Ubicación) Es obligatoria.',
                'numeric' => '(Ubicación) No se encuentra registrado.',
                'exact_length' => '(Ubicación) No se encuentra registrado.'
            ]
        ],
        'Sector' => [
            'rules' => 'permit_empty|max_length[50]',
            'errors' => [
                'max_length' => '(Sector) El número de carateres deben ser menores de 50.'
            ]
        ],
        'tipoUrb' => [
            'rules' => 'required|in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
            'errors' => [
                'required' => '(Tipo de Urb) Es obligatorio.',
                'in_list' => '(Tipo de Urb) Selecciona un Tipo de Urbanización.'
            ]
        ],
        'direccion_proyecto' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Dirección) Es obligatorio.',
                'max_length' => '(Dirección) El número de carateres deben ser menores de 50.'
            ]
        ],
        'Manz' => [
            'rules' => 'required|max_length[10]',
            'errors' => [
                'required' => '(Manzana) Es obligatorio.',
                'max_length' => '(Manzana) El número de carateres deben ser menores de 10.'
            ]
        ],
        'Lote' => [
            'rules' => 'required|max_length[10]',
            'errors' => [
                'required' => '(Lote) Es obligatorio.',
                'max_length' => '(Lote) El número de carateres deben ser menores de 10.'
            ]
        ],
        'Frente' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Frente) Es obligatorio.',
                'max_length' => '(Frente) El número de carateres deben ser menores de 50.'
            ]
        ],
        'FrenteM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Frente) Es obligatorio.',
                'numeric' => '(Medida del Frente) Dato debe ser numérico.',
                'max_length' => '(Medida del Frente) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Derecha' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Derecha) Es obligatorio.',
                'max_length' => '(Derecha) El número de carateres deben ser menores de 50.'
            ]
        ],
        'DerechaM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida de la Derecha) Es obligatorio.',
                'numeric' => '(Medida de la Derecha) Dato debe ser númerico.',
                'max_length' => '(Medida de la Derecha) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Izquierda' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Izquierda) Es obligatorio.',
                'max_length' => '(Izquierda) El número de carateres deben ser menores de 50.'
            ]
        ],
        'IzquierdaM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida de la Izquierda) Es obligatorio.',
                'numeric' => '(Medida de la Izquierda) Dato debe ser numérico.',
                'max_length' => '(Medida de la Izquierda) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Fondo' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Fondo) Es obligatorio.',
                'max_length' => '(Fondo) El número de carateres deben ser menores de 50.'
            ]
        ],
        'FondoM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Fondo) Es obligatorio.',
                'numeric' => '(Medida del Fondo) Dato debe ser numérico.',
                'max_length' => '(Medida del Fondo) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Area' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Área) Es obligatorio.',
                'numeric' => '(Medida del Área) Dato debe ser numérico.',
                'max_length' => '(Medida del Área) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Arancel' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Arancel) Es obligatorio.',
                'numeric' => '(Arancel) Dato debe ser numérico.',
                'max_length' => '(Arancel) El número de carateres deben ser menores de 11.'
            ]
        ],
        'CVU' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(CVU) Es obligatorio.',
                'numeric' => '(CVU) Dato debe ser numérico.',
                'max_length' => '(CVU) El número de carateres deben ser menores de 11.'
            ]
        ],
        'VObra' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Valor de Obra) Es obligatorio.',
                'numeric' => '(Valor de Obra) Dato debe ser numérico.',
                'max_length' => '(Valor de Obra) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Modulo' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Módulo) Es obligatoria.',
                'numeric' => '(Módulo) No es una Convocatoria Válida.',
                'max_length' => '(Módulo) No es una Convocatoria Válida.'
            ]
        ],
        'CoorX' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Coordenada X) Es obligatorio.',
                'numeric' => '(Coordenada X) No es Dato numérico.',
                'max_length' => '(Coordenada X) El número de carateres deben ser menores de 11.'
            ]
        ],
        'CoorY' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Coordenada Y) Es obligatorio.',
                'numeric' => '(Coordenada Y) No es Dato numérico.',
                'max_length' => '(Coordenada Y) El número de carateres deben ser menores de 11.'
            ]
        ],
        'estado' => [
            'rules' => 'required|in_list[E,N,D,C]',
            'errors' => [
                'required' => '(Estado) Es obligatorio.',
                'in_list' => '(Estado) Datos incorrectos.'
            ]
        ],
        'fecha' => [
            'rules' => 'required|date',
            'errors' => [
                'required' => '(Fecha) Es obligatorio.',
                'date' => '(Fecha) No es una fecha correcta.'
            ]
        ],
        'Luz' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Luz) Es obligatorio.',
                'not_in_list' => '(Luz) El número de carateres deben ser menores de 1.'
            ]
        ],
        'Agua' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Agua) Es obligatorio.',
                'not_in_list' => '(Agua) El número de carateres deben ser menores de 1.'
            ]
        ],
        'Desage' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Desagüe) Es obligatorio.',
                'not_in_list' => '(Desagüe) El número de carateres deben ser menores de 1.'
            ]
        ],
        'Septico' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Pozo Séptico) Es obligatorio.',
                'not_in_list' => '(Pozo Séptico) El número de carateres deben ser menores de 1.'
            ]
        ]
    ];
    //IDs Editar Campos del Proyecto
    public $ProyectEdit = [
        'Codigo' => [
            'rules' => 'required|exact_length[10]',
            'errors' => [
                'required' => '(Código) Es obligatoria.',
                'exact_length' => '(Código) El número de carateres deben ser 7.'
            ]
        ],
        'NContrato' => [
            'rules' => 'required|exact_length[10]',
            'errors' => [
                'required' => '(Número de Contrato) Es obligatoria.',
                'exact_length' => '(Número de Contrato) El número de carateres deben ser 7.'
            ]
        ],
        'Sector' => [
            'rules' => 'permit_empty|max_length[50]',
            'errors' => [
                'max_length' => '(Sector) El número de carateres deben ser menores de 50.'
            ]
        ],
        'tipoUrb' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Tipo de Urb) Es obligatorio.',
                'max_length' => '(Tipo de Urb) El número de carateres deben ser menores de 50.'
            ]
        ],
        'direccion_proyecto' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Dirección) Es obligatorio.',
                'max_length' => '(Dirección) El número de carateres deben ser menores de 50.'
            ]
        ],
        'Manz' => [
            'rules' => 'required|max_length[10]',
            'errors' => [
                'required' => '(Manzana) Es obligatorio.',
                'max_length' => '(Manzana) El número de carateres deben ser menores de 10.'
            ]
        ],
        'Lote' => [
            'rules' => 'required|max_length[10]',
            'errors' => [
                'required' => '(Lote) Es obligatorio.',
                'max_length' => '(Lote) El número de carateres deben ser menores de 10.'
            ]
        ],
        'Frente' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Frente) Es obligatorio.',
                'max_length' => '(Frente) El número de carateres deben ser menores de 50.'
            ]
        ],
        'FrenteM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Frente) Es obligatorio.',
                'max_length' => '(Medida del Frente) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Derecha' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Derecha) Es obligatorio.',
                'max_length' => '(Derecha) El número de carateres deben ser menores de 50.'
            ]
        ],
        'DerechaM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Derecha) Es obligatorio.',
                'max_length' => '(Medida del Derecha) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Izquierda' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Izquierda) Es obligatorio.',
                'max_length' => '(Izquierda) El número de carateres deben ser menores de 50.'
            ]
        ],
        'IzquierdaM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Izquierda) Es obligatorio.',
                'max_length' => '(Medida del Izquierda) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Fondo' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Fondo) Es obligatorio.',
                'max_length' => '(Fondo) El número de carateres deben ser menores de 50.'
            ]
        ],
        'FondoM' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Fondo) Es obligatorio.',
                'max_length' => '(Medida del Fondo) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Area' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Medida del Área) Es obligatorio.',
                'max_length' => '(Medida del Área) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Arancel' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Arancel) Es obligatorio.',
                'max_length' => '(Arancel) El número de carateres deben ser menores de 11.'
            ]
        ],
        'CVU' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(CVU) Es obligatorio.',
                'max_length' => '(CVU) El número de carateres deben ser menores de 11.'
            ]
        ],
        'VObra' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(VObra) Es obligatorio.',
                'max_length' => '(VObra) El número de carateres deben ser menores de 11.'
            ]
        ],
        'Modulo' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Módulo) Es obligatoria.',
                'numeric' => '(Módulo) No es una Convocatoria Válida.',
                'max_length' => '(Módulo) No es una Convocatoria Válida.'
            ]
        ],
        'CoorX' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Coordenada X) Es obligatorio.',
                'max_length' => '(Coordenada X) El número de carateres deben ser menores de 11.'
            ]
        ],
        'CoorY' => [
            'rules' => 'required|numeric|max_length[11]',
            'errors' => [
                'required' => '(Coordenada Y) Es obligatorio.',
                'max_length' => '(Coordenada Y) El número de carateres deben ser menores de 11.'
            ]
        ],
        'estado' => [
            'rules' => 'required|in_list[E,N,D,C]',
            'errors' => [
                'required' => '(Estado) Es obligatorio.',
                'in_list' => '(Estado) Datos incorrectos.'
            ]
        ],
        'fecha' => [
            'rules' => 'required|date',
            'errors' => [
                'required' => '(Fecha) Es obligatorio.',
                'date' => '(Fecha) No es una fecha correcta.'
            ]
        ],
        'Luz' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Luz) Es obligatorio.',
                'not_in_list' => '(Luz) El número de carateres deben ser menores de 1.'
            ]
        ],
        'Agua' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Agua) Es obligatorio.',
                'not_in_list' => '(Agua) El número de carateres deben ser menores de 1.'
            ]
        ],
        'Desage' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Desagüe) Es obligatorio.',
                'not_in_list' => '(Desagüe) El número de carateres deben ser menores de 1.'
            ]
        ],
        'Septico' => [
            'rules' => 'permit_empty|not_in_list[0,1,True,False]',
            'errors' => [
                'required' => '(Pozo Septico) Es obligatorio.',
                'not_in_list' => '(Pozo Séptico) El número de carateres deben ser menores de 1.'
            ]
        ]
    ];
    //Guardar o Registar el Proyecto
    public function doSaveProyect()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->ProyectReg);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            if (!is_dir(ROOTPATH . 'resources/proyect')) {
                $respuesta['error'] = "No existe una carpeta asignada!!";
            } else {
                $rest = $this->generate_string($this->permitted_chars, 30); //Genera Codigo
                $this->addDir(ROOTPATH . 'resources/proyect/' . $rest); //Añade Carpeta
                while (!is_dir(ROOTPATH . 'resources/proyect/' . $rest)) {
                    $rest = $this->generate_string($this->permitted_chars, 30);
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest);
                }
                if (!is_dir(ROOTPATH . 'resources/proyect/' . $rest)) {
                    $respuesta['error'] = "Error al crear directorio!!";
                } else {
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/1. Proyecto');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/2. Exp. Postulación');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/3. Zona Segura');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/4. Exp. Lima');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/5. Licencia de Edificación');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/6. Asignación');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/7. Conformidad');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/8. Inicio de Obra');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/9. Panel Fotografico');
                    $this->addDir(ROOTPATH . 'resources/proyect/' . $rest . '/10. Monitor VYZ');
                    if (!is_dir(ROOTPATH . 'resources/proyect/' . $rest . '/10. Monitor VYZ')) {
                        $respuesta['error'] = "Error al crear subdirectorios!!";
                    } else {
                        $request =  \Config\Services::request();
                        $Codigo  = $request->getPostGet('Codigo');
                        $NContrato   = $request->getPostGet('NContrato');
                        $Conv = $request->getPostGet('Conv');
                        $Persona  = $request->getPostGet('Persona');

                        $dist  = $request->getPostGet('dist');
                        $Sector  = $request->getPostGet('Sector');
                        $tipoUrb  = $request->getPostGet('tipoUrb');
                        $direccion_proyecto  = $request->getPostGet('direccion_proyecto');
                        $Manzana  = $request->getPostGet('Manz');
                        $Lote  = $request->getPostGet('Lote');
                        $Frente  = $request->getPostGet('Frente');
                        $FrenteM = $request->getPostGet('FrenteM');
                        $Derecha = $request->getPostGet('Derecha');
                        $DerechaM  = $request->getPostGet('DerechaM');
                        $Izquierda  = $request->getPostGet('Izquierda');
                        $IzquierdaM = $request->getPostGet('IzquierdaM');
                        $Fondo  = $request->getPostGet('Fondo');
                        $FondoM = $request->getPostGet('FondoM');
                        $Area  = $request->getPostGet('Area');
                        $Arancel = $request->getPostGet('Arancel');
                        $CVU = $request->getPostGet('CVU');
                        $VObra = $request->getPostGet('VObra');
                        $Modulo  = $request->getPostGet('Modulo');
                        $CoorX = $request->getPostGet('CoorX');
                        $CoorY = $request->getPostGet('CoorY');
                        $Estado = $request->getPostGet('estado');
                        $Fecha = $request->getPostGet('fecha');
                        $luz = $request->getPostGet('Luz');
                        $agua = $request->getPostGet('Agua');
                        $desage = $request->getPostGet('Desage');
                        $sept = $request->getPostGet('Septico');
                        if ($luz == 'on') {
                            $luz = 1;
                        } else {
                            $luz = 0;
                        }
                        if ($agua == 'on') {
                            $agua = 1;
                        } else {
                            $agua = 0;
                        }
                        if ($desage == 'on') {
                            $desage = 1;
                        } else {
                            $desage = 0;
                        }
                        if ($sept == 'on') {
                            $sept = 1;
                        } else {
                            $sept = 0;
                        }
                        $data = array(
                            $Codigo, $NContrato,
                            $Conv, $Persona,  $Estado, $Modulo, $Sector,
                            $tipoUrb, $direccion_proyecto,
                            $Manzana, $Lote, $Frente, $FrenteM,
                            $Derecha, $DerechaM, $Izquierda, $IzquierdaM,
                            $Fondo, $FondoM, $Area, $Arancel,
                            $CVU, $VObra,
                            $CoorX, $CoorY, $dist, $Fecha,
                            $luz, $agua,
                            $desage, $sept, $rest, $_SESSION['id_usuario']
                        );
                        $modelo = new clbM_administracion();
                        if ($modelo->registrar($data, 'sp_proyect_insert', '?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?')) {
                            $respuesta['error'] = "";
                            $respuesta['ok'] = "Operación realizada";
                        } else {
                            $respuesta['error'] = "Problemas al realizar operación!!";
                            $this->rmDir_rf(ROOTPATH . 'resources/proyect/' . $rest);
                        }
                    }
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Actualizar Proyecto
    public function doUpdateProyect()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->ProyectEdit);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {

            $request =  \Config\Services::request();
            $Codigo  = $request->getPostGet('Codigo');
            $NContrato   = $request->getPostGet('NContrato');
            $Sector  = $request->getPostGet('Sector');
            $tipoUrb  = $request->getPostGet('tipoUrb');
            $direccion_proyecto  = $request->getPostGet('direccion_proyecto');
            $Manzana  = $request->getPostGet('Manz');
            $Lote  = $request->getPostGet('Lote');
            $Frente  = $request->getPostGet('Frente');
            $FrenteM = $request->getPostGet('FrenteM');
            $Derecha = $request->getPostGet('Derecha');
            $DerechaM  = $request->getPostGet('DerechaM');
            $Izquierda  = $request->getPostGet('Izquierda');
            $IzquierdaM = $request->getPostGet('IzquierdaM');
            $Fondo  = $request->getPostGet('Fondo');
            $FondoM = $request->getPostGet('FondoM');
            $Area  = $request->getPostGet('Area');
            $Arancel = $request->getPostGet('Arancel');
            $CVU = $request->getPostGet('CVU');
            $VObra = $request->getPostGet('VObra');
            $Modulo  = $request->getPostGet('Modulo');
            $CoorX = $request->getPostGet('CoorX');
            $CoorY = $request->getPostGet('CoorY');
            $Estado = $request->getPostGet('estado');
            $Fecha = $request->getPostGet('fecha');
            $luz = $request->getPostGet('Luz');
            $agua = $request->getPostGet('Agua');
            $desage = $request->getPostGet('Desage');
            $sept = $request->getPostGet('Septico');
            $id = $request->getPostGet('ID');
            if ($luz == 'on') {
                $luz = 1;
            } else {
                $luz = 0;
            }
            if ($agua == 'on') {
                $agua = 1;
            } else {
                $agua = 0;
            }
            if ($desage == 'on') {
                $desage = 1;
            } else {
                $desage = 0;
            }
            if ($sept == 'on') {
                $sept = 1;
            } else {
                $sept = 0;
            }
            $data = array(
                $Codigo, $NContrato, $Estado, $Modulo, $Sector,
                $tipoUrb, $direccion_proyecto,
                $Manzana, $Lote, $Frente, $FrenteM,
                $Derecha, $DerechaM, $Izquierda, $IzquierdaM,
                $Fondo, $FondoM, $Area, $Arancel,
                $CVU, $VObra,
                $CoorX, $CoorY, $Fecha,
                $luz, $agua,
                $desage, $sept, $id
            );
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, 'sp_proyect_update', '?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Buscar Proyecto
    public function doSearchProyect()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'TipoDato' => [
                'rules' => 'required|numeric|exact_length[1]',
                'errors' => [
                    'required' => '(Tipo de Dato) Es obligatoria.',
                    'exact_length' => '(Tipo de Dato) Inválido.',
                    'numeric' => '(Tipo de Dato) Inválido.'
                ]
            ], 'Dato' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => '(Código) Es obligatoria.',
                    'max_length' => '(Código) El número de carateres deben ser 10.'
                ]
            ]
        ]);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $valueType = $request->getPostGet('TipoDato');
            $value = $request->getPostGet('Dato');
            $data = array($valueType, $value);
            $modelo = new clbM_administracion();
            $respuesta = $modelo->consultaMultiple($data, "sp_proyect_search", '?,?');
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Listar tabla Proyecto
    public function doListProyect()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_proyect_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Mostrar el contenido de la carpeta
    public function doOpenDirProyect()
    {
        $respuesta = array();
        $request =  \Config\Services::request();
        $DIR = $request->getPostGet('Cdir');
        if ($DIR != null) {
            $Url = ROOTPATH . 'resources/proyect/' . $DIR;
            $dir = opendir($Url);
            $cont = 0;
            $bool = 0;
            while ($elemento = readdir($dir)) {
                if ($elemento != "." && $elemento != "..") {
                    if (is_dir($Url . '/' . $elemento)) {
                        $Icon = '<i class="bi bi-folder ml-2 my-auto"></i>';
                        $bool = 1;
                    } else {
                        $Icon = '<i class="bi bi-file-earmark ml-2 my-auto"></i>';
                        $bool = 0;
                    }
                    $cont += 1;
                    $respuesta[$cont] = array('Elemento' => $elemento, 'Bool' => $bool, 'Icon' => $Icon);
                }
            }
            $respuesta['Length'] = $cont;
            $respuesta['URL'] = $Url;
        } else {
            $respuesta['Length'] = 0;
            $respuesta['1'] = 'Error al buscar';
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Control de Subida del Archivo
    public function doUpFile()
    {
        $respuesta = array();
        $request =  \Config\Services::request();
        $DIR = $request->getPostGet('Cdir');
        $file = $this->request->getFile('file');
        if ($DIR != null && $file != null) {
            $name = $file->getName();
            $file->move(ROOTPATH . 'resources/proyect/' . $DIR, $name);
            $respuesta['1'] = 'Se subió correctamente el archivo';
        } else {
            $respuesta['Length'] = 0;
            $respuesta['Cdir'] = $DIR;
            $respuesta['file'] = $file;
            $respuesta['1'] = 'Error al buscar';
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Control de Bajada del Archivo 
    public function doDropFile()
    {
        $respuesta = array();
        $request =  \Config\Services::request();
        $DIR = $request->getPostGet('Cdir');
        if ($DIR != null) {
            if (unlink(ROOTPATH . 'resources/proyect/' . $DIR)) {
                $respuesta['1'] = 'Funcionooo';
            } else {
                $respuesta['1'] = 'No se encontró el archivo';
            }
        } else {
            $respuesta['DIR'] = $DIR;
            $respuesta['Length'] = 0;
            $respuesta['1'] = 'Error al buscar';
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Generación del String
    public function generate_string($input, $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
    //Carga del Resumen del Proyecto
    public function doResumeProyect()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_proyect_resume');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    // Output: iNCHNGzByPjhApvn7XBD
    // echo generate_string($permitted_chars, 20);
    
}
