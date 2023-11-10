<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\clbM_administracion;
use App\Models\produccionModel;

class produccion extends BaseController
{

    public function __construct()
    {
        ob_start();
        session_start();
        helper(['form', 'url']);
    }

    public $Product = [
        'codigo_producto' => [
            'rules' => 'required|exact_length[10]',
            'errors' => [
                'required'   => '(Código del Producto) Es obligatorio',
                'exact_length' => '(Código del Producto) Debe tener mínimo 10 digitos'
            ]
        ],
        'descripcion'  => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required'    => '(Descripción) del Producto es obligatorio',
                'max_length'  => '(Descripción) del Producto solo puede tener 50 caracteres como máximo',
            ]
        ],
        'unidad_medida'  => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => '(Unidad de Medida) Es obligatorio',
                'is_natural_no_zero'  => '(Unidad de Medida) Solo acepta caracteres válidos',
            ]
        ],
        'stock'  => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => '(Stock Inicial) Es obligatorio',
                'is_natural_no_zero'  => '(Stock Inicial) Solo acepta datos numéricos',
            ]
        ],
        'stockMin'  => [
            'rules' => 'permit_empty|is_natural',
            'errors' => [
                'required' => '(Stock Mínimo) Es obligatorio',
                'is_natural'  => '(Stock Mínimo) solo acepta datos numéricos',
            ]
        ],
        'Fllegada'  => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => '(Fecha de Llegada) Es obligatorio',
                'is_natural'  => '(Fecha de Llegada) Solo acepta datos numéricos',
            ]
        ],
        'Hllegada'  => [
            'rules' => 'required|valid_date[H:i]',
            'errors' => [
                'required' => '(Hora de llegada) Es obligatorio',
                'is_natural'  => '(Hora de llegada) Solo acepta fechas correctas',
            ]
        ],
        'proveedor'  => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => '(Proveedor) Es obligatorio',
                'integer'  => '(Proveedor) Solo acepta caracteres válidos',
            ]
        ]
    ];

    public $ProductIns = [
        'id_producto' => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required'   => '(Producto) es obligatorio',
                'is_natural_no_zero'    => '(Producto) solo acepta caracteres numéricos',
            ]
        ],
        'observacion'  => [
            'rules' => 'permit_empty|max_length[50]',
            'errors' => [
                'alpha_space' => '(Descripción) Solo acepta caracteres alfabéticos y espacios',
                'max_length'  => '(Descripción) Solo puede tener 50 caracteres como máximo',
            ]
        ],
        'cantidad'  => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => '(Stock) Es obligatorio',
                'is_natural_no_zero'  => '(Stock) Solo acepta datos numéricos',
            ]
        ],
        'Fllegada'  => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => '(Fecha de Llegada) Es obligatorio',
                'is_natural'  => '(Fecha de Llegada) Solo acepta datos numéricos',
            ]
        ],
        'Hllegada'  => [
            'rules' => 'required|valid_date[H:i]',
            'errors' => [
                'required' => '(Hora de llegada) Es obligatorio',
                'is_natural'  => '(Hora de llegada) Solo acepta fechas correctas',
            ]
        ],
        'proveedor'  => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => '(Proveedor) Es obligatorio',
                'is_natural_no_zero'  => '(Proveedor) Solo acepta caracteres válidos',
            ]
        ],
        'motivo'  => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => '(Motivo) Es obligatorio',
                'is_natural_no_zero'  => '(Motivo) Solo acepta caracteres válidos',
            ]
        ]
    ]; 

    //Guardar Producto
    public function doSaveProducto()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->Product);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request = \Config\Services::request();
            $codigo_producto = $request->getPostGet('codigo_producto');
            $descripcion = $request->getPostGet('descripcion');
            $unidad_medida = $request->getPostGet('unidad_medida');
            $stock = $request->getPostGet('stock');
            $stockMin = $request->getPostGet('stockMin');
            $Fllegada = $request->getPostGet('Fllegada');
            $Hllegada = $request->getPostGet('Hllegada');
            $proveedor = $request->getPostGet('proveedor');
            $user = $_SESSION['id_usuario'];
            $data = array($codigo_producto, $descripcion, $unidad_medida, $stock, $stockMin, $Fllegada, $Hllegada, $proveedor, $user);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, 'sp_producto_insert', '?,?,?,?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "¡Problemas al realizar la operación! ";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Guardar Detalles del Producto
    public function doSaveProductoDetalleINS()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->ProductIns);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request = \Config\Services::request();
            $id_producto = $request->getPostGet('id_producto');
            $observacion = $request->getPostGet('observacion');
            $motivo = $request->getPostGet('motivo');
            $cantidad = $request->getPostGet('cantidad');
            $Fllegada = $request->getPostGet('Fllegada');
            $Hllegada = $request->getPostGet('Hllegada');
            $proveedor = $request->getPostGet('proveedor');
            $user = $_SESSION['id_usuario'];
            $data = array($observacion, $motivo, $cantidad, $Fllegada, $Hllegada, $proveedor, $user, $id_producto);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, 'sp_producto_detalle_insert', '?,?,?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "¡Problemas al realizar la operación! ";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Eliminar Detalles del Producto
    public function doSaveProductoDetalleDROP()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate($this->ProductIns);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request = \Config\Services::request();
            $id_producto = $request->getPostGet('id_producto');
            $observacion = $request->getPostGet('observacion');
            $motivo = $request->getPostGet('motivo');
            $cantidad = $request->getPostGet('cantidad');
            $Fllegada = $request->getPostGet('Fllegada');
            $Hllegada = $request->getPostGet('Hllegada');
            $proveedor = $request->getPostGet('proveedor');
            $user = $_SESSION['id_usuario'];
            $data = array($observacion, $motivo, $cantidad, $Fllegada, $Hllegada, $proveedor, $user, $id_producto);
            $modelo = new clbM_administracion();
            if ($modelo->registrar($data, 'sp_producto_detalle_drop', '?,?,?,?,?,?,?,?')) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "¡Problemas al realizar la operación! ";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Buscar Material
    public function search_material()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'txt_buscarM' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '(ID Material) Es obligatorio.',
                ]
            ]
        ]);

        if (!$proceso) {
            //error
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $identif = $request->getPostGet('txt_buscarM');

            $data = array($identif);
            $modelo = new produccionModel();

            if ($modelo->search_data($data, 'sp_buscar_material', '?')) {
                //Recopilamos de la base de datos				
                $respuesta['error'] = "";
                $respuesta['datos'] = $modelo->search_data($data, 'sp_buscar_material', '?');
            } else {
                $respuesta['error'] = "";
                $respuesta['datos'] = $modelo->search_data($data, 'sp_buscar_material', '?');
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta, JSON_UNESCAPED_UNICODE));
    }
    //Buscar Proyecto
    public function search_proyecto()
    {
        $validation = \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'txt_buscarP' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '(ID Material) Es obligatorio.',
                ]
            ]
        ]);

        if (!$proceso) {
            //error
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request =  \Config\Services::request();
            $identif = $request->getPostGet('txt_buscarP');

            $data = array($identif);
            $modelo = new produccionModel();

            if ($modelo->search_data($data, 'sp_buscar_proyecto', '?')) {
                //Recopilamos de la base de datos				
                $respuesta['error'] = "";
                $respuesta['datos'] = $modelo->search_data($data, 'sp_buscar_proyecto', '?');
            } else {
                $respuesta['error'] = "";
                $respuesta['datos'] = $modelo->search_data($data, 'sp_buscar_proyecto', '?');
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta, JSON_UNESCAPED_UNICODE));
    }
    //Registrar Movimiento (Tabla PRoyecto-Material)
    public function registar_PM()
    {
        $validation =  \Config\Services::validation();
        $respuesta = array();
        $proceso = $this->validate([
            'result_P' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '(Código del Material) Es obligatorio.',
                ]
            ],

            'result_M' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '(Códido del Proyecto) Es obligatorio.',
                ]
            ],


            'cantidad' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '(Cantidad) Es Obligatoria.',
                ]
            ]
        ]);
        if (!$proceso) {
            $respuesta['error'] = $validation->listErrors();
        } else {
            $request = \Config\Services::request();
            $result_P = $request->getPostGet('result_P');
            $result_M = $request->getPostGet('result_M');
            $cantidad = $request->getPostGet('cantidad');
            $data = array($result_P, $result_M, $cantidad);
            $modelo = new produccionModel();
            if ($modelo->register_data($data, 'sp_registrar_PM', '?,?,?')) {
                $respuesta['error'] = "";
                //$respuesta['datos'] = $modelo->register_data($data, 'sp_registrar_PM', '?,?,?');
                $respuesta['ok'] = "Operación realizada";
            } else {
                $respuesta['error'] = "¡Problemas al realizar la operación! ";
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Listados del Producto
    public function doListProducto()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_producto_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListProductoINST()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_detalle_producto_inst_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }

    public function doListProductoDROP()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_detalle_producto_drop_list');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Carga del combo Producto
    public function doComboProducto()
    {
        $respuesta = array();
        $modelo = new clbM_administracion();
        $respuesta['datos'] = $modelo->listar('sp_producto_combo');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Resumen de Movimientos
    public function ResumenMovimientos()
    {
        $respuesta = array();
        $modelo = new produccionModel();
        $respuesta['datos'] = $modelo->listar_data('sp_resumen_movimientos');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Resumen del Proyecto
    public function ResumenProyectos()
    {
        $respuesta = array();
        $modelo = new produccionModel();
        $respuesta['datos'] = $modelo->listar_data('sp_resumen_proyectos');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
    //Listado del Movimiento (Tabla PRoyecto-Material)
    public function listar_PM()
    {
        $respuesta = array();
        $modelo = new produccionModel();
        $respuesta['datos'] = $modelo->listar_data('sp_listar_PM');
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($respuesta));
    }
}
