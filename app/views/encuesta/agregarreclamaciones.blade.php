@extends('template')
@section('style')
    {{ HTML::style('/css/cssPersonal.css') }}
@stop

@section('section')

<div class="mensaje-error"></div>

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">Insertar Reclamación</h4>
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
	  		
			{{Form::open(array('method' => 'POST', 'url' => '/insertar-libro-reclamaciones/'.$idOpcion, 'files' => true))}}
			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Libro de Reclamaciones</h3>
					</div>
					<div class="panel-body">


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Sede: </span>
							{{ Form::select('local', $combolocal, array(),['class' => 'form-control control' , 'id' => 'local']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Fecha: </span>
							{{  Form::date('fecha','',array('class' => 'form-control control', 'id' => 'fecha')) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Numero de Reclamación: </span>
						  	{{Form::text('numeroreclamacion','', array('class' => 'solonumero form-control control', 'id' => 'numeroreclamacion' , 'maxlength' => '20'))}}
						</div>


					</div>
				</div>


				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">1. IDENTIFICACION DEL CONSUMIDOR RECLAMANTE</h3>
					</div>
					<div class="panel-body">



						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Nombres y Apellidos: </span>
						  	{{Form::text('nombres','', array('class' => 'form-control control', 'id' => 'nombres' , 'maxlength' => '200'))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">DNI / CE: </span>
						  	{{Form::text('dnice','', array('class' => 'solonumero form-control control', 'id' => 'dnice' , 'maxlength' => '20'))}}
						</div>


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Domicilio: </span>
						  	{{Form::text('domicilio','', array('class' => 'form-control control', 'id' => 'domicilio' , 'maxlength' => '200'))}}
						</div>


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Telefono: </span>
						  	{{Form::text('telefono','', array('class' => 'solonumero form-control control', 'id' => 'telefono' , 'maxlength' => '20'))}}
						</div>


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Email: </span>
						  	{{Form::text('email','', array('class' => 'form-control control', 'id' => 'email' , 'maxlength' => '60'))}}
						</div>


						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">PADRE O MADRE: <br><li>(Para el caso de menores de edad)</li> </span>
						</div>

						<div class="input-group grupo-imput">
							<span class="input-group-addon" id="basic-addon1">Nombre: </span>
						  	{{Form::text('padresmadre','', array('class' => 'form-control control', 'id' => 'padresmadre' , 'maxlength' => '200'))}}
						</div>



					</div>
				</div>





				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">2. IDENTIFICACION DEL BIEN CONTRATADO</h3>
					</div>
					<div class="panel-body">


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Bien Contratado: </span>
							{{ Form::select('biencontratado', $combobiencontratado, array(),['class' => 'form-control control' , 'id' => 'biencontratado']) }}
						</div>

						<div class="input-group grupo-imput">
							<span class="input-group-addon" id="basic-addon1">Monto Reclamado: </span>
						  	{{Form::text('montoreclamado','', array('class' => 'decimal form-control control', 'id' => 'montoreclamado' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Descripcion: </span>
						  	{{Form::text('descripcionbien','', array('class' => 'form-control control', 'id' => 'descripcionbien' , 'maxlength' => '1000'))}}
						</div>




					</div>
				</div>



				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">3. DETALLE DE LA RECLAMACION</h3>
					</div>
					<div class="panel-body">



						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Reclamacion: </span>
							{{ Form::select('reclamacionqueja', $comboreclamo, array(),['class' => 'form-control control' , 'id' => 'reclamacionqueja']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Detalle de Reclamaciones</span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('descripcionreque', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Detalle...', 'id' => 'descripcionreque', 'maxlength' => '1000']) }}
						</div>

					</div>
				</div>



				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">4. ACCIONES ADOPTADAS POR EL VENDEDOR</h3>
					</div>
					<div class="panel-body">


						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Detalle </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('descripcionadop', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Detalle...', 'id' => 'descripcionadop', 'maxlength' => '1000']) }}
						</div>

					</div>
				</div>


	
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btninsertarreclamaciones" class="btn btn-primary" value="Guardar">
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






	$("#btninsertarreclamaciones").click(function(e) {

	 	var alertaMensajeGlobal='';
		
	 	if(!valSelect($('#local').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Sede seleccionado es invalido<br>';}
	 	if(!valVacio($('#fecha').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo fecha es obligatorio<br>';}
	 	if(!valVacio($('#numeroreclamacion').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Numero de Reclamacion es obligatorio<br>';}

	 	if(!valVacio($('#nombres').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Nombre es obligatorio<br>';}
	 	if(!valVacio($('#dnice').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo DNI / CE es obligatorio<br>';}

	 	if(!valSelect($('#biencontratado').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Bien Contratado seleccionado es invalido<br>';}

	 	if(!valSelect($('#reclamacionqueja').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Reclamacion seleccionado es invalido<br>';}
	 	if(!valVacio($('#descripcionreque').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Detalle de Reclamacion es obligatorio<br>';}



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