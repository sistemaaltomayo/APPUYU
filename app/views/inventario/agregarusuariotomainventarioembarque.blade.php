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

<div class="titulo col-xs-12">
		<h4 style="text-align:center;">Agregar Usuario a la Toma {{$nombreopcion}} <br>Toma : <b>{{$tbUsuarioAgregados[0]->Codigo}}</b></h4>
</div>

<div class="mensaje-error"></div>


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

		
	  	<div class="cabecerageneral col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-12 col-lg-offset-0">


			<div class="row">

		        <div class="dual-list list-left col-md-5">
		        	<h4 style="text-align:center;">Usuarios sin Asignar</h4>
		            <div class="well text-right">
		                <div class="row">
		                    <div class="col-md-10">
		                        <div class="input-group">
		                            <!--<span class="input-group-addon glyphicon glyphicon-search"></span>-->
		                            <input type="text" name="SearchDualList" class="form-control" placeholder="Buscar" />
		                        </div>
		                    </div>
		                    <div class="col-md-2">
		                        <div class="btn-group">
		                            <a class="btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
		                        </div>
		                    </div>
		                </div>
		                <ul class="list-group">
					    	@foreach($tbUsuarioLocal as $item)
					    	 		<li class="list-group-item" id="{{$item->Id}}" style="text-align:left;">
					    	 			{{$item->Apellido}} {{$item->Nombre}}
					    	 		</li>
					      	@endforeach	
		                </ul>
		            </div>
		        </div>

		        <div class="list-arrows col-md-2 text-center">
		            <button class="btn btn-default btn-sm move-left">
		                <span class="glyphicon glyphicon-chevron-left"></span>
		            </button>

		            <button class="btn btn-default btn-sm move-right">
		                <span class="glyphicon glyphicon-chevron-right"></span>
		            </button>
		        </div>

		        <div class="dual-list list-right col-md-5">
		        	<div>
		        		<h4 style="text-align:center;">Usuarios Asignados</h4>
		        	</div>
		            <div class="well">
		                <div class="row">
		                    <div class="col-md-2">
		                    	<button type="button" class="btn btn-success" id="insertarusuariosE">
						      		<span class="glyphicon glyphicon-floppy-saved"></span>
								</button>
		                        <!--<div class="btn-group">
		                            <a class="btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
		                        </div>-->
		                    </div>
		                    <div class="col-md-10">
		                        <div class="input-group">
		                            <input type="text" name="SearchDualList" class="form-control" placeholder="Buscar" />
		                            <!--<span class="input-group-addon glyphicon glyphicon-search"></span>-->
		                        </div>
		                    </div>
		                </div>
		                @foreach($tbUsuarioAgregados as $item)
					    	<li class="list-group-item usuarioinsertado">{{$item->Apellido}} {{$item->Nombre}} </strong></li>
					    @endforeach	
		                
		                <ul class="list-group" id="usuariosagregados">
		                    
		                </ul>
		            </div>
		        </div>

			</div>

	  	</div>


	</div>	
	<div id='idopcion' style='display:none;'>{{$idOpcion}}</div>
	{{ Form::hidden('idtomaweb',$idtomaweb, ['id' => 'idtomaweb'])}}
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