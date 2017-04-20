@extends('template')
@section('style')
    {{ HTML::style('/css/cssPersonal.css') }}
@stop

@section('section')

<div class="mensaje-error"></div>

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">Insertar Solicitud Personal</h4>
</div>


@if(count($errors)>0)
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      @foreach($errors->all() as $error)
         <strong>Error!</strong> {{$error}}<br>
      @endforeach 
  </div>
@endif

<div class="container">
	<div class="row">

	  	<div class="paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
	  		
			{{Form::open(array('method' => 'POST', 'url' => '/insertar-solicitud-personal/'.$idOpcion, 'files' => true))}}
			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Solicitud del Personal</h3>
					</div>
					<div class="panel-body">


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Motivo: </span>
							{{ Form::select('motivosolicitud', $combomotivosolicitud, array(),['class' => 'selectmotivosolicitud form-control control' , 'id' => 'motivosolicitud']) }}
						</div>


						<div class='reemplazopersonal'>


							<div class="input-group grupo-imput">
							    <span class="titulospan input-group-addon" id="basic-addon1">PERSONAL Y MOTIVO DE REEMPLAZO: <br><li>(Seleccionar el nombre del personal y motivo de reemplazo)</li> </span>
							</div>

							<div class="input-group grupo-imput">
							    <span class="input-group-addon" id="basic-addon1">Personal de Reemplazo: </span>
								{{ Form::select('usuarior', $combousuarior, array(),['class' => 'selectusuarior form-control control' , 'id' => 'usuarior']) }}
							</div>

							<div class="input-group grupo-imput">
							    <span class="input-group-addon" id="basic-addon1">Motivo Reemplazo: </span>
								{{ Form::select('motivoreemplazo', $combomotivoreemplazo, array(),['class' => 'selectmotivoreemplazo form-control control' , 'id' => 'motivoreemplazo']) }}
							</div>
						</div>
						<div class='autorizacion'>

							<div class="input-group grupo-imput">
							    <span class="titulospan input-group-addon" id="basic-addon1">AUTORIZACION DE INCREMENTO DE PERSONAL: <br><li>(Indicar quien autorizo el incremento y por que medio)</li> </span>
							</div>


							<div class="input-group grupo-imput">
								<span class="input-group-addon" id="basic-addon1"></span>
							  	{{Form::text('autorizacion','', array('class' => 'form-control control', 'placeholder' => 'Autorización', 'id' => 'autorizacion', 'maxlength' => '1000'))}}
							</div>

						</div>






					</div>
				</div>


				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Datos del Cargo</h3>
					</div>
					<div class="panel-body">


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Cargo o puesto a ocupar: </span>
							{{ Form::select('tipousuario', $combotipousuario, array(),['class' => 'selecttipousuario form-control control' , 'id' => 'tipousuario']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Area: </span>
							{{ Form::select('local', $combolocal, array(),['class' => 'selectlocal form-control control' , 'id' => 'local']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Número Vacantes: </span>
						  	{{Form::number('numerovacantes','1', array('class' => 'solonumero form-control control', 'id' => 'numerovacantes'))}}
						</div>


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Edad: </span>
						  	{{Form::number('edadinicio','18', array('class' => 'solonumero form-control control', 'id' => 'edadinicio' ))}}
						  	<span class="input-group-addon">entre</span>
						  	{{Form::number('edadfin','18', array('class' => 'solonumero form-control control', 'id' => 'edadfin'  ))}}
						</div>


						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Perfil del Puesto: <br><li>(Estudios, cursos, tiempo, de experiencia y conocimientos adicionales)</li> </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('perfilpuesto', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Perfil del Puesto...', 'id' => 'perfilpuesto', 'maxlength' => '1000']) }}
						</div>


						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Funciones del Puesto: <br><li>(Actividades que realizará en el puesto de manera detallada)</li> </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('funcionpuesto', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Funciones del Puesto...', 'id' => 'funcionpuesto', 'maxlength' => '1000']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Hora de Trabajo: <br><li>(Días trabajados y días de descanso si aplica)</li> </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('horatrabajo', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Horario de Trabajo...', 'id' => 'horatrabajo', 'maxlength' => '1000']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Sueldo: S/.</span>
						  	{{Form::text('sueldo','0', array('class' => 'decimal form-control control', 'id' => 'sueldo' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Observación:  </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Observación...', 'id' => 'observacion', 'maxlength' => '1000']) }}
						</div>



					</div>
				</div>

	
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btninsertarsolicitudpersonal" class="btn btn-primary" value="Guardar">
			</div>
			{{Form::close()}}

	  </div>
	</div>	
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


	$( ".selectmotivosolicitud" ).change(function() {
	  
	  
	    if (this.value!=0) {

	    	if (this.value=='LIM01CEN000000000001'){

			    $('.paneltop .reemplazopersonal').css("display", "block");
			    $('.paneltop .autorizacion').css("display", "none");
			    $("#autorizacion").val("");

			}else{

			    $('.paneltop .reemplazopersonal').css("display", "none");
			    $('.paneltop .autorizacion').css("display", "block");

			    $("#usuarior option[value='0']").prop("selected", true);
			    $("#motivoreemplazo option[value='0']").prop("selected", true);

			}
		} else{
			$('.paneltop .reemplazopersonal').css("display", "none");
			$('.paneltop .autorizacion').css("display", "none");
		}


	});




	$("#btninsertarsolicitudpersonal").click(function(e) {

	 	var alertaMensajeGlobal='';
		
	 	if(!valSelect($('#motivosolicitud').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Motivo seleccionado es invalido<br>';}

		if(valSelect($('#motivosolicitud').val(),0)){ 

			if($('#motivosolicitud').val()=='LIM01CEN000000000001'){

				if(!valSelect($('#usuarior').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Personal de Reemplazo seleccionado es invalido<br>';}

				if(!valSelect($('#motivoreemplazo').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Motivo Reemplazo seleccionado es invalido<br>';}

			}else{
					if(!valVacio($('#autorizacion').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Autorización es obligatorio<br>';}

			}	

		}	


	 	if(!valSelect($('#tipousuario').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Cargo o puesto a ocupar seleccionado es invalido<br>';}
	 	if(!valSelect($('#local').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Area seleccionado es invalido<br>';}
	 	if(!numeroentre($('#numerovacantes').val(),1,10)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Número Vacantes debe ser de 1 a 10<br>';}

	 	if(!numeromayor($('#edadinicio').val(),18)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Edad debe ser mayor a 18<br>';}
	 	if(!numeromayor($('#edadfin').val(),18)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Edad debe ser mayor a 18<br>';}

		if(!valVacio($('#perfilpuesto').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Perfil del Puesto es obligatorio<br>';}
		if(!valVacio($('#funcionpuesto').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Funciones del Puesto es obligatorio<br>';}
		if(!valVacio($('#horatrabajo').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Hora de Trabajo es obligatorio<br>';}

	 	if(!numeromayor($('#sueldo').val(),1)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Sueldo debe ser mayor a 0<br>';}



		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);
			return false;
		}else{	
			$("#modalcargando").modal();
			return true; 
		}


	});

    </script>

@stop