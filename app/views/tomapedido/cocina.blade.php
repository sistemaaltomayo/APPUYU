@extends('template')

@section('section')

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<div class="permisomsj">

	</div>
	<h4 style="text-align:center;">COCINA </h4>
</div>

<div class="container containercocina" >

	<div class="row">
		<div class="col-xs-12 cabecerageneral ">
			<div class="col-xs-12 col-md-6">
				<div class="panel panel-primary">
				      <div class="panel-heading">
				        <h3 class="panel-title">EN COCINA</h3>
				      </div>
				      <div class="panel-body">
				        <table id="cabecera" class="table" >
							<tbody>
								<tr>
									<th style="display:none;"></th>
									<th style="display:none;"></th>
									<th width="50%">Descripcion</th>
									<th width="14%">Cantidad</th>
									<th width="14%" style="text-align:center">Cliente</th>
									<th width="22%"></th>
								</tr>
							</tbody>
						</table>
						<table id="mesarapida" class="table" >
							<tbody>
								@foreach($listaProductoD as $item)
									<tr id="{{$item->Id}}">
										<td style='display:none;'>{{$item->CodigoProducto}}</td>
										<td style='display:none;'>{{str_replace(" ","/",$item->FechaCrea)}}</td>
										<td width="50%">{{$item->Descripcion}}</td>
										<td width="14%" style='text-align:center'>
											<span class='badge cantidadcocina'>{{(int)($item->Cantidad)}}</span>
										</td>
										<td width="14%" style='text-align:center'>
											<span class='label label-default mesacocina'>{{$item->nomcli}}</span>
										</td>
										<td width="22%" style='text-align:center'>

												<ul class='nav navbar-nav navbar-left'>
													<li class='dropdown'>
														<button type='button' class='btn-detalle btn btn-default btn-sm' onclick="notapedido('{{$item->IdDetallePedido}}',this)" data-toggle='dropdown' class='dropdown-toggle'>
															<span class='glyphicon glyphicon-comment' style="@if($item->detped != "" || $item->EstadoNota>0)color:red;@elsecolor:#2e6da4;@endif" aria-hidden=true></span>
														</button>
														
														<ul class='dropdown-menu msjdet'>
															<li>
																<div class='yamm-content'>
																	
																</div>
															</li>
														</ul>
													</li>
												</ul>
												<button type='submit' id="{{$item->CodigoProducto}}**{{(int)($item->Cantidad)}}**{{$item->Numero}}**{{str_replace(" ","/",$item->FechaCrea)}}" class='btn btn-default btn-sm' onclick="atender('{{$item->CodigoProducto}}**{{(int)($item->Cantidad)}}**{{$item->Numero}}**{{str_replace(" ","/",$item->FechaCrea)}}**{{$item->Id}}')">
													<span class='glyphicon glyphicon-share-alt asignar' aria-hidden=true>
															
													</span>
												</button>
										</td>
									</tr>
							    @endforeach
							</tbody>
						</table>
						<table id="tablacocina" class="table table-striped" >
							<tbody>
								@foreach($listaProductoC as $item)
									<tr id="{{$item->Id}}">
										<td style='display:none;'>{{$item->CodigoProducto}}</td>
										<td style='display:none;'>{{str_replace(" ","/",$item->FechaCrea)}}</td>
										<td width="50%">{{$item->Descripcion}}</td>
										<td width="14%" style='text-align:center'>
											<span class='badge cantidadcocina'>{{(int)($item->Cantidad)}}</span>
										</td>
										<td width="14%" style='text-align:center'>
											<span class='label label-default mesacocina'>{{$item->nomcli}}</span>
										</td>
										<td width="22%" style='text-align:center'>

												<ul class='nav navbar-nav navbar-left'>
													<li class='dropdown'>
														<button type='button' class='btn-detalle btn btn-default btn-sm' onclick="notapedido('{{$item->IdDetallePedido}}',this)" data-toggle='dropdown' class='dropdown-toggle'>
															<span class='glyphicon glyphicon-comment' style="@if($item->detped != "" || $item->EstadoNota>0)color:red;@elsecolor:#2e6da4;@endif" aria-hidden=true></span>
														</button>
														
														<ul class='dropdown-menu msjdet'>
															<li>
																<div class='yamm-content'>
																	
																</div>
															</li>
														</ul>
													</li>
												</ul>
												<button type='submit' id="{{$item->CodigoProducto}}**{{(int)($item->Cantidad)}}**{{$item->Numero}}**{{str_replace(" ","/",$item->FechaCrea)}}" class='btn btn-default btn-sm' onclick="atender('{{$item->CodigoProducto}}**{{(int)($item->Cantidad)}}**{{$item->Numero}}**{{str_replace(" ","/",$item->FechaCrea)}}**{{$item->Id}}')">
													<span class='glyphicon glyphicon-share-alt asignar' aria-hidden=true>
															
													</span>
												</button>
										</td>
									</tr>
							    @endforeach
							</tbody>
						</table>	
				      </div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="panel panel-info">
				      <div class="panel-heading">
				        <h3 class="panel-title">PREPARADOS</h3>
				      </div>
				      <div class="panel-body">
				        <table id="cabeceracliente" class="table" >
							<tbody>
								<tr>
									<th width="55%">Descripcion</th>
									<th width="15%">Cantidad</th>
									<th width="15%" style="text-align:center">Mesa</th>
									<th width="15%"></th>
								</tr>
							</tbody>
						</table>

						<table id="tablaclienter" class="table table-striped" >
							<tbody>
								@foreach($listaProductoR as $item)
									<tr id="{{$item->Id}}">
										<td width="55%">{{$item->Descripcion}}</td>
										<td width="15%" style="text-align:center">
											<span class="badge cantidadcocina">{{(int)($item->Cantidad)}}</span>
										</td>
										<td width="15%" style="text-align:center">
											<span class="label label-default mesacocina">{{$item->Numero}}</span>
										</td>
										<td width="15%" style='text-align:center'>
												<button type='submit' id="" class='btn btn-default btn-sm' onclick="servido('{{$item->Id}}','{{$item->Numero}}')">
													<span class='glyphicon glyphicon-cutlery asignar' aria-hidden=true>
															
													</span>
												</button>
										</td>
									</tr>
							    @endforeach
							</tbody>
						</table>

						<table id="tablacliente" class="table table-striped" >
							<tbody>
								@foreach($listaProductoP as $item)
									<tr id="{{$item->Id}}">
										<td width="55%">{{$item->Descripcion}}</td>
										<td width="15%" style="text-align:center">
											<span class="badge cantidadcocina">{{(int)($item->Cantidad)}}</span>
										</td>
										<td width="15%" style="text-align:center">
											<span class="label label-default mesacocina">{{$item->Numero}}</span>
										</td>
										<td width="15%" style='text-align:center'>
												<button type='submit' id="" class='btn btn-default btn-sm' onclick="servido('{{$item->Id}}',{{$item->Numero}})">
													<span class='glyphicon glyphicon-cutlery asignar' aria-hidden=true>
															
													</span>
												</button>
										</td>
									</tr>
							    @endforeach
							</tbody>
						</table>
				      </div>
				</div>

			</div>

	</div>	
	</div>
