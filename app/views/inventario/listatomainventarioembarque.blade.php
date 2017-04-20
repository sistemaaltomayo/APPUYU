@extends('template')
@section('style')


    {{ HTML::style('/css/tabla/footable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.sortable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.paginate.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}


@stop

@section('section')


    @if (Session::get('alertaMensajeGlobal'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <strong>Bien Hecho!</strong> {{ Session::get('alertaMensajeGlobal') }}
       
      </div>
    @endif  

    @if (Session::get('alertaMensajeGlobalE'))

    <div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>¡Error!</strong> {{ Session::get('alertaMensajeGlobalE') }}
	  <br>

	    @if (Session::get('listaPrioridad'))
	      {{--*/ $listaPrioridad   = Session::get('listaPrioridad') /*--}}
            <ul class="list-group">
		    	@foreach ($listaPrioridad as $item)
					 <li class="list-group-item">{{$item['CodigoProducto']}} - {{$item['Descripcion']}}</li>
				@endforeach
            </ul>
	    @endif  

	</div>
    @endif 


<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">Lista Toma {{$nombreopcion}} <small>(Ultimas 30 Tomas)</small></h4>
</div>

<div class="container">

	<div class="row">
		<div class="col-xs-12 cabecerageneral">


			<div class="col-xs-12 buscaragregar">
				<div class="filter col-xs-12 col-sm-8  col-md-8 col-lg-6">
					<input id="filter" class="form-control control" placeholder="Buscar" type="text" />
				</div>
				<div class="agregar col-xs-12 col-sm-4  col-md-4 col-lg-6">

                    <a href="{{ url('/insertar-toma-inventario-embarque/'.$idOpcion) }}" class="btnagregartomaE btn btn-success">
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                    </a>

				</div>
			</div>



			<div class="listatoma col-xs-12">
			    <table data-filter="#filter" class="table demo" data-page-size="30">
			      	<thead>
				        <tr>
				          	<th data-class="expand">
				            	Código Barra
				          	</th>
				          	<th>
				            	Estado
				          	</th>
				          	<th>
				            	Fecha Creación
				          	</th>
				          	<th data-hide="phone,tablet">
				            	Observación
				          	</th>
				          	<th data-hide="phone,tablet">
				            	Opciones
				          	</th>

				        </tr>
			      	</thead>
			      	<tbody>
			      		@foreach($listaTomaWeb as $item)

							{{--*/ $pc = '' /*--}}
							{{--*/ $sc = '' /*--}}
							{{--*/ $color = 'sincerrar' /*--}}
							{{--*/ $opciones = '' /*--}}
							{{--*/ $texto = 'Nuevo Sin Ningún Cierre' /*--}}

							@if($item->EstadoProceso=='S')
								{{--*/ $pc = 'btnbloqueado' /*--}}
								{{--*/ $color = 'primercierre' /*--}}
								{{--*/ $texto = 'Primer Cierre' /*--}}
							@endif

							@if($item->EstadoProceso=='P')	
								{{--*/ $sc = 'btnbloqueado' /*--}}
							@endif

							@if($item->EstadoProceso=='C')
								{{--*/ $pc = 'btnbloqueado' /*--}}
								{{--*/ $sc = 'btnbloqueado' /*--}}
								{{--*/ $color = 'cerrado' /*--}}
								{{--*/ $texto = 'Cierre Finalizado' /*--}}
								{{--*/ $opciones = 'btnbloqueado' /*--}}
							@endif

			        	<tr>
			        		
			        			<td>{{$item->Codigo}}</td>
			        			<td style="text-align:center;"><i class="fa fa-circle fa-lg {{$color}}" data-toggle="tooltip" data-placement="left" title="{{$texto}}"></i></td>
				        		<td>{{date_format(date_create($item->FechaCrea), 'm/d/Y H:i:s')}}</td>
				        		<td>{{$item->Observacion}}</td>

				        		<td>
								    <div class="btn-group">
									    <button type="button" class="btn btn-default dropdown-toggle"
									            data-toggle="dropdown">
									      Opciones
									      <span class="caret"></span>
									    </button>

									    {{--*/ $class = '' /*--}}
									    @if($item->EstadoProceso == 'C') 
								      		{{--*/ $class = 'notactiveurl' /*--}}
									    @endif

									    <ul class="dropdown-menu menulistas">
									      <li><a class='{{$class}}' href="{{ url('/editar-toma-inventario-embarque/'.$idOpcion.'/'.$item->Id) }}">Modificar</a></li>

									      @foreach($listaOpcionPlus as $itemp)
									      
									      		{{--*/ $resultadop = strpos($itemp->Nombre, 'Primer') /*--}}
									      		{{--*/ $resultados = strpos($itemp->Nombre, 'Segundo') /*--}}

									      		{{--*/ $class = '' /*--}}
									      		{{--*/ $idOpcioncerrar = '/'.$idOpcion /*--}}

									      		@if($resultadop !== FALSE) 
									      			@if($item->primerCierre != '') 
									      				{{--*/ $class = 'primercierre notactiveurl' /*--}}
									      			@else
									      				{{--*/ $class = 'primercierre' /*--}}
										      		@endif
									      		@endif

									      		@if($resultados !== FALSE) 
									      			@if($item->segundoCierre != '') 
									      				{{--*/ $class = 'segundocierre notactiveurl' /*--}}
									      			@else
									      				{{--*/ $class = 'segundocierre' /*--}}
										      		@endif
									      		@endif

									      		{{--*/ $resultadotoma = strpos($itemp->Nombre, 'Toma') /*--}}
									      		@if($resultadotoma !== FALSE)
												    @if($item->EstadoProceso == 'C') 
											      		{{--*/ $class = 'notactiveurl' /*--}}
												    @endif
									      		@endif
									      		
									      		{{--*/ $resultadoagregar= strpos($itemp->Nombre, 'Agregar') /*--}}
									      		@if($resultadoagregar !== FALSE)
												    @if($item->EstadoProceso == 'C') 
											      		{{--*/ $class = 'notactiveurl' /*--}}
												    @endif
									      		@endif


									      	<li><a class='{{$class}}' href="{{ url('/'.$itemp->Pagina.'/'.Hashids::encode(substr($itemp->Id, -12)).'/'.$item->Id.$idOpcioncerrar)}}">{{$itemp->Nombre}}</a></li>
									    	
									      @endforeach



									    </ul>
									</div>
				        		</td>
                            

			            </tr>
			            @endforeach
			      	</tbody>
			      	<tfoot class="footable-pagination">
			        	<tr>
			          		<td colspan="6"><ul id="pagination" class="footable-nav"></ul></td>
			        	</tr>
			      	</tfoot>
			    </table>  
			</div>

		</div>

	</div>	
</div>
@stop

@section('script')

	<!-- TABLA JS -->
	{{ HTML::script('/js/tabla/footable.js'); }}
	{{ HTML::script('/js/tabla/footable.sortable.js'); }}
	{{ HTML::script('/js/tabla/footable.filter.js'); }}
	{{ HTML::script('/js/tabla/footable.paginate.js'); }}

	<script type="text/javascript">

	    $(function() {
	      $('table').footable();
	    });

	    $(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
	</script>

@stop