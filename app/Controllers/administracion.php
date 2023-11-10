<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\clbM_administracion;

class administracion extends BaseController
{

    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url']);
    }

    /** 
     ************************************************************************
     * *                    Variables de Validación
     * Estas variables publicas nos permiten almacenar nuestras validaciones 
     * con mensajes personalizados a gusto, estas son llamadas con el 
     * siguiente metodo:
     * 
     * $      $this -> validate( $this-> 'Variable de Validación');
     * 
     * que devuelve un valor significativo de la ejecución del proceso, en
     * este caso @param TRUE si se ejecuto sin errores y @param FALSE si
     * ocurrieron errores.
     ************************************************************************
     */

    //// Validación para el registro y Actualización de los proveedores.

    public $Proovedores = [
        'ruc' => [
            'rules' => 'required|numeric|exact_length[11]',
            'errors' => [
                'required' => '(RUC) Es obligatoria.',
                'numeric' => '(RUC) Solo se aceptan caracteres numéricos.',
                'exact_length' => '(RUC) El número de caracteres deben ser 11.',
            ]
        ],
        'razon'  => [
            'rules' => 'required',
            'errors' => [
                'required' => '(Razón Social) Es obligatoria.',
            ]
        ],
        'dir'  => [
            'rules' => 'required',
            'errors' => [
                'required' => '(Dirección) Es obligatoria.'
            ]
        ],
        'tel'  => [
            'rules' => 'required|numeric|min_length[3]|max_length[15]',
            'errors' => [
                'required' => '(Teléfono) Es obligatoria.',
                'numeric' => '(Teléfono) Solo se aceptan caracteres numéricos.',
                'min_length' => '(Teléfono) El número de caracteres debe ser mayor de 2',
                'max_length' => '(Teléfono) El número de caracteres no debe ser mayor de 15',
            ],
        ],
        'correo' => [
            'rules' => 'required|min_length[8]|max_length[200]|valid_email',
            'errors' => [
                'required' => '(Correo Electrónico) Es obligatorio.',
                'min_length' => '(Correo Electrónico) El número de caracteres debe ser mayor de 8.',
                'max_length' => '(Correo Electrónico) El número de caracteres no debe ser mayor de 200.',
                'valid_email' => '(Correo Electrónico) No se asemeja a un correo electrónico.'
            ]
        ],
        'dist' => [
            'rules' => 'required|numeric|exact_length[6]',
            'errors' => [
                'required' => '(Ubicación) Es obligatoria.',
                'numeric' => '(Ubicación) No se encuentra registrado.',
                'exact_length' => '(Ubicación) No se encuentra registrado.'
            ]
        ]
    ];

    //// Validación para el registro y Actualización de los beneficiarios y empleados.

    public $Persona = [
        'dni' => [
            'rules' => 'required|numeric|exact_length[8]',
            'errors' => [
                'required' => '(DNI) Es obligatorio.',
                'numeric' => '(DNI) Solo se aceptan caracteres numericos.',
                'exact_length' => '(DNI) El número de caracteres debe ser 8.',
            ]
        ],
        'profe'  => [
            'rules' => 'permit_empty|alpha_space',
            'errors' => [
                'alpha_space' => '(Profesión) Solo se aceptan caracteres válidos.',
            ]
        ],
        'dir'  => [
            'rules' => 'permit_empty|min_length[2]|max_length[100]',
            'errors' => [
                'min_length' => '(Dirección) El número de caracteres debe ser mayor de 1',
                'max_length' => '(Dirección) El número de caracteres no debe ser mayor de 100',
            ]
        ],
        'tel'  => [
            'rules' => 'permit_empty|numeric|min_length[5]|max_length[15]',
            'errors' => [
                'permit_empty' => '(Teléfono) No es obligatorio.',
                'numeric' => '(Teléfono) Solo se aceptan caracteres válidos.',
                'min_length' => '(Teléfono) El número de caracteres debe ser mayor de 1',
                'max_length' => '(Teléfono) El número de caracteres no debe ser mayor de 15',
            ]
        ],
        'correo' => [
            'rules' => 'permit_empty|max_length[200]|valid_email',
            'errors' => [
                'max_length' => '(Correo Electrónico) El numero de caracteres no debe ser mayor de 200.',
                'valid_email' => '(Correo Electrónico) No se asemeja el formato.'
            ]
        ],
        'nombre'  => [
            'rules' => 'required|alpha_space|min_length[2]|max_length[50]',
            'errors' => [
                'required' => '(Nombre) Es obligatorio.',
                'alpha_space' => '(Nombre) Solo se aceptan caracteres válidos',
                'min_length' => '(Nombre) El número de caracteres debe ser mayor de 1',
                'max_length' => '(Nombre) El número de caracteres no debe ser mayor de 50',
            ]
        ],
        'apelPAT'  => [
            'rules' => 'required|alpha_space|min_length[2]|max_length[50]',
            'errors' => [
                'required' => '(Apellido Paterno) es obligatorio',
                'alpha_space' => '(Apellido Paterno) Solo se aceptan caracteres válidos',
                'min_length' => '(Apellido Paterno) El número de caracteres debe ser mayor de 1',
                'max_length' => '(Apellido Paterno) El número de caracteres no debe ser mayor de 50',
            ]
        ],
        'apelMAT'  => [
            'rules' => 'required|alpha_space|min_length[2]|max_length[50]',
            'errors' => [
                'required' => '(Apellido Materno) Campos Apellidos es obligatorio',
                'alpha_space' => '(Apellido Materno) Solo se aceptan caracteres válidos',
                'min_length' => '(Apellido Materno) El número de caracteres debe ser mayor de 1',
                'max_length' => '(Apellido Materno) El número de caracteres no debe ser mayor de 50',
            ]
        ],
        'sexo'  => [
            'rules' => 'required|in_list[M,F,N]',
            'errors' => [
                'required' => '(Sexo) Es obligatorio.',
                'in_list' => '(Sexo) Selecciona un sexo.'
            ]
        ],
        'estado'  => [
            'rules' => 'required|in_list[0,1,2,3]',
            'errors' => [
                'required' => '(Estado Civil) Es obligatorio.',
                'in_list' => '(Estado Civil) Selecciona un estado.'
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
        'nacimi' => [
            'rules' => 'permit_empty|valid_date',
            'errors' => [
                'permit_empty' => '(Fecha de Nacimiento) No has iniciado Sesión.',
                'valid_date' => '(Fecha de Nacimiento) No se asemeja al formato.'
            ]
        ]
    ];

    //// Validación para los tipos de modulos de vivienda.

    public $Module = [
        'mod' => [
            'rules' => 'required|numeric|max_length[6]',
            'errors' => [
                'required' => '(Módulo) Es obligatorio.',
                'numeric' => '(Módulo) Solo se aceptan caracteres numéricos.',
                'max_length' => '(Módulo) El número de caracteres no debe ser mayor de 6.',
            ]
        ],
        'desc'  => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Descripción) Es obligatorio.',
                'max_length' => '(Descripción) El número de caracteres no debe ser mayor de 50.',
            ]
        ],
        'atec' => [
            'rules' => 'required|numeric|max_length[6]',
            'errors' => [
                'required' => '(Área Techada) Es obligatorio.',
                'numeric' => '(Área Techada) Solo se aceptan caracteres numéricos.',
                'max_length' => '(Área Techada) El número de caracteres no debe ser mayor de 6.',
            ]
        ],
        'acon' => [
            'rules' => 'required|numeric|max_length[6]',
            'errors' => [
                'required' => '(Área Construida) Es obligatorio.',
                'numeric' => '(Área Construida) Solo se aceptan caracteres numéricos.',
                'max_length' => '(Área Construida) El número de caracteres no debe ser mayor de 6.',
            ]
        ]
    ];

    //// Validación para las convocatorias.

    public $Convocatoria = [
        'conv' => [
            'rules' => 'required|max_length[6]',
            'errors' => [
                'required' => '(Convocatoria) Es obligatorio.',
                'max_length' => '(Convocatoria) El número de caracteres no debe ser mayor de 6.',
            ]
        ],
        'desc'  => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Descripción) Es obligatorio.',
                'max_length' => '(Descripción) El número de caracteres no debe ser mayor de 50.',
            ]
        ],
        'ini' => [
            'rules' => 'required|valid_date',
            'errors' => [
                'required' => '(Fecha de Inicio) Es obligatorio.',
                'valid_date' => '(Fecha de Inicio) No se asemeja al formato.'
            ]
        ],
        'fin' => [
            'rules' => 'permit_empty|valid_date',
            'errors' => [
                'permit_empty' => '(Fecha de Fin) Es obligatorio.',
                'valid_date' => '(Fecha de Fin) No se asemeja al formato.'
            ]
        ]
    ];

    //// Validación para las convocatorias.

    public $Category = [
        'catg' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '(Categoría) Es obligatorio.',
                'max_length' => '(Categoría) El número de caracteres no debe ser mayor de 50.',
            ]
        ],
        'desc'  => [
            'rules' => 'required|max_length[100]',
            'errors' => [
                'required' => '(Descripción) Es obligatorio.',
                'max_length' => '(Descripción) El número de caracteres no debe ser mayor de 100.',
            ]
        ]
    ];

    //// Validación para las unidades de medida.

    public $UnidMed = [
        'unid' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => '(Unidad) Es obligatorio.',
                'max_length' => '(Unidad) El número de caracteres no debe ser mayor de 50.',
            ]
        ],
        'plr' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => '(Plurar) Es obligatorio.',
                'max_length' => '(Plurar) El número de caracteres no debe ser mayor de 50.',
            ]
        ],
        'simb'  => [
            'rules' => 'permit_empty|max_length[20]',
            'errors' => [
                'permit_empty' => '(Símbolo) No es obligatorio.',
                'max_length' => '(Símbolo) El número de caracteres no debe ser mayor de 100.',
            ]
        ]
    ];

    /**
     ************************************************************************
     * *                    Metodos de Registro de Datos
     * Estos metodos de controlador nos permiten enviar los datos validados
     * en un arreglo a nuestro controlador para que este ejecute los
     * procedimientos almacenados en la base de datos. En este caso el 
     * metodo de modelo usado para todos los registros es:
     * 
     * $        registrar( 'data' , 'procedure' , 'parametros' );
     * 
     * que devuelve un valor significativo de la ejecución del proceso, en
     * este caso @param TRUE si se ejecuto sin errores y @param FALSE si 
     * ocurrieron errores. Enviando a la capa de presentación finalmente 
     * estos valores mediante el metodo:
     *  
     * ?   header('Content-Type: application/x-json; charset=utf-8');
     * ?   echo (json_encode($respuesta)); 
     * 
     ************************************************************************
     */

    /**
     **                     Registrar Proveedor
     * Este método registra los datos de los proveedores, nos permite
     * registrar los siguientes datos:
     * 
     *   - RUC (@param ruc)
     *   - Razón (@param razon)
     *   - Dirección (@param dir)
     *   - Telefono (@param tel)
     *   - Correo Electronico (@param correo)
     *   - Distrito (@param dist)
     *   - Usuario de registro (@param user)
     * 
     * Para ello valida que los datos tengan coherencia con las
     * validaciones previamente diseñadas y establecidas, ejecutando
     * un proceso que de ser verdadero continua con el almacenamiento
     * en un array para enviarlo y convertir su respuesta en un mensaje
     * legible para la capa de presentación.
     * 
     * TODO: El procedimiento almacenado 'sp_proveedor_insert' consta de 6 parametros IN y 1 OUT.
     */

    public function doSaveProveedor()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Proovedores);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $ruc = $request->getPostGet('ruc');
            $razon = $request->getPostGet('razon');
            $dir = $request->getPostGet('dir');
            $tel = $request->getPostGet('tel');
            $correo = $request->getPostGet('correo');
            $dist = $request->getPostGet('dist');
            $user = $_SESSION['id_usuario'];
            $data = array($ruc, $razon, $correo, $tel, $dir, $dist, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, 'sp_proveedor_insert', '?,?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /**
     **                    Registrar Persona
     * Este metodo registra los datos de los beneficiarios y empleados,
     * que nos son utiles en todos los procesos del sistema. Este consta de
     * los siguientes datos:
     * 
     *   - Identificación (@param dni)
     *   - Nombre (@param nombre)
     *   - Apellido Materno (@param apelMAT)
     *   - Apellido Paterno (@param apelPAT)
     *   - Sexo (@param sexo)
     *   - Dirección (@param dir)
     *   - Profesión (@param profe)
     *   - Telefono (@param tel)
     *   - Fecha de Nacimiento (@param nacimi)
     *   - Correo Electronico (@param correo)
     *   - Distrito (@param dist)
     *   - Usuario de registro (@param user)
     * 
     * Para ello valida que los datos tengan coherencia con las
     * validaciones previamente diseñadas y establecidas, ejecutando
     * un proceso que de ser verdadero continua con el almacenamiento
     * en un array para enviarlo y convertir su respuesta en un mensaje
     * legible para la capa de presentación.
     * 
     * TODO: El procedimiento almacenado 'sp_person_insert' consta de 13 parametros IN y 1 OUT.
     */

    public function doSavePerson()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Persona);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $dni = $request->getPostGet('dni');
            $profe = $request->getPostGet('profe');
            $nombre = $request->getPostGet('nombre');
            $dir = $request->getPostGet('dir');
            $sexo = $request->getPostGet('sexo');
            $estado = $request->getPostGet('estado');
            $apelMAT = $request->getPostGet('apelMAT');
            $apelPAT = $request->getPostGet('apelPAT');
            $tel = $request->getPostGet('tel');
            $correo = $request->getPostGet('correo');
            $dist = $request->getPostGet('dist');
            $user = $_SESSION['id_usuario'];
            $nacimi = $request->getPostGet('nacimi');
            $data = array($dni, $nombre, $apelPAT, $apelMAT, $sexo, $dir, $dist, $estado, $tel, $correo, $profe, $nacimi, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_person_insert", '?,?,?,?,?,?,?,?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /**
     **                    Registrar Tipo de Modulo
     * Este metodo registra los datos de los tipos de modulo, que nos son
     * utiles en todos los procesos del sistema. Este consta de los 
     * siguientes datos:
     * 
     *   - Modulo (@param mod)
     *   - Descripción (@param desc)
     *   - Área Techada (@param atec)
     *   - Área Construida (@param acon)
     *   - Usuario de registro (@param user)
     * 
     * Para ello valida que los datos tengan coherencia con las
     * validaciones previamente diseñadas y establecidas, ejecutando
     * un proceso que de ser verdadero continua con el almacenamiento
     * en un array para enviarlo y convertir su respuesta en un mensaje
     * legible para la capa de presentación.
     * 
     * TODO: El procedimiento almacenado 'sp_modulo_insert' consta de 5 parametros IN y 1 OUT.
     */

    public function doSaveModule()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Module);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $mod = $request->getPostGet('mod');
            $desc = $request->getPostGet('desc');
            $atec = $request->getPostGet('atec');
            $acon = $request->getPostGet('acon');
            $user = $_SESSION['id_usuario'];
            $data = array($mod, $desc, $atec, $acon, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_modulo_insert", '?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /**
     **                   Registrar Convocatoria
     * Este metodo registra los datos de las convocatorias, que nos son
     * utiles en todos los procesos del sistema. Este consta de los 
     * siguientes datos:
     * 
     *   - Convocatoria (@param conv)
     *   - Descripción (@param desc)
     *   - Fecha de Inicio (@param ini)
     *   - Fecha de Fin (@param fin)
     *   - Usuario de registro (@param user)
     * 
     * Para ello valida que los datos tengan coherencia con las
     * validaciones previamente diseñadas y establecidas, ejecutando
     * un proceso que de ser verdadero continua con el almacenamiento
     * en un array para enviarlo y convertir su respuesta en un mensaje
     * legible para la capa de presentación.
     * 
     * TODO: El procedimiento almacenado 'sp_convocatoria_insert' consta de 5 parametros IN y 1 OUT.
     */

    public function doSaveConvocatoria()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Convocatoria);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $mod = $request->getPostGet('conv');
            $desc = $request->getPostGet('desc');
            $atec = $request->getPostGet('ini');
            $acon = $request->getPostGet('fin');
            $user = $_SESSION['id_usuario'];
            $data = array($mod, $desc, $atec, $acon, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_convocatoria_insert", '?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /**
     **                   Registrar Categoria
     * Este metodo registra los datos de las categorias, que nos son
     * utiles en todos los procesos del sistema. Este consta de los 
     * siguientes datos:
     * 
     *   - Convocatoria (@param catg)
     *   - Descripción (@param desc)
     *   - Usuario de registro (@param user)
     * 
     * Para ello valida que los datos tengan coherencia con las
     * validaciones previamente diseñadas y establecidas, ejecutando
     * un proceso que de ser verdadero continua con el almacenamiento
     * en un array para enviarlo y convertir su respuesta en un mensaje
     * legible para la capa de presentación.
     * 
     * TODO: El procedimiento almacenado 'sp_category_insert' consta de 3 parametros IN y 1 OUT.
     */

    public function doSaveCategory()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Category);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $catg = $request->getPostGet('catg');
            $desc = $request->getPostGet('desc');
            $user = $_SESSION['id_usuario'];
            $data = array($catg, $desc, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_category_insert", '?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /**
     **                   Registrar Medida
     * Este metodo registra los datos de las medidas de unidades, que nos son
     * utiles en todos los procesos del sistema. Este consta de los 
     * siguientes datos:
     * 
     *   - Unidad de Medida (@param unid)
     *   - Plural de Medida (@param plr)
     *   - Simbolo (@param plr)
     *   - Usuario de registro (@param user)
     * 
     * Para ello valida que los datos tengan coherencia con las
     * validaciones previamente diseñadas y establecidas, ejecutando
     * un proceso que de ser verdadero continua con el almacenamiento
     * en un array para enviarlo y convertir su respuesta en un mensaje
     * legible para la capa de presentación.
     * 
     * TODO: El procedimiento almacenado 'sp_unidmedida_insert' consta de 4 parametros IN y 1 OUT.
     */

    public function doSaveMedida()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->UnidMed);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $unid = $request->getPostGet('unid');
            $plr = $request->getPostGet('plr');
            $simb = $request->getPostGet('simb');
            $user = $_SESSION['id_usuario'];
            $data = array($unid, $plr, $simb, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_unidmedida_insert", '?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operación!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /**
     ************************************************************************
     * *                    Metodos de Actualización de Datos
     * Estos metodos de controlador nos permiten enviar los datos validados
     * en un arreglo a nuestro controlador para que este ejecute los
     * procedimientos almacenados en la base de datos. En este caso el 
     * metodo de modelo usado para todos los registros es:
     * 
     * $        registrar( 'data' , 'procedure' , 'parametros' );
     * 
     * que devuelve un valor significativo de la ejecución del proceso, en
     * este caso @param TRUE si se ejecuto sin errores y @param FALSE si 
     * ocurrieron errores. Enviando a la capa de presentación finalmente 
     * estos valores mediante el metodo:
     *  
     * ?   header('Content-Type: application/x-json; charset=utf-8');
     * ?   echo (json_encode($respuesta)); 
     * 
     ************************************************************************
     */

    /**
     **                     Actualizar Proveedor
     * Este metodo actualiza los datos de los proveedores mediante su id, 
     * lo cual nos permite actualizar los siguientes datos:
     * 
     *   - RUC (@param ruc)
     *   - Razón (@param razon)
     *   - Dirección (@param dir)
     *   - Telefono (@param tel)
     *   - Correo Electronico (@param correo)
     *   - Distrito (@param dist)
     * 
     * Para ello valida que los datos tengan coherencia con las
     * validaciones previamente diseñadas y establecidas, ejecutando
     * un proceso que de ser verdadero continua con el almacenamiento
     * en un array para enviarlo y convertir su respuesta en un mensaje
     * legible para la capa de presentación.
     * 
     * TODO: El procedimiento almacenado 'sp_proveedor_insert' consta de 6 parametros IN y 1 OUT.
     */

    public function doUpdateProveedor()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso =  $this->validate($this->Proovedores);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $ruc = $request->getPostGet('ruc');
            $razon = $request->getPostGet('razon');
            $dir = $request->getPostGet('dir');
            $tel = $request->getPostGet('tel');
            $correo = $request->getPostGet('correo');
            $dist = $request->getPostGet('dist');
            $id = $request->getPostGet('id');
            $estado = $request->getPostGet('estado_modal');
            if ($id == '' || !is_numeric($id) || $estado == '') {
                $respuesta['error'] = "No enviaste un id o estado";
            } else {
                $data = array($ruc, $razon, $correo, $tel, $dir, $dist, $estado, $id);
                $modelo = new clbM_administracion();
                if ($modelo->registrar($data, 'sp_proveedor_update', '?,?,?,?,?,?,?,?')) {
                    $respuesta['error'] = "";
                    $respuesta['ok'] = "Operación realizada" . $estado;
                } else {
                    $respuesta['error'] = "Problemas al realizar operación!!";
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doUpdatePerson()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Persona);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $dni = $request->getPostGet('dni');
            $profe = $request->getPostGet('profe');
            $nombre = $request->getPostGet('nombre');
            $dir = $request->getPostGet('dir');
            $sexo = $request->getPostGet('sexo');
            $estado = $request->getPostGet('estado');
            $apelMAT = $request->getPostGet('apelMAT');
            $apelPAT = $request->getPostGet('apelPAT');
            $tel = $request->getPostGet('tel');
            $correo = $request->getPostGet('correo');
            $dist = $request->getPostGet('dist');
            $nacimi = $request->getPostGet('nacimi');
            $id = $request->getPostGet('id');
            $status = $request->getPostGet('status');
            if (!is_numeric($id) || !is_numeric($status)) {
                $respuesta['error'] = "No enviaste un id valido";
            } else {
                $data = array($dni, $nombre, $apelPAT, $apelMAT, $sexo, $dir, $dist, $estado, $tel, $correo, $profe, $nacimi, $status, $id);
                $modelo = new clbM_administracion();
                if ($modelo->registrar($data, "sp_person_update", '?,?,?,?,?,?,?,?,?,?,?,?,?,?')) {
                    $respuesta['error'] = "";
                    $respuesta['ok'] = "Operación realizada";
                } else {
                    $respuesta['error'] = "Problemas al realizar operación!!";
                }
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /*
    *               Actualizar Tipo de Modulo
    *   Este metodo Actualiza los datos de Convocatoria por id, 
    *   nos permite modificar los siguientes datos: 
    *    - Nombre de la Convocatoria
    *    - Descripción de Convocatoria
    *    - Fecha de inicio de Convocatoria
    *    - Fecha de Fin de Convocatoria
    *    - Estado de Convocatoria
    *
    *   Para ello encuentra la convocatoria referida mediante su id
    *   anteriormente listado por el metodo doListConvocatoria
    *
    */

    public function doUpdateModule()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Module);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $mod = $request->getPostGet('mod');
            $desc = $request->getPostGet('desc');
            $atec = $request->getPostGet('atec');
            $acon = $request->getPostGet('acon');
            $id = $request->getPostGet('id');
            $status = $request->getPostGet('status');
            $data = array($mod, $desc, $atec, $acon, $status, $id);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_modulo_update", '?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operacion realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operacion!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /** 
     *               Actualizar Convocatoria
     *   Este metodo Actualiza los datos de Convocatoria por id, 
     *   nos permite modificar los siguientes datos: 
     *    - Nombre de la Convocatoria
     *    - Descripción de Convocatoria
     *    - Fecha de inicio de Convocatoria
     *    - Fecha de Fin de Convocatoria
     *    - Estado de Convocatoria
     *
     *   Para ello encuentra la convocatoria referida mediante su id
     *   anteriormente listado por el metodo doListConvocatoria
     *
     */

    public function doUpdateConvocatoria()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Convocatoria);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $mod = $request->getPostGet('conv');
            $desc = $request->getPostGet('desc');
            $atec = $request->getPostGet('ini');
            $acon = $request->getPostGet('fin');
            $id = $request->getPostGet('id');
            $status = $request->getPostGet('status');
            $data = array($mod, $desc, $atec, $acon, $status, $id);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_convocatoria_update", '?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operacion realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operacion!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /*
    *               Actualizar Categoria
    *   Este metodo Actualiza los datos de Categoria por id, 
    *   nos permite modificar los siguientes datos: 
    *    - Nombre de la Categoria
    *    - Descripción de la Categoria
    *    - Estado de la Categoria
    *
    *   Para ello encuentra la categoria referida mediante su id
    *   anteriormente listado por el metodo doListCategory
    *
    */

    public function doUpdateCategory()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Category);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $catg = $request->getPostGet('catg');
            $desc = $request->getPostGet('desc');
            $id = $request->getPostGet('id');
            $status = $request->getPostGet('status');
            $data = array($catg, $desc, $status, $id);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_category_update", '?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operacion realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operacion!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    /*
    *               Actualizar Unidades de Medidas
    *   Este metodo Actualiza los datos de Unidades de Medidas
    *    por id, nos permite modificar los siguientes datos: 
    *    - Unidad de Medida
    *    - Plural de Medida
    *    - Simbolo
    *
    *   Para ello encuentra la categoria referida mediante su id
    *   anteriormente listado por el metodo doListCategory
    *
    */

    public function doUpdateMedida()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->UnidMed);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $unid = $request->getPostGet('unid');
            $simb = $request->getPostGet('simb');
            $plr = $request->getPostGet('plr');
            $id = $request->getPostGet('id');
            $status = $request->getPostGet('status');
            $data = array($unid, $plr, $simb, $status, $id);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, "sp_unidmedida_update", '?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operacion realizada";
            } else {
                $respuesta['error'] = "Problemas al realizar operacion!!";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    // Metodos de Listado de Datos

    public function doListProveedor()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_proveedor_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListPerson()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_person_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListModule()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_modulo_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListConvocatoria()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_convocatoria_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListCategory()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_category_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListMedida()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_unidmedida_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    // Metodos de Listado de Datos en Formato id - value

    public function doComboProveedor()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_proveedor_combo');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doComboPerson()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_person_combo');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doComboModule()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_modulo_combo');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doComboConvocatoria()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_convocatoria_combo');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doComboCategory()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_category_combo');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doComboMedida()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_unidmedida_combo');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    // Metodos de Resumenes

    public function doResumeProveedor()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_proveedor_resume');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doResumePerson()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_person_resume');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doResumeModulo()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_modulo_resume');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doResumeConvocatoria()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_convocatoria_resume');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doResumeCategory()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta = $modelo->listar('sp_category_resume');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
}
