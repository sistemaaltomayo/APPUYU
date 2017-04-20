<?php
use app\bibliotecas\GeneralClass;
class InspeccionController extends BaseController
{

	public function actionCheckList($idOpcion)
	{


		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}


		$InspeccionesAgrupados = DB::table('GEN.LocalInspeccion')
								  ->join('GEN.TipoInspeccion', 'GEN.LocalInspeccion.IdTipoInspeccion', '=', 'GEN.TipoInspeccion.Id')
								  ->join('GEN.LocalMovil', 'GEN.LocalInspeccion.IdLocalMovil', '=', 'GEN.LocalMovil.Id')
								  ->groupBy('GEN.LocalInspeccion.Codigo')
								  ->groupBy('GEN.LocalInspeccion.FechaCrea')
								  ->groupBy('GEN.TipoInspeccion.Descripcion')
								  ->groupBy('GEN.LocalMovil.Zona')
								  ->select('GEN.LocalInspeccion.Codigo','GEN.LocalInspeccion.FechaCrea',
								  		   'GEN.TipoInspeccion.Descripcion','GEN.LocalMovil.Zona')
								  ->orderBy('GEN.LocalInspeccion.FechaCrea', 'desc')
								  ->take(30)
								  ->get();

		$AreasInspecciones 		= DB::table('GEN.LocalInspeccion')
								  ->join('GEN.AreaInspeccion', 'GEN.LocalInspeccion.IdAreaInspeccion', '=', 'GEN.AreaInspeccion.Id')
								  ->select('GEN.LocalInspeccion.Codigo','GEN.AreaInspeccion.Descripcion',
								  		   'GEN.LocalInspeccion.Id','GEN.LocalInspeccion.Estado')
								  ->orderBy('GEN.LocalInspeccion.IdAreaInspeccion', 'asc')
								  ->get();


