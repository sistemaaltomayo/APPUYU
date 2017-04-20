<?php
use app\bibliotecas\GeneralClass;
class InventarioController extends BaseController
{


    /**************************************** CAFETERIA ************************************/

	public function actionListaTomaInventario($idOpcion)
	{

		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}


    	$nombreopcion = $validarurl->getNombreOpcion($idOpcion);

		$idusuario = Session::get('Usuario')[0]->Id;

		$listaTomaWeb = DB::table('INV.TomaWeb')
		->join('INV.TomaUsuario', 'INV.TomaWeb.Id', '=', 'INV.TomaUsuario.IdTomaWeb')
   		->where('INV.TomaWeb.Activo', '=', 1)
   		->where('INV.TomaUsuario.idUsuario', '=', $idusuario)
   		->orderBy('INV.TomaWeb.FechaCrea', 'desc')
   		->take(30)
	    ->get();

	    $listaOpcionPlus = $validarurl->getlistaOpcionPlus($idOpcion);

		return View::make('inventario/listatomainventario',
						 ['listaTomaWeb'  	 => $listaTomaWeb,
						  'listaOpcionPlus'	 => $listaOpcionPlus,
						  'nombreopcion' 	 => $nombreopcion,
						  'idOpcion' 		 => $idOpcion
						  ]);



	}


	public function actionInsertarTomaInventario($idOpcion)
	{

		if($_POST){
			$imputs=Input::all();
			$idusuario=Session::get('Usuario')[0]->Id;
			$ubicacion = Input::get('ubicacion');
				$reglas = array(
								//'nombres' 				=> 'required|max:100',
								'tipotoma' 				=> 'required|not_in:0',
								'ubicacion' 			=> 'required|not_in:0',
								//'observacion' 			=> 'required|max:300',
							   );

				$validar = Validator::make($imputs, $reglas);

				if($validar->fails())
				{
					return Redirect::back()->withErrors($validar->messages())->withInput();
				}else{


				$estado = DB::table('INV.TomaWeb')
		        ->join('INV.TomaUsuario', 'INV.TomaWeb.Id', '=', 'INV.TomaUsuario.IdTomaWeb')
		        ->join('SEG.Usuario', 'INV.TomaUsuario.IdUsuario', '=', 'SEG.Usuario.Id')
		        ->join('GEN.Persona', 'SEG.Usuario.IdEmpleado', '=', 'GEN.Persona.Id')
		   		->whereIn('EstadoProceso', array('P','S'))
		   		->where('INV.TomaWeb.Activo', '=', 1)
		   		->orderBy('INV.TomaUsuario.fechaCrea', 'asc')
		   	    ->get();


				if(count($estado)>0){

						return Redirect::to('/getion-inventario-cafeteria'.'/'.$idOpcion)->with('alertaMensajeGlobalE', 'Operación Rechazada existe una toma de inventario abierta por el usuario '.$estado[0]->Nombre.' '.$estado[0]->Apellido.' - <a href="/APPCOFFEE/cerrar-toma-otro-usuario/'.$estado[0]->IdTomaWeb.'/'.$idOpcion.'">(Cerrar Toma)</a>');
				
				}		  

					$fechaC = date("Ymd H:i:s");

					$idtomaweb="";
					$tabla='INV.TomaWeb';
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
			        $stmt->bindParam(3, $idtomaweb ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
			        $stmt->execute();		

					$tINVTomaWeb= new INVTomaWeb;
					$tINVTomaWeb->Id=$idtomaweb;
					$tINVTomaWeb->IdLocal=$idLocal[0]->Idlocal;
					$tINVTomaWeb->Codigo=substr($idtomaweb, -8);
					$tINVTomaWeb->IdTipoToma=Input::get('tipotoma');
					$tINVTomaWeb->Observacion=Input::get('observacion');
					$tINVTomaWeb->EstadoProceso='P';
					$tINVTomaWeb->FechaCrea=$fechaC;
					$tINVTomaWeb->Activo=1;
					$tINVTomaWeb->save();

					$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_TOMAINVENTARIO ?,?,?');
			        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
			        $stmt->bindParam(2, $idusuario ,PDO::PARAM_STR);
			        $stmt->bindParam(3, $ubicacion ,PDO::PARAM_STR);
			        $stmt->execute();


			        /************** Plantilla Prioridad *******************/

			        $listaTomaPlantilla = DB::table('INV.TomaPlantilla')
	    		    ->join('INV.PrioridadToma', 'INV.TomaPlantilla.CodigoProducto', '=', 'INV.PrioridadToma.Codigo')
	    		    ->where('INV.TomaPlantilla.IdTomaWeb','=', $idtomaweb)
	    		    ->where('INV.PrioridadToma.Activo','=', 1)
	    		    ->where('INV.PrioridadToma.IdLocal','=', $idLocal[0]->Idlocal)
            	    ->select('INV.TomaPlantilla.*')
            	    ->get();


					foreach($listaTomaPlantilla as $item){

						$tINVPlantillaPrioridadToma 				= new INVPlantillaPrioridadToma;
						$tINVPlantillaPrioridadToma->Codigo 		= $item->CodigoProducto;
						$tINVPlantillaPrioridadToma->IdLocal 		= $idLocal[0]->Idlocal;
						$tINVPlantillaPrioridadToma->IdTomaWeb 		= $idtomaweb;
						$tINVPlantillaPrioridadToma->Digito         = 0;
						$tINVPlantillaPrioridadToma->save();

					}


					/*********************************************************/


					return Redirect::to('/getion-inventario-cafeteria'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');

				}
		}
		
		$permiso=permisos($idOpcion,'Anadir');

		if($permiso==0){

			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para añadir aquí');

		}else{

			$nombreOpcion = new GeneralClass();
			$nombreopcion = $nombreOpcion->getNombreOpcion($idOpcion);

			$TipoToma  = INVTipoToma::all()->lists('Descripcion','Id');
			$Ubicacion = INVUbicacionToma::all()->lists('Descripcion','Id');

			$combobox  = array(0 => "Seleccione Tipo Toma") + $TipoToma;
			$selected  = array();

			$comboubicacion  = array(0 => "Seleccione Ubicación") + $Ubicacion;
			$selectedubicacion  = array();

	        return View::make('inventario/insertartomainventario', 
					[
					 'combobox'   			=> $combobox,
					 'selected'   			=> $selected,
					 'comboubicacion'   	=> $comboubicacion,
					 'selectedubicacion'  	=> $selectedubicacion,
					 'nombreopcion'  		=> $nombreopcion,
					 'idOpcion' 		 	=> $idOpcion
					]);
		}



	}	

	public function actionEditarTomaInventario($idOpcion,$idtomaweb)
	{

		$permiso=permisos($idOpcion,'Modificar');

		if($permiso==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para Modificar aquí');
		}else{

			$nombreOpcion = new GeneralClass();
			$nombreopcion = $nombreOpcion->getNombreOpcion($idOpcion);

			$TomaWeb = DB::table('INV.TomaWeb')->where('Id', $idtomaweb)->get();

			$TipoTomaSeleccionado = DB::table('INV.TipoToma')->where('Id', $TomaWeb[0]->IdTipoToma)->get();

			$TipoToma = INVTipoToma::all()->lists('Descripcion','Id');
			$combobox = array($TipoTomaSeleccionado[0]->Id => $TipoTomaSeleccionado[0]->Descripcion) + $TipoToma;
			$selected = array();

	        return View::make('inventario/editartomainventario', 
	        				['TomaWeb'   => $TomaWeb,
	        				 'combobox'  => $combobox,
	        				 'selected'  => $selected,
	        				 'nombreopcion'  => $nombreopcion,
					 		 'idOpcion'  =>  $idOpcion
	        				]);
	    }    

	}

	public function actionActualizarTomaInventario($idOpcion)
	{
		if($_POST){
			$imputs=Input::all();

				$reglas = array(
								//'nombres' 				=> 'required|max:100',
								'tipotoma' 				=> 'required|not_in:0',
								//'observacion' 			=> 'required|max:300',
							   );

				$validar = Validator::make($imputs, $reglas);

				if($validar->fails())
				{
					return Redirect::back()->withErrors($validar->messages())->withInput();
				}else{

					$tINVTomaWeb=INVTomaWeb::find(Input::get('idtomaweb'));
					$tINVTomaWeb->Codigo		= Input::get('codigo');
					$tINVTomaWeb->Observacion 	= Input::get('observacion');
					$tINVTomaWeb->IdTipoToma 	= Input::get('tipotoma');
					$tINVTomaWeb->Activo    	= Input::get('activo');
					$tINVTomaWeb->save();

					return Redirect::to('/getion-inventario-cafeteria/'.$idOpcion)->with('alertaMensajeGlobal', 'Actualización Exitoso');

				}
		}
	}


	public function actionTomaDeInventario($idOpcionPLus,$idtomaweb,$idOpcion)
	{


		/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Toma Inventario)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$idusuario=Session::get('Usuario')[0]->Id;

		$listatoma = DB::table('INV.TomaWeb')
		->where('INV.TomaWeb.Id', '=', $idtomaweb)
		->get();


	    $selectedmedida =   DB::table('GEN.UnidadMedida')
	    		    ->join('GEN.ConversionUnidad', 'GEN.UnidadMedida.Id', '=', 'GEN.ConversionUnidad.IdUnidadOrigen')
            	    ->select('GEN.UnidadMedida.Descripcion','GEN.UnidadMedida.Id')
            	    ->distinct()
            	    ->get();


		if($listatoma[0]->EstadoProceso=="P"){

			$listaPlantillaToma = DB::table('INV.TomaPlantillaUsuario')
			->join('INV.TomaPlantilla', function($join)
	        {
	            $join->on('INV.TomaPlantillaUsuario.IdTomaWeb', '=', 'INV.TomaPlantilla.IdTomaWeb')
	           	->on('INV.TomaPlantillaUsuario.IdProducto', '=', 'INV.TomaPlantilla.IdProducto');
	        })
	        ->join('INV.TomaWeb', 'INV.TomaWeb.Id', '=', 'INV.TomaPlantilla.IdTomaWeb')
	   		->leftjoin('INV.PlantillaPrioridadToma', function ($join) use($idtomaweb){
	            $join->on('INV.PlantillaPrioridadToma.Codigo', '=', 'INV.TomaPlantilla.CodigoProducto')
	            ->where('INV.PlantillaPrioridadToma.IdTomaWeb', '=', $idtomaweb);
	            
	        })
	        //->leftJoin('INV.PlantillaPrioridadToma', 'INV.PlantillaPrioridadToma.Codigo', '=', 'INV.TomaPlantilla.CodigoProducto')
	   		->where('INV.TomaPlantillaUsuario.Activo', '=', 1)
	   		->where('INV.TomaPlantilla.Activo', '=', 1)
	   		->where('INV.TomaPlantillaUsuario.IdTomaWeb', '=', $idtomaweb)
	   		->where('INV.TomaPlantillaUsuario.IdUsuario', '=', $idusuario)
		   	->select('INV.TomaPlantillaUsuario.*','INV.TomaPlantilla.*','INV.TomaWeb.Codigo as Correlativo','INV.TomaWeb.EstadoProceso',
		   	    	'INV.PlantillaPrioridadToma.Codigo','INV.PlantillaPrioridadToma.Digito')
	   		->orderBy('INV.PlantillaPrioridadToma.Digito', 'desc')
	   	    ->get();

    		return View::make('inventario/tomadeinventario', 
			['listaPlantillaToma'  => $listaPlantillaToma,
			 'selectedmedida'	   => $selectedmedida,
			 'nombreopcion'	   	   => $nombreopcion,
			 'idOpcion'  		   =>  $idOpcion
			]);

		}else{



			if($listatoma[0]->EstadoProceso=="S"){



				$listadoProductoE = DB::table('INV.TomaPlantillaUsuario')
				->join('INV.TomaPlantilla', function($join)
		        {
		            $join->on('INV.TomaPlantillaUsuario.IdProducto', '=', 'INV.TomaPlantilla.IdProducto')
		           	->on('INV.TomaPlantillaUsuario.IdTomaWeb', '=', 'INV.TomaPlantilla.IdTomaWeb');
		        })
		   		->where('INV.TomaPlantillaUsuario.IdTomaWeb', '=', $idtomaweb)
		   		->where('INV.TomaPlantilla.Tipo', '=', 'N')
		   		->select('INV.TomaPlantillaUsuario.IdProducto','INV.TomaPlantilla.CodigoProducto')
		   		->groupBy('INV.TomaPlantillaUsuario.IdProducto','INV.TomaPlantilla.CodigoProducto')
		   		->havingRaw('SUM(INV.TomaPlantillaUsuario.StockFisico1) = max(INV.TomaPlantilla.Existencia)')
		   	    ->get();

				$IdProducto=array(-1);

				for ( $i = 0 ; $i < count($listadoProductoE) ; $i ++) {


					/********************* Prioridad **************/
					$prioridadplanilla = DB::table('INV.PlantillaPrioridadToma')->where('IdTomaWeb', '=', $idtomaweb)
							  			 ->where('Codigo', '=', $listadoProductoE[$i]->CodigoProducto)
							  			 ->where('Digito', '=', 0)
							  			 ->first();

					if(count($prioridadplanilla)==0){
						$IdProducto[$i]=$listadoProductoE[$i]->IdProducto;
					}

					/***********************************************/


				}


				$listaPlantillaToma = DB::table('INV.TomaPlantillaUsuario')
				->join('INV.TomaPlantilla', function($join)
		        {
		            $join->on('INV.TomaPlantillaUsuario.IdTomaWeb', '=', 'INV.TomaPlantilla.IdTomaWeb')
		           	->on('INV.TomaPlantillaUsuario.IdProducto', '=', 'INV.TomaPlantilla.IdProducto');
		        })
		        ->join('INV.TomaWeb', 'INV.TomaWeb.Id', '=', 'INV.TomaPlantilla.IdTomaWeb')

		   		->leftjoin('INV.PlantillaPrioridadToma', function ($join) use($idtomaweb){
		            $join->on('INV.PlantillaPrioridadToma.Codigo', '=', 'INV.TomaPlantilla.CodigoProducto')
		            ->where('INV.PlantillaPrioridadToma.IdTomaWeb', '=', $idtomaweb);
		            
		        })

				//->leftJoin('INV.PlantillaPrioridadToma', 'INV.PlantillaPrioridadToma.Codigo', '=', 'INV.TomaPlantilla.CodigoProducto')
		   		->where('INV.TomaPlantillaUsuario.Activo', '=', 1)
		   		->where('INV.TomaPlantilla.Activo', '=', 1)
		   	    ->select('INV.TomaPlantillaUsuario.*','INV.TomaPlantilla.*','INV.TomaWeb.Codigo as Correlativo','INV.TomaWeb.EstadoProceso',
		   	    	'INV.PlantillaPrioridadToma.Codigo','INV.PlantillaPrioridadToma.Digito')
		   		->whereNotIn('INV.TomaPlantillaUsuario.IdProducto',$IdProducto)
		   		->where('INV.TomaPlantillaUsuario.IdTomaWeb', '=', $idtomaweb)
		   		->where('INV.TomaPlantillaUsuario.IdUsuario', '=', $idusuario)
		   		->orderBy('INV.PlantillaPrioridadToma.Digito', 'desc')
		   	    ->get();

				return View::make('inventario/tomadeinventario', 
					['listaPlantillaToma'  => $listaPlantillaToma,
					 'selectedmedida'	   => $selectedmedida,
					 'nombreopcion'	   	   => $nombreopcion,
					 'idOpcion'  =>  $idOpcion
					]);
			}
		}

		return Redirect::to('/getion-inventario-cafeteria/'.$idOpcion)->with('alertaMensajeGlobalE', 'Su transacción no se Realizo por que se cerro la Toma de Inventario');

	}




	public function actionInsertarStockInventario()
	{
		$arraystock = explode('*',  Input::get('idstock'));
		$stock = Input::get('stock');

		$idtomaweb = $arraystock[0];
		$idproducto = $arraystock[1];
		$idusuario = $arraystock[2];
		$EstadoProceso = $arraystock[3];
		$nombrecampo = "StockFisico";

		$estado = INVTomaWeb::where('Id', '=', $idtomaweb)->get()->first();

		if($EstadoProceso=="P"){
			$nombrecampo=$nombrecampo."1";
		}else{
			$nombrecampo=$nombrecampo."2";
		}

		if($estado->EstadoProceso == $EstadoProceso){

			DB::table('INV.TomaPlantillaUsuario')
			->where('IdTomaWeb', $idtomaweb)
			->where('IdProducto', $idproducto)
			->where('IdUsuario', $idusuario)
			->update(array( $nombrecampo => $stock));


			/**************** Prioridad *****************/

			$tomaplantilla = DB::table('INV.TomaPlantilla')
							 ->where('IdTomaWeb', '=', $idtomaweb)
							 ->where('IdProducto', '=', $idproducto)->first();

			if(count($tomaplantilla)>0){

				$idusuariocrea = Session::get('Usuario')[0]->Id;

				DB::table('INV.PlantillaPrioridadToma')
				->where('IdTomaWeb', $idtomaweb)
				->where('Codigo', $tomaplantilla->CodigoProducto)
				->update(array( 'Digito' => 1 , 'UsuarioDig' => $idusuariocrea));

			}				 



			echo 1;

		}else{

			echo 0;
		
		}

	}



	public function actionAgregarUsuarioTomaInventario($idOpcionPLus,$idtomaweb,$idOpcion)
	{


				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Agregar Usuarios)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);
	
		$tbUsuarioAgregados = DB::table('tbUsuarioLocal')
		->join('INV.TomaUsuario', 'INV.TomaUsuario.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->join('INV.TomaWeb', 'INV.TomaUsuario.IdTomaWeb', '=', 'INV.TomaWeb.Id')
		->join('INV.UbicacionToma', 'INV.UbicacionToma.Id', '=', 'INV.TomaUsuario.IdUbicacion')
   		->where('INV.TomaUsuario.Activo', '=', 1)
   		->where('INV.TomaUsuario.IdTomaWeb', '=', $idtomaweb)
   		->orderBy('tbUsuarioLocal.Apellido', 'asc')
	    ->get();

	    $usuarios=array(-1);

		for ( $i = 0 ; $i < count($tbUsuarioAgregados) ; $i ++) {
			$usuarios[$i]=$tbUsuarioAgregados[$i]->IdUsuario;
		}
	    
		$tbUsuarioLocal = DB::table('tbUsuarioLocal')
   		->orderBy('tbUsuarioLocal.Apellido', 'asc')
   		->whereNotIn('tbUsuarioLocal.id',$usuarios)
	    ->get();


	    $Ubicacion = INVUbicacionToma::all()->lists('Descripcion','Id');

		$comboubicacion  = array(0 => "Seleccione Ubicación") + $Ubicacion;
		$selectedubicacion  = array();

        return View::make('inventario/agregarusuariotomainventario',
					['tbUsuarioLocal'  	 		=> $tbUsuarioLocal,
					 'idtomaweb'		 		=> $idtomaweb,	
					 'tbUsuarioAgregados'  	 	=> $tbUsuarioAgregados,
					 'comboubicacion'		 	=> $comboubicacion,	
					 'selectedubicacion'  	 	=> $selectedubicacion,
					 'nombreopcion'  	 	=> $nombreopcion,
					 'idOpcion'  =>  $idOpcion
					]);

	}


	public function actionInsertarUsuarioTomaInventario()
	{

		$xml='<U>';
		$idtomaweb = Input::get('idtomaweb');

		$arrayusuario = explode('*',  Input::get('usuarios'));

		
		for ($i = 0; $i < count($arrayusuario)-1; $i++) {

			$arrayubicacion = explode('-',  $arrayusuario[$i]);

			$xml=$xml.'<usu><fil>'.($i+1).'</fil><idusu>'.$arrayubicacion[0].'</idusu><idubi>'.$arrayubicacion[1].'</idubi></usu>';

		}
		
		$xml=$xml.'</U>';


		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_USUARIOTOMAWEB ?,?');
        $stmt->bindParam(1, $xml ,PDO::PARAM_STR); 
        $stmt->bindParam(2, $idtomaweb ,PDO::PARAM_STR);
        $stmt->execute();

	}


	public function actionUsuariosExitoso($idOpcion)
	{
		return Redirect::to('/getion-inventario-cafeteria/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro de Usuarios Exitoso');
	}



	public function actionMonitoreoDeInventario($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Monitoreo)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_MONITOREOWEB ?');
        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
        $stmt->execute();

		$listaUsuarios = DB::table('INV.TomaUsuario')
		->join('INV.UbicacionToma', 'INV.UbicacionToma.Id', '=', 'INV.TomaUsuario.IdUbicacion')
		->join('tbUsuarioLocal', 'INV.TomaUsuario.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->where('INV.TomaUsuario.IdTomaWeb', '=', $idtomaweb)
		->orderBy('tbUsuarioLocal.Login', 'asc')
		->get(); 

		$listaMonitoreo = DB::table('INV.Monitoreotoma')
		->get(); 

		return View::make('inventario/monitoreodeinventario',
					['listaUsuarios'  	 		=> $listaUsuarios,
					 'nombreopcion'  	 		=> $nombreopcion,
					 'listaMonitoreo'		 	=> $listaMonitoreo]);
	}



	public function actionReporteInventario($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Descargar Excel)');
		}
	
		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_MONITOREOWEB ?');
        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
        $stmt->execute();

		$listaUsuarios = DB::table('INV.TomaUsuario')
		->join('INV.UbicacionToma', 'INV.UbicacionToma.Id', '=', 'INV.TomaUsuario.IdUbicacion')
		->join('tbUsuarioLocal', 'INV.TomaUsuario.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->where('INV.TomaUsuario.IdTomaWeb', '=', $idtomaweb)
		->orderBy('tbUsuarioLocal.Login', 'asc')
		->get(); 

		$codigo = DB::table('INV.TomaWeb')->where('INV.TomaWeb.Id', '=', $idtomaweb)->first(); 
		$titulo = 'Monitoreo-Cafeteria-'.$codigo->Codigo;


		$listaMonitoreo = DB::table('INV.Monitoreotoma')
		->get(); 

		Excel::create($titulo,function($excel) use($listaUsuarios,$listaMonitoreo){

			$excel->sheet('Sheetname', function($sheet) use($listaUsuarios,$listaMonitoreo){


				$arrayfilas=[
							 'A','B','C','D','E','F','G','H','I','J','K','L',
							 'M','N','O','P','Q','R','S','T','U','V','W','X',
							 'Y','Z',
							 'AA','BB','CC','DD','EE','FF','GG','HH','II','JJ','KK','LL',
							 'MM','NN','OO','PP','QQ','RR','SS','TT','UU','VV','WW','XX',
							 'YY','ZZ'
							 ];
				$ultimo  = 2;
				$primero = '';


				$cadena = "";
				$arraycabecera1=[];
				$columnas=[];
				$arraycabecera2=[];

				$numero = 2;



				$sheet->mergeCells('A6:B6');
				$sheet->setWidth('A', 15);
				$sheet->setWidth('B', 30);

				array_push($arraycabecera2, 'Código');
				array_push($arraycabecera2, 'Descripción');
				
				for ($i = 0; $i < count($listaUsuarios); $i++){

					$segundo = '';
					$primero = $arrayfilas[$ultimo].'6:';
					$ultimo  = $ultimo + 1;
					$segundo = $primero.$arrayfilas[$ultimo].'6';
					$ultimo  = $ultimo + 1;
				    $sheet->mergeCells($segundo);
				    array_push($arraycabecera2, 'Stock_1');
				    array_push($arraycabecera2, 'Stock_2');

				}

				$sheet->mergeCells($arrayfilas[$ultimo].'6:'.$arrayfilas[$ultimo+1].'6');



				array_push($arraycabecera1, 'Información del Producto');
				array_push($arraycabecera1, '');

				for ($i = 0; $i < count($listaUsuarios); $i++){

				    array_push($arraycabecera1, $listaUsuarios[$i]->Login.'-'.$listaUsuarios[$i]->Descripcion);
				    array_push($arraycabecera1, '');

				}
				array_push($arraycabecera1, 'Total');
				array_push($arraycabecera1, '');
				array_push($arraycabecera2, 'T1');
				array_push($arraycabecera2, 'T2');

				$arraycabecerat = array(
                $arraycabecera1,
                $arraycabecera2
            	);


				for ($i = 0; $i < count($listaMonitoreo); $i++){

					$T1 = 0.0;
					$T2 = 0.0;

					$arraycontenido=[];
					array_push($arraycontenido, $listaMonitoreo[$i]->CodigoProducto);
					array_push($arraycontenido, $listaMonitoreo[$i]->Descripcion);

					for ($j = 0; $j < count($listaUsuarios); $j++){


						$Id1 = $listaUsuarios[$j]->Id.'_'.$listaUsuarios[$j]->Login.'_1';
						$Id2 = $listaUsuarios[$j]->Id.'_'.$listaUsuarios[$j]->Login.'_2';

						$T1 = $T1 + $listaMonitoreo[$i]->$Id1;
						$T2 = $T2 + $listaMonitoreo[$i]->$Id2;

						array_push($arraycontenido, number_format($listaMonitoreo[$i]->$Id1,2));
						array_push($arraycontenido, number_format($listaMonitoreo[$i]->$Id2,2));

					}

					array_push($arraycontenido, number_format($T1,2));
					array_push($arraycontenido, number_format($T2,2));

					array_push($arraycabecerat , $arraycontenido);

				}




			    $sheet->cells('A6:'.$arrayfilas[$ultimo+1].'6', function($cells)
			    {
			     $cells->setBackground('#CCCCCC');
			     $cells->setFontColor('#000000');
			     $cells->setAlignment('center');
			     $cells->setValignment('center');
			     $cells->setFontWeight('bold');
			    });
			    $sheet->cells('A7:'.$arrayfilas[$ultimo+1].'7', function($cells)
			    {
			     $cells->setBackground('#CCCCCC');
			     $cells->setFontColor('#000000');
			     $cells->setAlignment('center');
			     $cells->setValignment('center');
			     $cells->setFontWeight('bold');
			    });


				$sheet->fromArray($arraycabecerat,null,'A6',false,false);

			});


		})->download('xlsx');

	}


	public function actionPrimerCierreInventario($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Primer Cierre)');
		}
	

		$tINVTomaWeb=INVTomaWeb::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='S';
		$tINVTomaWeb->save();

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_PASARMANUFACTURADOPC ?');
        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR);
        $stmt->execute();



        /****************** Prioridad ************************/

		$listaPlantillaToma = DB::table('INV.TomaPlantillaUsuario')
		->join('INV.TomaPlantilla', function($join)
        {
            $join->on('INV.TomaPlantillaUsuario.IdTomaWeb', '=', 'INV.TomaPlantilla.IdTomaWeb')
           	->on('INV.TomaPlantillaUsuario.IdProducto', '=', 'INV.TomaPlantilla.IdProducto');
        })
        ->leftJoin('INV.PlantillaPrioridadToma', 'INV.PlantillaPrioridadToma.Codigo', '=', 'INV.TomaPlantilla.CodigoProducto')
   		->where('INV.TomaPlantillaUsuario.Activo', '=', 1)
   		->where('INV.TomaPlantilla.Activo', '=', 1)
   		->where('INV.TomaPlantilla.IdTomaWeb', '=', $idtomaweb)
   		->select('INV.TomaPlantillaUsuario.*','INV.TomaPlantilla.*')
   	    ->get();

   	    $idusuariocrea = Session::get('Usuario')[0]->Id;

		foreach($listaPlantillaToma as $item){

			if($item->StockFisico1>0){

				DB::table('INV.PlantillaPrioridadToma')
				->where('IdTomaWeb', $idtomaweb)
				->where('Codigo', $item->CodigoProducto)
				->update(array( 'Digito' => 1 , 'UsuarioDig' => $idusuariocrea));

			}

		}

		/*********************************************************/



        $codigo = DB::table('INV.TomaWeb')->where('INV.TomaWeb.Id', '=', $idtomaweb)->first(); 
		return Redirect::to('/getion-inventario-cafeteria/'.$idOpcion)->with('alertaMensajeGlobal', 'Primer Cierre del Inventario '.$codigo->Codigo.' Exitoso');

	}


	public function actionSegundoCierreInventario($idOpcionPLus,$idtomaweb,$idOpcion)
	{

						/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Segundo Cierre)');
		}

		$primercierre = DB::table('INV.TomaWeb')->where('Id', '=', $idtomaweb)->where('EstadoProceso', '=', 'S')->first();

  		if(count($primercierre)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'Debe Tener un Primer Cierre');
		}


		


		$listaExistencia = DB::table('INV.TOMAPLANTILLA')
   		->leftjoin('ProductoNoDescargable', function ($join) {
            $join->on('ProductoNoDescargable.idProducto', '=', 'INV.TOMAPLANTILLA.idProducto')
            ->where('ProductoNoDescargable.Activo', '=', 1);
            
        })
   		->where('INV.TOMAPLANTILLA.IdTomaWeb', '=', $idtomaweb)
   		->where('INV.TOMAPLANTILLA.Existencia ', '>', 0)
   		->whereNull('ProductoNoDescargable.idProducto')
	    ->get();


	    $listaInventario = DB::table('INV.TOMAPLANTILLAUSUARIO')
   		->leftjoin('ProductoNoDescargable', function ($join) {
            $join->on('ProductoNoDescargable.idProducto', '=', 'INV.TOMAPLANTILLAUSUARIO.idProducto')
            ->where('ProductoNoDescargable.Activo', '=', 1);
            
        })
   		->where('INV.TOMAPLANTILLAUSUARIO.IdTomaWeb', '=', $idtomaweb)
   		->whereNull('ProductoNoDescargable.idProducto')
   		->groupBy('INV.TOMAPLANTILLAUSUARIO.Idproducto')
        ->havingRaw('sum(INV.TOMAPLANTILLAUSUARIO.StockFisico1) + sum(INV.TOMAPLANTILLAUSUARIO.StockFisico2)>0')
	    ->select('INV.TOMAPLANTILLAUSUARIO.Idproducto')	
	    ->get();

	    $listaInventariocount = DB::table('INV.TOMAPLANTILLAUSUARIO')
   		->where('INV.TOMAPLANTILLAUSUARIO.IdTomaWeb', '=', $idtomaweb)
   		->groupBy('INV.TOMAPLANTILLAUSUARIO.Idproducto')
        ->havingRaw('sum(INV.TOMAPLANTILLAUSUARIO.StockFisico1) + sum(INV.TOMAPLANTILLAUSUARIO.StockFisico2)>0')
	    ->select('INV.TOMAPLANTILLAUSUARIO.Idproducto')	
	    ->get();

	    $maxConfiguracion = DB::table('GEN.ConfiguracionTablet')
	    ->where('GEN.ConfiguracionTablet.Id ', '=', 'LIM01CEN000000000001')
		->get();

		/************************** Prioridad *************************/

	    $listaPrioridad = 		INVPlantillaPrioridadToma::join('INV.TomaPlantilla', 'INV.PlantillaPrioridadToma.Codigo', '=', 'INV.TomaPlantilla.CodigoProducto')
   							    ->where('INV.TomaPlantilla.IdTomaWeb', '=', $idtomaweb)
   							    ->where('INV.PlantillaPrioridadToma.IdTomaWeb', '=', $idtomaweb)
   							    ->where('INV.PlantillaPrioridadToma.Digito', '=', 0)
   							    ->select('INV.TomaPlantilla.CodigoProducto','INV.TomaPlantilla.Descripcion')
   							    ->get()->toArray();

   		/***************************************************************/

		$max = (int)$maxConfiguracion[0]->MaxInventario;

	    if( count($listaPrioridad) == 0){

			$idLocal = DB::table('GEN.EquipoTablet')
			->select('GEN.EquipoTablet.Idlocal')
			->get();


			$nodescargable = DB::table('DetalleProductoNoDescargable')
			->join('GEN.Local', 'Gen.Local.Descripcion', '=', 'DetalleProductoNoDescargable.Local')
	   		->where('DetalleProductoNoDescargable.Fecha', '=', date("Y-m-d"))
	   		->where('GEN.Local.Id', '=', $idLocal[0]->Idlocal)
		    ->get();



		    if(count($nodescargable)>0){

				$idusuario=Session::get('Usuario')[0]->Id;
				$tINVTomaWeb=INVTomaWeb::find($idtomaweb);
				$tINVTomaWeb->EstadoProceso='C';
				$tINVTomaWeb->save();

				$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_PASARMANUFACTURADOSC ?');
		        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR);
		        $stmt->execute();

				$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_CABECERAINVENTARIO ?');
		        $stmt->bindParam(1, $idusuario ,PDO::PARAM_STR);
		        $stmt->execute();



		        $codigo = DB::table('INV.TomaWeb')->where('INV.TomaWeb.Id', '=', $idtomaweb)->first();
				return Redirect::to('/getion-inventario-cafeteria/'.$idOpcion)->with('alertaMensajeGlobal', 'Segundo Cierre del Inventario '.$codigo->Codigo.' Exitoso');
			
		    }else{

		    	return Redirect::back()->with('alertaMensajeGlobalE', 'Debe realizar el llenado de Productos No Descargable');

		    }

	    }else{

			Session::flash('listaPrioridad', $listaPrioridad);
	    	return Redirect::back()->with('alertaMensajeGlobalE', 'Aun falta  '. count($listaPrioridad) .' productos por tomar inventario <br> ');
	    }


	}


	public function actionCerrarTomaOtroUsuario($idtomaweb,$idOpcion)
	{

		$nombreUsuario=Session::get('Usuario')[0]->Nombre.' '.Session::get('Usuario')[0]->Apellido;

		$tINVTomaWeb=INVTomaWeb::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='S';
		$tINVTomaWeb->save();

		$tINVTomaWeb=INVTomaWeb::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='C';
		$tINVTomaWeb->Observacion=$tINVTomaWeb->Observacion.' - Cerrado por '.$nombreUsuario;
		$tINVTomaWeb->save();

		return Redirect::to('/getion-inventario-cafeteria/'.$idOpcion)->with('alertaMensajeGlobal', 'Cierre de toma exitoso puede crear una toma nueva');
	

	}


