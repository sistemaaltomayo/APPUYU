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


{{Form::open(array('method' => 'POST', 'url' => '/cambiaridioma/'.$idOpcion))}}

	<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
		<h4 style="text-align:center;">{{trans('encuesta.titulo')}}</h4>

			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-4 col-lg-offset-8">
				<div class="input-group grupo-imput">
				    <span class="input-group-addon" id="basic-addon1">{{trans('encuesta.cmb_idioma')}}: </span>
				    {{ Form::select('idioma', $comboidioma, array(),['class' => 'form-control control' , 'id' => 'idioma']) }}
				</div>
			</div>  	
	</div>

{{Form::close()}}


<div class="container" style="margin-top:100px;">



	<div class="panel panel-primary" style="margin-top:25px;">

     	<div class="panel-heading">
        	<h3 class="panel-title">{{trans('encuesta.titulo_general')}}</h3>
      	</div>

    


      	<div class="panel-body">



			<div class="col-xs-12 col-md-12 encuestanombre">
				<div class="input-group">
		        	<span class="input-group-addon"  id="basic-addon2">
				       <span class="glyphicon glyphicon-qrcode" style="color:#286090" aria-hidden="true"></span>
				  	</span>
				  	<input type="text" name="txtDni" id="dni"  maxlength="12" class="solonumero form-control" placeholder="{{trans('encuesta.input_dni')}}">
				</div>
				<br>

				<div class="input-group">
		        	<span class="input-group-addon"  id="basic-addon2">
				       <span class="glyphicon glyphicon-user" style="color:#286090" aria-hidden="true"></span>
				  	</span>
				  	<input type="text" name="txtNombre" id="nombre" maxlength="40" class="form-control" placeholder="{{trans('encuesta.input_nombre')}}">
				</div>
				<br>

				<div class="input-group">
		        	<span class="input-group-addon"  id="basic-addon2">
				       <span class="glyphicon glyphicon-phone" style="color:#286090" aria-hidden="true"></span>
				  	</span>
				  	<input type="text" name="txtCelular" id="celular" maxlength="9" class="solonumero form-control" placeholder="{{trans('encuesta.input_celular')}}" >
				</div>

			</div>



				{{--*/ $idPregunta = "" /*--}}
				{{--*/ $contador = 0 /*--}}
				{{--*/ $contadorItem = 1 /*--}}
				{{--*/ $contadorUnico = 0 /*--}}
				{{--*/ $contadorMultiple = 0 /*--}}
				{{--*/ $contadorText = 0 /*--}}

				{{--*/ $contrecomendacion = 0 /*--}}

		        @foreach($listaPregunta as $item)
					
					{{--*/ $contrecomendacion = $contrecomendacion + 1 /*--}}

		        	@if($item->Id!=$idPregunta)
						<div class="col-xs-12 col-md-12">
							<div class="preguntas pregunta{{$contadorItem}}">

								<div class="numero"><p>{{$contadorItem}}</p></div>
								<div class="pregunta">
									<p><b>{{$item->NombreIdioma}}</b></p>	
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
						            <label for="checkbox{{$contador}}">{{$item->NombreRespuestaIdioma}}</label>
					        	</div>
						@else
							@if($item->DescripcionTipo=='Unica') 

							    <div class="funkyradio-success">
						            <input type="radio" name="radio{{$contadorUnico}}" id="radio{{$contador}}" value="{{$item->IdPreguntaRespuesta}}" />
						            <label for="radio{{$contador}}">{{$item->NombreRespuestaIdioma}}</label>
						        </div>

							@else
								<textarea class="form-control textarea" id="text{{$contadorText}}" rows="6"></textarea>
							@endif
						        
						@endif

					@if($contrecomendacion == 5)

								<div class="input-group grupo-imput">
								    <span class="titulospan input-group-addon" id="basic-addon1">{{trans('encuesta.titulo_text')}} </span>
								</div>

								<br>
								<textarea class="form-control textarea" id="recomendacion{{$contadorItem}}" rows="5" placeholder='{{trans('encuesta.titulo_text')}} .....'></textarea>


								{{--*/ $contrecomendacion = 0 /*--}}

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


				
				<button type="button" class="btn btn-success btnencuesta" id="guardarencuesta">{{trans('encuesta.btn_guardar')}}</button>
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


			$('#idioma').change(function(){
			    $('form').submit();
			});


			$("#guardarencuesta").click(function () {

				
				var xml="";
				var contador=0;
				var xmlt="";
				var alertaMensajeGlobal="";
				var idopcion = $("#idopcion").html();
				var listapregunta = '';

				$(".alerta").html("");
				$('.preguntas').css("border", "1px solid #ccc");


				for (i=1; i<=$("#contadorUnico").html(); i++)
				{

					if($('input:radio[name=radio'+i+']').is(':checked')) {

						contr = i+1; 
						xml = xml + ($('input:radio[name=radio'+i+']:checked').val()) + '&&&' + $('#recomendacion'+contr).val() + '***';
						contador=contador+1;

					}else{

						$('.pregunta'+i).css("border", "2px solid #a94442");
						listapregunta = listapregunta + i + '-';

					}


				}

				for (i=1; i<=$("#contadorMultiple").html(); i++)
				{
					$('input:checkbox[name=checkbox'+i+']:checked').each(   
				    function() {
				    	xml=xml+$(this).val()+'*';
				    	contador=contador+1;
				    }
					);
				}

				for (i=1; i<=$("#contadorText").html(); i++)
				{
						xmlt=xmlt+$('#text'+i).val()+'*';
				}




				alertaMensajeGlobal+=(!valVacio($('#dni').val()) ? '<strong>¡Error!</strong> Complete el campo CI<br>' : '');
				alertaMensajeGlobal+=(!valVacio($('#nombre').val()) ? '<strong>¡Error!</strong> Complete el campo Nombre<br>' : '');

				//alertaMensajeGlobal+=(!valCantidad($('#dni').val(),8) && $('#dni').val()!="" ? '<strong>¡Error!</strong> CI son 5 Digitos<br>' : '');
				alertaMensajeGlobal+=(!valCantidad($('#celular').val(),9) && $('#celular').val()!="" ? '<strong>¡Error!</strong> Celular son 9 Digitos<br>' : '');


				if(contador<parseInt($("#contadorUnico").html())){
					alertaMensajeGlobal+='<strong>¡Error!</strong> Complete la Encuesta Preguntas('+listapregunta+')<br> ';
				}
				


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
						idioma = $('#idioma').val();

						$.ajax(
					    {

			                				    	
					        url: "/APPUYU/insertarencuesta",
					        type: "POST",
					        //data: "xml="+xml+"&xmlt="+xmlt+"&dni="+$('#dni').val()+"&celular="+$('#celular').val()+"&nombre="+$('#nombre').val(),
					        data: { xml : xml, xmlt : xmlt, dni : $('#dni').val(), celular : $('#celular').val(), nombre : $('#nombre').val(), idioma : idioma },	

					    }).done(function(pagina) 
		                {

		                	//console.log(pagina);
		                	
					    	$(puntero).prop("disabled",false);
					    	window.location.href = '/APPUYU/atencione/'+idopcion;
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

