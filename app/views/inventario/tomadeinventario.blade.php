@extends('template')
@section('style')


    {{ HTML::style('/css/tabla/footable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.sortable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.paginate.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}
    {{ HTML::style('/css/cssInventario.css') }}


@stop


@section('section')

<div class="titulo col-xs-12 col-md-12">


	<h4 style="text-align:center;">
		Toma de {{$nombreopcion}} - 
		{{$listaPlantillaToma[0]->Correlativo}} - 
		@if($listaPlantillaToma[0]->EstadoProceso=='P')
			Primera Toma
		@else
		 	Segunda Toma
		@endif - 
		{{count($listaPlantillaToma)}} Productos

	</h4>

</div>
<div class="conversor" data-toggle="modal" data-target="#conversor">
	<i class="fa fa-calculator fa-3x"></i>
</div>


    @if (Session::get('alertaMensajeGlobal'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <strong>Bien Hecho!</strong> {{ Session::get('alertaMensajeGlobal') }}
       
      </div>
    @endif  

<div class="container">



	<div class="row">
		
		<div class="col-xs-12 cabecerageneral">
		<div class="col-xs-12">


			    <ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#inventario">Toma Inventario</a></li>
				  <li><a data-toggle="tab" href="#productermi">Producto Terminado</a></li>
				</ul>


				<div class="tab-content">

				  <div id="inventario" class="tab-pane fade in active">
						<div class="filtro col-xs-12 col-md-12">

							<div class="input-group" >
				
						    	<input  class="form-control control" id="textsearxh"  placeholder="Buscar" >
			
							    <span class="input-group-btn">
							    	<button class=" btn btn-success" id="searchInputbtnb" type="button">
								    	<i class="fa fa-search fa-lg"></i>

								    </button>
							    </span>

						    </div>	

						</div>
					<div class="listatabla col-xs-12">	
						<div class="listatoma col-xs-12">

						    <table class="table demo" >
						      	<thead>
							        <tr>
							          	<th >
							            	Cód.
							          	</th>
							          	<th class="descripcion">
							            	Descripción
							          	</th>
							          	<th class="stock">
							            	Stock Físico
							          	</th>
							          	<th class="unidadd">
							            	Und.
							          	</th>
							        </tr>
						      	</thead>
						      	<tbody id="fbody">
						        		@foreach($listaPlantillaToma as $item)

						        		@if($item->Tipo=='N')
											<tr id="{{$item->IdTomaWeb}}*{{$item->IdProducto}}*{{$item->IdUsuario}}*{{$item->EstadoProceso}}" class='tablapedidodatanormal' data-toggle="modal" data-target="#insertarinventarionormal">
													{{--*/ $stock = 'StockFisico1' /*--}}
													@if($item->EstadoProceso=='S')
														{{--*/ $stock = 'StockFisico2' /*--}}
													@endif		

													<!--          Prioridad             -->
													{{--*/ $prioridad = '' /*--}}
													{{--*/ $realizo   = '' /*--}}

													@if($item->Codigo!='')
														{{--*/ $prioridad = '(P)' /*--}}

														{{--*/ $realizo   = '' /*--}}	
													@endif	

													@if($item->Digito == 0)
														{{--*/ $realizo   = "<small class='digito'></small>" /*--}}	
													@endif
													@if($item->Digito == 1)
														{{--*/ $realizo   = "<small class='digito'><i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i></small>" /*--}}	
													@endif	


								        			<td class="codigo">{{$item->CodigoProducto}}</td>
								        			<td class="descripcion">
								        				{{strtoupper($item->Descripcion)}} <strong>{{$prioridad}} </strong> {{$realizo}}								        				

								        			</td>

								        			<td class="stock" id="S{{$item->IdProducto}}">{{number_format($item->$stock, 3, '.', '')}}</td>
									        		<td class="unidadd">{{strtoupper($item->Abreviatura)}}</td>



								            </tr>
						                @endif
									@endforeach
						      	</tbody>
						      	<tfoot class="footable-pagination">
						        	<tr>
						          		<td colspan="6"><ul id="pagination" class="footable-nav"></ul></td>
						        	</tr>
						      	</tfoot>
						    </table> 
						</div>

					</div>

				  </div>
				  <div id="productermi" class="tab-pane fade">





						<div class="filtro col-xs-12 col-md-12">


							<div class="input-group" >
				
						    	<input  class="form-control control" id="textsearxhm"  placeholder="Buscar" >
			
							    <span class="input-group-btn">
							    	<button class=" btn btn-success" id="searchmanufacturado" type="button">
								    	<i class="fa fa-search fa-lg"></i>

								    </button>
							    </span>

						    </div>	

						


						</div>

						<div class="listatoma col-xs-12">
						    <table class="table demo" >
						      	<thead>
							        <tr>
							          	<th >
							            	Cód.
							          	</th>
							          	<th class="descripcion">
							            	Descripción
							          	</th>
							          	<th class="stock">
							            	Stock Físico
							          	</th>
							          	<th class="unidadd">
							            	Und.
							          	</th>
							        </tr>
						      	</thead>
						      	<tbody id="fbodymanufacturado">
						        
						        		@foreach($listaPlantillaToma as $item)

							        		@if($item->Tipo=='M')
												<tr id="{{$item->IdTomaWeb}}*{{$item->IdProducto}}*{{$item->IdUsuario}}*{{$item->EstadoProceso}}" class='tablapedidodatamanu' data-toggle="modal" data-target="#insertarinventariomanu">
													{{--*/ $stock = 'StockFisico1' /*--}}
													@if($item->EstadoProceso=='S')
														{{--*/ $stock = 'StockFisico2' /*--}}
													@endif	


													<!--          Prioridad             -->
													{{--*/ $prioridad = '' /*--}}
													{{--*/ $realizo   = '' /*--}}

													@if($item->Codigo!='')
														{{--*/ $prioridad = '(P)' /*--}}

														{{--*/ $realizo   = '' /*--}}	
													@endif	

													@if($item->Digito == 0)
														{{--*/ $realizo   = "<small class='digito'></small>" /*--}}	
													@endif
													@if($item->Digito == 1)
														{{--*/ $realizo   = "<small class='digito'><i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i></small>" /*--}}	
													@endif	

													

								        			<td class="codigo">{{$item->CodigoProducto}}</td>
								        			<td class="descripcion">
								        				{{strtoupper($item->Descripcion)}}
								        				<strong>{{$prioridad}} </strong> {{$realizo}}

								        			</td>
								        			<td class="stock" id="S{{$item->IdProducto}}">{{number_format($item->$stock, 3, '.', '')}}</td>
									        		<td class="unidadd">{{strtoupper($item->Abreviatura)}}</td>
								            	</tr>
							            	@endif

										@endforeach
						      	</tbody>
						      	<tfoot class="footable-pagination">
						        	<tr>
						          		<td colspan="6"><ul id="pagination" class="footable-nav"></ul></td>
						        	</tr>
						      	</tfoot>
						    </table> 

						</div>





				  </div>

				</div>








		</div>

	</div>	
	</div>	

</div>


  <!-- Modal -->
  <div class="modal fade" id="conversor" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Conversor de Medida</h4>
        </div>
        <div class="modal-body">

        	<div class="row">
        		<div class="col-xs-12 col-lg-5">

				    <div class="input-group">
				        <span class="input-group-addon"><strong>De:</strong></span>

				        <div class="form-group">
				            <input  type="number" min="0.0" name="unidadorigen" id="unidadorigen" class="decimal form-control"  placeholder="Origen" >             
				        </div>

				        <div class="form-group">

				        	<select class="form-control control" id="sunidadorigen" name='sunidadorigen'>
								<option value='0'>Seleccione Unidad Origen</option>
								@foreach($selectedmedida as $item)
									<option value='{{$item->Id}}'>{{$item->Descripcion}}</option>
								@endforeach	
							</select>       
				        </div>
				    </div>

        			
				</div>
				<div class="col-xs-12 col-lg-2" style="text-align:center;">

					 <button type="submit" id="convertirunidad" class="btn btn-primary">Convertir</button>

				</div>
				<div class="col-xs-12 col-lg-5">

					<div class="input-group">
				        <span class="input-group-addon"><strong>A:</strong></span>

				        <div class="form-group">
				        	<span class="form-control input-group-addon" id="unidaddestino" name="unidaddestino">0.00</span>              
				        </div>

				        <div class="form-group">

							<select class="form-control control" id="sunidaddestino" name='sunidaddestino'>
								<option value='0'>Seleccione Unidad Destino</option>
							</select>
         
				        </div>
				    </div>



				</div>

				<div class="col-xs-12" style="margin-top:15px;">
					<div class="alert alert-danger error-unidad" style="display:none;">
					  
					</div>
				</div>

			</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
 



	  <!-- Modal -->
	  <div class="modal fade" id="insertarinventarionormal" role="dialog">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title tituloproducto" style="text-align:center;"></h4>
	        </div>
	        <div class="modal-body ">

	        	<div class="row">
	        		<div class="col-xs-12 col-lg-12">
						<div class="input-group" >
					    	<span class="input-group-addon" id="totalstock"></span>
						    <input type="number" min="0.0" id="plusstock" autofocus class="stockingresado decimal form-control" placeholder="0.00" >
						    <span class="input-group-btn">
						    	<button class="btnagregarstock btn btn-success" id="" type="button">
							    	<i class="fa fa-plus fa-lg"></i>
							    	<div style="display:none;" class="loader">Loading...</div>
							    	<i class="fa fa-check" style="display:none;"></i>
							    </button>

							    <button class="btndisminuirstock btn btn-danger" id="" type="button">
							    	<i class="fa fa-minus fa-lg"></i>
							    	<div style="display:none;" class="loader">Loading...</div>
							    	<i class="fa fa-check" style="display:none;"></i>
							    </button>


							    <button class="btneditstock btn btn-primary" id="" type="button">
							    	<i class="fa fa-pencil fa-lg"></i>
							    	<div style="display:none;" class="loader">Loading...</div>
							    	<i class="fa fa-check" style="display:none;"></i>
							    </button>

						    </span>

					    </div>

					    <div class="alerterror">
					    </div>

					</div>

				</div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        </div>
	      </div>
	    </div>
	  </div>



	  <!-- Manufacturado -->
	  <div class="modal fade" id="insertarinventariomanu" role="dialog">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title tituloproducto" style="text-align:center;"></h4>
	        </div>
	        <div class="modal-body ">

	        	<div class="row">
	        		<div class="col-xs-12 col-lg-12">

						    <div class="input-group" >
						    	<span class="input-group-addon" id="totalstock"></span>
							    <input type="number" min="0.0" id="plusstock" class="stockingresado numero form-control " placeholder="0" >
							    <span class="input-group-btn">

							    	<button class="btnagregarstock btn btn-success" id="" type="button">
								    	<i class="fa fa-plus fa-lg"></i>
								    	<div style="display:none;" class="loader">Loading...</div>
								    	<i class="fa fa-check" style="display:none;"></i>
								    </button>

								    <button class="btndisminuirstock btn btn-danger" id="" type="button">
								    	<i class="fa fa-minus fa-lg"></i>
								    	<div style="display:none;" class="loader">Loading...</div>
								    	<i class="fa fa-check" style="display:none;"></i>
								    </button>

								    <button class="btneditstock btn btn-primary" id="" type="button">
								    	<i class="fa fa-pencil fa-lg"></i>
								    	<div style="display:none;" class="loader">Loading...</div>
								    	<i class="fa fa-check" style="display:none;"></i>
								    </button>

							    </span>

						    </div>

						    <div class="alerterror">
						    </div>

					</div>

				</div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        </div>
	      </div>
	    </div>
	  </div>

	  <div id='idopcion' style='display:none;'>{{$idOpcion}}</div>

	  

@stop

@section('script')

	<script type="text/javascript">


			$('.tablapedidodatanormal').on('click', function(event){

				$('#insertarinventarionormal .tituloproducto').html($(this).find('.descripcion').html());
				$('#insertarinventarionormal #totalstock').html($(this).find('.stock').html());
				$('#insertarinventarionormal .btnagregarstock').attr("id",$(this).attr('id'));
				$('#insertarinventarionormal .btndisminuirstock').attr("id",$(this).attr('id'));
				$('#insertarinventarionormal .btneditstock').attr("id",$(this).attr('id'));
				$('.fa-check').css("display", "none");
				
		    });

		    $('#insertarinventarionormal').on('shown.bs.modal', function () {
			  $('#insertarinventarionormal #plusstock').focus();
			})


			$('.tablapedidodatamanu').on('click', function(event){

				$('#insertarinventariomanu .tituloproducto').html($(this).find('.descripcion').html());
				$('#insertarinventariomanu #totalstock').html($(this).find('.stock').html());
				$('#insertarinventariomanu .btnagregarstock').attr("id",$(this).attr('id'));
				$('#insertarinventariomanu .btndisminuirstock').attr("id",$(this).attr('id'));
				$('#insertarinventariomanu .btneditstock').attr("id",$(this).attr('id'));
				$('.fa-check').css("display", "none");
				
		    });

		    $('#insertarinventariomanu').on('shown.bs.modal', function () {
			    $('#insertarinventariomanu #plusstock').focus();
			})



	    	$("#searchInputbtnb").on('click',function () {

			    var rows = $("#fbody").find("tr").hide();
			   	var t = document.getElementById('textsearxh');		
			    if (t.value.length) {
			        var data = t.value.split(" ");
			        
			        $.each(data, function (i, v) {
			            rows.filter("*:contains('" + v.toUpperCase() + "')").show();
			        });
			    } else rows.show();

			});

			$("#searchmanufacturado").on('click',function () {
			    var rows = $("#fbodymanufacturado").find("tr").hide();
			    var t = document.getElementById('textsearxhm');
			    console.log(t);
			    if (t.value.length) {
			        var data = t.value.split(" ");
			        
			        $.each(data, function (i, v) {
			            rows.filter("*:contains('" + v.toUpperCase() + "')").show();
			        });
			    } else rows.show();
			});

	</script>

@stop