/*******************************************************************************************************/


	public function actionUnidadDestinoAjax()
	{

		$idunidadorigen=Input::get('idunidadorigen');

		$listaUnidad = DB::table('GEN.ConversionUnidad')
		->join('GEN.UnidadMedida', 'GEN.ConversionUnidad.IdUnidadOrigen', '=', 'GEN.UnidadMedida.Id')
   		->where('GEN.ConversionUnidad.IdUnidadOrigen', '=', $idunidadorigen)
   		->where('GEN.ConversionUnidad.Activo', '=', 1)
	    ->get();

	    $destino=array(-1);

		for ( $i = 0 ; $i < count($listaUnidad) ; $i ++) {
			$destino[$i]=$listaUnidad[$i]->IdUnidadDestino;
		}
   
		$listaUnidadDestino = DB::table('GEN.ConversionUnidad')
		->join('GEN.UnidadMedida', 'GEN.ConversionUnidad.IdUnidadDestino', '=', 'GEN.UnidadMedida.Id')	
   		->orderBy('GEN.UnidadMedida.Descripcion', 'asc')
   		->where('GEN.ConversionUnidad.IdUnidadOrigen', '=', $idunidadorigen)
   		->whereIn('GEN.ConversionUnidad.IdUnidadDestino',$destino)
	    ->get();

		return View::make('inventarioajax/unidaddestinoajax',
				 [
				  'listaUnidadDestino' => $listaUnidadDestino
				 ]);	



	}



	public function actionConvertirUnidad()
	{

		$unidadcantidad = Input::get('unidadorigen');
		$calculo=0.0;

		$convertir = DB::table('GEN.ConversionUnidad')
   		->where('GEN.ConversionUnidad.Activo', '=', 1)
   		->where('GEN.ConversionUnidad.IdUnidadOrigen', '=', Input::get('idorigen'))
   		->where('GEN.ConversionUnidad.IdUnidadDestino', '=', Input::get('iddestino'))
	    ->get();

	    //-EC-- No hay combinacion de unidades


	    if(count($convertir)>0){

	    	if($convertir[0]->Operacion=="M"){

	    		$calculo=Input::get('unidadorigen')*$convertir[0]->Factor;

	    	}else{
				$calculo=Input::get('unidadorigen')/$convertir[0]->Factor;
	    	}
	    	echo $calculo;
	    	
	    }else{
	    	echo "EC";
	    }
	}
	



