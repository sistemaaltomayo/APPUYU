<?php
use app\bibliotecas\GeneralClass;

class EncuestaController extends BaseController
{


	public function actionLibroReclamaciones($idOpcion)
	{

		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}


		$listaReclamaciones = DB::table('GEN.LibroReclamaciones')
		->join('GEN.Local', 'GEN.LibroReclamaciones.IdLocal', '=', 'GEN.Local.Id')
		->select('GEN.LibroReclamaciones.*','GEN.Local.Descripcion as NombreLocal')
   		->orderBy('GEN.LibroReclamaciones.FechaCrea', 'desc')
   		->take(30)
	    ->get();


		return View::make('encuesta/listalibroreclamaciones',
		[
		 	'idOpcion' 		 =>  $idOpcion,
		 	'listaReclamaciones'  =>  $listaReclamaciones
		]);

	}


	public function actionAgregarReclamaciones($idOpcion)
	{


		$localmovil  	= GENLocalMovil::where('Activo','=',1)->where('IdLocal','!=','LIM01CEN000000000000')->lists('Descripcion', 'IdLocal');
		$combolocal  	= array(0 => "Seleccione Sede") + $localmovil;
		$combobiencontratado  	= array(0 => "Seleccione Bien Contratado",'PRODUCTO' => "PRODUCTO",'SERVICIO' => "SERVICIO");
		$comboreclamo  	= array(0 => "Seleccione Reclamo",'RECLAMACION' => "RECLAMACION",'QUEJA' => "QUEJA");



		return View::make('encuesta/agregarreclamaciones',
						  [
						   'idOpcion'   => $idOpcion,
						   'combolocal' => $combolocal,
						   'combobiencontratado' => $combobiencontratado,
						   'comboreclamo' => $comboreclamo,
						  ]
						 );
	}

	

	public function actionRegistrarLibroReclamaciones($idOpcion)
	{

		if($_POST){



				$local 				= Input::get('local');
				$fecha 				= Input::get('fecha'); //(string)date_format(date_create(Input::get('fecha')), 'Y-m-d');

				$numeroreclamacion 	= Input::get('numeroreclamacion');

				$nombres 			= Input::get('nombres');
				$dnice 				= Input::get('dnice');
				$domicilio 			= Input::get('domicilio');
				$telefono 			= Input::get('telefono');
				$email 				= Input::get('email');		
				$padresmadre 		= Input::get('padresmadre');

				$biencontratado 	= Input::get('biencontratado');
				$montoreclamado 	= Input::get('montoreclamado');
				$descripcionbien 	= Input::get('descripcionbien');

				$reclamacionqueja 	= Input::get('reclamacionqueja');
				$descripcionreque 	= Input::get('descripcionreque');

				$descripcionadop 	= Input::get('descripcionadop');

				$IdUsuarioCrea 		= Session::get('Usuario')[0]->Id;
				$fechacrea 			= date("Y-m-d H:i:s");

				


				$clases 			= new GeneralClass();
		    	$id 				= $clases->getCreateIdInvictus('GEN.LibroReclamaciones');


				
				$tGENLibroReclamaciones						= new GENLibroReclamaciones;
				$tGENLibroReclamaciones->Id 				= $id;
				$tGENLibroReclamaciones->IdLocal 			= $local;
				$tGENLibroReclamaciones->Fecha				= $fecha;
				$tGENLibroReclamaciones->NumeroReclamacion	= $numeroreclamacion;

				$tGENLibroReclamaciones->Nombres			= $nombres;
				$tGENLibroReclamaciones->Domicilio			= $domicilio;
				$tGENLibroReclamaciones->DNICE				= $dnice;
				$tGENLibroReclamaciones->Telefono			= $telefono;
				$tGENLibroReclamaciones->Email				= $email;
				$tGENLibroReclamaciones->PadresMadre		= $padresmadre;

				$tGENLibroReclamaciones->BienContratado		= $biencontratado;
				$tGENLibroReclamaciones->MontoReclamado		= $montoreclamado;
				$tGENLibroReclamaciones->DescripcionBien	= $descripcionbien;

				$tGENLibroReclamaciones->ReclamacionQueja	= $reclamacionqueja;
				$tGENLibroReclamaciones->DescripcionReQue	= $descripcionreque;
				$tGENLibroReclamaciones->DescripcionAdopt	= $descripcionadop;
				$tGENLibroReclamaciones->FechaCrea			= $fechacrea;
				$tGENLibroReclamaciones->IdUsuario			= $IdUsuarioCrea;

				$tGENLibroReclamaciones->save();


			return Redirect::to('/getion-libro-reclamaciones'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');
			

		}
	}	








	public function actionEncuesta($idOpcion)
	{

		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}


		$listaEncuesta = DB::table('GEN.Encuesta')
		->join('GEN.Cliente', 'GEN.Encuesta.IdCliente', '=', 'GEN.Cliente.Id')
		->join('GEN.Local', 'GEN.Encuesta.IdLocal', '=', 'GEN.Local.Id')
		->join('tbUsuarioLocal', 'GEN.Encuesta.IdUsuarioCrea', '=', 'tbUsuarioLocal.Id')
   		->select('GEN.Local.Descripcion','GEN.Encuesta.FechaCrea','GEN.Cliente.DNI','tbUsuarioLocal.Nombre','tbUsuarioLocal.Apellido')
   		->orderBy('GEN.Encuesta.FechaCrea', 'desc')
   		->take(30)
	    ->get();

	    //print_r($listaEncuesta);
	    //exit();


		return View::make('encuesta/listaencuestacliente',
		[
		 	'idOpcion' 		 =>  $idOpcion,
		 	'listaEncuesta'  =>  $listaEncuesta
		]);

	}

	public function actionAtencionE($idOpcion)
	{
		return Redirect::to('/getion-encuesta/'.$idOpcion)->with('alertaMensajeGlobal', 'Encuesta Registrada Correctamente');
	}	



	public function actionAgregarEncuesta($idOpcion)
	{

		$listaPregunta = DB::table('GEN.TipoRespuesta')
		->join('GEN.Pregunta', 'GEN.TipoRespuesta.Id', '=', 'GEN.Pregunta.IdTipoRespuesta')
   		->leftJoin('GEN.PreguntaRespuesta', function($leftJoin)
	        {
	            $leftJoin->on('GEN.Pregunta.Id', '=', 'GEN.PreguntaRespuesta.IdPregunta')
	            ->where('GEN.PreguntaRespuesta.Activo', '=', 1);
	        })
   		->leftJoin('GEN.Respuesta', function($leftJoin)
	        {
	            $leftJoin->on('GEN.Respuesta.Id', '=', 'GEN.PreguntaRespuesta.IdRespuesta')
	            ->where('GEN.Respuesta.Activo', '=', 1);
	        })
   		->where('GEN.Pregunta.Activo', '=', 1)
   		->orderBy('GEN.Pregunta.Numero', 'ASC')
   		->select('GEN.Pregunta.Id','GEN.PreguntaRespuesta.Id as IdPreguntaRespuesta','GEN.TipoRespuesta.Descripcion as DescripcionTipo','GEN.Pregunta.Descripcion','GEN.Respuesta.Descripcion as DescripcionResp')
	    ->get();

		return View::make('encuesta/encuesta',
						  [
						   'listaPregunta' => $listaPregunta,
						   'idOpcion' => $idOpcion
						  ]
						 );

	}

	public function actionInsertarEncuesta(){

		$idusuario=Session::get('Usuario')[0]->Id;

		$xmle=explode('***', Input::get('xml'));

		$xmlt=explode('*', Input::get('xmlt'));
		$dni=Input::get('dni');
		$nombre=Input::get('nombre');

		$cont=0;
		$celular=Input::get('celular');
		$xml='<R>';
			// radio y check
		for ($i = 0; $i < count($xmle)-1; $i++) {

			$separar=explode('&&&', $xmle[$i]);
			$cont=$cont+1;
			$xml=$xml.'<ent><fil>'.($cont).'</fil><idpr>'.$separar[0].'</idpr><rec>'.$separar[1].'</rec><idu>'.$idusuario.'</idu><dni>'.$dni.'</dni><cel>'.$celular.'</cel><nom>'.$nombre.'</nom><de></de></ent>';
		}
			//text
		for ($i = 0; $i < count($xmlt)-1; $i++) {
			$cont=$cont+1;
			$xml=$xml.'<ent><fil>'.($cont).'</fil><idpr></idpr><rec></rec><idu>'.$idusuario.'</idu><dni>'.$dni.'</dni><cel>'.$celular.'</cel><nom>'.$nombre.'</nom><de>'.$xmlt[$i].'</de></ent>';
		}

		$xml=$xml.'</R>';



		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_ENCUESTAXML ?');
        $stmt->bindParam(1, $xml ,PDO::PARAM_STR); 
        $stmt->execute();		
	}


	public function actionPromocionesEventos($idOpcion)
	{


		$listaPromociones = DB::table('GEN.Cliente')
		->where('Nombre','<>','')
   		->orderBy('GEN.Cliente.Id', 'desc')
   		->take(30)
	    ->get();


		return View::make('encuesta/listapromocioneseventos',
						  [
						   'idOpcion' => $idOpcion,
						   'listaPromociones' => $listaPromociones
						  ]
						 );
	}


	public function actionAgregarPromocionesEventos($idOpcion)
	{
		return View::make('encuesta/agregarpromocioneseventos',
						  [
						   'idOpcion' => $idOpcion
						  ]
						 );
	}


	public function actionRegistrarCliente($idOpcion){

		$lCliente=GENCliente::whereRaw('Dni=?',[Input::get('txtDni')])->where('Nombre','<>','')->get();

		$FechaNacimiento=Input::get('txtFechaNacimiento');
		if($FechaNacimiento==""){$FechaNacimiento="1901-01-01";}

		if(count($lCliente)>0)
		{
			return View::make('encuesta/agregarpromocioneseventos',
				[
				 'alertaMensajeGlobal' => 'Usted ya se encuentra registrado',
				 'claseAviso'          => 'alert-danger',
				 'strongAviso'		   => '¡Error!',
				 'idOpcion' => $idOpcion,
				]);


		}else{

			$idcliente="";
			$tabla='GEN.Cliente';
			$idLocal = DB::table('GEN.EquipoTablet')
			->select('GEN.EquipoTablet.Idlocal')
			->get();
			$prefijon = DB::table('GEN.local')
			->select('GEN.local.prefijolocal')
			->where('GEN.local.Id', '=', $idLocal[0]->Idlocal)
			->get(); 
			$prefijo = $prefijon[0]->prefijolocal;
			$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC GEN.AM_GeneraIDM ?,?,?');
	        $stmt->bindParam(1, $tabla ,PDO::PARAM_STR);
	        $stmt->bindParam(2, $prefijo ,PDO::PARAM_STR);   
	        $stmt->bindParam(3, $idcliente ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
	        $stmt->execute();

			$tCliente=new GENCliente;
			$tCliente->ID=$idcliente;
			$tCliente->Nombre=Input::get('txtNombres');
			$tCliente->Apellido=Input::get('txtApellidos');
			$tCliente->Dni=Input::get('txtDni');
			$tCliente->FechaNacimiento=date_format(date_create($FechaNacimiento), 'Ymd H:i:s');
			$tCliente->Profesion=Input::get('txtProfesion');
			$tCliente->Telefono=Input::get('txtTelefono');
			$tCliente->Celular=Input::get('txtCelular');
			$tCliente->Domicilio=Input::get('txtDomicilio');
			$tCliente->Correo=Input::get('txtCorreo');
			$tCliente->Estado=0;
			$tCliente->save();

			return Redirect::to('/getion-eventos-promociones/'.$idOpcion)->with('alertaMensajeGlobal', 'Usuario Registrada Correctamente');


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