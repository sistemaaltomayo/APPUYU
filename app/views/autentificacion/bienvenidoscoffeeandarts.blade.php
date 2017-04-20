@extends('template')
@section('section')

<div class="container">
	<div class="row">  


		<div class="errorpagina">
	        <div class="error-code m-b-10 m-t-20">Bienvenido <i class="fa fa-hand-paper-o"></i></div>
	        <h3 class="font-bold">Sistema Multiplataforma COFFEE AND ARTS</h3>

	        <div class="error-desc">
	            Seleccione una opción del menú y empecemos a trabajar  <br/>
	        </div>

	         <h3 class="font-bold" style='color:#08257C;font-weight:bold;'>{{Session::get('zona')->Zona}}</h3>

		</div>

	</div>	
</div>

@stop

