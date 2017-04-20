@extends('template')

@section('style')
	{{ HTML::style('css/cssCliente.css'); }}
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
	</div>
    @endif 

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">LISTA DE CHECK LIST <small>(Ultimas 30 Check List)</small></h4>
</div>

<div class="container">

	<div class="row">
		
		<div class="col-xs-12 cabecerageneral">

			<div class="col-xs-12 buscaragregar">
				<div class="filter col-xs-12 col-sm-8  col-md-8 col-lg-6">
					<input id="filter" class="form-control control" placeholder="Buscar" type="text" />
				</div>
				<div class="agregar col-xs-12 col-sm-4  col-md-4 col-lg-6">

                    <a href="{{ url('/agregar-checklist/'.$idOpcion) }}" class="btn btn-success">
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                    </a>

				</div>
			</div>


			<div class="listatabla col-xs-12">	
				<div class="listatoma">
				    <table data-filter="#filter" class="table demo" data-page-size="20">
				      	<thead>
					        <tr>
					        	<th class='id' data-class="expand" >
					            	Id
					          	</th>
					          	<th>
					            	Zona
					          	</th>
					          	<th>
					            	Codigo
					          	</th>
					          	<th>
					            	Tipo Inspección
					          	</th>
			 
					          	<th data-hide="phone,tablet" data-sort-initial="descending">
					          		Fecha Creación
					          	</th>	
					          	<th data-hide="phone,tablet">
					            	Opciones
					          	</th>
					        </tr>
				      	</thead>
				      	<tbody>
				      		{{--*/ $numeracion = 1 /*--}}
				      		{{--*/ $estado = '' /*--}}
				      		@foreach($InspeccionesAgrupados as $item)

				        	<tr>
				        		
				        			<td class='id'>{{$numeracion}}</td>
				        			<td>{{$item->Zona}}</td>
				        			<td>{{$item->Codigo}}</td>
									<td>{{$item->Descripcion}}</td>
									<td>{{date_format(date_create($item->FechaCrea), 'd/m/Y')}}</td>

					        		<td>

									    <div class="btn-group">
										    <button type="button" class="btn btn-default dropdown-toggle"
										            data-toggle="dropdown">
										      Opciones
										      <span class="caret"></span>
										    </button>
										    <ul class="dropdown-menu menulistas">
										      @foreach($AreasInspecciones as $itemp)

							 					@if($itemp->Codigo == $item->Codigo)

							 						@if($itemp->Estado == 'A')
							 							{{--*/ $estado = 'Abierto' /*--}}
							 						@else
							 							{{--*/ $estado = 'Cerrado' /*--}}
													@endif

							 						<li><a href="{{ url('/detallechecklist/'.$itemp->Id.'/'.$itemp->Codigo.'/'.$idOpcion) }}">{{$itemp->Descripcion}} <span class="estadoinspeccion">({{$estado}})</span></a></li> 
							 					@endif
										      	   
										      @endforeach
										    </ul>
										</div>

				            		</td>
				            </tr>
				            {{--*/ $numeracion = $numeracion + 1 /*--}}
				            @endforeach
				      	</tbody>
				      	<tfoot class="footable-pagination">
				        	<tr>
				          		<td colspan="8"><ul id="pagination" class="footable-nav"></ul></td>
				        	</tr>
				      	</tfoot>
				    </table>  
				</div>

			</div>

	</div>	
</div>
@stop
@section('javascript')


	{{ HTML::script('/js/tabla/footable.js'); }}
	{{ HTML::script('/js/tabla/footable.sortable.js'); }}
	{{ HTML::script('/js/tabla/footable.filter.js'); }}
	{{ HTML::script('/js/tabla/footable.paginate.js'); }}

	<script type="text/javascript">
	    $(function() {
	      $('table').footable();
	    });
	</script>

@stop