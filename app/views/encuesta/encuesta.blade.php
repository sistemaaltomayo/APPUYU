@extends('template')
@section('style')


    {{ HTML::style('/css/tabla/footable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.sortable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.paginate.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}

    {{ HTML::style('/css/cssCliente.css') }}
@stop
@section('section')

<div class="container" style="margin-top:55px;">

	<div class="panel panel-primary" style="margin-top:25px;">
      <div class="panel-heading">
        <h3 class="panel-title">Le damos la bienvenida a la Encuesta de Satisfacción del Cliente. Valoramos su opinión y agradecemos que dedique su tiempo en completar nuestra encuesta.</h3>
      </div>
      <div class="panel-body">

			<div class="col-xs-12 col-md-12 encuestanombre">
				<div class="input-group">
		        	<span class="input-group-addon"  id="basic-addon2">
				       <span class="glyphicon glyphicon-qrcode" style="color:#286090" aria-hidden="true"></span>
				  	</span>
				  	<input type="text" name="txtDni" id="dni" maxlength="8" class="form-control" placeholder="Dni">
				</div>
				<br>
				<div class="input-group">
		        	<span class="input-group-addon"  id="basic-addon2">
				       <span class="glyphicon glyphicon-phone" style="color:#286090" aria-hidden="true"></span>
				  	</span>
				  	<input type="text" name="txtCelular" id="celular" maxlength="9" class="form-control" placeholder="Celular" >
				</div>
			</div>



				{{--*/ $idPregunta = "" /*--}}
				{{--*/ $contador = 0 /*--}}
				{{--*/ $contadorItem = 1 /*--}}
				{{--*/ $contadorUnico = 0 /*--}}
				{{--*/ $contadorMultiple = 0 /*--}}
				{{--*/ $contadorText = 0 /*--}}
		        @foreach($listaPregunta as $item)
					
		        	@if($item->Id!=$idPregunta)
						<div class="col-xs-12 col-md-12">
							<div class="preguntas">

								<div class="numero"><p>{{$contadorItem}}</p></div>
								<div class="pregunta">
									<p><b>{{$item->Descripcion}}</b></p>	
								</div>
							    <div class="funkyradio @if($item->DescripcionTipo=='Multiple') check @endif">
								@if($item->DescripcionTipo=='Multiple') 
							        	{{--*/ $contadorMultiple = $contadorMultiple + 1 /*--}}
								@else
									@if($item->DescripcionTipo=='Unica') 
								        {{--*/ $contadorUnico = $contadorUnico + 1 /*--}}
									@else
										{{--*/ $contadorText = $contadorText + 1 /*--}}
									@endif
								       
								@endif
								{{--*/ $idPregunta = $item->Id /*--}}
								{{--*/ $contadorItem = $contadorItem + 1 /*--}}	    
		        	@endif
					
						@if($item->DescripcionTipo=='Multiple') 
						        <div class="funkyradio-success">
						            <input type="checkbox" name="checkbox{{$contadorMultiple}}" id="checkbox{{$contador}}" value="{{$item->IdPreguntaRespuesta}}" />
						            <label for="checkbox{{$contador}}">{{$item->DescripcionResp}}</label>
					        	</div>
						@else
							@if($item->DescripcionTipo=='Unica') 
							    <div class="funkyradio-success">
						            <input type="radio" name="radio{{$contadorUnico}}" id="radio{{$contador}}" value="{{$item->IdPreguntaRespuesta}}" />
						            <label for="radio{{$contador}}">{{$item->DescripcionResp}}</label>
						        </div>
							@else
								<textarea class="form-control textarea" id="text{{$contadorText}}" rows="6"></textarea>
							@endif
						        
						@endif
						  
					@if(!isset($listaPregunta[$contador+1]->Id))
								  </div>
							</div>
						</div>
					@else
			        	@if($listaPregunta[$contador+1]->Id != $idPregunta)
			        				</div>
							</div>
						</div>
			        	@endif
					@endif
					{{--*/ $contador = $contador + 1 /*--}}
				@endforeach
			<div class="col-xs-12 col-md-12 encuestanombre">


				
				<button type="button" class="btn btn-success btnencuesta" id="guardarencuesta">Guardar</button>
				<div class="alerta">
				    @if(isset($alertaMensajeGlobal) && $alertaMensajeGlobal!='')
					<div class="alert {{$claseAviso}}">
						<strong>{{$strongAviso}}</strong>
					    {{$alertaMensajeGlobal}}
					</div>
					@endif      	
			    </div>  
			</div>


      </div>
    </div>	

</div> <!--container-->

<div>
    <p id="contadorUnico" style="display:none;">{{$contadorUnico}}</p>
    <p id="contadorMultiple" style="display:none;">{{$contadorMultiple}}</p>
    <p id="contadorText" style="display:none;">{{$contadorText}}</p>
    <p id="idopcion" style="display:none;">{{$idOpcion}}</p>
    
</div>

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


	<script>
		$(document).ready(function()
		{
			$("#guardarencuesta").click(function () {

				
				var xml="";
				var xmlt="";
				var alertaMensajeGlobal="";
				var idopcion = $("#idopcion").html();

				$(".alerta").html("");


				for (i=1; i<=$("#contadorUnico").html(); i++)
				{
					if($('input:radio[name=radio'+i+']').is(':checked')) { 
						xml=xml+($('input:radio[name=radio'+i+']:checked').val())+'*';
					}	
				}

				for (i=1; i<=$("#contadorMultiple").html(); i++)
				{
					$('input:checkbox[name=checkbox'+i+']:checked').each(   
				    function() {
				    	xml=xml+$(this).val()+'*';
				    }
					);
				}

				for (i=1; i<=$("#contadorText").html(); i++)
				{
						xmlt=xmlt+$('#text'+i).val()+'*';
				}


				alertaMensajeGlobal+=(!valVacio($('#dni').val()) ? '<strong>¡Error!</strong> Complete el campo Dni<br>' : '');
				alertaMensajeGlobal+=(!valCantidad($('#dni').val(),8) && $('#dni').val()!="" ? '<strong>¡Error!</strong> Dni son 8 Digitos<br>' : '');
				alertaMensajeGlobal+=(!valCantidad($('#celular').val(),9) && $('#celular').val()!="" ? '<strong>¡Error!</strong> Celular son 9 Digitos<br>' : '');
				alertaMensajeGlobal+=(!valVacio(xml) ? '<strong>¡Error!</strong> Complete la Encuesta <br>' : '');
				var cadenaHtml="<div class='alert alert-danger'>"+alertaMensajeGlobal+"</div>"
				if(alertaMensajeGlobal!='')
				{
					$(".alerta").append(cadenaHtml);
					$('html, body').animate({scrollTop:$(document).height()}, 'slow');
					return;
				}else{

						$("#modalcargando").modal();
						puntero = this;
						$(puntero).prop("disabled",true);


						$.ajax(
					    {
					        url: "/APPCOFFEE/insertarencuesta",
					        type: "POST",
					        data: "xml="+xml+"&xmlt="+xmlt+"&dni="+$('#dni').val()+"&celular="+$('#celular').val(),
					    }).done(function(pagina) 
		                {

					    	$(puntero).prop("disabled",false);
					    	window.location.href = '/APPCOFFEE/atencione/'+idopcion;
		                    $('#modalcargando').modal('hide');
		                    //$('.cargandoreporte img').css("display", "none");

		                }).fail( function( jqXHR, textStatus, errorThrown ) {

		                	$('.alertajax').css("display", "block");
		                	$('.msjfailajax').html(errores(jqXHR.status,textStatus,jqXHR.responseText));

						}).always( function() {

		                    console.log('PERFECT');

		                });


						return;
				}
			});
		 });
	</script>
@stop	

