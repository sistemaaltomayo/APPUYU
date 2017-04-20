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
	</div>
    @endif 

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">Lista Solicitudes Personal <small>(Ultimas 30 Solicitudes)</small></h4>
</div>

<div class="container">

	<div class="row">
		
		<div class="col-xs-12 cabecerageneral">

			<div class="col-xs-12 buscaragregar">
				<div class="filter col-xs-12 col-sm-8  col-md-8 col-lg-6">
					<input id="filter" class="form-control control" placeholder="Buscar" type="text" />
				</div>
				<div class="agregar col-xs-12 col-sm-4  col-md-4 col-lg-6">

                    <a href="{{ url('/insertar-solicitud-personal/'.$idOpcion) }}" class="btn btn-success">
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                    </a>

				</div>
			</div>


			<div class="listatabla col-xs-12">
				<div class="listatoma">

				    <table data-filter="#filter" class="table demo" data-page-size="30">
				      	<thead>
					        <tr>
					        	<th data-class="expand" >
					            	Correlativo
					          	</th>
					          	<th >
					            	Zona
					          	</th>
					          	<th data-sort-initial="descending">
					            	Fecha Creación
					          	</th>
					          	<th >
					            	Motivo
					          	</th>
					          	<th data-hide="phone,tablet">
					            	Cargo
					          	</th>
					          	<th data-hide="phone,tablet">
					            	Usuario Creación
					          	</th>					          	
					          	<th data-hide="phone,tablet">
					            	Opciones
					          	</th>

					        </tr>
				      	</thead>
				      	<tbody>
				      		@foreach($listaSolicitudPersonal as $item)
				        	<tr>
				        		
				        			<td>{{$item->Correlativo}}</td>
				        			<td>{{$item->Nombre}}</td>
				        			<td>{{date_format(date_create($item->FechaCrea), 'm/d/Y H:i:s')}}</td>
					        		<td>{{$item->MotivoSolicitud}}</td>
					        		<td>{{$item->Cargo}}</td>
					        		<td>{{$item->Nombreusuario}} {{$item->Apellidousuario}}</td>


					        		<td>
									    <div class="btn-group">
										    <button type="button" class="btn btn-default dropdown-toggle"
										            data-toggle="dropdown">
										      Opciones
										      <span class="caret"></span>
										    </button>

										    <ul class="dropdown-menu menulistas">
										      <li><a href="{{ url('/modificar-solicitud-personal/'.$idOpcion.'/'.$item->Id) }}">Modificar</a></li>

										      @foreach($listaOpcionPlus as $itemp)

										      	<li><a href="{{ url('/'.$itemp->Pagina.'/'.Hashids::encode(substr($itemp->Id, -12)).'/'.$item->Id)}}">{{$itemp->Nombre}}</a></li>										    	
										      @endforeach

										    </ul>
										</div>
					        		</td>

				            </tr>
				            @endforeach
				      	</tbody>
				      	<tfoot class="footable-pagination">
				        	<tr>
				          		<td colspan="7"><ul id="pagination" class="footable-nav"></ul></td>
				        	</tr>
				      	</tfoot>
				    </table>  
				</div>
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