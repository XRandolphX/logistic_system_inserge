<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    public function verificar($data)
    {
        $db = \Config\Database::connect();
        $sql = "CALL sp_acceso_validar(?)";
        $result = $db->query($sql, $data);
        $db->close();
        return $result->getRow();
        //return $result->getResultArray();
    }

    public function validar($data)
    {
        $db = \Config\Database::connect();
        $sql = "CALL validar_contrasenia(?)";
        $result = $db->query($sql, $data);
        $db->close();
        return $result->getRow();
    }

    public function listarAll()
    {
        $db = \Config\Database::connect();
        $sql = "CALL sp_acceso_validar_respuesta()";
        $result = $db->query($sql);
        $db->close();
        return $result->getResultArray();
    }

    public function UpdateAcceso($data)
    {
        $db = \Config\Database::connect();
        $sql = "CALL sp_acceso_usuario(?,@s)";
        $db->query($sql, $data);
        $res = $db->query('select @s as out_param');
        $db->close();
        return $res->getRow()->out_param;
    }

    public function UpdateCierreAcceso($data)
    {
        $db = \Config\Database::connect();
        $sql = "CALL sp_cerrar_usuario(?,@s)";
        $db->query($sql, $data);
        $res = $db->query('select @s as out_param');
        $db->close();
        return $res->getRow()->out_param;
    }
}
