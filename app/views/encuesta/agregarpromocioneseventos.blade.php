@extends('template')

@section('style')
	{{ HTML::style('css/cssLogin.css'); }}
	{{ HTML::style('css/cssCliente.css'); }}
@stop
@section('section')

    

	<div class="container">

	  	    <form action="/APPCOFFEE/registrarcliente/{{$idOpcion}}" method="post" id="formlogin" class="form-signin" role="form" style="max-width:400px;margin-top:25px;">
				<div class="panel panel-primary">
			      <div class="panel-heading">
			        <h3 class="panel-title">¿Todavía no te has registrado? ¡Hazlo gratis!</h3>
			      </div>
			      <div class="panel-body">

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-qrcode" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtDni" id="dni" maxlength="8" class="form-control" placeholder="Dni">
					</div>
					
	  	        	<div class="input-group">
	  	        		<span class="input-group-addon" id="basic-addon2">
					       <span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#286090"></span>
					  	</span>
					  	<input type="text" name="txtNombres" id="nombre" maxlength="40" class="form-control" placeholder="Nombres" aria-describedby="basic-addon2">
					</div>

			        <div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-user" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input ttype="text" name="txtApellidos" id="apellido" maxlength="40" class="form-control" placeholder="Apellidos" aria-describedby="basic-addon2">
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-time" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="date" name="txtFechaNacimiento" id="nacimiento"  class="form-control codigoheigth" placeholder="Fecha Nacimiento" style="height:44px;">
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-education" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtProfesion" id="profesion" maxlength="40" class="form-control" placeholder="Profesión" >
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-earphone" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtTelefono"  id="telefono" maxlength="9" class="form-control" placeholder="Teléfono" >
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-phone" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtCelular" id="celular" maxlength="9" class="form-control" placeholder="Celular" >
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-map-marker" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtDomicilio" id="domicilio" maxlength="200" class="form-control" placeholder="Domicilio" >
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-envelope" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtCorreo" id="correo" maxlength="80" class="form-control" placeholder="Correo" >
					</div>
					<input type="button" value="Registrar" onclick="registrar();" style="margin-top:10px;" class="btn btn-lg btn-primary btn-block">
			       
				    <div class="alerta" style="margin-top:10px;">
					    @if(isset($alertaMensajeGlobal) && $alertaMensajeGlobal!='')
						<div class="alert {{$claseAviso}}">
							<strong>{{$strongAviso}}</strong>
						    {{$alertaMensajeGlobal}}
						</div>
						@endif      	
				    </div>  

			      </div>
	    		</div>
		    </form>

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

		function registrar(){

			var alertaMensajeGlobal="";
			$(".alerta").html("");

			alertaMensajeGlobal+=(!valVacio($('#nombre').val()) ? '<strong>¡Error!</strong> Complete el campo Nombre<br>' : '');
			alertaMensajeGlobal+=(!valVacio($('#apellido').val()) ? '<strong>¡Error!</strong> Complete el campo Apellido<br>' : '');
			alertaMensajeGlobal+=(!valVacio($('#dni').val()) ? '<strong>¡Error!</strong> Complete el campo Dni<br>' : '');
			alertaMensajeGlobal+=(!valCantidad($('#dni').val(),8) && $('#dni').val()!="" ? '<strong>¡Error!</strong> Dni son 8 Digitos<br>' : '');
			//alertaMensajeGlobal+=(!valVacio($('#nacimiento').val()) ? '<strong>¡Error!</strong> Complete el campo Fecha Nacimiento<br>' : '');
			//alertaMensajeGlobal+=(!valVacio($('#profesion').val()) ? '<strong>¡Error!</strong> Complete el campo Profesión<br>' : '');
			//alertaMensajeGlobal+=((!valVacio($('#telefono').val()) && !valVacio($('#celular').val())) ? '<strong>¡Error!</strong> Complete el campo Telefono o Celular<br>' : '');
			//alertaMensajeGlobal+=(!valCantidad($('#telefono').val(),9) && $('#telefono').val()!="" ? '<strong>¡Error!</strong> Telefono son 9 Digitos<br>' : '');
			//alertaMensajeGlobal+=(!valVacio($('#celular').val()) ? '<strong>¡Error!</strong> Complete el campo Celular<br>' : '');
			//alertaMensajeGlobal+=(!valCantidad($('#celular').val(),9) && $('#celular').val()!="" ? '<strong>¡Error!</strong> Celular son 9 Digitos<br>' : '');
			//alertaMensajeGlobal+=(!valVacio($('#domicilio').val()) ? '<strong>¡Error!</strong> Complete el campo Domicilio<br>' : '');
			//alertaMensajeGlobal+=(!valVacio($('#correo').val()) ? '<strong>¡Error!</strong> Complete el campo Correo<br>' : '');
			//alertaMensajeGlobal+=(!valEmail($('#correo').val()) ? '<strong>¡Error!</strong> Escribe un Correo Electrónico válido<br>' : '');
			var cadenaHtml="<div class='alert alert-danger'>"+alertaMensajeGlobal+"</div>"
			 

			if(alertaMensajeGlobal!='')
			{
				$(".alerta").append(cadenaHtml);
				return;
			}else{
				$("#modalcargando").modal();
				$('#formlogin').submit();
				return;
			}
					
		}
    </script>

@stop