/*********************************************************************************************/
/************************************** MARKET ********************************************/
/*********************************************************************************************/


	public function actionListaTomaInventarioA($idOpcion)
	{


		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}

    	$nombreopcion = $validarurl->getNombreOpcion($idOpcion);

		$idusuario=Session::get('Usuario')[0]->Id;

		$listaTomaWeb = DB::table('INV.TomaWebA')
		->join('INV.TomaUsuarioA', 'INV.TomaWebA.Id', '=', 'INV.TomaUsuarioA.IdTomaWeb')
   		->where('INV.TomaWebA.Activo', '=', 1)
   		->where('INV.TomaUsuarioA.idUsuario', '=', $idusuario)
   		->orderBy('INV.TomaWebA.FechaCrea', 'desc')
   		->take(30)
	    ->get();


	    $listaOpcionPlus = $validarurl->getlistaOpcionPlus($idOpcion);

		return View::make('inventario/listatomainventarioartesania',
		['listaTomaWeb'  	 => $listaTomaWeb,
		 'listaOpcionPlus'	 => $listaOpcionPlus,
		 'nombreopcion'	     => $nombreopcion,
		 'idOpcion' 		 =>  $idOpcion]);


	}


	public function actionInsertarTomaInventarioA($idOpcion)
	{


		if($_POST){

			$imputs=Input::all();
			$idusuario=Session::get('Usuario')[0]->Id;
				$reglas = array(		
								'tipotoma' 				=> 'required|not_in:0',
							   );

				$validar = Validator::make($imputs, $reglas);

				if($validar->fails())
				{
					return Redirect::back()->withErrors($validar->messages())->withInput();
				}else{

				$estado = DB::table('INV.TomaWebA')
		        ->join('INV.TomaUsuarioA', 'INV.TomaWebA.Id', '=', 'INV.TomaUsuarioA.IdTomaWeb')
		        ->join('SEG.Usuario', 'INV.TomaUsuarioA.IdUsuario', '=', 'SEG.Usuario.Id')
		        ->join('GEN.Persona', 'SEG.Usuario.IdEmpleado', '=', 'GEN.Persona.Id')
		   		->whereIn('INV.TomaWebA.EstadoProceso', array('P','S'))
		   		->where('INV.TomaWebA.Activo', '=', 1)
		   		->orderBy('INV.TomaUsuarioA.fechaCrea', 'asc')
		   	    ->get();

				if(count($estado)>0){
						return Redirect::to('/getion-inventario-market'.'/'.$idOpcion)->with('alertaMensajeGlobalE', 'Operación Rechazada existe una toma de inventario abierta por el usuario '.$estado[0]->Nombre.' '.$estado[0]->Apellido.' - <a href="/APPCOFFEE/cerrar-toma-otro-usuario-artesania/'.$estado[0]->IdTomaWeb.'/'.$idOpcion.'">(Cerrar Toma)</a>');
				}		  


					$fechaC = date("Ymd H:i:s");

					$idLo = DB::table('INV.Sublocales')->where('INV.Sublocales.Id', '=', 'LIM01CEN000000000002')->first(); 

					//$idLo = $this->idLocalMarquet;
					
					$idtomaweb="";
					$tabla='INV.TomaWebA';
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
			        $stmt->bindParam(3, $idtomaweb ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
			        $stmt->execute();		

					$tINVTomaWeb= new INVTomaWebA;
					$tINVTomaWeb->Id=$idtomaweb;
					$tINVTomaWeb->IdLocal=$idLo->IdLocal;
					$tINVTomaWeb->Codigo=substr($idtomaweb, -8);
					$tINVTomaWeb->IdTipoToma=Input::get('tipotoma');
					$tINVTomaWeb->Observacion=Input::get('observacion');
					$tINVTomaWeb->EstadoProceso='P';
					$tINVTomaWeb->FechaCrea=$fechaC;
					$tINVTomaWeb->Activo=1;
					$tINVTomaWeb->save();

					$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_TOMAINVENTARIOA ?,?');
			        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
			        $stmt->bindParam(2, $idusuario ,PDO::PARAM_STR);
			        $stmt->execute();




			        /************** Plantilla Prioridad *******************/

			        $listaTomaPlantilla = DB::table('INV.TomaPlantillaA')
	    		    ->join('INV.PrioridadToma', 'INV.TomaPlantillaA.CodigoProducto', '=', 'INV.PrioridadToma.Codigo')
	    		    ->where('INV.TomaPlantillaA.IdTomaWeb','=', $idtomaweb)
	    		    ->where('INV.PrioridadToma.Activo','=', 1)
	    		    ->where('INV.PrioridadToma.IdLocal','=', $idLo->IdLocal)
            	    ->select('INV.TomaPlantillaA.*')
            	    ->get();


					foreach($listaTomaPlantilla as $item){

						$tINVPlantillaPrioridadToma 				= new INVPlantillaPrioridadTomaA;
						$tINVPlantillaPrioridadToma->Codigo 		= $item->CodigoProducto;
						$tINVPlantillaPrioridadToma->IdLocal 		= $idLo->IdLocal;
						$tINVPlantillaPrioridadToma->IdTomaWeb 		= $idtomaweb;
						$tINVPlantillaPrioridadToma->Digito         = 0;
						$tINVPlantillaPrioridadToma->save();

					}


					/*********************************************************/




					return Redirect::to('/getion-inventario-market'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');

				}
		}
		
		$permiso=permisos($idOpcion,'Anadir');

		if($permiso==0){

			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para añadir aquí');

		}else{

			$nombreOpcion = new GeneralClass();
			$nombreopcion = $nombreOpcion->getNombreOpcion($idOpcion);

			$TipoToma  = INVTipoTomaA::all()->lists('Descripcion','Id');

			$combobox  = array(0 => "Seleccione Tipo Toma") + $TipoToma;
			$selected  = array();


	        return View::make('inventario/insertartomainventarioartesania', 
					[
					 'combobox'   		=> $combobox,
					 'selected'   		=> $selected,
					 'nombreopcion'   	=>  $nombreopcion,
					 'idOpcion'   		=>  $idOpcion
					]);
	    }

	}	


	public function actionEditarTomaInventarioA($idOpcion,$idtomaweb)
	{


		$permiso=permisos($idOpcion,'Modificar');

		if($permiso==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para Modificar aquí');
		}else{

			$nombreOpcion = new GeneralClass();
			$nombreopcion = $nombreOpcion->getNombreOpcion($idOpcion);


			$TomaWeb = DB::table('INV.TomaWebA')->where('Id', $idtomaweb)->get();

	        return View::make('inventario/editartomainventarioartesania', 
	        				['TomaWeb'  => $TomaWeb,
	        				 'nombreopcion'  =>  $nombreopcion,
	        				 'idOpcion'  =>  $idOpcion
	        				]);

	    } 

	}

	public function actionActualizarTomaInventarioA($idOpcion)
	{
		if($_POST){

					$tINVTomaWeb=INVTomaWebA::find(Input::get('idtomaweb'));
					$tINVTomaWeb->Codigo		= Input::get('codigo');
					$tINVTomaWeb->Observacion 	= Input::get('observacion');
					$tINVTomaWeb->Activo    	= Input::get('activo');
					$tINVTomaWeb->save();

					return Redirect::to('/getion-inventario-market/'.$idOpcion)->with('alertaMensajeGlobal', 'Actualización Exitoso');
				
		}
	}


	public function actionTomaDeInventarioA($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Toma Inventario)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$idusuario=Session::get('Usuario')[0]->Id;

		$listatoma = DB::table('INV.TomaWebA')
		->where('INV.TomaWebA.Id', '=', $idtomaweb)
		->get();


	    $selectedmedida =   DB::table('GEN.UnidadMedida')
	    		    ->join('GEN.ConversionUnidad', 'GEN.UnidadMedida.Id', '=', 'GEN.ConversionUnidad.IdUnidadOrigen')
            	    ->select('GEN.UnidadMedida.Descripcion','GEN.UnidadMedida.Id')
            	    ->distinct()
            	    ->get();


		if($listatoma[0]->EstadoProceso=="P"){

			$listaPlantillaToma = DB::table('INV.TomaPlantillaUsuarioA')
			->join('INV.TomaPlantillaA', function($join)
	        {
	            $join->on('INV.TomaPlantillaUsuarioA.IdTomaWeb', '=', 'INV.TomaPlantillaA.IdTomaWeb')
	           	->on('INV.TomaPlantillaUsuarioA.IdProducto', '=', 'INV.TomaPlantillaA.IdProducto');
	        })
	        ->join('INV.TomaWebA', 'INV.TomaWebA.Id', '=', 'INV.TomaPlantillaA.IdTomaWeb')
	   		->leftjoin('INV.PlantillaPrioridadTomaA', function ($join) use($idtomaweb){
	            $join->on('INV.PlantillaPrioridadTomaA.Codigo', '=', 'INV.TomaPlantillaA.CodigoProducto')
	            ->where('INV.PlantillaPrioridadTomaA.IdTomaWeb', '=', $idtomaweb);
	        })

	        //->leftJoin('INV.PlantillaPrioridadTomaA', 'INV.PlantillaPrioridadTomaA.Codigo', '=', 'INV.TomaPlantillaA.CodigoProducto')
	   		->where('INV.TomaPlantillaUsuarioA.Activo', '=', 1)
	   		->where('INV.TomaPlantillaA.Activo', '=', 1)
	   		->where('INV.TomaPlantillaUsuarioA.IdTomaWeb', '=', $idtomaweb)
	   		->where('INV.TomaPlantillaUsuarioA.IdUsuario', '=', $idusuario)
		   	->select('INV.TomaPlantillaUsuarioA.*','INV.TomaPlantillaA.*','INV.TomaWebA.Codigo as Correlativo','INV.TomaWebA.EstadoProceso',
		   	    	'INV.PlantillaPrioridadTomaA.Codigo','INV.PlantillaPrioridadTomaA.Digito')
	   		->orderBy('INV.PlantillaPrioridadTomaA.Digito', 'desc')
	   	    ->get();


    		return View::make('inventario/tomadeinventarioartesania', 
			['listaPlantillaToma'  => $listaPlantillaToma,
			 'selectedmedida'	   => $selectedmedida,
			 'nombreopcion'	   	   => $nombreopcion,
			 'idOpcion'  		   =>  $idOpcion
			]);

		}else{

			if($listatoma[0]->EstadoProceso=="S"){

				$listadoProductoE = DB::table('INV.TomaPlantillaUsuarioA')
				->join('INV.TomaPlantillaA', function($join)
		        {
		            $join->on('INV.TomaPlantillaUsuarioA.IdProducto', '=', 'INV.TomaPlantillaA.IdProducto')
		           	->on('INV.TomaPlantillaUsuarioA.IdTomaWeb', '=', 'INV.TomaPlantillaA.IdTomaWeb');
		        })
		   		->where('INV.TomaPlantillaUsuarioA.IdTomaWeb', '=', $idtomaweb)
		   		->select('INV.TomaPlantillaUsuarioA.IdProducto','INV.TomaPlantillaA.CodigoProducto')
		   		->groupBy('INV.TomaPlantillaUsuarioA.IdProducto','INV.TomaPlantillaA.CodigoProducto')
		   		->havingRaw('SUM(INV.TomaPlantillaUsuarioA.StockFisico1) = max(INV.TomaPlantillaA.Existencia)')
		   	    ->get();

				$IdProducto=array(-1);

				for ( $i = 0 ; $i < count($listadoProductoE) ; $i ++) {

					/********************* Prioridad **************/
					$prioridadplanilla = DB::table('INV.PlantillaPrioridadTomaA')->where('IdTomaWeb', '=', $idtomaweb)
							  			 ->where('Codigo', '=', $listadoProductoE[$i]->CodigoProducto)
							  			 ->where('Digito', '=', 0)
							  			 ->first();

					if(count($prioridadplanilla)==0){
						$IdProducto[$i]=$listadoProductoE[$i]->IdProducto;
					}

					/***********************************************/


				}

				$listaPlantillaToma = DB::table('INV.TomaPlantillaUsuarioA')
				->join('INV.TomaPlantillaA', function($join)
		        {
		            $join->on('INV.TomaPlantillaUsuarioA.IdTomaWeb', '=', 'INV.TomaPlantillaA.IdTomaWeb')
		           	->on('INV.TomaPlantillaUsuarioA.IdProducto', '=', 'INV.TomaPlantillaA.IdProducto');
		        })
		        ->join('INV.TomaWebA', 'INV.TomaWebA.Id', '=', 'INV.TomaPlantillaA.IdTomaWeb')
		   		->leftjoin('INV.PlantillaPrioridadTomaA', function ($join) use($idtomaweb){
		            $join->on('INV.PlantillaPrioridadTomaA.Codigo', '=', 'INV.TomaPlantillaA.CodigoProducto')
		            ->where('INV.PlantillaPrioridadTomaA.IdTomaWeb', '=', $idtomaweb);
		        })

		        //->leftJoin('INV.PlantillaPrioridadTomaA', 'INV.PlantillaPrioridadTomaA.Codigo', '=', 'INV.TomaPlantillaA.CodigoProducto')
		   		->where('INV.TomaPlantillaUsuarioA.Activo', '=', 1)
		   		->where('INV.TomaPlantillaA.Activo', '=', 1)
		   		->select('INV.TomaPlantillaUsuarioA.*','INV.TomaPlantillaA.*','INV.TomaWebA.Codigo as Correlativo','INV.TomaWebA.EstadoProceso',
		   	    	'INV.PlantillaPrioridadTomaA.Codigo','INV.PlantillaPrioridadTomaA.Digito')
		   		->whereNotIn('INV.TomaPlantillaUsuarioA.IdProducto',$IdProducto)
		   		->where('INV.TomaPlantillaUsuarioA.IdTomaWeb', '=', $idtomaweb)
		   		->where('INV.TomaPlantillaUsuarioA.IdUsuario', '=', $idusuario)
		   		->orderBy('INV.PlantillaPrioridadTomaA.Digito', 'desc')
		   	    ->get();

				return View::make('inventario/tomadeinventarioartesania', 
					['listaPlantillaToma'  => $listaPlantillaToma,
					 'selectedmedida'	   => $selectedmedida,
					 'nombreopcion'	   	   => $nombreopcion,
					 'idOpcion'  		   =>  $idOpcion
					]);
			}
		}

		return Redirect::to('/getion-inventario-market/'.$idOpcion)->with('alertaMensajeGlobalE', 'Su transacción no se Realizo por que se cerro la Toma de Inventario');

	}



	public function actionInsertarStockInventarioA()
	{
		$arraystock = explode('*',  Input::get('idstock'));
		$stock = Input::get('stock');


		$idtomaweb = $arraystock[0];
		$idproducto = $arraystock[1];
		$idusuario = $arraystock[2];
		$EstadoProceso = $arraystock[3];
		$nombrecampo = "StockFisico";



		$estado = INVTomaWebA::where('Id', '=', $idtomaweb)->get()->first();

		if($EstadoProceso=="P"){
			$nombrecampo=$nombrecampo."1";
		}else{
			$nombrecampo=$nombrecampo."2";
		}


		if($estado->EstadoProceso == $EstadoProceso){


			DB::table('INV.TomaPlantillaUsuarioA')
			->where('IdTomaWeb', $idtomaweb)
			->where('IdProducto', $idproducto)
			->where('IdUsuario', $idusuario)
			->update(array( $nombrecampo => $stock));



			/**************** Prioridad *****************/

			$tomaplantilla = DB::table('INV.TomaPlantillaA')
							 ->where('IdTomaWeb', '=', $idtomaweb)
							 ->where('IdProducto', '=', $idproducto)->first();

			if(count($tomaplantilla)>0){

				$idusuariocrea = Session::get('Usuario')[0]->Id;

				DB::table('INV.PlantillaPrioridadTomaA')
				->where('IdTomaWeb', $idtomaweb)
				->where('Codigo', $tomaplantilla->CodigoProducto)
				->update(array( 'Digito' => 1 , 'UsuarioDig' => $idusuariocrea));

			}	


			echo 1;


		}else{

			echo 0;
		
		}

	}


	public function actionAgregarUsuarioTomaInventarioA($idOpcionPLus,$idtomaweb,$idOpcion)
	{
		
				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Agregar Usuarios)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$tbUsuarioAgregados = DB::table('tbUsuarioLocal')
		->join('INV.TomaUsuarioA', 'INV.TomaUsuarioA.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->join('INV.TomaWebA', 'INV.TomaUsuarioA.IdTomaWeb', '=', 'INV.TomaWebA.Id')
   		->where('INV.TomaUsuarioA.Activo', '=', 1)
   		->where('INV.TomaUsuarioA.IdTomaWeb', '=', $idtomaweb)
   		->orderBy('tbUsuarioLocal.Apellido', 'asc')
	    ->get();

	    $usuarios=array(-1);

		for ( $i = 0 ; $i < count($tbUsuarioAgregados) ; $i ++) {
			$usuarios[$i]=$tbUsuarioAgregados[$i]->IdUsuario;
		}
	    
		$tbUsuarioLocal = DB::table('tbUsuarioLocal')
   		->orderBy('tbUsuarioLocal.Apellido', 'asc')
   		->whereNotIn('tbUsuarioLocal.id',$usuarios)
	    ->get();


        return View::make('inventario/agregarusuariotomainventarioartesania',
					['tbUsuarioLocal'  	 		=> $tbUsuarioLocal,
					 'idtomaweb'		 		=> $idtomaweb,	
					 'tbUsuarioAgregados'  	 	=> $tbUsuarioAgregados,
					 'nombreopcion'  	 	=> $nombreopcion,
					 'idOpcion'  =>  $idOpcion
					]);

	}


	public function actionInsertarUsuarioTomaInventarioA()
	{
		$xml='<U>';

		$idtomaweb = Input::get('idtomaweb');

		$arrayusuario = explode('*',  Input::get('usuarios'));

		
		for ($i = 0; $i < count($arrayusuario)-1; $i++) {

			$arrayubicacion = explode('-',  $arrayusuario[$i]);

			$xml=$xml.'<usu><fil>'.($i+1).'</fil><idusu>'.$arrayubicacion[0].'</idusu></usu>';

		}
		
		$xml=$xml.'</U>';


		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_USUARIOTOMAWEBA ?,?');
        $stmt->bindParam(1, $xml ,PDO::PARAM_STR); 
        $stmt->bindParam(2, $idtomaweb ,PDO::PARAM_STR);
        $stmt->execute();

	}

	
	public function actionUsuariosExitosoA($idOpcion)
	{
		return Redirect::to('/getion-inventario-market/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro de Usuarios Exitoso');
	}
	


	public function actionMonitoreoDeInventarioA($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Monitoreo)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_MONITOREOWEBA ?');
        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
        $stmt->execute();

		$listaUsuarios = DB::table('INV.TomaUsuarioA')
		->join('tbUsuarioLocal', 'INV.TomaUsuarioA.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->where('INV.TomaUsuarioA.IdTomaWeb', '=', $idtomaweb)
		->orderBy('tbUsuarioLocal.Login', 'asc')
		->get(); 

		$listaMonitoreo = DB::table('INV.MonitoreotomaA')
		->get(); 

		return View::make('inventario/monitoreodeinventarioartesania',
					['listaUsuarios'  	 		=> $listaUsuarios,
					 'nombreopcion'  	 		=> $nombreopcion,
					 'listaMonitoreo'		 	=> $listaMonitoreo]);
	}




	public function actionReporteInventarioA($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Descargar Excel)');
		}


		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_MONITOREOWEBA ?');
        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
        $stmt->execute();

		$listaUsuarios = DB::table('INV.TomaUsuarioA')
		->join('tbUsuarioLocal', 'INV.TomaUsuarioA.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->where('INV.TomaUsuarioA.IdTomaWeb', '=', $idtomaweb)
		->orderBy('tbUsuarioLocal.Login', 'asc')
		->get(); 

		$listaMonitoreo = DB::table('INV.MonitoreotomaA')
		->get(); 

		$codigo = DB::table('INV.TomaWebA')->where('INV.TomaWebA.Id', '=', $idtomaweb)->first(); 
		$titulo = 'Monitoreo-Market-'.$codigo->Codigo;

		Excel::create($titulo,function($excel) use($listaUsuarios,$listaMonitoreo){

			$excel->sheet('Sheetname', function($sheet) use($listaUsuarios,$listaMonitoreo){


				$arrayfilas=[
							 'A','B','C','D','E','F','G','H','I','J','K','L',
							 'M','N','O','P','Q','R','S','T','U','V','W','X',
							 'Y','Z',
							 'AA','BB','CC','DD','EE','FF','GG','HH','II','JJ','KK','LL',
							 'MM','NN','OO','PP','QQ','RR','SS','TT','UU','VV','WW','XX',
							 'YY','ZZ'
							 ];
				$ultimo  = 2;
				$primero = '';


				$cadena = "";
				$arraycabecera1=[];
				$columnas=[];
				$arraycabecera2=[];

				$numero = 2;



				$sheet->mergeCells('A6:B6');
				$sheet->setWidth('A', 15);
				$sheet->setWidth('B', 30);

				array_push($arraycabecera2, 'Código');
				array_push($arraycabecera2, 'Descripción');
				
				for ($i = 0; $i < count($listaUsuarios); $i++){

					$segundo = '';
					$primero = $arrayfilas[$ultimo].'6:';
					$ultimo  = $ultimo + 1;
					$segundo = $primero.$arrayfilas[$ultimo].'6';
					$ultimo  = $ultimo + 1;
				    $sheet->mergeCells($segundo);
				    array_push($arraycabecera2, 'Stock_1');
				    array_push($arraycabecera2, 'Stock_2');

				}

				$sheet->mergeCells($arrayfilas[$ultimo].'6:'.$arrayfilas[$ultimo+1].'6');



				array_push($arraycabecera1, 'Información del Producto');
				array_push($arraycabecera1, '');

				for ($i = 0; $i < count($listaUsuarios); $i++){

				    array_push($arraycabecera1, $listaUsuarios[$i]->Login);
				    array_push($arraycabecera1, '');

				}
				array_push($arraycabecera1, 'Total');
				array_push($arraycabecera1, '');
				array_push($arraycabecera2, 'T1');
				array_push($arraycabecera2, 'T2');

				$arraycabecerat = array(
                $arraycabecera1,
                $arraycabecera2
            	);


				for ($i = 0; $i < count($listaMonitoreo); $i++){

					$T1 = 0.0;
					$T2 = 0.0;

					$arraycontenido=[];
					array_push($arraycontenido, $listaMonitoreo[$i]->CodigoProducto);
					array_push($arraycontenido, $listaMonitoreo[$i]->Descripcion);

					for ($j = 0; $j < count($listaUsuarios); $j++){


						$Id1 = $listaUsuarios[$j]->Id.'_'.$listaUsuarios[$j]->Login.'_1';
						$Id2 = $listaUsuarios[$j]->Id.'_'.$listaUsuarios[$j]->Login.'_2';

						$T1 = $T1 + $listaMonitoreo[$i]->$Id1;
						$T2 = $T2 + $listaMonitoreo[$i]->$Id2;

						array_push($arraycontenido, number_format($listaMonitoreo[$i]->$Id1,2));
						array_push($arraycontenido, number_format($listaMonitoreo[$i]->$Id2,2));

					}

					array_push($arraycontenido, number_format($T1,2));
					array_push($arraycontenido, number_format($T2,2));

					array_push($arraycabecerat , $arraycontenido);

				}




			    $sheet->cells('A6:'.$arrayfilas[$ultimo+1].'6', function($cells)
			    {
			     $cells->setBackground('#CCCCCC');
			     $cells->setFontColor('#000000');
			     $cells->setAlignment('center');
			     $cells->setValignment('center');
			     $cells->setFontWeight('bold');
			    });
			    $sheet->cells('A7:'.$arrayfilas[$ultimo+1].'7', function($cells)
			    {
			     $cells->setBackground('#CCCCCC');
			     $cells->setFontColor('#000000');
			     $cells->setAlignment('center');
			     $cells->setValignment('center');
			     $cells->setFontWeight('bold');
			    });

				$sheet->fromArray($arraycabecerat,null,'A6',false,false);

			});


		})->download('xlsx');

	}


	public function actionPrimerCierreInventarioA($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Primer Cierre)');
		}
	
		$tINVTomaWeb=INVTomaWebA::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='S';
		$tINVTomaWeb->save();

		$codigo = DB::table('INV.TomaWebA')->where('INV.TomaWebA.Id', '=', $idtomaweb)->first(); 
		return Redirect::to('/getion-inventario-market/'.$idOpcion)->with('alertaMensajeGlobal', 'Primer Cierre del Inventario '.$codigo->Codigo.' Exitoso');
	}


	public function actionSegundoCierreInventarioA($idOpcionPLus,$idtomaweb,$idOpcion)
	{

						/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Segundo Cierre)');
		}



		$primercierre = DB::table('INV.TomaWebA')->where('Id', '=', $idtomaweb)->where('EstadoProceso', '=', 'S')->first();

  		if(count($primercierre)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'Debe Tener un Primer Cierre');
		}




		$listaExistencia = DB::table('INV.TOMAPLANTILLAA')
   		->leftjoin('ProductoNoDescargable', function ($join) {
            $join->on('ProductoNoDescargable.idProducto', '=', 'INV.TOMAPLANTILLAA.idProducto')
            ->where('ProductoNoDescargable.Activo', '=', 1);
            
        })
   		->where('INV.TOMAPLANTILLAA.IdTomaWeb', '=', $idtomaweb)
   		->where('INV.TOMAPLANTILLAA.Existencia ', '>', 0)
   		->whereNull('ProductoNoDescargable.idProducto')
	    ->get();


	    $listaInventario = DB::table('INV.TOMAPLANTILLAUSUARIOA')
   		->leftjoin('ProductoNoDescargable', function ($join) {
            $join->on('ProductoNoDescargable.idProducto', '=', 'INV.TOMAPLANTILLAUSUARIOA.idProducto')
            ->where('ProductoNoDescargable.Activo', '=', 1);
            
        })
   		->where('INV.TOMAPLANTILLAUSUARIOA.IdTomaWeb', '=', $idtomaweb)
   		->whereNull('ProductoNoDescargable.idProducto')
   		->groupBy('INV.TOMAPLANTILLAUSUARIOA.Idproducto')
        ->havingRaw('sum(INV.TOMAPLANTILLAUSUARIOA.StockFisico1) + sum(INV.TOMAPLANTILLAUSUARIOA.StockFisico2)>0')
	    ->select('INV.TOMAPLANTILLAUSUARIOA.Idproducto')	
	    ->get();

	    $listaInventariocount = DB::table('INV.TOMAPLANTILLAUSUARIOA')
   		->where('INV.TOMAPLANTILLAUSUARIOA.IdTomaWeb', '=', $idtomaweb)
   		//->whereNull('ProductoNoDescargable.idProducto')
   		->groupBy('INV.TOMAPLANTILLAUSUARIOA.Idproducto')
        ->havingRaw('sum(INV.TOMAPLANTILLAUSUARIOA.StockFisico1) + sum(INV.TOMAPLANTILLAUSUARIOA.StockFisico2)>0')
	    ->select('INV.TOMAPLANTILLAUSUARIOA.Idproducto')	
	    ->get();

	    $maxConfiguracion = DB::table('GEN.ConfiguracionTablet')
	    ->where('GEN.ConfiguracionTablet.Id ', '=', 'LIM01CEN000000000002')
		->get();

		/************************** Prioridad *************************/

	    $listaPrioridad = 		INVPlantillaPrioridadTomaA::join('INV.TomaPlantillaA', 'INV.PlantillaPrioridadTomaA.Codigo', '=', 'INV.TomaPlantillaA.CodigoProducto')
   							    ->where('INV.TomaPlantillaA.IdTomaWeb', '=', $idtomaweb)
   							    ->where('INV.PlantillaPrioridadTomaA.IdTomaWeb', '=', $idtomaweb)
   							    ->where('INV.PlantillaPrioridadTomaA.Digito', '=', 0)
   							    ->select('INV.TomaPlantillaA.CodigoProducto','INV.TomaPlantillaA.Descripcion')
   							    ->get()->toArray();

   		/***************************************************************/


		$max = (int)$maxConfiguracion[0]->MaxInventario;

	    if(count($listaPrioridad) == 0){

	    	$idLo = DB::table('INV.Sublocales')->where('INV.Sublocales.Id', '=', 'LIM01CEN000000000002')->first();

		    $nodescargable = DB::table('DetalleProductoNoDescargable')
			->join('GEN.Local', 'Gen.Local.Descripcion', '=', 'DetalleProductoNoDescargable.Local')
	   		->where('DetalleProductoNoDescargable.Fecha', '=', date("Y-m-d"))
	   		->where('GEN.Local.Id', '=', $idLo->IdLocal)
		    ->get();

		    if(count($nodescargable)>0){

		    	$idusuario=Session::get('Usuario')[0]->Id;
				$tINVTomaWeb=INVTomaWebA::find($idtomaweb);
				$tINVTomaWeb->EstadoProceso='C';
				$tINVTomaWeb->save();

				$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_CABECERAINVENTARIOA ?');
		        $stmt->bindParam(1, $idusuario ,PDO::PARAM_STR);
		        $stmt->execute();

		        $codigo = DB::table('INV.TomaWebA')->where('INV.TomaWebA.Id', '=', $idtomaweb)->first();
				return Redirect::to('/getion-inventario-market/'.$idOpcion)->with('alertaMensajeGlobal', 'Segundo Cierre del Inventario '.$codigo->Codigo.' Exitoso');

		    }else{

		    	return Redirect::back()->with('alertaMensajeGlobalE', 'Debe realizar el llenado de Productos No Descargable');

		    }
	    }else{
	    	Session::flash('listaPrioridad', $listaPrioridad);
	    	return Redirect::back()->with('alertaMensajeGlobalE', 'Aun falta  '. count($listaPrioridad) .' productos por tomar inventario <br> ');
	    }


	}


	public function actionCerrarTomaOtroUsuarioA($idtomaweb,$idOpcion)
	{

		$nombreUsuario=Session::get('Usuario')[0]->Nombre.' '.Session::get('Usuario')[0]->Apellido;

		$tINVTomaWeb=INVTomaWebA::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='S';
		$tINVTomaWeb->save();

		$tINVTomaWeb=INVTomaWebA::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='C';
		$tINVTomaWeb->Observacion=$tINVTomaWeb->Observacion.' - Cerrado por '.$nombreUsuario;
		$tINVTomaWeb->save();

		return Redirect::to('/getion-inventario-market/'.$idOpcion)->with('alertaMensajeGlobal', 'Cierre de toma exitoso puede crear una toma nueva');
	

	}





