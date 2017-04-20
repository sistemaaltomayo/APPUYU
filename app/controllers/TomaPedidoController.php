<?php
use app\bibliotecas\GeneralClass;

class TomaPedidoController extends BaseController
{

	public function actionTomaPedido()
	{
		$mesas="";
		$listaMesa=tbListarMesa::all();
		$listaProducto=tbListarProducto::all();
		$mensaje="0";
		
		if(Session::get('mensaje')==1){
			$mensaje="1";
			Session::put('mensaje',0);
		}

		foreach($listaMesa as $item)
		{
			$mesas=$mesas.$item->Numero.",";
		}
		return View::make('tomapedido/tomapedido', 
						  ['mesas'        => $mesas,
			              'listaMesa'     => $listaMesa,
			              'mensaje'       => $mensaje,
 			              'listaProducto' => $listaProducto]
			             );
	}



	public function actionlistaProductoAjax()
	{

		$idpedido = VENPedido::where('IdMesa', '=', Input::get('idmesa'))
		->orderBy('FechaCrea', 'desc')
		->first();

		if(isset($idpedido->Id)){
			$codigo=$idpedido->Id;
		}else{
			$codigo="";
		}	

		$listaProductoA = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
		->where('VEN.Mesa.IdEstado', '=', 'LIM01CEN000000000002')
   		->where('VEN.Pedido.Id', '=', $codigo)
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('VEN.Pedido.IdEstado', '=', 'LIM01CEN000000000002')
   		->select('tbDetallePedido.numerodocumento','tbDetallePedido.razonsocial','tbDetallePedido.EstadoNota','tbDetallePedido.Id as IdDetallePedido','tbDetallePedido.nomcli','tbDetallePedido.detped','tbDetallePedido.Activo','VEN.Pedido.Id as IdPedido','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.DetallePedido.Id','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();
		
		return View::make('tomapedidoajax/listarproductoajax',
						 ['listaProductoA' => $listaProductoA,
						 'idmesas' => Input::get('idmesa'),
						 'numero' => Input::get('numero')]
			             );
	}

	public function actionCartAjax()
	{
		
		$listaproducto=explode('*', Input::get('id'));
		$listaCarta= DB::table('tbListarCarta')
   		->whereIn('tbListarCarta.idcategoria', $listaproducto)
   		->orderBy('tbListarCarta.idcarta', 'asc')
   		->get();
		return View::make('tomapedidoajax/cartajax',
						 ['listaCarta' => $listaCarta]);

	}


	public function actionProductoDetAjax(){

		$idProducto=Input::get('idproducto');
		$radio="";
		$text="";
		$arrayradio="";

		if(Input::get('detalle')!=""){
			$detalle=explode('/', Input::get('detalle'));
			$radio=$detalle[0];
			$text = $detalle[1];
			if($radio!=""){
				$arrayradio = explode('*', $radio);
			}
		}

		$listaProductoNota = DB::table('GEN.Producto')
   		->join('GEN.NotaProducto', 'GEN.Producto.Id', '=', 'GEN.NotaProducto.IdProducto')
   		->join('GEN.Nota', 'GEN.NotaProducto.IdNota', '=', 'GEN.Nota.Id')
   		->where('GEN.Producto.Id', '=', $idProducto)
   		->orderBy('GEN.NotaProducto.Agrupamiento', 'ASC')
   		->select('GEN.NotaProducto.Id','GEN.Nota.Descripcion','GEN.NotaProducto.Agrupamiento')
	    ->get();

		return View::make('tomapedidoajax/productodetalleajax',					
						 [
						 'arrayradio' => $arrayradio,
						 'text' => $text,
						 'idProducto' => $idProducto,
						 'listaProductoNota' => $listaProductoNota
						 ]);
	}


    public function actionActualizarRuc(){
    	
    	$numerodoc=Input::get('numerodoc');
    	$razonsocial=Input::get('razonsocial');
    	$idpedido=Input::get('idpedido');

		DB::table('tbDetallePedido')
		->where('Idpedido', $idpedido)
		->update(array(
						'numerodocumento' => $numerodoc,
						'razonsocial' => $razonsocial)
				);
    }

	public function actionMostrarNotaAjax(){

		$iddetallepedido=Input::get('iddetallepedido');

		$listaNota = DB::table('tbDetallePedido')
   		->leftJoin('GEN.DetallePedidoNota', 'tbDetallePedido.Id', '=', 'GEN.DetallePedidoNota.IdDetallePedido')
   		->leftJoin('GEN.NotaProducto', 'GEN.DetallePedidoNota.IdNotaProducto', '=', 'GEN.NotaProducto.Id')
   		->leftJoin('GEN.Nota', 'GEN.NotaProducto.IdNota', '=', 'GEN.Nota.Id')
   		->where('tbDetallePedido.Id', '=', $iddetallepedido)
   		->select('tbDetallePedido.detped','GEN.Nota.Descripcion')
	    ->get();

		
		return View::make('tomapedidoajax/mostrarnotaajax',					
						 [
						 'listaNota' => $listaNota
						 ]);
	}

	public function actionEliminarProductoAjax()
	{
			$iddetalle = Input::get('iddetalle');
			$codigoeli = Input::get('codigoeli');
			$sumatotal = Input::get('sumatotal');
			$cambio = GENTipoCambio::orderBy('FechaCrea', 'desc')->first();
			
			$tVENPedido=VENPedido::find(Input::get('idpedido'));
			$tVENPedido->BaseAfecta=($sumatotal/1.18);
			$tVENPedido->Igv=($sumatotal-($sumatotal/1.18));
			$tVENPedido->TotalMN=$sumatotal;
			$tVENPedido->TotalME=($sumatotal/($cambio->CambioCompra));
			$tVENPedido->save();

			$tVENDetallePedido=VENDetallePedido::find(Input::get('iddetalle'));
			$tVENDetallePedido->activo=0;
			$tVENDetallePedido->save();

			$arrayjson[] = array(
							'codigo'          => $codigoeli,
							'actualizacion' => '3'
			);

			echo json_encode($arrayjson);
	}


	public function actionInsertarConAjax()
	{

		$xml='<R>';
		$xmldet='<D>';
		$fecha = date("Y-m-d H:i:s");
		$idpedido=Input::get('idpedido');

		$idusuario=Session::get('Usuario')[0]->Id; // que usuario le ponemos al cliente?

		$listaprecio=explode(',', Input::get('precio'));
		$detalletexto=explode(',', Input::get('detalletexto'));
		$listacantidad=explode(',', Input::get('cantidad'));
		$listasubtotal=explode(',', Input::get('subtotal'));
		$listaidproducto=explode(',', Input::get('idproducto'));
		$codigo=Input::get('codigo');
		$descripcion=Input::get('descripcion');
		$cantidad=Input::get('cantidad');
		$mesa=Input::get('mesa');
		$txtdetalle = "";
		$nombrecli = Input::get('nombrecli');
		$numerodoc = Input::get('numerodoc');
		$razonsocial = Input::get('razonsocial');
		$mesarapida = 0;
		
		$arrayjson = array();
		$idmesa=Input::get('idmesa');
		$arrayCarrito = array();
		Session::put('arrayCarrito', $arrayCarrito);
		Session::put('mensaje', 1);

		//mesa rapida
		$posicion = strpos($mesa, "TG");
		if($posicion !== FALSE){
			$mesarapida=1;
		}

		for ($i = 0; $i < count($listaprecio)-1; $i++) {

			if($detalletexto[$i]!=""){

				$detalle = explode('/', $detalletexto[$i]);
				$txtdetalle=$detalle[1];

				if($detalle[0]!=""){
					$radio = explode('*', $detalle[0]);
					for ($j = 0; $j < count($radio)-1; $j++) {
						$xmldet=$xmldet.'<detno><fil>'.($i+1).'</fil><filn>'.($j+1).'</filn><idn>'.$radio[$j].'</idn></detno>';
					}
				}
			}
			$xml=$xml.'<pdo><fil>'.($i+1).'</fil><fch>'.$fecha.'</fch><idusu>'.$idusuario.'</idusu><idme>'.$idmesa.'</idme><cant>'.$listacantidad[$i].'</cant><pre>'.$listaprecio[$i].'</pre><stl>'.$listasubtotal[$i].'</stl><idpro>'.$listaidproducto[$i].'</idpro><detped>'.$txtdetalle.'</detped><nomcli>'.$nombrecli.'</nomcli><numdoc>'.$numerodoc.'</numdoc><razonso>'.$razonsocial.'</razonso><mr>'.$mesarapida.'</mr></pdo>';
			$txtdetalle="";	
		}

		$xml=$xml.'</R>';
		$xmldet=$xmldet.'</D>';

		$idpedidog="";
		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC AM_PEDIDOXML ?,?,?,?');
        $stmt->bindParam(1, $xml ,PDO::PARAM_STR);
        $stmt->bindParam(2, $xmldet ,PDO::PARAM_STR);
        $stmt->bindParam(3, $idpedido ,PDO::PARAM_STR);   
        $stmt->bindParam(4, $idpedidog ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,20);
        $stmt->execute();
		

         $listaProductoC = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.Pedido.IdEstado', '=', 'LIM01CEN000000000002')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 0)
   		->where('tbDetallePedido.Estado', '=', 0)
   		->where('VEN.Pedido.ID', '=', $idpedidog)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('tbDetallePedido.EstadoNota','tbDetallePedido.Id as IdDetallePedido','tbDetallePedido.nomcli','tbDetallePedido.detped','VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();

		$listaPedido=true;
		$arrayjson[] = array(
							'codigo'           => $codigo,
							'descripcion'      => $descripcion,
							'cantidad'         => $cantidad,
							'mesa'             => $mesa,
							'fecha'            => $fecha,
							'nombrecli'		   => $nombrecli,
							'listaPedido'      => $listaPedido,
							'listaProductoC'   => $listaProductoC,
							'idUsuario'        => $idusuario,
							'actualizacion'    => '1'
		);

		echo json_encode($arrayjson);


	}


	public function actionCocina()
	{


		$listaProductoD = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 0)
   		->where('tbDetallePedido.MesaRapido', '=', 1)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('tbDetallePedido.EstadoNota','tbDetallePedido.Id as IdDetallePedido','tbDetallePedido.nomcli','tbDetallePedido.detped','VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();

		$listaProductoC = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.Pedido.IdEstado', '=', 'LIM01CEN000000000002')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 0)
   		->where('tbDetallePedido.MesaRapido', '=', 0)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('tbDetallePedido.EstadoNota','tbDetallePedido.Id as IdDetallePedido','tbDetallePedido.nomcli','tbDetallePedido.detped','VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();


	    $listaProductoP = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.Pedido.IdEstado', '=', 'LIM01CEN000000000002')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.MesaRapido', '=', 0)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();

	     $listaProductoR = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.MesaRapido', '=', 1)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();

		return View::make('tomapedido/cocina',
						 ['listaProductoC' => $listaProductoC,
						  'listaProductoP' => $listaProductoP,
						  'listaProductoD' => $listaProductoD,
						  'listaProductoR' => $listaProductoR]
			             );
	}


	public function actionCocinaAjax()
	{
		$fechaP = date("Ymd H:i:s");
		$codigo=Input::get('codigo');
		$descripcion=Input::get('descripcion');
		$cantidad=Input::get('cantidad');
		$mesa=Input::get('mesa');
		$fecha=Input::get('fecha');
		$IdDetPed=Input::get('IdDetPed');
		$arrayjson = array();

		$tbDetPed=tbDetallePedido::find($IdDetPed);
		$tbDetPed->Activo=1;
		$tbDetPed->FechaPreparado=$fechaP;
		$tbDetPed->save();

		$arrayjson[] = array(
							'codigo'        => $codigo,
							'descripcion'   => $descripcion,
							'cantidad'      => $cantidad,
							'mesa'          => $mesa,
							'IdDetPed'      => $IdDetPed,
							'fechaP'	    => $fechaP,
							'actualizacion' => '2'
		);

		echo json_encode($arrayjson);
	}


	public function actionAtendido()
	{
		$fechaA = date("Ymd H:i:s");
		$iddetped=Input::get('iddetped');
		$mesa=Input::get('mesa');

		$tbDetPed=tbDetallePedido::find($iddetped);
		$tbDetPed->Activo=2;
		$tbDetPed->FechaAtendido=$fechaA;
		$tbDetPed->save();

		$arrayjson[] = array(
							'iddetped'           => $iddetped,
							'mesa'           => $mesa,
							'actualizacion'    => '5'
		);

		echo json_encode($arrayjson);

	}


	public function actionCocinaMesero()
	{

		$listaProductoC = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.Pedido.IdEstado', '=', 'LIM01CEN000000000002')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 0)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('tbDetallePedido.EstadoNota','tbDetallePedido.Id as IdDetallePedido','tbDetallePedido.nomcli','tbDetallePedido.detped','VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();

	    $listaProductoP = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.Pedido.IdEstado', '=', 'LIM01CEN000000000002')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.MesaRapido', '=', 0)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();

	    $listaProductoR = DB::table('VEN.Pedido')
   		->join('VEN.DetallePedido', 'VEN.Pedido.Id', '=', 'VEN.DetallePedido.IdPedido')
   		->join('GEN.Producto', 'GEN.Producto.Id', '=', 'VEN.DetallePedido.IdProducto')
   		->join('VEN.Mesa', 'VEN.Mesa.Id', '=', 'VEN.Pedido.IdMesa')
   		->join('tbDetallePedido', 'tbDetallePedido.Id', '=', 'VEN.DetallePedido.Id')
   		->where('VEN.DetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.Activo', '=', 1)
   		->where('tbDetallePedido.MesaRapido', '=', 1)
   		->orderBy('VEN.Pedido.FechaCrea', 'ASC')
   		->select('VEN.DetallePedido.Id','GEN.Producto.CodigoProducto','VEN.Pedido.FechaCrea','VEN.Mesa.Numero','GEN.Producto.Descripcion','VEN.DetallePedido.PrecioExtendido','VEN.DetallePedido.Cantidad','VEN.Pedido.TotalMN')
	    ->get();

		return View::make('tomapedido/cocinamesero',
						 ['listaProductoC' => $listaProductoC,
						  'listaProductoP' => $listaProductoP,
						  'listaProductoR' => $listaProductoR]
			             );
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