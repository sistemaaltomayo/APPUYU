@extends('template')
@section('style')


    {{ HTML::style('/css/tabla/footable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.sortable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.paginate.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}
    {{ HTML::style('/css/cssInspeccion.css') }}


@stop



@section('section')
<div class="mensaje-error"></div>


    @if (Session::get('alertaMensajeGlobalE'))
    <div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>¡Error!</strong> {{ Session::get('alertaMensajeGlobalE') }}
	</div>
    @endif

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">LISTA CHECK LIST</h4>
</div>

<div class="container">
	<div class="row">

	  	<div class="formulario col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">

			<div class="listatabla col-xs-12">	
				<div class="listatoma">
				    <table  class="table demo">
				      	<thead>
					        <tr>
					        	<th colspan="6" class='id'>
					            	{{$listaarea->Descripcion}}
					          	</th>
					        </tr>
					        <tr>
					        	<th colspan="3" class='id'>
					            	ASPECTO A EVALUAR
					          	</th>
					          	<th colspan="2" class='id'>
					            	(SI / NO)
					          	</th>
					          	<th  class='id'>
					            	OBSER.
					          	</th>
					        </tr>
				      	</thead>
				      	<tbody>

				      			{{--*/ $numeraciontotal = 1 /*--}}
				      			{{--*/ $numeracion = 1 /*--}}
				      			{{--*/ $numeraciongrupo = 1 /*--}}
				      			{{--*/ $idpregunta = '' /*--}}
							    @foreach($listaTituloInspeccion as $item)
							    	<tr class='titulotabla'>
							    		<td ></td>
							    		<td colspan="5" ><b>{{$item->Descripcion}}</b></td>
							    	</tr>
							    	@foreach($listaLugarInspeccion as $item2)

										@if($item->Id == $item2->IdTituloInspeccion) 
								 			<tr class='lugartabla'>
								 				<td ></td>
								 				<td colspan="5"><b>{{$item2->Descripcion}}</b></td>
								 			</tr>

								 		@foreach($localPreguntaInspeccion as $item3)
								 			
								 			@if($item2->IdLugarInspeccion == $item3->IdLugarInspeccion) 
									 			<tr>
									 				
									 				@if($item3->Cantidad>1)
									 					@if($idpregunta != $item3->IdPregunta)
															{{--*/ $numeraciongrupo = 1 /*--}}							 					
									 						<td rowspan="{{$item3->Cantidad}}" class="verticalalign">{{$numeracion}}</td>
									 						<td rowspan="{{$item3->Cantidad}}" class="verticalalign"><b>{{$item3->Pregunta}}</b></td>
									 						{{--*/ $idpregunta = $item3->IdPregunta /*--}}
									 						{{--*/ $numeracion = $numeracion + 1 /*--}}
									 					@endif
									 					
									 					<td class="verticalalign detallepregunta"><b>{{$numeraciongrupo}}. {{$item3->DetallePregunta}}</b></td>
									 					{{--*/ $numeraciongrupo = $numeraciongrupo + 1 /*--}}
									 				@else

									 					<td class="verticalalign">{{$numeracion}}</td>
									 					<td colspan="2" class="verticalalign"><b>{{$item3->DetallePregunta}}</b></td>
									 					{{--*/ $numeracion = $numeracion + 1 /*--}}
									 				@endif 


									 				@if($item3->Puntaje > 0)
									 					{{--*/ $cantidadresta = 1 /*--}}

										 				<td>
															<div class="funkyradio ">															 	     													 
															    <div class="funkyradio-success">
															        <input type="radio" name="radio{{$numeraciontotal}}" id="radio{{$numeraciontotal}}" value="{{$item3->Puntaje}}">
															        <label for="radio{{$numeraciontotal}}">SI</label>
															    </div>				        					 										        											  
															</div>
										 				</td>

									 					<td>
															<div class="funkyradio ">															 	     													 			        					 
															    <div class="funkyradio-success">
															        <input type="radio" name="radio{{$numeraciontotal}}" id="radion{{$numeraciontotal}}" value="-{{$item3->Puntaje}}">
															        <label for="radion{{$numeraciontotal}}">NO</label>
															    </div>											        											  
															</div>
										 				</td>
									 				@else

									 				<td colspan="2" >

									 						<div class="funkyradio radiocero">															 	     													 
															    <div class="funkyradio-success">
															        <input type="radio" name="radio{{$numeraciontotal}}" id="radiox{{$numeraciontotal}}" value="{{$item3->Puntaje}}" checked>
															        <label for="radiox{{$numeraciontotal}}">SI</label>
															    </div>				        					 										        											  
															</div>

									 				</td>

									 				@endif 
									 				<td class='grupobtn'>


												      <input type="text" class="form-control control observaciontabla" id='observacion{{$numeraciontotal}}' placeholder="Observación" maxlength="200">
												      <span class="input-group-btn btntabla">
												        	<button class="btntablainspeccion btn btn-secondary btn-warning" type="button">
												        		<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
												        		<i class="fa fa-check" aria-hidden="true"></i>
												        		<i class="pregunta{{$numeraciontotal}} fa fa-question-circle" aria-hidden="true"></i>
												        	</button>
												      </span>
												      <span class="databtn">0</span>
												      <span class="datapuntaje">{{$item3->Puntaje}}</span>
												      <span style='display:none;' class="idlocalinspeccionpregunta{{$numeraciontotal}}">{{$item3->Id}}</span>
												      
									 				
									 				</td>

									 			</tr>
									 		{{--*/ $numeraciontotal = $numeraciontotal + 1 /*--}}
									 		@endif
									 		
								 		@endforeach



										@endif
							    	@endforeach
							    @endforeach
				      		
				      	</tbody>
				    </table>  
				</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btnguardarinspeccion" class="btnguardar btn btn-primary" value="Guardar">
				<div class="alerta">
   	
			    </div> 
			</div>
			<p id="contadorUnico" style="display:none;">{{$numeraciontotal}}</p>
			<span id='idlocalinspeccion' style='display:none;'>{{$idlocalinspeccion}}</span>
			</div>

	  	</div>

	</div>	
</div>
<div id='idopcion' style='display:none;'>{{$idOpcion}}</div>

<div class="modal fade" id="modalcargando" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="width:320px;height:310px;margin:0 auto">

        <div class="modal-body">
          	<div class="cargandoreportefail">
				{{ HTML::image('img/cargando1.gif', 'cargando') }}
			</div>
			<p class="msjcargando">Espere por favor</p>
			<p class="msjcargando">Esto puede tardar varios minutos ...</p>

		    <div class="alertajax alert alert-danger ">
		        <a href="javascript:location.reload()" class="btnfail btn btn-xs btn-danger pull-right">Intentar Nuevamente</a>
		        <strong>Error: </strong> <span class='msjfailajax'></span>
		    </div>


        </div>

      </div>
    </div>
</div>

@stop
@section('script')

	<script type="text/javascript">

		$('.btntablainspeccion').on('click', function(event){

			cajatexto = $(this).parent().siblings('.observaciontabla');
			dataspan  = $(this).parent().siblings('.databtn');
			hijocheck = $(this).find('.fa-check');
			if(dataspan.html()=='0'){
				$(cajatexto).css( "display", "block" );
				dataspan.html('1');
				$(cajatexto).focus();
			}else{
				if(cajatexto.val()!=""){
					$(hijocheck).css( "display", "inline-block" );
				}else{
					$(hijocheck).css( "display", "none" );
				}
				$(cajatexto).css( "display", "none" );	
				dataspan.html('0');
			}
	    });


		$('#btnguardarinspeccion').on('click', function(event){

			var xml="";
			var sw = "1";
			var id ="";
			var puntaje = "";
			var alertaMensajeGlobal="";
			var idlocalinspeccion = $('#idlocalinspeccion').html();

			$(".alerta").html("");


			for (i=1; i<=parseInt($("#contadorUnico").html())-1; i++)
			{

				if($('input:radio[name=radio'+i+']').is(':checked')) { 

					console.log(i);
					$('.pregunta'+i).css( "display", "none" );
					id = $('.idlocalinspeccionpregunta'+i).html();
					puntaje = $('input:radio[name=radio'+i+']:checked').val();
					observacion = $('#observacion'+i).val();

					if(puntaje=='0' && observacion.trim() == ""){
						sw="";
						$('.pregunta'+i).css( "display", "inline-block" );
					}

					xml= xml + (id+'(***)'+puntaje+'(***)'+observacion+'(&&&)');

				}else{
					console.log("else");
					sw="";
					$('.pregunta'+i).css( "display", "inline-block" );
				}
			}

			alertaMensajeGlobal+=(!valVacio(sw) ? '<strong><i class="fa fa-question-circle" aria-hidden="true"></i> </strong> Complete la Inspeccion <br>' : '');
			var cadenaHtml="<div class='alert alert-danger'>"+alertaMensajeGlobal+"</div>"
			if(alertaMensajeGlobal!='')
			{
				$(".alerta").append(cadenaHtml);
				$('html, body').animate({scrollTop:$(document).height()}, 'slow');
				return;
			}else{
				puntero = this;
				idOpcion = $('#idopcion').html();
				$(puntero).prop("disabled",true);
				$("#modalcargando").modal();
				$.ajax(
			    {
			        url: "/APPCOFFEE/ajaxagregarchecklist",
			        type: "POST",
			        data: { xml : xml , idlocalinspeccion : idlocalinspeccion},
			    }).done(function(pagina) 
			    {
			    	$(puntero).prop("disabled",false);
			    	window.location.href = '/APPCOFFEE/ajaxlistarchecklist/'+idOpcion;
			    });

			}
			

	    });



	    

	</script>

@stop
