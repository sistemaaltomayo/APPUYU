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

    @if (Session::get('alertaMensajeGlobal'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <strong>Bien Hecho!</strong> {{ Session::get('alertaMensajeGlobal') }}
       
      </div>
    @endif  

<div class="container">

	<div class="conversor" data-toggle="modal" data-target="#conversor">
		<i class="fa fa-calculator fa-3x"></i>
	</div>

	<div class="row">
		

		<div class="col-xs-12 cabecerageneral">

						<div class="filtro col-xs-12 col-md-12">



							<div class=" col-xs-12 col-md-6">

								<div class="input-group" >
					
									<input id="searchInputa" class="form-control control"  placeholder="Buscar">
									
									<span class="input-group-btn">
								    	<button class=" btn btn-success" onclick="btnbuscar();" type="button">
									    	<i class="fa fa-search fa-lg"></i>
									    </button>
								    </span>

							    </div>

							</div>	
							<div class=" col-xs-12 col-md-6">
								<input id="codigobarra" class="form-control control"  placeholder="Codigo de barra" onKeyPress="codigobarra(event)">
							</div>	
								
						</div>


						<div class="listatoma col-xs-12">
						    <table class="table demo" >
						      	<thead>
							        <tr>
							        	<th style="display:none;">
							            	Cód.Barra
							          	</th>
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
										<tr  id="{{$item->IdTomaWeb}}*{{$item->IdProducto}}*{{$item->IdUsuario}}*{{$item->EstadoProceso}}" class='tablapedidodata' data-toggle="modal" data-target="#insertarinventario">
											{{--*/ $stock = 'StockFisico1' /*--}}
											@if($item->EstadoProceso=='S')
												{{--*/ $stock = 'StockFisico2' /*--}}
											@endif


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



											<td style="display:none;">{{$item->CodigoBarra}}</td>
						        			<td class="codigo">{{$item->CodigoProducto}}</td>
						        			<td class="descripcion">
						        				{{strtoupper($item->Descripcion)}} <strong>{{$prioridad}} </strong> {{$realizo}}
						        			</td>
							        		<td class="stock" id="S{{$item->IdProducto}}">{{number_format($item->$stock, 3, '.', '')}}</td>
							        		<td class="unidadd">{{strtoupper($item->Abreviatura)}}</td>
						            	</tr>
									@endforeach
						      	</tbody>
						      	<tfoot class="footable-pagination">
						        	<tr>
						          		<td colspan="6">
						          			<ul id="pagination" class="footable-nav"></ul>
						          		</td>
						        	</tr>
						      	</tfoot>
						    </table> 

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
				        <span class="input-group-addon">
				        	<strong>De:</strong>
				        </span>

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

	<audio class="erroraudio" id="audioerror" style="display:none;" >
	  <source src="/APPCOFFEE/audio/error.mp3" type="audio/mpeg">
	</audio>
 



  <!-- Modal -->
  <div class="modal fade" id="insertarinventario" role="dialog">
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
						    	
						    	<button class="btnagregarstockE btn btn-success" id="" type="button">
							    	<i class="fa fa-plus fa-lg"></i>
							    	<div style="display:none;" class="loader">Loading...</div>
							    	<i class="fa fa-check" style="display:none;"></i>
							    </button>

							    <button class="btndisminuirstockE btn btn-danger" id="" type="button">
							    	<i class="fa fa-minus fa-lg"></i>
							    	<div style="display:none;" class="loader">Loading...</div>
							    	<i class="fa fa-check" style="display:none;"></i>
							    </button>


							    <button class="btneditstockE btn btn-primary" id="" type="button">
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

			$('.tablapedidodata').on('click', function(event){

				$('.tituloproducto').html($(this).find('.descripcion').html());
				$('#totalstock').html($(this).find('.stock').html());
				$('.btnagregarstockE').attr("id",$(this).attr('id'));
				$('.btndisminuirstockE').attr("id",$(this).attr('id'));
				$('.btneditstockE').attr("id",$(this).attr('id'));
				$('.fa-check').css("display", "none");
				

		    });

		    $('#insertarinventario').on('shown.bs.modal', function () {
			  $('#plusstock').focus();
			})



	    	function btnbuscar() {

			    var rows = $("#fbody").find("tr").hide();
			   	var t = document.getElementById('searchInputa');	
			   	
			    if (t.value.length) {
			        var data = t.value.split(" ");
			        
			        $.each(data, function (i, v) {
			            rows.filter("*:contains('" + v.toUpperCase() + "')").show();
			        });
			    } else rows.show();

			}


			function codigobarra(event)
			{

				var idopcion = $('#idopcion').html();
		  	    if (event.which == 13 && !event.shiftKey) {

		  	    	var codigobarra = $("#codigobarra").val();
		  	    	var preciostock = 0;
		  	    	var sw=0;
		  	    	var puntero="";



			        $("#searchInputa").val(codigobarra);

					$('#searchInputa').focus().click();
					btnbuscar();

			        setTimeout(function(){
					   $('#codigobarra').focus();
					}, 500);
			        

					$('#fbody tr').each(function () {
						var codigo = $(this).find("td").eq(0).html();
						if(codigo == codigobarra){
							sw=1;
							preciostock = $(this).find(".stock").html();
							puntero = $(this).attr('id');
						}
					});

					var idtabla = puntero;
        			var array = idtabla.split('*');

					$("#codigobarra").val("");

					if(sw>0){

						
						var suma = parseFloat(preciostock)+1;

	                    $.ajax(
	                    {
	                        url: "/APPCOFFEE/insertar-stock-inventario-embarque",
	                        type: "POST",
	                        data: "idstock="+puntero+"&stock="+suma,

	                    }).done(function(pagina) 
	                    {

	                        if(pagina==1){

	                        	$("#S"+array[1]).html(suma.toFixed(3));
	                        	$("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");
	                        }else{
	                            window.location.href = '/getion-inventario-embarque/'+idopcion;
	                        }
	                        
	                    }); 



					}else{

						$("#audioerror")[0].play();

					}

					

			    }

			}



	</script>

@stop