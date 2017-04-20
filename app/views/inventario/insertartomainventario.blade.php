@extends('template')
@section('section')

<div class="mensaje-error"></div>

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">Insertar toma {{$nombreopcion}}</h4>
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


	    

	  	<div class="formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
	  		
			{{Form::open(array('method' => 'POST', 'url' => '/insertar-toma-inventario/'.$idOpcion, 'files' => true))}}
			<div class="col-xs-12">

				<!--<div class='grupo-imput e-nombres'>
					{{Form::text('nombres','', array('class' => 'form-control control', 'placeholder' => 'Descripción', 'id' => 'nombres', 'maxlength' => '100'))}}	
				</div>-->

				<div class='grupo-imput e-tipotoma'>
					{{ Form::select('tipotoma', $combobox, $selected,['class' => 'form-control control' , 'id' => 'tipotoma']) }}
				</div>

				<div class='grupo-imput e-tipotoma'>
					{{ Form::select('ubicacion', $comboubicacion, $selectedubicacion,['class' => 'form-control control' , 'id' => 'ubicacion']) }}
					<p style="color:red;font-size:0.8em;">* La ubicación se le asignara al administrador que cree esta toma de inventario.</p>
				</div>

				<div class='grupo-imput e-observacion'>
					{{ Form::textarea('observacion', null, ['class' => 'form-control','rows' => '9','placeholder' => 'Observación...', 'id' => 'observacion', 'maxlength' => '300']) }}		
				</div>


	
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btninsertartoma" class="btn btn-primary" value="Crear Toma Inventario">
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

	$("#btninsertartoma").click(function(e) {

	 	var alertaMensajeGlobal='';
		
		//if(!valVacio($('#nombres').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo descripción es obligatorio<br>';}
		
		if(!valSelect($('#tipotoma').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Tipo Toma seleccionado es invalido<br>';}

		if(!valSelect($('#ubicacion').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Ubicacion seleccionado es invalido<br>';}

	    //if(!valVacio($('#ubicacion').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo observacion es obligatorio';}


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