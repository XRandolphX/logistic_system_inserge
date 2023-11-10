<?php

namespace App\Models;

use CodeIgniter\Model;

class produccionModel extends Model
{
    public function search_data($data, $Query, $Parametros)
    {
        $db = \Config\Database::connect();
        $sql = "CALL " . $Query . "(" . $Parametros . ")";
        $result = $db->query($sql, $data);
        $db->close();
        return $result->getResultArray();
    }

    public function listar_data($Query)
    {
        $db = \Config\Database::connect();
        $sql = "CALL " . $Query . "()";
        $result = $db->query($sql);
        $db->close();
        return $result->getResultArray();
    }

    public function register_data($data, $Query, $Parametros)
    {
        $db = \Config\Database::connect();
        $sql = "CALL " . $Query . "(" . $Parametros . ",@s)";
        $db->query($sql, $data);
        $res = $db->query('select @s as out_param');
        $db->close();
        return   $res->getRow()->out_param;
    }

    public function update_data($data, $Query, $Parametros)
    {
        $db = \Config\Database::connect();
        $sql = "CALL " . $Query . "(" . $Parametros . ",@s)";
        $db->query($sql, $data);
        $res = $db->query('select @s as out_param');
        $db->close();
        return   $res->getRow()->out_param;
    }
}
