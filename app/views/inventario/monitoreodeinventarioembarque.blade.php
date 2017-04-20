@extends('template')
@section('style')


    {{ HTML::style('/css/tabla/footable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.sortable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.paginate.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}
    {{ HTML::style('/css/cssInventario.css') }}


@stop
@section('section')

<div class="titulo col-xs-12 col-md-12">
	<h4 style="text-align:center;">
		Monitoreo de Toma {{$nombreopcion}}
	</h4>
</div>


    @if (Session::get('alertaMensajeGlobal'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <strong>Bien Hecho!</strong> {{ Session::get('alertaMensajeGlobal') }}
       
      </div>
    @endif  
<div class="container">
	<div class="row">
		<div class=" cabecerageneral col-xs-12">

			<div class="filtro col-xs-12 col-md-12">
				<input id="filter" class="form-control control" placeholder="Buscar" type="text" />


			</div>

			{{--*/ $celdas = (count($listaUsuarios)*2)+4 /*--}}
			
			<div class="listatoma col-xs-12" id="listamonitoreo">

			    <table data-filter="#filter" class="demo table" data-page-size="200">
			      	<thead>

		      	        <tr class="footable-group-row">
				          <th data-group="group1" colspan="2" style="text-align:center;">Información del Producto</th>
				          {{--*/ $cont = 2 /*--}}
				          @foreach($listaUsuarios as $item)
				          	<th data-group="group{{$cont}}" colspan="2" style="text-align:center;">{{$item->Login}} </th>
				          	{{--*/ $cont = $cont + 1 /*--}}
				          @endforeach

				          {{--*/ $ctotal = 1 + ($cont-2) +1 /*--}}
				          <th data-group="group{{$ctotal}}" colspan="2" style="text-align:center;">Total</th>
				        
				        </tr>
				        <tr>
				          	<th  data-group="group1" data-class="expand" data-sort-initial="true">
				            	Código
				          	</th>
				          	<th data-group="group1">
				            	Descripción
				          	</th>
				          	{{--*/ $cont = 2 /*--}}
							@foreach($listaUsuarios as $item)
					          	<th data-group="group{{$cont}}" data-hide="phone,tablet">
					            	Stock_1
					          	</th>
					          	<th data-group="group{{$cont}}" data-hide="phone,tablet">
					            	Stock_2
					          	</th>
					          	{{--*/ $cont = $cont + 1 /*--}}
				          	@endforeach
			          		<th data-group="group{{$ctotal}}">
				            	T1
				          	</th>
				          	<th data-group="group{{$ctotal}}">
				            	T2
				          	</th>
				        </tr>
			      	</thead>
			      	<tbody class="monitoreo">
			      		@foreach($listaMonitoreo as $itemm)
			        	<tr>
			        			{{--*/ $T1 = 0.0 /*--}}
			        			{{--*/ $T2 = 0.0 /*--}}
			        			<td>{{$itemm->CodigoProducto}}</td>
			        			<td class="descripcion">{{$itemm->Descripcion}}</td>
								@foreach($listaUsuarios as $item)
									{{--*/ $Id1 = $item->Id.'_'.$item->Login.'_1' /*--}}
									{{--*/ $Id2 = $item->Id.'_'.$item->Login.'_2' /*--}}

									{{--*/ $T1 = $T1 + $itemm->$Id1/*--}}
									{{--*/ $T2 = $T2 + $itemm->$Id2/*--}}

						          	<td data-hide="phone,tablet">
										{{number_format($itemm->$Id1, 2, '.', ',')}}
						          	</td>
						          	<td data-hide="phone,tablet">
						            	{{number_format($itemm->$Id2, 2, '.', ',')}}
						          	</td>
					          	@endforeach
                   				<td>{{number_format($T1, 2, '.', ',')}}</td>
                   				<td>{{number_format($T2, 2, '.', ',')}}</td>
						@endforeach
			            </tr>
			            
			      	</tbody>
			      	<tfoot class="footable-pagination">
			        	<tr>
			          		<td colspan="{{$celdas}}"><ul id="pagination" class="footable-nav"></ul></td>
			        	</tr>
			      	</tfoot>
			    </table>  
			</div>

		</div>

	</div>	
</div>
@stop

@section('script')


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