</div>
<div id="atendido"></div>

<div id="mensajellama">

</div>
	<audio class="player"  >
	  <source src="/APPCOFFEE/audio/correcaminos_bip_bip.mp3" type="audio/mpeg">
	  no soporta audio
	</audio>
	<audio class="player2"  >
	  <source src="/APPCOFFEE/audio/alerta.mp3" type="audio/mpeg">
	  no soporta audio
	</audio>

@stop

@section('script')

	{{ HTML::script('js/fancywebsocket.js'); }}

<script type="text/javascript">

	function notapedido(iddetallepedido,obj){
		
		var hijo  = $(obj).siblings('.msjdet').find('li').find('.yamm-content');
		hijo.html("");
		$.ajax(
	    {
	        url: "/APPCOFFEE/mostrarnotaajax",
	        type: "POST",
	        data: "iddetallepedido="+iddetallepedido,//+"&detalle="+tabla.html(),
	    }).done(function(pagina) 
	    {
	        hijo.html(pagina);
	    });

	}


	function servido(iddetped,mesa){

			$("#"+iddetped).remove();
			
			$.ajax({
			type: "POST",
			url: "/APPCOFFEE/atendido",
			data: "iddetped="+iddetped+"&mesa="+mesa,
			dataType:"html",
			success: function(data) 
			{
			 	send(data);
			}
			});
	}

	function atender(dataa){


		var tabla="";

		var arr = dataa.split('**');
		var codigo=arr[0];
		var descripcion="";
		var cantidad=arr[1];
		var mesa=arr[2];
		var fecha=arr[3];
		var IdDetPed=arr[4];

		if(mesa.indexOf('TG') != -1){
			tabla=document.getElementById("mesarapida");
		}else{
			tabla=document.getElementById("tablacocina");
		}
		

		for (var i=0;i<tabla.rows.length;i++) {
			if (tabla.rows[i].cells[0].innerHTML==codigo) {
				descripcion=tabla.rows[i].cells[2].innerHTML;
			}				
		}

		$.ajax({
			type: "POST",
			url: "/APPCOFFEE/cocinaajax",
			data: "codigo="+codigo+"&descripcion="+descripcion+"&cantidad="+cantidad+"&mesa="+mesa+"&fecha="+fecha+"&IdDetPed="+IdDetPed,
			dataType:"html",
			success: function(data) 
			{
			 	send(data);
			}
			});
	}
</script>

@stop