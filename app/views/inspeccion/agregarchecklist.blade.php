@extends('template')

@section('section')
<div class="mensaje-error"></div>


    @if (Session::get('alertaMensajeGlobalE'))
    <div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>¡Error!</strong> {{ Session::get('alertaMensajeGlobalE') }}
	</div>
    @endif

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">AGREGAR CHECK LIST </h4>
</div>

<div class="container">
	<div class="row">
 
		{{Form::open(array('method' => 'POST', 'url' => '/agregar-checklist/'.$idOpcion))}}
	  	<div class="formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div class="col-xs-12">
				<div class="input-group grupo-imput">
				    <span class="input-group-addon" id="basic-addon1" ><b>{{date("d-m-Y")}}</b></span>
				    <span class="input-group-addon" id="basic-addon1" ><b>{{date("H:i:s")}}</b></span>
				</div>

				<div class="input-group grupo-imput">
				    <span class="input-group-addon" id="basic-addon1" style='font-size:0.75em;'><b>{{$zonaactivo}}</b></span>
				</div>


				<div class="input-group grupo-imput">
				    <span class="input-group-addon" id="basic-addon1">Tipo de Inspección: </span>
					{{ Form::select('tipoinspeccion', $combotipoinspeccion, array(),['class' => 'form-control control' , 'id' => 'tipoinspeccion']) }}
				</div>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btnguardararea"  class="btnguardar btn btn-primary" value="Guardar" onclick="registrar();">
			</div>
	  	</div>

	  	{{Form::close()}}
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

		function registrar(){
			$("#modalcargando").modal();
			return true;			
		}
    </script>

@stop
