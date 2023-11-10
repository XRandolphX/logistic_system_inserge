<?php

namespace App\Models;
use CodeIgniter\Model;

class clbM_administracion extends Model{

	public function listar($Query){
		$db = \Config\Database::connect();
		$sql = "CALL ".$Query."()";
		$result=$db->query($sql);
		$db->close();
		return $result->getResultArray(); 
	}

	public function registrar($data, $Query, $Parametros){
		$db = \Config\Database::connect();
		$sql = "CALL ".$Query."(".$Parametros.",@s)";
		$db->query($sql,$data);
		$res =$db->query('select @s as out_param');
		$db->close();
    	return   $res->getRow()->out_param; 
	}

    public function editar($data, $Query, $Parametros){ //Aun falta probar
		$db = \Config\Database::connect();
		$sql = "CALL ".$Query."(".$Parametros.",@s)";
		$db->query($sql,$data);
		$res =$db->query('select @s as out_param');
		$db->close();
    	return   $res->getRow()->out_param; 
	}

    public function consultar($Query,$data){  //Aun falta probar
		$db = \Config\Database::connect();
		$sql = "CALL ".$Query."('$data')";
		$result=$db->query($sql);
		$db->close();
		return $result->getResultArray(); 
	}

	public function consultaMultiple($data, $Query, $Parametros){  //Aun falta probar
		$db = \Config\Database::connect();
		$sql = "CALL ".$Query."($Parametros)";
		$result=$db->query($sql,$data);
		$db->close();
		return $result->getResultArray(); 
	}


}