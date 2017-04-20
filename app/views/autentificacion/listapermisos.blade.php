@extends('template')
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
	<div class="permisomsj">

	</div>
	<h4 style="text-align:center;">PERMISOS </h4>
</div>

<div class="container">

	<div class="row">
		




		<div class="listatabla permisos col-xs-12">	
			<div class="listatoma ">

				<div class="container">
					<div class=" col-sm-4 col-md-2">
					    <nav class="nav-sidebar">
							<ul class="tabsroles nav tabs">
								{{--*/ $sw = 1 /*--}}
							  	@foreach($listaRoles as $item)

						          	<li class="selectrolper @if ($sw == 1) active @endif" id="{{$item->Id}}"><a href="#tab{{$item->Id}}" data-toggle="tab">{{$item->Descripcion}}</a></li>

						          	{{--*/ $sw = $sw + 1 /*--}}
					         	 @endforeach                               
							</ul>
						</nav>
					</div>

					<div class="tab-content  col-sm-8 col-md-10">

						{{--*/ $sw = 1 /*--}}
					  	@foreach($listaRoles as $item)

					  		<div class="tab-pane @if ($sw == 1) active @endif text-style" id="tab{{$item->Id}}">
					  			@if ($sw == 1) Los permisos del Super Administrador no pueden ser modificados. @endif
							</div>
				          	{{--*/ $sw = $sw + 1 /*--}}
				     	 @endforeach  

					</div>
				       
				</div>

			</div>

		</div>

	</div>	
</div>
@stop
