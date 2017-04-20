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
    <h4 style="text-align:center;">LISTA ENCUESTA CLIENTE <small>(Ultimas 30 Encuestas)</small> </h4>
</div>

<div class="container">

    <div class="row">
        
        <div class="col-xs-12 cabecerageneral">


            <div class="col-xs-12 buscaragregar">
                <div class="filter col-xs-12 col-sm-8  col-md-8 col-lg-6">
                    <input id="filter" class="form-control control" placeholder="Buscar" type="text" />
                </div>
                <div class="agregar col-xs-12 col-sm-4  col-md-4 col-lg-6">
                    <a href="{{ url('/agregar-encuesta/'.$idOpcion) }}" class="btn btn-success">
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                    </a>
                </div>
            </div>

            <div class="listatabla col-xs-12">  
                <div class="listatoma">
                    <table data-filter="#filter" class="table demo" data-page-size="60">
                        <thead>
                            <tr>
                                <th class='id' data-class="expand" >
                                    Id
                                </th>
                                <th>
                                    Zona
                                </th>
                                <th>
                                   Fecha Creación 
                                </th>
                                <th>
                                   DNI
                                </th>
                                <th>
                                   Usuario Toma Encuesta
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            {{--*/ $numeracion = 1 /*--}}
                            @foreach($listaEncuesta as $item)

                            <tr>
                                    <td class='id'>{{$numeracion}}</td>
                                    <td>{{$item->Descripcion}}</td>
                                    <td>{{date_format(date_create($item->FechaCrea), 'd/m/Y H:i:s')}} </td>
                                    <td>{{$item->DNI}}</td>
                                    <td>{{$item->Nombre}} {{$item->Apellido}}</td>
                            </tr>

                            {{--*/ $numeracion = $numeracion + 1 /*--}}
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