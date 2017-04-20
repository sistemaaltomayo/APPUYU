@extends('template')
@section('section')

<div class="mensaje-error"></div>

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">Editar Toma {{$nombreopcion}}</h4>
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
	  		
			{{Form::open(array('method' => 'POST', 'url' => '/actualizar-toma-inventario/'.$idOpcion, 'files' => true))}}
			<div class="col-xs-12">
				{{ Form::hidden('idtomaweb', $TomaWeb[0]->Id, ['id' => 'idtomaweb']) }}
				{{ Form::hidden('codigo',$TomaWeb[0]->Codigo, ['id' => 'codigo'])}}
				<div class='grupo-imput e-nombres'>
					{{Form::label('nombres',$TomaWeb[0]->Codigo, array('class' => 'form-control control', 'placeholder' => 'Descripción', 'id' => 'nombres', 'maxlength' => '100'))}}	
				</div>

				<div class='grupo-imput e-tipotoma'>
					{{ Form::select('tipotoma', $combobox, $selected,['class' => 'form-control control' , 'id' => 'tipotoma']) }}
				</div>

				<div class='grupo-imput e-observacion'>
					{{ Form::textarea('observacion', $TomaWeb[0]->Observacion, ['class' => 'form-control','rows' => '9','placeholder' => 'Observación...', 'id' => 'observacion', 'maxlength' => '300']) }}		
				</div>

				<div class="btn-group grupo-imput" data-toggle="buttons">
					
				<label class="btnactivado btn btn-success @if($TomaWeb[0]->Activo == 1) active @endif">
					<input type="radio" name="activo" id="option1" autocomplete="off"  value="1" @if($TomaWeb[0]->Activo == 1) checked @endif>
					<span class="glyphicon">Activado</span>
				</label>

				<label class="btnactivado btn btn-danger @if($TomaWeb[0]->Activo == 0) active @endif">
					<input type="radio" name="activo" id="option2" autocomplete="off"  value="0" @if($TomaWeb[0]->Activo == 0) checked @endif>
					<span class="glyphicon">Desactivado</span>
				</label>
				
				</div>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btninsertartoma" class="btn btn-primary" value="Actualizar Toma Inventario">
			</div>
			{{Form::close()}}

	  </div>

	</div>	
</div>
@stop