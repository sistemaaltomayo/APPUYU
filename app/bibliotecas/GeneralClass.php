<?php

namespace app\bibliotecas;
use DB,Hashids,Session,Redirect,PDO;

class GeneralClass {

	 public function getRangoFechas($fechainicio,$fechafin) {

		$arrayFechas=array();
		$fechaMostrar = $fechainicio;

		while(strtotime($fechaMostrar) <= strtotime($fechafin)) {
		$arrayFechas[]=$fechaMostrar;
		$fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 day"));
		}
		return $arrayFechas;
	}
	
	  public function getBaseXml() {

		$archivo = 'C:\Conexion\conexionmoviluyu.xml';
		if (file_exists($archivo)) {
		    $xml 		= simplexml_load_file($archivo);
			$json 		= json_encode($xml);
			$xmlarray 	= json_decode($json,TRUE);
		    return $xmlarray;
		}else{
		    return false;
		}
	  }


	  public function getIps() {


		$archivo = 'C:\Conexion\conexionmoviluyu.xml';
		if (file_exists($archivo)) {
		    $xml 		= simplexml_load_file($archivo);
			$json 		= json_encode($xml);
			$xmlarray 	= json_decode($json,TRUE);
		    return $xmlarray;
		}else{
		    return false;
		}


		
	  }


