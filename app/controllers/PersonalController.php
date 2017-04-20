<?php
use app\bibliotecas\GeneralClass;

class PersonalController extends BaseController
{



	/******************************* Personal ************************************/



	public function actionAgregarPersonalTerminoSolicitudAjax()
	{


		$generalclass        = new GeneralClass();
		$idsolicitud  	 	 = Input::get('idsolicitud');
		$nombre  	 	 	 = Input::get('nombre');
		$termino  	 	 	 = Input::get('termino');
		$dni  	 	 	 	 = Input::get('dni');
		$id 				 = $generalclass->getCreateIdInvictus('PER.SolicitudPersonal');

		$tPERSolicitudPersonal						= new PERSolicitudPersonal;
		$tPERSolicitudPersonal->Id 					= $id;
		$tPERSolicitudPersonal->IdSolicitud 		= $idsolicitud;
		$tPERSolicitudPersonal->Nombre				= $nombre;
		$tPERSolicitudPersonal->Dni 			    = $dni;
		$tPERSolicitudPersonal->Termino				= $termino;
		$tPERSolicitudPersonal->Completo			= 0;
		$tPERSolicitudPersonal->save();

	}	


	public function actionAgregarPersonalSolicitud($idOpcionRolPlus,$idSolicitud)
	{

		/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionRolPlus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Agregar Personal)');
		}

		$solicitud  				= PERSolicitud::where('Id','=',$idSolicitud)->first();

		$provincia  				= GENProvincia::where('Activo','=',1)->orderBy('Descripcion', 'asc')->lists('Descripcion', 'Id');
		$comboprovincia  			= array(0 => "Seleccione Provincia") + $provincia;

		/*$distrito  					= GENDistrito::where('Activo','=',1)->orderBy('Descripcion', 'asc')->lists('Descripcion', 'Id');
		$combodistrito  			= array(0 => "Seleccione Distrito") + $distrito;*/

		$gradoinstruccion  			= PERGradoInstruccion::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$combogradoinstruccion  	= array(0 => "Seleccione Grado Instrucción") + $gradoinstruccion;

		$estadocivil  				= PEREstadoCivil::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$comboestadocivil  			= array(0 => "Seleccione Estado Civil") + $estadocivil;




		return View::make('personal/agregarpersonalsolicitud',
		[
		 'idOpcionRolPlus' 			=> $idOpcionRolPlus,
		 'idSolicitud' 				=> $idSolicitud,
		 'solicitud' 				=> $solicitud,
		 'comboprovincia' 			=> $comboprovincia,
		 'combogradoinstruccion' 	=> $combogradoinstruccion,
		 'comboestadocivil' 		=> $comboestadocivil
		]);

	}	






    /**************************************** Solicitud Personal ************************************/

	public function actionListaSolicitudPersonal($idOpcion)
	{


		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}

		$idusuario = Session::get('Usuario')[0]->Id;

		$listaSolicitudPersonal = DB::table('PER.Solicitud')
		->join('GEN.Local', 'GEN.Local.Id', '=', 'PER.Solicitud.IdLocal')
		->join('PER.MotivoSolicitud', 'PER.MotivoSolicitud.Id', '=', 'PER.Solicitud.IdMotivoSolicitud')
		->join('SEG.TipoUsuario', 'SEG.TipoUsuario.Id', '=', 'PER.Solicitud.IdTipoUsuario')
		->join('tbUsuarioLocal', 'tbUsuarioLocal.Id', '=', 'PER.Solicitud.IdUsuarioCrea')
		->select('PER.Solicitud.Id','PER.Solicitud.Correlativo','GEN.Local.Nombre','PER.Solicitud.FechaCrea','PER.MotivoSolicitud.Nombre as MotivoSolicitud','SEG.TipoUsuario.Descripcion as Cargo','tbUsuarioLocal.Nombre as Nombreusuario','tbUsuarioLocal.Apellido as Apellidousuario')
   		->orderBy('PER.Solicitud.FechaCrea', 'desc')
   		->take(30)
	    ->get();

	    $listaOpcionPlus = $validarurl->getlistaOpcionPlus($idOpcion);

		return View::make('personal/listasolicitudpersonal',
						 [
						  'listaSolicitudPersonal'  	 => $listaSolicitudPersonal,
						  'listaOpcionPlus'	 			 => $listaOpcionPlus,
						  'idOpcion' 		 			 => $idOpcion
						  ]);
	}





	public function actionInsertarSolicitudPersonal($idOpcion)
	{

		if($_POST){

			try{

				DB::beginTransaction();

				$IdMotivoSolicitud 	= Input::get('motivosolicitud');
				$IdUsuario 			= Input::get('usuarior');
				$IdMotivoRemplazo 	= Input::get('motivoreemplazo');
				$Autorizacion 		= Input::get('autorizacion');
				$IdTipoUsuario 		= Input::get('tipousuario');
				$IdLocal 			= Input::get('local');
				$NumeroVacantes 	= Input::get('numerovacantes');
				$EdadInicio 		= Input::get('edadinicio');		
				$EdadFin 			= Input::get('edadfin');	
				$PerfilPuesto 		= Input::get('perfilpuesto');
				$FuncionesPuesto 	= Input::get('funcionpuesto');
				$HorariosTrabajo 	= Input::get('horatrabajo');			
				$Sueldo 			= Input::get('sueldo');
				$Observacion 		= Input::get('observacion');
				$IdUsuarioCrea 		= Session::get('Usuario')[0]->Id;
				$fecha 				= date("Ymd H:i:s");

				$clases 			= new GeneralClass();
		    	$id 				= $clases->getCreateIdInvictus('PER.Solicitud');
				$correlativo 		= $clases->getCorrelativo('PER.Solicitud'); 

				
				$tPERSolicitud						= new PERSolicitud;
				$tPERSolicitud->Id 					= $id;
				$tPERSolicitud->Correlativo 		= $correlativo;
				$tPERSolicitud->IdMotivoSolicitud	= $IdMotivoSolicitud;
				$tPERSolicitud->IdUsuario			= $IdUsuario;
				$tPERSolicitud->IdMotivoRemplazo	= $IdMotivoRemplazo;
				$tPERSolicitud->Autorizacion		= $Autorizacion;
				$tPERSolicitud->IdTipoUsuario		= $IdTipoUsuario;
				$tPERSolicitud->IdLocal				= $IdLocal;
				$tPERSolicitud->NumeroVacantes		= $NumeroVacantes;
				$tPERSolicitud->EdadInicio			= $EdadInicio;
				$tPERSolicitud->EdadFin				= $EdadFin;
				$tPERSolicitud->PerfilPuesto		= $PerfilPuesto;
				$tPERSolicitud->FuncionesPuesto		= $FuncionesPuesto;
				$tPERSolicitud->HorariosTrabajo		= $HorariosTrabajo;
				$tPERSolicitud->Sueldo				= $Sueldo;
				$tPERSolicitud->Observacion			= $Observacion;
				$tPERSolicitud->IdUsuarioCrea		= $IdUsuarioCrea;
				$tPERSolicitud->Activo 				= 1;
				$tPERSolicitud->Email 				= 0;
				$tPERSolicitud->EmailMod 			= 0;
				$tPERSolicitud->FechaCrea			= $fecha;
				$tPERSolicitud->save();

				DB::commit();


			}catch(Exception $ex){
				DB::rollback();
				return Redirect::to('/getion-solicitud-personal/'.$idOpcion)->with('alertaMensajeGlobalE', 'Ocurrio un error inesperado. Porfavor contacte con el administrador del sistema');	
			}


			/******************************************* Envio de Email *******************************************/


			$data = PERSolicitud::join('GEN.Local', 'GEN.Local.Id', '=', 'PER.Solicitud.IdLocal')
			->join('PER.MotivoSolicitud', 'PER.MotivoSolicitud.Id', '=', 'PER.Solicitud.IdMotivoSolicitud')
			->join('SEG.TipoUsuario', 'SEG.TipoUsuario.Id', '=', 'PER.Solicitud.IdTipoUsuario')
			->join('tbUsuarioLocal', 'tbUsuarioLocal.Id', '=', 'PER.Solicitud.IdUsuarioCrea')		
			->select('PER.Solicitud.Id','PER.Solicitud.IdUsuario','PER.Solicitud.IdMotivoRemplazo','PER.Solicitud.Correlativo','PER.MotivoSolicitud.Nombre as MotivoSolicitud','tbUsuarioLocal.Nombre as Nombreusuario','tbUsuarioLocal.Apellido as Apellidousuario','PER.Solicitud.Autorizacion','SEG.TipoUsuario.Descripcion as Cargo','GEN.Local.Nombre as NombreLocal','PER.Solicitud.NumeroVacantes','PER.Solicitud.EdadInicio','PER.Solicitud.EdadFin','PER.Solicitud.PerfilPuesto','PER.Solicitud.FuncionesPuesto','PER.Solicitud.HorariosTrabajo','PER.Solicitud.Sueldo','PER.Solicitud.Observacion','PER.Solicitud.FechaCrea','PER.Solicitud.IdUsuarioMod')
			->where('PER.Solicitud.Id','=',$id)
		    ->first();

		    $email = GENSmsEmail::where('GEN.SmsEmail.Id','=','LIM01CEN000000000002')->first(); 
			$asunto = $data->NombreLocal;
			$array = $data->toArray();

	        try {

				Mail::send('emails.solicitud', $array, function($message) use ($email,$asunto)
				{

					$emails = explode(",", $email->Correo); 
				    $message->from('sistemascoffe@altomayoretail.pe', $email->DescripcionEstado);
				    $message->to($emails);
				    $message->subject('SOLICITUD PERSONAL '.$asunto);

				});

				$tPERSolicitud            =	PERSolicitud::find($id); 
				$tPERSolicitud->Email 	  = 1;
				$tPERSolicitud->save();

	        } catch (Exception $e) {
				return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');
	        }

			return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');
			

		}else{


			$permiso=permisos($idOpcion,'Anadir');

			if($permiso==0){

				return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para añadir aquí');

			}else{

				$motivosolicitud = PERMotivoSolicitud::where('Activo','=',1)->lists('Nombre', 'Id');
				$combomotivosolicitud  = array(0 => "Seleccione Motivo Solicitud") + $motivosolicitud;

				$tipousuario= SEGTipoUsuario::where('Activo','=',1)
							  ->whereIn('Id', ['LIM01CEN000000000002','LIM01CEN000000000003'])
							  ->lists('Descripcion', 'Id');

				$combotipousuario  = array(0 => "Seleccione Cargo") + $tipousuario;


				$local= GENLocal::join('GEN.LocalMovil', 'GEN.Local.Id', '=', 'GEN.LocalMovil.IdLocal')
							  ->where('GEN.LocalMovil.Activo','=',1)
							  ->where('GEN.LocalMovil.IdLocal','!=','LIM01CEN000000000000')
							  ->select('GEN.Local.Id','GEN.Local.Nombre')
							  ->lists('Nombre', 'Id');
				$combolocal  = array(0 => "Seleccione Area") + $local;


				$usuarior = tbUsuarioLocal::select(DB::raw("Id , Apellido + ' ' + Nombre as Nombre "))
							->orderBy('Nombre', 'asc')
							->whereIn('IdTipoUsuario', ['LIM01CEN000000000002','LIM01CEN000000000003'])
							->lists('Nombre', 'Id');

				$combousuarior  = array(0 => "Seleccione Personal de Remplazo") + $usuarior;

				$motivoreemplazo = PERMotivoReemplazo::where('Activo','=',1)->lists('Nombre', 'Id');
				$combomotivoreemplazo  = array(0 => "Seleccione Motivo Reemplazo") + $motivoreemplazo;



		        return View::make('personal/insertarsolicitudpersonal', 
						[
						 	'idOpcion' 		 		=> $idOpcion,
						 	'combomotivosolicitud' 	=> $combomotivosolicitud,
						 	'combomotivoreemplazo' 	=> $combomotivoreemplazo,
						 	'combotipousuario' 		=> $combotipousuario,
						 	'combolocal' 			=> $combolocal,
						 	'combousuarior' 		=> $combousuarior,
						]);
			}
		}
	}	


	public function actionModificarSolicitudPersonal($idOpcion,$idSolicitud)
	{


		if($_POST)
		{

			try{

				DB::beginTransaction();

				$IdMotivoSolicitud 	= Input::get('motivosolicitud');
				$IdUsuario 			= Input::get('usuarior');
				$IdMotivoRemplazo 	= Input::get('motivoreemplazo');
				$Autorizacion 		= Input::get('autorizacion');
				$IdTipoUsuario 		= Input::get('tipousuario');
				$IdLocal 			= Input::get('local');
				$NumeroVacantes 	= Input::get('numerovacantes');
				$EdadInicio 		= Input::get('edadinicio');		
				$EdadFin 			= Input::get('edadfin');	
				$PerfilPuesto 		= Input::get('perfilpuesto');
				$FuncionesPuesto 	= Input::get('funcionpuesto');
				$HorariosTrabajo 	= Input::get('horatrabajo');			
				$Sueldo 			= Input::get('sueldo');
				$Observacion 		= Input::get('observacion');
				$IdUsuarioMod 		= Session::get('Usuario')[0]->Id;
	
				$tPERSolicitud						= PERSolicitud::find($idSolicitud);
				$tPERSolicitud->IdMotivoSolicitud	= $IdMotivoSolicitud;
				$tPERSolicitud->IdUsuario			= $IdUsuario;
				$tPERSolicitud->IdMotivoRemplazo	= $IdMotivoRemplazo;
				$tPERSolicitud->Autorizacion		= $Autorizacion;
				$tPERSolicitud->IdTipoUsuario		= $IdTipoUsuario;
				$tPERSolicitud->IdLocal				= $IdLocal;
				$tPERSolicitud->NumeroVacantes		= $NumeroVacantes;
				$tPERSolicitud->EdadInicio			= $EdadInicio;
				$tPERSolicitud->EdadFin				= $EdadFin;
				$tPERSolicitud->PerfilPuesto		= $PerfilPuesto;
				$tPERSolicitud->FuncionesPuesto		= $FuncionesPuesto;
				$tPERSolicitud->HorariosTrabajo		= $HorariosTrabajo;
				$tPERSolicitud->Sueldo				= $Sueldo;
				$tPERSolicitud->Observacion			= $Observacion;
				$tPERSolicitud->IdUsuarioMod		= $IdUsuarioMod;
				$tPERSolicitud->save();

				DB::commit();


			}catch(Exception $ex){
				DB::rollback();
				return Redirect::to('/getion-solicitud-personal/'.$idOpcion)->with('alertaMensajeGlobalE', 'Ocurrio un error inesperado. Porfavor contacte con el administrador del sistema');	
			}



			/******************************************* Envio de Email *******************************************/


			$data = PERSolicitud::join('GEN.Local', 'GEN.Local.Id', '=', 'PER.Solicitud.IdLocal')
			->join('PER.MotivoSolicitud', 'PER.MotivoSolicitud.Id', '=', 'PER.Solicitud.IdMotivoSolicitud')
			->join('SEG.TipoUsuario', 'SEG.TipoUsuario.Id', '=', 'PER.Solicitud.IdTipoUsuario')
			->join('tbUsuarioLocal', 'tbUsuarioLocal.Id', '=', 'PER.Solicitud.IdUsuarioCrea')		
			->select('PER.Solicitud.Id','PER.Solicitud.IdUsuario','PER.Solicitud.IdMotivoRemplazo','PER.Solicitud.Correlativo','PER.MotivoSolicitud.Nombre as MotivoSolicitud','tbUsuarioLocal.Nombre as Nombreusuario','tbUsuarioLocal.Apellido as Apellidousuario','PER.Solicitud.Autorizacion','SEG.TipoUsuario.Descripcion as Cargo','GEN.Local.Nombre as NombreLocal','PER.Solicitud.NumeroVacantes','PER.Solicitud.EdadInicio','PER.Solicitud.EdadFin','PER.Solicitud.PerfilPuesto','PER.Solicitud.FuncionesPuesto','PER.Solicitud.HorariosTrabajo','PER.Solicitud.Sueldo','PER.Solicitud.Observacion','PER.Solicitud.FechaCrea','PER.Solicitud.IdUsuarioMod')
			->where('PER.Solicitud.Id','=',$idSolicitud)
		    ->first();

		    $email = GENSmsEmail::where('GEN.SmsEmail.Id','=','LIM01CEN000000000002')->first(); 
			$asunto = $data->NombreLocal;
			$array = $data->toArray();

	        try {

				Mail::send('emails.solicitud', $array, function($message) use ($email,$asunto)
				{

					$emails = explode(",", $email->Correo); 
				    $message->from('sistemascoffe@altomayoretail.pe', $email->DescripcionEstado);
				    $message->to($emails);
				    $message->subject('SOLICITUD PERSONAL '.$asunto);

				});

				$tPERSolicitud            	=	PERSolicitud::find($idSolicitud); 
				$tPERSolicitud->EmailMod 	= 1;
				$tPERSolicitud->save();

	        } catch (Exception $e) {
				return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Modificación Exitosa');
	        }
			return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Modificación Exitosa');


		}else{

			$permiso=permisos($idOpcion,'Modificar');

			if($permiso==0){

				return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para Modificar aquí');

			}else{



				$persolicitud 			= PERSolicitud::where('PER.Solicitud.Id','=',$idSolicitud)->first();



				$motivosolicitud 		= PERMotivoSolicitud::where('Id','<>',$persolicitud->IdMotivoSolicitud)
								          ->where('Activo','=',1)
								          ->lists('Nombre', 'Id');
				$selectmotivosolicitud  = PERMotivoSolicitud::where('Id','=',$persolicitud->IdMotivoSolicitud)
								          ->first();
				$combomotivosolicitud   = array($selectmotivosolicitud->Id => $selectmotivosolicitud->Nombre) + $motivosolicitud;

				$selectusuario			= tbUsuarioLocal::where('Id','=',$persolicitud->IdUsuario)
								          ->first();		          
				if(count($selectusuario) > 0){

					$usuarior 				= tbUsuarioLocal::select(DB::raw("Id , Apellido + ' ' + Nombre as Nombre "))
											   ->orderBy('Nombre', 'asc')
											   ->whereIn('IdTipoUsuario', ['LIM01CEN000000000002','LIM01CEN000000000003'])
											   ->where('Id','<>',$persolicitud->IdUsuario)
											   ->lists('Nombre', 'Id');
					$combousuarior  	= array($selectusuario->Id => $selectusuario->Nombre.' '.$selectusuario->Apellido ,0 => "Seleccione Personal de Remplazo") + $usuarior;

				}else{

					$usuarior 				= tbUsuarioLocal::select(DB::raw("Id , Apellido + ' ' + Nombre as Nombre "))
											   ->orderBy('Nombre', 'asc')
											   ->whereIn('IdTipoUsuario', ['LIM01CEN000000000002','LIM01CEN000000000003'])
											   ->lists('Nombre', 'Id');
					$combousuarior  = array(0 => "Seleccione Personal de Remplazo") + $usuarior;
				}

				$selectmotivoreemplazo  = PERMotivoReemplazo::where('Id','=',$persolicitud->IdMotivoRemplazo)
								          ->first();

				if(count($selectmotivoreemplazo) > 0){
					$motivoreemplazo 		= PERMotivoReemplazo::where('Id','<>',$persolicitud->IdMotivoRemplazo)
											  ->where('Activo','=',1)->lists('Nombre', 'Id');
					$combomotivoreemplazo  = array($selectmotivoreemplazo->Id => $selectmotivoreemplazo->Nombre,0 => "Seleccione Motivo Reemplazo") + $motivoreemplazo;

				}else{
					$motivoreemplazo 		= PERMotivoReemplazo::where('Activo','=',1)->lists('Nombre', 'Id');
					$combomotivoreemplazo  = array(0 => "Seleccione Motivo Reemplazo") + $motivoreemplazo;
				}


				$tipousuario 			= SEGTipoUsuario::where('Activo','=',1)
											->where('Id','<>',$persolicitud->IdTipoUsuario)
											->whereIn('Id', ['LIM01CEN000000000002','LIM01CEN000000000003'])
											->lists('Descripcion', 'Id');
				$selecttipousuario  	= SEGTipoUsuario::where('Id','=',$persolicitud->IdTipoUsuario)
								          ->first();											
				$combotipousuario  = array($selecttipousuario->Id => $selecttipousuario->Descripcion) + $tipousuario;


				$local= GENLocal::join('GEN.LocalMovil', 'GEN.Local.Id', '=', 'GEN.LocalMovil.IdLocal')
							  ->where('GEN.LocalMovil.Activo','=',1)
							  ->where('GEN.LocalMovil.IdLocal','<>',$persolicitud->IdLocal)
							  ->where('GEN.LocalMovil.IdLocal','!=','LIM01CEN000000000000')
							  ->select('GEN.Local.Id','GEN.Local.Nombre')
							  ->lists('Nombre', 'Id');

				$selectlocal 	= GENLocal::where('Id','=',$persolicitud->IdLocal)
								          ->first();

				$combolocal  = array($selectlocal->Id => $selectlocal->Descripcion) + $local;




				/*






*/


				/*$Usuario = DB::table('Usuario')->where('Id', $idUsuario)->get();

				$RolSeleccionado = DB::table('Rol')->where('Id', $Usuario[0]->IdRol)->get();

				$Rol = Rol::where('Id','<>','PLCHICLA000000000001')->lists('Nombre','Id');

				$comborol = array($RolSeleccionado[0]->Id => $RolSeleccionado[0]->Nombre) + $Rol;
				$selectedrol = array();*/



		        return View::make('personal/modificarsolicitudpersonal', 
		        				[
		        					'idOpcion' 		 		=> $idOpcion,
		        					'persolicitud' 		 	=> $persolicitud,
		        					'combomotivosolicitud' 	=> $combomotivosolicitud,
		        					'combousuarior' 		=> $combousuarior,
		        					'combomotivoreemplazo' 	=> $combomotivoreemplazo,
		        					'combotipousuario' 		=> $combotipousuario,
		        					'combolocal' 			=> $combolocal,		
		        				]);
		
			}

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