		return View::make('inspeccion/listachecklist',
        					[
							 'InspeccionesAgrupados' => $InspeccionesAgrupados,
							 'AreasInspecciones' 	 => $AreasInspecciones,
							 'idOpcion' 			 => $idOpcion,
							]
						 );


	}	



	public function actionAgregarCheckList($idOpcion)
	{

		if($_POST){


			$idusuario 				= Session::get('Usuario')[0]->Id;
			$fecha 			  		= date("Ymd H:i:s");
			$IdTipoInspeccion 	    = Input::get('tipoinspeccion');
			$localMovil       		= GENLocalMovil::where('Activo','=','1')->select('Id','IdAreaInspeccion','Idlocal')->orderBy('Id', 'asc')->get();
			$TablaLocalInspeccion   = 'GEN.LocalInspeccion';
			$TablaLocalInspeccionPregunta   = 'GEN.LocalInspeccionPregunta';
			$abreviaturalocal = '';
			


			/********************************* Creacion de CODIGO ************************************/
			$Codigo 				= GENLocalInspeccion::select(DB::raw('max(Codigo) as Codigo'))->get();
			if(count($Codigo)>0){
				$maxcodigo = $Codigo[0]->Codigo;
			}else{
				$maxcodigo = 0;
			}

            $idsuma = (int)$maxcodigo + 1;
		  	$correlativocompleta = str_pad($idsuma, 8, "0", STR_PAD_LEFT); 
		  	/*****************************************************************************************/


			foreach($localMovil as $item){


				/******************* Prefijo de los locales ****************/
				$listaprefijo 	 = GENLocal::whereId($item->Idlocal)->first();
				if($listaprefijo != ''){
					$prefijo = $listaprefijo->PrefijoLocal;
				}else{
					$prefijo = 'AL'.substr($prefijo, 2, strlen($prefijo)-2);
				}
				/***********************************************************/

				$IdLocalInspeccion="";
				$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC GEN.AM_GeneraIDM ?,?,?');
		        $stmt->bindParam(1, $TablaLocalInspeccion ,PDO::PARAM_STR);
		        $stmt->bindParam(2, $prefijo ,PDO::PARAM_STR);   
		        $stmt->bindParam(3, $IdLocalInspeccion ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
		        $stmt->execute();


				$localInpeccion   		= GENTATLInspeccion::where('Activo','=','1')->where('IdAreaInspeccion','=', $item->IdAreaInspeccion)
										  ->where('IdTipoInspeccion','=', $IdTipoInspeccion)->get();				  
				$IdTATLInspeccion 		= $localInpeccion->lists('Id');
				$localPreguntaInpeccion = DB::table('GEN.TATLPDetalleInspeccion')
										  ->join('GEN.DetallePreguntaInspeccion', 'GEN.TATLPDetalleInspeccion.IdDetallePreguntaInspeccion', '=', 'GEN.DetallePreguntaInspeccion.Id')
										  ->where('GEN.TATLPDetalleInspeccion.Activo','=','1')
										   ->where('GEN.DetallePreguntaInspeccion.Activo','=','1')
										  ->whereIn('IdTATLInspeccion', $IdTATLInspeccion)
										  ->select('GEN.TATLPDetalleInspeccion.Id','GEN.TATLPDetalleInspeccion.IdTATLInspeccion',
										  		   'GEN.TATLPDetalleInspeccion.IdDetallePreguntaInspeccion','GEN.DetallePreguntaInspeccion.Puntaje')
										  ->get();


		        $tLocalInspeccion            		=	new GENLocalInspeccion;
				$tLocalInspeccion->Id 	 	  		= 	$IdLocalInspeccion;
				$tLocalInspeccion->IdLocalMovil 	= 	$item->Id;
				$tLocalInspeccion->IdAreaInspeccion = 	$item->IdAreaInspeccion;
				$tLocalInspeccion->IdTipoInspeccion = 	$IdTipoInspeccion;
				$tLocalInspeccion->Codigo 			= 	$correlativocompleta;
				$tLocalInspeccion->Estado 			= 	'A';
				$tLocalInspeccion->Activo 	 		=   1;
				$tLocalInspeccion->IdUsuarioCrea 	=   $idusuario;
				$tLocalInspeccion->FechaCrea 		= 	$fecha;
				$tLocalInspeccion->save();



				foreach($localPreguntaInpeccion as $itemd){


					$IdLocalInspeccionPregunta="";
					$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC GEN.AM_GeneraIDM ?,?,?');
			        $stmt->bindParam(1, $TablaLocalInspeccionPregunta ,PDO::PARAM_STR);
			        $stmt->bindParam(2, $prefijo ,PDO::PARAM_STR);   
			        $stmt->bindParam(3, $IdLocalInspeccionPregunta ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
			        $stmt->execute();

			        $tLocalInspeccionPregunta            				=	new GENLocalInspeccionPregunta;
					$tLocalInspeccionPregunta->Id 	 	  				= 	$IdLocalInspeccionPregunta;
					$tLocalInspeccionPregunta->IdLocalInspeccion 		= 	$IdLocalInspeccion;
					$tLocalInspeccionPregunta->IdTATLPDetalleInspeccion = 	$itemd->Id;
					$tLocalInspeccionPregunta->Puntaje 					= 	$itemd->Puntaje;
					$tLocalInspeccionPregunta->PuntajeSeleccionado 	 	=   0;
					$tLocalInspeccionPregunta->save();

				}	

			}	
			return Redirect::to('/getion-check-list/'.$idOpcion)->with('alertaMensajeGlobal', 'Inspección Creada con Exito');

		}else{


		    $tipoinspeccion    		=   GENTipoInspeccion::lists('Descripcion','Id');
			$combotipoinspeccion  	=   $tipoinspeccion;
			$zonaactivo    			=   GENLocalMovil::where('Activo','=','1')->lists('Descripcion');
			$zonaactivo 			= 	implode(" / ", $zonaactivo);

	        return View::make('inspeccion/agregarchecklist',
	        					[
								 'combotipoinspeccion' 	=> $combotipoinspeccion,
								 'zonaactivo' 			=> $zonaactivo,
								 'idOpcion' 			=> $idOpcion,

								]);

		}
		
	}	




	public function actionDetalleCheckList($idlocalinspeccion,$codigo,$idOpcion)
	{


		$listaarea  = GENLocalInspeccion::join('GEN.AreaInspeccion', 'GEN.LocalInspeccion.IdAreaInspeccion', '=', 'GEN.AreaInspeccion.Id')
						  ->where('GEN.LocalInspeccion.Id','=',$idlocalinspeccion)->first();


		$groupTituloInspeccion = GENLocalInspeccionPregunta::join('GEN.TATLPDetalleInspeccion', 'GEN.TATLPDetalleInspeccion.Id', '=', 'GEN.LocalInspeccionPregunta.IdTATLPDetalleInspeccion')
			  ->join('GEN.TATLInspeccion', 'GEN.TATLInspeccion.Id', '=', 'GEN.TATLPDetalleInspeccion.IdTATLInspeccion')
			  ->where('GEN.LocalInspeccionPregunta.IdLocalInspeccion','=',$idlocalinspeccion)
			  ->select('GEN.TATLInspeccion.IdTituloInspeccion')
			  ->groupBy('GEN.TATLInspeccion.IdTituloInspeccion')
			  ->lists('IdTituloInspeccion');


		$listaLugarInspeccion = GENLocalInspeccionPregunta::join('GEN.TATLPDetalleInspeccion', 'GEN.TATLPDetalleInspeccion.Id', '=', 'GEN.LocalInspeccionPregunta.IdTATLPDetalleInspeccion')
		  ->join('GEN.TATLInspeccion', 'GEN.TATLInspeccion.Id', '=', 'GEN.TATLPDetalleInspeccion.IdTATLInspeccion')
		  ->join('GEN.LugarInspeccion', 'GEN.LugarInspeccion.Id', '=', 'GEN.TATLInspeccion.IdLugarInspeccion')
		  ->where('GEN.LocalInspeccionPregunta.IdLocalInspeccion','=',$idlocalinspeccion)
		  ->select('GEN.TATLInspeccion.IdTituloInspeccion','GEN.TATLInspeccion.IdLugarInspeccion','GEN.LugarInspeccion.Descripcion')
		  ->groupBy('GEN.TATLInspeccion.IdTituloInspeccion')
		  ->groupBy('GEN.TATLInspeccion.IdLugarInspeccion')
		  ->groupBy('GEN.LugarInspeccion.Descripcion')
		  ->orderBy('GEN.TATLInspeccion.IdTituloInspeccion', 'asc')
		  ->orderBy('GEN.TATLInspeccion.IdLugarInspeccion', 'asc')
		  ->get();		  


		$localPreguntaInspeccion = GENLocalInspeccionPregunta::join('GEN.TATLPDetalleInspeccion', 'GEN.TATLPDetalleInspeccion.Id', '=', 'GEN.LocalInspeccionPregunta.IdTATLPDetalleInspeccion')
			->join('GEN.TATLInspeccion', 'GEN.TATLInspeccion.Id', '=', 'GEN.TATLPDetalleInspeccion.IdTATLInspeccion')
			->join('GEN.DetallePreguntaInspeccion', 'GEN.DetallePreguntaInspeccion.Id', '=', 'GEN.TATLPDetalleInspeccion.IdDetallePreguntaInspeccion')
			->join('GEN.PreguntaInspeccion', 'GEN.PreguntaInspeccion.Id', '=', 'GEN.DetallePreguntaInspeccion.IdPreguntaInspeccion')
			->select('GEN.TATLInspeccion.IdTituloInspeccion','GEN.TATLInspeccion.IdLugarInspeccion',
				'GEN.LocalInspeccionPregunta.Id','GEN.LocalInspeccionPregunta.Puntaje','GEN.LocalInspeccionPregunta.PuntajeSeleccionado','GEN.LocalInspeccionPregunta.Observacion',
				'GEN.PreguntaInspeccion.Id as IdPregunta','GEN.DetallePreguntaInspeccion.Descripcion as DetallePregunta',
				'GEN.PreguntaInspeccion.Descripcion as Pregunta','GEN.PreguntaInspeccion.Cantidad')
			->where('GEN.LocalInspeccionPregunta.IdLocalInspeccion','=',$idlocalinspeccion)
			->orderBy('GEN.TATLInspeccion.IdTituloInspeccion', 'asc')
			->orderBy('GEN.TATLInspeccion.IdLugarInspeccion', 'asc')
			->orderBy('GEN.PreguntaInspeccion.Id', 'asc')
			->get();



		$listaTituloInspeccion = GENTituloInspeccion::where('Activo','=','1')
								 ->orderBy('Id', 'asc')
								 ->whereIn('Id', $groupTituloInspeccion)
								 ->get();						  

		if($listaarea->Estado=='A'){						 

	        return View::make('inspeccion/listadetallelist',
						[
						 'listaarea'  				 => $listaarea,
						 'listaTituloInspeccion'  	 => $listaTituloInspeccion,
						 'listaLugarInspeccion'   	 => $listaLugarInspeccion, 
						 'localPreguntaInspeccion' 	 => $localPreguntaInspeccion,
						 'idlocalinspeccion'		 => $idlocalinspeccion,
						 'idOpcion'		 			 => $idOpcion,
						]);


		}else{

	        return View::make('inspeccion/reportedetallelist',
			[
			 'listaarea'  				 => $listaarea,
			 'listaTituloInspeccion'  	 => $listaTituloInspeccion,
			 'listaLugarInspeccion'   	 => $listaLugarInspeccion, 
			 'localPreguntaInspeccion' 	 => $localPreguntaInspeccion,
			 'idlocalinspeccion'		 => $idlocalinspeccion,
			]);


		}

	}	

	public function actionajaxListarCheckList($idOpcion)
	{
		return Redirect::to('/getion-check-list/'.$idOpcion)->with('alertaMensajeGlobal', 'Inspección realizada correctamente');
		
	}	


	public function actionajaxAgregarCheckList()
	{

		$xml 	    		= Input::get('xml');
		$idlocalinspeccion 	= Input::get('idlocalinspeccion');
		$idusuario 			= Session::get('Usuario')[0]->Id;

        $tLocalInspeccion            		=	GENLocalInspeccion::find($idlocalinspeccion);
		$tLocalInspeccion->Estado 			= 	'C';
		$tLocalInspeccion->IdUsuarioMod 	=   $idusuario;
		$tLocalInspeccion->save();

		$arrayinspecciones    = explode("(&&&)", $xml);

		for ($i = 0 ; $i < count($arrayinspecciones)-1 ; $i ++) {

			$arraypregunta    								 =  explode("(***)", $arrayinspecciones[$i]);
			$tLocalInspeccionPregunta     		 			 =	GENLocalInspeccionPregunta::find($arraypregunta[0]);
			$tLocalInspeccionPregunta->PuntajeSeleccionado 	 =  (int)$arraypregunta[1]; 
			$tLocalInspeccionPregunta->Observacion 	 		 =  $arraypregunta[2]; 
			$tLocalInspeccionPregunta->save();	

		}

	
	}	



}
	function permisos($idOpcion,$accion){

		$deco = new GeneralClass();
    	$id = $deco->getDecodificar($idOpcion);

		$listaMenu = Session::get('listaMenu');
		$result = 0;

		for( $i = 0 ; $i < count($listaMenu) ; $i ++){
			if($listaMenu[$i]->IdOpcion == $id && $listaMenu[$i]->$accion == 1){
				$result = 1;
			}
		}
		return $result;

	}
?>