	  public function getUrl($idopcion) {

	  	//decodificar variable
	  	$decidopcion = Hashids::decode($idopcion);
	  	//ver si viene con letras la cadena codificada
	  	if(count($decidopcion)==0){
	  		return false;
	  	}

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($decidopcion[0], 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
	  	
	  	$prefijo = DB::table('GEN.ConfiguracionLocalZ')
		->join('GEN.Local', 'GEN.ConfiguracionLocalZ.idLocal', '=', 'GEN.Local.Id')
		->get();

		$idopcioncompleta = $prefijo[0]->PrefijoLocal.$idopcioncompleta;

	  	// ver si la opcion existe
	  	$opcion =  DB::table('GEN.OpcionZ')
	  	->where('Id', $idopcioncompleta)->first();



	  	if(count($opcion)>0){
	  		return true;
	  	}else{
	  		return false;
	  	}

	  }


	  public function getNombreOpcion($idopcion) {

	  	//decodificar variable
	  	$decidopcion = Hashids::decode($idopcion);
	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($decidopcion[0], 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
	  	$prefijo = DB::table('GEN.ConfiguracionLocalZ')
		->join('GEN.Local', 'GEN.ConfiguracionLocalZ.idLocal', '=', 'GEN.Local.Id')
		->get();
		$idopcioncompleta = $prefijo[0]->PrefijoLocal.$idopcioncompleta;

	  	// ver si la opcion existe
	  	$opcion =  DB::table('GEN.OpcionZ')
	  	->where('Id', $idopcioncompleta)->first();
	  	return $opcion->Nombre;

	  }




	  public function getIdOpcionCompleta($idopcion) {

	  	//decodificar variable
	  	$decidopcion = Hashids::decode($idopcion);
	  	//ver si viene con letras la cadena codificada
	  	if(count($decidopcion)==0){
	  		return false;
	  	}

	  	//concatenar con ceros
	  	$idopcioncompleta = str_pad($decidopcion[0], 12, "0", STR_PAD_LEFT); 
	  	//concatenar prefijo
	  	$prefijo = DB::table('GEN.ConfiguracionLocal')
		->join('GEN.Local', 'GEN.ConfiguracionLocal.idLocal', '=', 'GEN.Local.Id')
		->get();
		$idopcioncompleta = $prefijo[0]->PrefijoLocal.$idopcioncompleta;

	  	return $idopcioncompleta;


	  }


	  public function getDecodificar($id) {

	  		$id= Hashids::decode($id);
	  		$idopcioncompleta = str_pad($id[0], 12, "0", STR_PAD_LEFT); 
		  	//concatenar prefijo
		  	$prefijo = DB::table('GEN.ConfiguracionLocalZ')
			->join('GEN.Local', 'GEN.ConfiguracionLocalZ.idLocal', '=', 'GEN.Local.Id')
			->get();
			$idopcioncompleta = $prefijo[0]->PrefijoLocal.$idopcioncompleta;
	  		return $idopcioncompleta;
	  		
	  }


	  public function getCreateId($basedatos) {

	  		// maximo valor de la tabla referente
			$id = DB::table($basedatos)
            ->select(DB::raw('max(SUBSTRING(id,9,12)) as id'))
            ->get();

            //conversion a string y suma uno para el siguiente id
            $idsuma = (int)$id[0]->id + 1;

		  	//concatenar con ceros
		  	$idopcioncompleta = str_pad($idsuma, 12, "0", STR_PAD_LEFT); 
		  	//concatenar prefijo
		  	$prefijo = DB::table('GEN.ConfiguracionLocal')
			->join('GEN.Local', 'GEN.ConfiguracionLocal.idLocal', '=', 'Local.Id')
			->get();
			$idopcioncompleta = $prefijo[0]->PrefijoLocal.$idopcioncompleta;

	  		return $idopcioncompleta;

	  }


	  public function getCorrelativo($basedatos) {

	  		// maximo valor de la tabla referente
			$Correlativo = DB::table($basedatos)
            ->select(DB::raw('max(SUBSTRING(Correlativo,2,12)) as Correlativo'))
            ->get();

            //conversion a string y suma uno para el siguiente id
            $idsuma = (int)$Correlativo[0]->Correlativo + 1;

		  	//concatenar con ceros
		  	$correlativocompleta = str_pad($idsuma, 10, "0", STR_PAD_LEFT); 

	  		return $correlativocompleta;

	  }


	  public function getListaOpcionPlus($idopcion) {


	  		$deco = new GeneralClass();
	    	$idopcion = $deco->getDecodificar($idopcion);

			$listaMenu = Session::get('listaMenu');
			$idopcionrol = '';

			for( $i = 0 ; $i < count($listaMenu) ; $i ++){
				if($listaMenu[$i]->IdOpcion == $idopcion){
					$idopcionrol = $listaMenu[$i]->Id;
				}
			}

		  	$listaOpcionPlus = DB::table('GEN.RolOpcionPlusZ')
			->join('GEN.OpcionPlusZ', 'GEN.OpcionPlusZ.Id', '=', 'GEN.RolOpcionPlusZ.IdOpcionPlus')
			->where('GEN.RolOpcionPlusZ.IdRolOpcion','=',$idopcionrol)
			->select('GEN.RolOpcionPlusZ.Id','GEN.OpcionPlusZ.Nombre','GEN.OpcionPlusZ.Pagina')
			->get();

	  		return $listaOpcionPlus;
	  		
	  }


	  public function getPermisoPlus($idopcionrolplus) {


	  		$deco = new GeneralClass();
	    	$idopcionplus = $deco->getDecodificar($idopcionrolplus);

		  	$listaOpcionPlus = DB::table('GEN.RolOpcionPlusZ')
			->where('GEN.RolOpcionPlusZ.Id','=',$idopcionplus)
			->where('GEN.RolOpcionPlusZ.Activo','=',1)
			->get();

			return $listaOpcionPlus;

	  		
	  }



	  public function getMonitoreoUsuario($idopcion,$idusuario,$idlocal,$fechainicio,$fechafin,$periodo) {


	  		$monitoreo        =  new GeneralClass();
			$id 			  =  $monitoreo->getCreateId('GEN.MonitoreoUsuarioMovil'); 
			$idopcioncompleta =  $monitoreo->getIdOpcionCompleta($idopcion); 
			$fecha 			  = date("Ymd H:i:s");

			DB::table('GEN.MonitoreoUsuarioMovil')->insert(
			    ['Id' => $id, 'IdOpcion' => $idopcioncompleta, 'IdUsuario' => $idusuario, 'Activo' => 1, 'FechaCrea' => $fecha, 'IdLocal' => $idlocal, 'FechaInicio' => $fechainicio, 'FechaFin' => $fechafin, 'Periodo' => $periodo]
			);
 		
	  }
	  
	  public function getCreateIdInvictus($tabla) {

	  		$id="";
			$idlocalpre = DB::table('GEN.EquipoTablet')->select('GEN.EquipoTablet.Idlocal')->first();
			$prefijon = DB::table('GEN.local')
			->select('GEN.local.prefijolocal')
			->where('GEN.local.Id', '=', $idlocalpre->Idlocal)
			->first(); 
			$prefijo = $prefijon->prefijolocal;

			$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC GEN.AM_GeneraIDM ?,?,?');
	        $stmt->bindParam(1, $tabla ,PDO::PARAM_STR);
	        $stmt->bindParam(2, $prefijo ,PDO::PARAM_STR);   
	        $stmt->bindParam(3, $id ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
	        $stmt->execute();	

	  		return $id;

	  }



}