/*********************************************************************************************/
/************************************** EMBARQUE ********************************************/
/*********************************************************************************************/





	public function actionListaTomaInventarioE($idOpcion)
	{


		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}

		$nombreopcion = $validarurl->getNombreOpcion($idOpcion);

		$idusuario=Session::get('Usuario')[0]->Id;

		$listaTomaWeb = DB::table('INV.TomaWebE')
		->join('INV.TomaUsuarioE', 'INV.TomaWebE.Id', '=', 'INV.TomaUsuarioE.IdTomaWeb')
   		->where('INV.TomaWebE.Activo', '=', 1)
   		->where('INV.TomaUsuarioE.idUsuario', '=', $idusuario)
   		->orderBy('INV.TomaWebE.FechaCrea', 'desc')
   		->take(30)
	    ->get();


	    $listaOpcionPlus = $validarurl->getlistaOpcionPlus($idOpcion);


		return View::make('inventario/listatomainventarioembarque',
		['listaTomaWeb'  	 => $listaTomaWeb,
		 'listaOpcionPlus'	 => $listaOpcionPlus,
		 'nombreopcion'	 	 => $nombreopcion,
	 	 'idOpcion' 		 =>  $idOpcion]);


	}




	public function actionInsertarTomaInventarioE($idOpcion)
	{

		if($_POST){
			$imputs=Input::all();
			$idusuario=Session::get('Usuario')[0]->Id;
				$reglas = array(		
								'tipotoma' 				=> 'required|not_in:0',
							   );

				$validar = Validator::make($imputs, $reglas);

				if($validar->fails())
				{
					return Redirect::back()->withErrors($validar->messages())->withInput();
				}else{

				$estado = DB::table('INV.TomaWebE')
		        ->join('INV.TomaUsuarioE', 'INV.TomaWebE.Id', '=', 'INV.TomaUsuarioE.IdTomaWeb')
		        ->join('SEG.Usuario', 'INV.TomaUsuarioE.IdUsuario', '=', 'SEG.Usuario.Id')
		        ->join('GEN.Persona', 'SEG.Usuario.IdEmpleado', '=', 'GEN.Persona.Id')
		   		->whereIn('INV.TomaWebE.EstadoProceso', array('P','S'))
		   		->where('INV.TomaWebE.Activo', '=', 1)
		   		->orderBy('INV.TomaUsuarioE.fechaCrea', 'asc')
		   	    ->get();

				if(count($estado)>0){

					return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobalE', 'Operación Rechazada existe una toma de inventario abierta por el usuario '.$estado[0]->Nombre.' '.$estado[0]->Apellido.' - <a href="/APPCOFFEE/cerrar-toma-otro-usuario-embarque/'.$estado[0]->IdTomaWeb.'/'.$idOpcion.'">(Cerrar Toma)</a>');
				
				}		  



					$fechaC = date("Ymd H:i:s");
					$idLo = DB::table('INV.Sublocales')->where('INV.Sublocales.Id', '=', 'LIM01CEN000000000003')->first();
					//$idLo = $this->idLocalEmbarque;
					
					$idtomaweb="";
					$tabla='INV.TomaWebE';
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
			        $stmt->bindParam(3, $idtomaweb ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
			        $stmt->execute();		

					$tINVTomaWeb= new INVTomaWebE;
					$tINVTomaWeb->Id=$idtomaweb;
					$tINVTomaWeb->IdLocal=$idLo->IdLocal;
					$tINVTomaWeb->Codigo=substr($idtomaweb, -8);
					$tINVTomaWeb->IdTipoToma=Input::get('tipotoma');
					$tINVTomaWeb->Observacion=Input::get('observacion');
					$tINVTomaWeb->EstadoProceso='P';
					$tINVTomaWeb->FechaCrea=$fechaC;
					$tINVTomaWeb->Activo=1;
					$tINVTomaWeb->save();

					$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_TOMAINVENTARIOE ?,?');
			        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
			        $stmt->bindParam(2, $idusuario ,PDO::PARAM_STR);
			        $stmt->execute();




			        /************** Plantilla Prioridad *******************/

			        $listaTomaPlantilla = DB::table('INV.TomaPlantillaE')
	    		    ->join('INV.PrioridadToma', 'INV.TomaPlantillaE.CodigoProducto', '=', 'INV.PrioridadToma.Codigo')
	    		    ->where('INV.TomaPlantillaE.IdTomaWeb','=', $idtomaweb)
	    		    ->where('INV.PrioridadToma.Activo','=', 1)
	    		    ->where('INV.PrioridadToma.IdLocal','=', $idLo->IdLocal)
            	    ->select('INV.TomaPlantillaE.*')
            	    ->get();


					foreach($listaTomaPlantilla as $item){

						$tINVPlantillaPrioridadToma 				= new INVPlantillaPrioridadTomaE;
						$tINVPlantillaPrioridadToma->Codigo 		= $item->CodigoProducto;
						$tINVPlantillaPrioridadToma->IdLocal 		= $idLo->IdLocal;
						$tINVPlantillaPrioridadToma->IdTomaWeb 		= $idtomaweb;
						$tINVPlantillaPrioridadToma->Digito         = 0;
						$tINVPlantillaPrioridadToma->save();

					}


					/*********************************************************/



			        return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');

				}
		}
		
		$permiso=permisos($idOpcion,'Anadir');

		if($permiso==0){

			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para añadir aquí');

		}else{


			$nombreOpcion = new GeneralClass();
			$nombreopcion = $nombreOpcion->getNombreOpcion($idOpcion);


			$TipoToma  = INVTipoTomaE::all()->lists('Descripcion','Id');

			$combobox  = array(0 => "Seleccione Tipo Toma") + $TipoToma;
			$selected  = array();

	        return View::make('inventario/insertartomainventarioembarque', 
					[
					 'combobox'   		=> $combobox,
					 'selected'   		=> $selected,
					 'nombreopcion'   	=> $nombreopcion,
					 'idOpcion'   		=> $idOpcion
					]);

	    }


	}	

	public function actionEditarTomaInventarioE($idOpcion,$idtomaweb)
	{


		$permiso=permisos($idOpcion,'Modificar');

		if($permiso==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para Modificar aquí');
		}else{

			$nombreOpcion = new GeneralClass();
			$nombreopcion = $nombreOpcion->getNombreOpcion($idOpcion);

			$TomaWeb = DB::table('INV.TomaWebE')->where('Id', $idtomaweb)->get();

	        return View::make('inventario/editartomainventarioembarque', 
	        				['TomaWeb'  => $TomaWeb,
	        				 'nombreopcion'  =>  $nombreopcion,
	        				 'idOpcion'  =>  $idOpcion
	        				]);

	    } 

	}

	public function actionActualizarTomaInventarioE($idOpcion)
	{
		if($_POST){

					$tINVTomaWeb=INVTomaWebE::find(Input::get('idtomaweb'));
					$tINVTomaWeb->Codigo		= Input::get('codigo');
					$tINVTomaWeb->Observacion 	= Input::get('observacion');
					$tINVTomaWeb->Activo    	= Input::get('activo');
					$tINVTomaWeb->save();

					return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Actualización Exitoso');
				
		}
	}

	public function actionTomaDeInventarioE($idOpcionPLus,$idtomaweb,$idOpcion)
	{


				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Toma Inventario)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$idusuario=Session::get('Usuario')[0]->Id;

		$listatoma = DB::table('INV.TomaWebE')
		->where('INV.TomaWebE.Id', '=', $idtomaweb)
		->get();


	    $selectedmedida =   DB::table('GEN.UnidadMedida')
	    		    ->join('GEN.ConversionUnidad', 'GEN.UnidadMedida.Id', '=', 'GEN.ConversionUnidad.IdUnidadOrigen')
            	    ->select('GEN.UnidadMedida.Descripcion','GEN.UnidadMedida.Id')
            	    ->distinct()
            	    ->get();


		if($listatoma[0]->EstadoProceso=="P"){

			$listaPlantillaToma = DB::table('INV.TomaPlantillaUsuarioE')
			->join('INV.TomaPlantillaE', function($join)
	        {
	            $join->on('INV.TomaPlantillaUsuarioE.IdTomaWeb', '=', 'INV.TomaPlantillaE.IdTomaWeb')
	           	->on('INV.TomaPlantillaUsuarioE.IdProducto', '=', 'INV.TomaPlantillaE.IdProducto');
	        })
	        ->join('INV.TomaWebE', 'INV.TomaWebE.Id', '=', 'INV.TomaPlantillaE.IdTomaWeb')
	   		->leftjoin('INV.PlantillaPrioridadTomaE', function ($join) use($idtomaweb){
	            $join->on('INV.PlantillaPrioridadTomaE.Codigo', '=', 'INV.TomaPlantillaE.CodigoProducto')
	            ->where('INV.PlantillaPrioridadTomaE.IdTomaWeb', '=', $idtomaweb);
	        })
	        //->leftJoin('INV.PlantillaPrioridadTomaE', 'INV.PlantillaPrioridadTomaE.Codigo', '=', 'INV.TomaPlantillaE.CodigoProducto')
	   		->where('INV.TomaPlantillaUsuarioE.Activo', '=', 1)
	   		->where('INV.TomaPlantillaE.Activo', '=', 1)
	   		->where('INV.TomaPlantillaE.Activo', '=', 1)
	   		->where('INV.TomaPlantillaUsuarioE.IdTomaWeb', '=', $idtomaweb)
	   		->where('INV.TomaPlantillaUsuarioE.IdUsuario', '=', $idusuario)
		   	->select('INV.TomaPlantillaUsuarioE.*','INV.TomaPlantillaE.*','INV.TomaWebE.Codigo as Correlativo','INV.TomaWebE.EstadoProceso',
		   	    	'INV.PlantillaPrioridadTomaE.Codigo','INV.PlantillaPrioridadTomaE.Digito')
	   		->orderBy('INV.PlantillaPrioridadTomaE.Digito', 'desc')
	   	    ->get();


    		return View::make('inventario/tomadeinventarioembarque', 
			['listaPlantillaToma'  => $listaPlantillaToma,
			 'selectedmedida'	   => $selectedmedida,
			 'nombreopcion'	   	   => $nombreopcion,
			 'idOpcion'  		   =>  $idOpcion
			]);

		}else{

			if($listatoma[0]->EstadoProceso=="S"){

				$listadoProductoE = DB::table('INV.TomaPlantillaUsuarioE')
				->join('INV.TomaPlantillaE', function($join)
		        {
		            $join->on('INV.TomaPlantillaUsuarioE.IdProducto', '=', 'INV.TomaPlantillaE.IdProducto')
		           	->on('INV.TomaPlantillaUsuarioE.IdTomaWeb', '=', 'INV.TomaPlantillaE.IdTomaWeb');
		        })
		   		->where('INV.TomaPlantillaUsuarioE.IdTomaWeb', '=', $idtomaweb)
		   		->select('INV.TomaPlantillaUsuarioE.IdProducto','INV.TomaPlantillaE.CodigoProducto')
		   		->groupBy('INV.TomaPlantillaUsuarioE.IdProducto','INV.TomaPlantillaE.CodigoProducto')
		   		->havingRaw('SUM(INV.TomaPlantillaUsuarioE.StockFisico1) = max(INV.TomaPlantillaE.Existencia)')
		   	    ->get();



				$IdProducto=array(-1);

				for ( $i = 0 ; $i < count($listadoProductoE) ; $i ++) {


					$prioridadplanilla = DB::table('INV.PlantillaPrioridadTomaE')->where('IdTomaWeb', '=', $idtomaweb)
							  			 ->where('Codigo', '=', $listadoProductoE[$i]->CodigoProducto)
							  			 ->where('Digito', '=', 0)
							  			 ->first();

					if(count($prioridadplanilla)==0){
						$IdProducto[$i]=$listadoProductoE[$i]->IdProducto;
					}

					/***********************************************/


				}



				$listaPlantillaToma = DB::table('INV.TomaPlantillaUsuarioE')
				->join('INV.TomaPlantillaE', function($join)
		        {
		            $join->on('INV.TomaPlantillaUsuarioE.IdTomaWeb', '=', 'INV.TomaPlantillaE.IdTomaWeb')
		           	->on('INV.TomaPlantillaUsuarioE.IdProducto', '=', 'INV.TomaPlantillaE.IdProducto');
		        })
		        ->join('INV.TomaWebE', 'INV.TomaWebE.Id', '=', 'INV.TomaPlantillaE.IdTomaWeb')
		        ->leftjoin('INV.PlantillaPrioridadTomaE', function ($join) use($idtomaweb){
	            $join->on('INV.PlantillaPrioridadTomaE.Codigo', '=', 'INV.TomaPlantillaE.CodigoProducto')
	            ->where('INV.PlantillaPrioridadTomaE.IdTomaWeb', '=', $idtomaweb);
	        	})
		        //->leftJoin('INV.PlantillaPrioridadTomaE', 'INV.PlantillaPrioridadTomaE.Codigo', '=', 'INV.TomaPlantillaE.CodigoProducto')
		   		->where('INV.TomaPlantillaUsuarioE.Activo', '=', 1)
		   		->where('INV.TomaPlantillaE.Activo', '=', 1)
		   		->select('INV.TomaPlantillaUsuarioE.*','INV.TomaPlantillaE.*','INV.TomaWebE.Codigo as Correlativo','INV.TomaWebE.EstadoProceso',
		   	    	'INV.PlantillaPrioridadTomaE.Codigo','INV.PlantillaPrioridadTomaE.Digito')
		   		->whereNotIn('INV.TomaPlantillaUsuarioE.IdProducto',$IdProducto)
		   		->where('INV.TomaPlantillaUsuarioE.IdTomaWeb', '=', $idtomaweb)
		   		->where('INV.TomaPlantillaUsuarioE.IdUsuario', '=', $idusuario)
		   		->orderBy('INV.PlantillaPrioridadTomaE.Digito', 'desc')
		   	    ->get();


				return View::make('inventario/tomadeinventarioembarque', 
					['listaPlantillaToma'  => $listaPlantillaToma,
					 'selectedmedida'	   => $selectedmedida,
					 'nombreopcion'	   	   => $nombreopcion,
					 'idOpcion'  		   =>  $idOpcion
					]);
			}
		}

		return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobalE', 'Su transacción no se Realizo por que se cerro la Toma de Inventario');

	}

	public function actionInsertarStockInventarioE()
	{
		$arraystock = explode('*',  Input::get('idstock'));
		$stock = Input::get('stock');


		$idtomaweb = $arraystock[0];
		$idproducto = $arraystock[1];
		$idusuario = $arraystock[2];
		$EstadoProceso = $arraystock[3];
		$nombrecampo = "StockFisico";

		$estado = INVTomaWebE::where('Id', '=', $idtomaweb)->get()->first();

		if($EstadoProceso=="P"){
			$nombrecampo=$nombrecampo."1";
		}else{
			$nombrecampo=$nombrecampo."2";
		}

		if($estado->EstadoProceso == $EstadoProceso){


			DB::table('INV.TomaPlantillaUsuarioE')
			->where('IdTomaWeb', $idtomaweb)
			->where('IdProducto', $idproducto)
			->where('IdUsuario', $idusuario)
			->update(array( $nombrecampo => $stock));

			/**************** Prioridad *****************/

			$tomaplantilla = DB::table('INV.TomaPlantillaE')
							 ->where('IdTomaWeb', '=', $idtomaweb)
							 ->where('IdProducto', '=', $idproducto)->first();

			if(count($tomaplantilla)>0){

				$idusuariocrea = Session::get('Usuario')[0]->Id;

				DB::table('INV.PlantillaPrioridadTomaE')
				->where('IdTomaWeb', $idtomaweb)
				->where('Codigo', $tomaplantilla->CodigoProducto)
				->update(array( 'Digito' => 1 , 'UsuarioDig' => $idusuariocrea));

			}	



			echo 1;


		}else{

			echo 0;
		
		}

	}


	public function actionAgregarUsuarioTomaInventarioE($idOpcionPLus,$idtomaweb,$idOpcion)
	{
		
				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Agregar Usuarios)');
		}


		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$tbUsuarioAgregados = DB::table('tbUsuarioLocal')
		->join('INV.TomaUsuarioE', 'INV.TomaUsuarioE.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->join('INV.TomaWebE', 'INV.TomaUsuarioE.IdTomaWeb', '=', 'INV.TomaWebE.Id')
   		->where('INV.TomaUsuarioE.Activo', '=', 1)
   		->where('INV.TomaUsuarioE.IdTomaWeb', '=', $idtomaweb)
   		->orderBy('tbUsuarioLocal.Apellido', 'asc')
	    ->get();

	    $usuarios=array(-1);

		for ( $i = 0 ; $i < count($tbUsuarioAgregados) ; $i ++) {
			$usuarios[$i]=$tbUsuarioAgregados[$i]->IdUsuario;
		}
	    
		$tbUsuarioLocal = DB::table('tbUsuarioLocal')
   		->orderBy('tbUsuarioLocal.Apellido', 'asc')
   		->whereNotIn('tbUsuarioLocal.id',$usuarios)
	    ->get();


        return View::make('inventario/agregarusuariotomainventarioembarque',
					['tbUsuarioLocal'  	 		=> $tbUsuarioLocal,
					 'idtomaweb'		 		=> $idtomaweb,	
					 'tbUsuarioAgregados'  	 	=> $tbUsuarioAgregados,
					 'nombreopcion'  	 	=> $nombreopcion,
					 'idOpcion' 			    => $idOpcion
					]);

	}

	public function actionUsuariosExitosoE($idOpcion)
	{
		return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro de Usuarios Exitoso');
	}

	public function actionInsertarUsuarioTomaInventarioE()
	{
		$xml='<U>';

		$idtomaweb = Input::get('idtomaweb');

		$arrayusuario = explode('*',  Input::get('usuarios'));

		
		for ($i = 0; $i < count($arrayusuario)-1; $i++) {

			$arrayubicacion = explode('-',  $arrayusuario[$i]);

			$xml=$xml.'<usu><fil>'.($i+1).'</fil><idusu>'.$arrayubicacion[0].'</idusu></usu>';

		}
		
		$xml=$xml.'</U>';


		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_USUARIOTOMAWEBE ?,?');
        $stmt->bindParam(1, $xml ,PDO::PARAM_STR); 
        $stmt->bindParam(2, $idtomaweb ,PDO::PARAM_STR);
        $stmt->execute();

	}


	public function actionMonitoreoDeInventarioE($idOpcionPLus,$idtomaweb,$idOpcion)
	{


				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Monitoreo)');
		}

		$nombreopcion = $validarpermiso->getNombreOpcion($idOpcion);

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_MONITOREOWEBE ?');
        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
        $stmt->execute();

		$listaUsuarios = DB::table('INV.TomaUsuarioE')
		->join('tbUsuarioLocal', 'INV.TomaUsuarioE.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->where('INV.TomaUsuarioE.IdTomaWeb', '=', $idtomaweb)
		->orderBy('tbUsuarioLocal.Login', 'asc')
		->get(); 

		$listaMonitoreo = DB::table('INV.MonitoreotomaE')
		->get(); 

		return View::make('inventario/monitoreodeinventarioembarque',
					['listaUsuarios'  	 		=> $listaUsuarios,
					 'nombreopcion'  	 		=> $nombreopcion,
					 'listaMonitoreo'		 	=> $listaMonitoreo]);
	}



	public function actionReporteInventarioE($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Descargar Excel)');
		}
	
		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_MONITOREOWEBE ?');
        $stmt->bindParam(1, $idtomaweb ,PDO::PARAM_STR); 
        $stmt->execute();

		$listaUsuarios = DB::table('INV.TomaUsuarioE')
		->join('tbUsuarioLocal', 'INV.TomaUsuarioE.IdUsuario', '=', 'tbUsuarioLocal.Id')
		->where('INV.TomaUsuarioE.IdTomaWeb', '=', $idtomaweb)
		->orderBy('tbUsuarioLocal.Login', 'asc')
		->get(); 

		$listaMonitoreo = DB::table('INV.MonitoreotomaE')
		->get(); 

		$codigo = DB::table('INV.TomaWebE')->where('INV.TomaWebE.Id', '=', $idtomaweb)->first(); 
		$titulo = 'Monitoreo-embarque-'.$codigo->Codigo;

		Excel::create($titulo,function($excel) use($listaUsuarios,$listaMonitoreo){

			$excel->sheet('Sheetname', function($sheet) use($listaUsuarios,$listaMonitoreo){


				$arrayfilas=[
							 'A','B','C','D','E','F','G','H','I','J','K','L',
							 'M','N','O','P','Q','R','S','T','U','V','W','X',
							 'Y','Z',
							 'AA','BB','CC','DD','EE','FF','GG','HH','II','JJ','KK','LL',
							 'MM','NN','OO','PP','QQ','RR','SS','TT','UU','VV','WW','XX',
							 'YY','ZZ'
							 ];
				$ultimo  = 2;
				$primero = '';


				$cadena = "";
				$arraycabecera1=[];
				$columnas=[];
				$arraycabecera2=[];

				$numero = 2;



				$sheet->mergeCells('A6:B6');
				$sheet->setWidth('A', 15);
				$sheet->setWidth('B', 30);

				array_push($arraycabecera2, 'Código');
				array_push($arraycabecera2, 'Descripción');
				
				for ($i = 0; $i < count($listaUsuarios); $i++){

					$segundo = '';
					$primero = $arrayfilas[$ultimo].'6:';
					$ultimo  = $ultimo + 1;
					$segundo = $primero.$arrayfilas[$ultimo].'6';
					$ultimo  = $ultimo + 1;
				    $sheet->mergeCells($segundo);
				    array_push($arraycabecera2, 'Stock_1');
				    array_push($arraycabecera2, 'Stock_2');

				}

				$sheet->mergeCells($arrayfilas[$ultimo].'6:'.$arrayfilas[$ultimo+1].'6');



				array_push($arraycabecera1, 'Información del Producto');
				array_push($arraycabecera1, '');

				for ($i = 0; $i < count($listaUsuarios); $i++){

				    array_push($arraycabecera1, $listaUsuarios[$i]->Login);
				    array_push($arraycabecera1, '');

				}
				array_push($arraycabecera1, 'Total');
				array_push($arraycabecera1, '');
				array_push($arraycabecera2, 'T1');
				array_push($arraycabecera2, 'T2');

				$arraycabecerat = array(
                $arraycabecera1,
                $arraycabecera2
            	);


				for ($i = 0; $i < count($listaMonitoreo); $i++){

					$T1 = 0.0;
					$T2 = 0.0;

					$arraycontenido=[];
					array_push($arraycontenido, $listaMonitoreo[$i]->CodigoProducto);
					array_push($arraycontenido, $listaMonitoreo[$i]->Descripcion);

					for ($j = 0; $j < count($listaUsuarios); $j++){


						$Id1 = $listaUsuarios[$j]->Id.'_'.$listaUsuarios[$j]->Login.'_1';
						$Id2 = $listaUsuarios[$j]->Id.'_'.$listaUsuarios[$j]->Login.'_2';

						$T1 = $T1 + $listaMonitoreo[$i]->$Id1;
						$T2 = $T2 + $listaMonitoreo[$i]->$Id2;

						array_push($arraycontenido, number_format($listaMonitoreo[$i]->$Id1,2));
						array_push($arraycontenido, number_format($listaMonitoreo[$i]->$Id2,2));

					}

					array_push($arraycontenido, number_format($T1,2));
					array_push($arraycontenido, number_format($T2,2));

					array_push($arraycabecerat , $arraycontenido);

				}




			    $sheet->cells('A6:'.$arrayfilas[$ultimo+1].'6', function($cells)
			    {
			     $cells->setBackground('#CCCCCC');
			     $cells->setFontColor('#000000');
			     $cells->setAlignment('center');
			     $cells->setValignment('center');
			     $cells->setFontWeight('bold');
			    });
			    $sheet->cells('A7:'.$arrayfilas[$ultimo+1].'7', function($cells)
			    {
			     $cells->setBackground('#CCCCCC');
			     $cells->setFontColor('#000000');
			     $cells->setAlignment('center');
			     $cells->setValignment('center');
			     $cells->setFontWeight('bold');
			    });

				$sheet->fromArray($arraycabecerat,null,'A6',false,false);

			});


		})->download('xlsx');

	}


	public function actionPrimerCierreInventarioE($idOpcionPLus,$idtomaweb,$idOpcion)
	{

				/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Primer Cierre)');
		}

		$tINVTomaWeb=INVTomaWebE::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='S';
		$tINVTomaWeb->save();

		$codigo = DB::table('INV.TomaWebE')->where('INV.TomaWebE.Id', '=', $idtomaweb)->first(); 
		return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Primer Cierre del Inventario '.$codigo->Codigo.' Exitoso');
	
	}

	public function actionSegundoCierreInventarioE($idOpcionPLus,$idtomaweb,$idOpcion)
	{

						/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionPLus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Segundo Cierre)');
		}

		$primercierre = DB::table('INV.TomaWebE')->where('Id', '=', $idtomaweb)->where('EstadoProceso', '=', 'S')->first();
  		if(count($primercierre)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'Debe Tener un Primer Cierre');
		}


		$listaExistencia = DB::table('INV.TOMAPLANTILLAE')
   		->leftjoin('ProductoNoDescargable', function ($join) {
            $join->on('ProductoNoDescargable.idProducto', '=', 'INV.TOMAPLANTILLAE.idProducto')
            ->where('ProductoNoDescargable.Activo', '=', 1);
            
        })
   		->where('INV.TOMAPLANTILLAE.IdTomaWeb', '=', $idtomaweb)
   		->where('INV.TOMAPLANTILLAE.Existencia ', '>', 0)
   		->whereNull('ProductoNoDescargable.idProducto')
	    ->get();


	    $listaInventario = DB::table('INV.TOMAPLANTILLAUSUARIOE')
   		->leftjoin('ProductoNoDescargable', function ($join) {
            $join->on('ProductoNoDescargable.idProducto', '=', 'INV.TOMAPLANTILLAUSUARIOE.idProducto')
            ->where('ProductoNoDescargable.Activo', '=', 1);
            
        })
   		->where('INV.TOMAPLANTILLAUSUARIOE.IdTomaWeb', '=', $idtomaweb)
   		->whereNull('ProductoNoDescargable.idProducto')
   		->groupBy('INV.TOMAPLANTILLAUSUARIOE.Idproducto')
        ->havingRaw('sum(INV.TOMAPLANTILLAUSUARIOE.StockFisico1) + sum(INV.TOMAPLANTILLAUSUARIOE.StockFisico2)>0')
	    ->select('INV.TOMAPLANTILLAUSUARIOE.Idproducto')	
	    ->get();

	    $listaInventariocount = DB::table('INV.TOMAPLANTILLAUSUARIOE')
   		->where('INV.TOMAPLANTILLAUSUARIOE.IdTomaWeb', '=', $idtomaweb)
   		//->whereNull('ProductoNoDescargable.idProducto')
   		->groupBy('INV.TOMAPLANTILLAUSUARIOE.Idproducto')
        ->havingRaw('sum(INV.TOMAPLANTILLAUSUARIOE.StockFisico1) + sum(INV.TOMAPLANTILLAUSUARIOE.StockFisico2)>0')
	    ->select('INV.TOMAPLANTILLAUSUARIOE.Idproducto')	
	    ->get();

	    $maxConfiguracion = DB::table('GEN.ConfiguracionTablet')
	    ->where('GEN.ConfiguracionTablet.Id ', '=', 'LIM01CEN000000000003')
		->get();

		/************************** Prioridad *************************/

	    $listaPrioridad = 		INVPlantillaPrioridadTomaE::join('INV.TomaPlantillaE', 'INV.PlantillaPrioridadTomaE.Codigo', '=', 'INV.TomaPlantillaE.CodigoProducto')
   							    ->where('INV.TomaPlantillaE.IdTomaWeb', '=', $idtomaweb)
   							    ->where('INV.PlantillaPrioridadTomaE.IdTomaWeb', '=', $idtomaweb)
   							    ->where('INV.PlantillaPrioridadTomaE.Digito', '=', 0)
   							    ->select('INV.TomaPlantillaE.CodigoProducto','INV.TomaPlantillaE.Descripcion')
   							    ->get()->toArray();

   		/***************************************************************/


		$max = (int)$maxConfiguracion[0]->MaxInventario;

	    if(count($listaPrioridad) == 0){

	    	$idLo = DB::table('INV.Sublocales')->where('INV.Sublocales.Id', '=', 'LIM01CEN000000000003')->first();

		    $nodescargable = DB::table('DetalleProductoNoDescargable')
			->join('GEN.Local', 'Gen.Local.Descripcion', '=', 'DetalleProductoNoDescargable.Local')
	   		->where('DetalleProductoNoDescargable.Fecha', '=', date("Y-m-d"))
	   		->where('GEN.Local.Id', '=', $idLo->IdLocal)
		    ->get();

		    if(count($nodescargable)>0){

		    	$idusuario=Session::get('Usuario')[0]->Id;
				$tINVTomaWeb=INVTomaWebE::find($idtomaweb);
				$tINVTomaWeb->EstadoProceso='C';
				$tINVTomaWeb->save();

				$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_CABECERAINVENTARIOE ?');
		        $stmt->bindParam(1, $idusuario ,PDO::PARAM_STR);
		        $stmt->execute();

		        $codigo = DB::table('INV.TomaWebE')->where('INV.TomaWebE.Id', '=', $idtomaweb)->first();
				return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Segundo Cierre del Inventario '.$codigo->Codigo.' Exitoso');

		    }else{

		    	return Redirect::back()->with('alertaMensajeGlobalE', 'Debe realizar el llenado de Productos No Descargable');

		    }
	    }else{
	    	
	    	Session::flash('listaPrioridad', $listaPrioridad);
	    	return Redirect::back()->with('alertaMensajeGlobalE', 'Aun falta  '. count($listaPrioridad) .' productos por tomar inventario <br> ');
	    
		}


	}

	public function actionCerrarTomaOtroUsuarioE($idtomaweb,$idOpcion)
	{



		$nombreUsuario=Session::get('Usuario')[0]->Nombre.' '.Session::get('Usuario')[0]->Apellido;
		
		$tINVTomaWeb=INVTomaWebE::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='S';
		$tINVTomaWeb->save();

		$tINVTomaWeb=INVTomaWebE::find($idtomaweb);
		$tINVTomaWeb->EstadoProceso='C';
		$tINVTomaWeb->Observacion=$tINVTomaWeb->Observacion.' - Cerrado por '.$nombreUsuario;
		$tINVTomaWeb->save();

		return Redirect::to('/getion-inventario-embarque'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Cierre de toma exitoso puede crear una toma nueva');
	

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