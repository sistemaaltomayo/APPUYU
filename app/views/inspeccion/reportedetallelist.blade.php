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
					          	<th class='id'>
					            	PUN.
					          	</th>
					          	<th colspan="2" >
					            	OBSER.
					          	</th>
					        </tr>
				      	</thead>
				      	<tbody>

				      			{{--*/ $numeraciontotal = 1 /*--}}
				      			{{--*/ $numeracion = 1 /*--}}
				      			{{--*/ $numeraciongrupo = 1 /*--}}
				      			{{--*/ $idpregunta = '' /*--}}
				      			{{--*/ $puntaje = '' /*--}}
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

									 				{{--*/ $puntaje = $puntaje + $item3->PuntajeSeleccionado /*--}}

									 				@if($item3->Puntaje > 0)
										 				<td>
										 					<b>{{$item3->PuntajeSeleccionado}}</b>
										 				</td>
									 				@else
										 				<td >
										 					<b>{{$item3->PuntajeSeleccionado}}</b>
										 				</td>
									 				@endif 

									 				<td  colspan="2" class='observacioninspeccion'>
									 					{{$item3->Observacion}}
									 				</td>

									 			</tr>
									 		{{--*/ $numeraciontotal = $numeraciontotal + 1 /*--}}
									 		@endif
									 		
								 		@endforeach



										@endif
							    	@endforeach
							    @endforeach
				      		
				      	</tbody>
				      	<tfoot class="inspecciontotal">
				        	<tr >
				          		<td colspan="3" class='totalfooter'>
				          			TOTAL
				          		</td>
				          		<td>
				          			{{$puntaje}}
				          		</td>
				          		<td colspan="2">

				          		</td>
				        	</tr>
				      	</tfoot>
				    </table>  
				</div>

			</div>

	  	</div>

	</div>	
</div>


@stop

