<?php
use app\bibliotecas\GeneralClass;

class GeneralAjaxController extends BaseController
{




	public function actionprovinciaajax()
	{

		$coddepartamento   = Input::get('coddepartamento');

		$Provincia = Provincia::where('IdDepartamento','=',$coddepartamento)
						->lists('Nombre','Id');
		$comboprovincia  = array(0 => "Seleccione Provincia") + $Provincia;

		return View::make('ajaxgenerales/provinciaajax',
						 [
						 'comboprovincia' => $comboprovincia
						 ]);

	}	


	public function actiondistritoajax()
	{

		$codprovincia   = Input::get('codprovincia');

		$distrito  					= GENDistrito::where('Activo','=',1)
									  ->where('IdProvincia','=',$codprovincia)
									  ->orderBy('Descripcion', 'asc')->lists('Descripcion', 'Id');
									  
		$combodistrito  			= array(0 => "Seleccione Distrito") + $distrito;


		return View::make('ajaxgenerales/distritoajax',
						 [
						 'combodistrito' => $combodistrito
						 ]);


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