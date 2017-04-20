<?php
use app\bibliotecas\GeneralClass;

class AutentificacionController extends BaseController
{
	//print_r(Hashids::encode(1));
	//print_r(Hashids::decode('DBzD'));
	public function actionBienvenidoCoffeeAndArts()
	{
		return View::make('autentificacion/bienvenidoscoffeeandarts');
	}

	public function actionLogin()
	{
		if($_POST)
		{
			/*************  base de datos *************/

			$xml = new GeneralClass();
	    	$basedatos = $xml->getBaseXml();
	    	Session::put('basedatos', $basedatos);

	    	/******************************************/

			$usuario = strtoupper(Input::get('usuario'));
			$clave   = strtoupper(Input::get('clave'));

		    $tUsuario= DB::table('tbUsuarioLocal')
		    		  ->join('SEG.TipoUsuario', 'SEG.TipoUsuario.Id', '=', 'tbUsuarioLocal.IdTipoUsuario')
		    		  ->whereRaw('UPPER(Login)=?',[$usuario])
		    		  ->select('tbUsuarioLocal.Id as Id','tbUsuarioLocal.Codigo',
			   				 'tbUsuarioLocal.Login','tbUsuarioLocal.Nombre',
			   				 'tbUsuarioLocal.Apellido','SEG.TipoUsuario.Descripcion as NombreRol')
		    		  ->get();


			if(count($tUsuario)==0)
			{

				return View::make('autentificacion/login',
					[
					 'alertaMensajeGlobal' => 'Usuario o clave incorrectoo'
					]);
			}
			else
			{

				if(strtoupper($tUsuario[0]->Codigo)==$clave)
				{


					$listaMenu = DB::table('tbUsuarioLocal')
					->join('SEG.TipoUsuario', 'SEG.TipoUsuario.Id', '=', 'tbUsuarioLocal.IdTipoUsuario')
			   		->join('GEN.RolOpcionZ', 'GEN.RolOpcionZ.IdRol', '=', 'SEG.TipoUsuario.Id')
			   		->join('GEN.OpcionZ', 'GEN.OpcionZ.Id', '=', 'GEN.RolOpcionZ.IdOpcion')
			   		->join('GEN.GrupoOpcionZ', 'GEN.GrupoOpcionZ.Id', '=', 'GEN.OpcionZ.IdGrupoOpcion')
			   		//->where('Usuario.Activo', '=', 1)
			   		->where('tbUsuarioLocal.Id', '=', $tUsuario[0]->Id)
			   		->where('SEG.TipoUsuario.Activo', '=', 1)
			   		->where('GEN.OpcionZ.Activo', '=', 1)
			   		->where('GEN.RolOpcionZ.Ver', '=', 1)
			   		->where('GEN.GrupoOpcionZ.Activo', '=', 1)
			   		->select('tbUsuarioLocal.Id','GEN.RolOpcionZ.Id','GEN.RolOpcionZ.IdOpcion','GEN.RolOpcionZ.IdRol',
			   				 'GEN.OpcionZ.Pagina','GEN.RolOpcionZ.Ver','GEN.RolOpcionZ.Anadir','GEN.RolOpcionZ.Modificar',
			   				 'GEN.RolOpcionZ.Eliminar',
			   				 'GEN.GrupoOpcionZ.Nombre as NombreGrupo','GEN.OpcionZ.Nombre as NombreOpcion',
			   				 'GEN.GrupoOpcionZ.Orden as OrdenGrupo','GEN.RolOpcionZ.Orden as OrdenOpcion')
			   		->orderBy('GrupoOpcionZ.Orden', 'asc')
			   		->orderBy('RolOpcionZ.Orden', 'asc')
				    ->get();

				    $zona 	= DB::table('GEN.LocalMovil')->where('Activo','=','1')->first();
				   /* print_r($listaMenu);
				    exit();*/

					Session::put('Usuario', $tUsuario);
					Session::put('listaMenu', $listaMenu);
					Session::put('zona', $zona);


					return Redirect::to('bienvenidos-coffee-and-arts');

				}
				else
				{
					return View::make('autentificacion/login',
					[
					'alertaMensajeGlobal' => 'Usuario o clave incorrecto'
					]);
				}
			}
		}

		return View::make('autentificacion/login');

		/*******************************************/
	}
	public function actionCerrarSesion()
	{

		Session::forget('listaMenu');
		Session::forget('Usuario');
		Session::forget('basedatos');
		return Redirect::to('/login');
	}
	public function actionListarPermisos($idOpcion)
	{

		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}

		$listaRoles = DB::table('Seg.TipoUsuario')->get();

		return View::make('autentificacion/listapermisos',
						 [
						 'listaRoles' => $listaRoles
						 ]);
	}
	public function actionListarAjaxPermisos()
	{



		$idrol =  Input::get('idRol');
		$arrayplus = array();

		$listaRolOpciones   = DB::table('GEN.RolOpcionZ')
							->join('GEN.OpcionZ', 'GEN.RolOpcionZ.IdOpcion', '=', 'GEN.OpcionZ.Id')
							->where('GEN.RolOpcionZ.IdRol', '=', $idrol)
							->select('GEN.RolOpcionZ.Id','GEN.OpcionZ.Nombre','GEN.RolOpcionZ.Ver',
								     'GEN.RolOpcionZ.Anadir','GEN.RolOpcionZ.Modificar',
								     'GEN.RolOpcionZ.Eliminar','GEN.RolOpcionZ.Todas',
								     'GEN.RolOpcionZ.IdOpcion','GEN.RolOpcionZ.IdRol')
							->get();


		/*************** Ver si tiene opciones adicionales *********************/
		$listaRolOpcionPlus = DB::table('GEN.RolOpcionZ')
							->join('GEN.RolOpcionPlusZ', 'GEN.RolOpcionZ.Id', '=', 'GEN.RolOpcionPlusZ.IdRolOpcion')
							->where('GEN.RolOpcionZ.IdRol', '=', $idrol)
							->select('GEN.RolOpcionPlusZ.IdRolOpcion')
							->get();

		foreach($listaRolOpcionPlus as $item){
			array_push($arrayplus, $item->IdRolOpcion);
		}
		/**********************************************************************/			




		return View::make('ajax/listaajaxpermisos',
						 [
						 'listaRolOpciones'   => $listaRolOpciones,
						 'arrayplus' => $arrayplus
						 ]);
	}
	public function actionActivarAjaxPermisos()
	{


		$idopcion = Input::get('idopcion');
		$permiso=permisos($idopcion,'Anadir');

		if($permiso==0){

			echo("0");

		}else{

			$idrol = Input::get('idrol');

			$checkcadena = Input::get('checkcadena');
			$accion = Input::get('accion');
			$arrays = explode(",", $checkcadena);

			$consulta ="UPDATE GEN.RolOpcionZ SET ";
			$cadenaset ="";
			for($i = 0; $i < count($arrays); $i++) {
				$cadenaset  .= $arrays[$i]." = ".$accion.",";
			}
			$deco = new GeneralClass();
    		$id = $deco->getDecodificar($idopcion);
			
			$consulta .= substr($cadenaset, 0, -1);
			$consulta .= " where IdOpcion ='".$id."' and IdRol = '".$idrol."'";

			DB::update($consulta);
			echo("1");

		}	
	}
	public function actionListarAjaxPermisosPlus()
	{


		$idrolopcion = Input::get('idRolOpcion');

		$listaRolOpcionPlus = DB::table('GEN.RolOpcionPlusZ')
					->join('GEN.OpcionPlusZ', 'GEN.OpcionPlusZ.Id', '=', 'GEN.RolOpcionPlusZ.IdOpcionPlus')
					->where('GEN.RolOpcionPlusZ.IdRolOpcion', '=', $idrolopcion)
					->select('GEN.RolOpcionPlusZ.Id','GEN.RolOpcionPlusZ.Activo','GEN.OpcionPlusZ.Nombre')
					->orderBy('GEN.RolOpcionPlusZ.IdRolOpcion', 'asc')
					->get();

		return View::make('ajax/listaajaxpermisosplus',
						 [
						 'listaRolOpcionPlus'   => $listaRolOpcionPlus,
						 'idrolopcion'			=> $idrolopcion,
						 ]);
	}
	public function actionActivarAjaxPermisosPlus()
	{

		$identiti 		= Input::get('identiti');
		$checkcadena 	= Input::get('checkcadena');
		$accion 		= Input::get('accion');

		$consultadeshabilitar ="UPDATE GEN.RolOpcionPlus SET Activo= 0 where IdRolOpcion='".$identiti."'";
		DB::update($consultadeshabilitar);

		if(count($checkcadena)>0){

			$arrays = explode(",", $checkcadena);

			for($i = 0; $i < count($arrays)-1; $i++) {
				$consulta ="UPDATE GEN.RolOpcionPlus SET Activo = 1 where Id='".$arrays[$i]."'";
				DB::update($consulta);
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