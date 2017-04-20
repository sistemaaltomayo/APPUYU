<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>Sistema COFFEE AND ARTS - Multiplataforma</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="icon" href="{{asset('img/logo.ico')}}"/>

        {{ HTML::style('css/bootstrap.min.css'); }}
        {{ HTML::style('css/font-awesome.min.css'); }}
        @yield('style')
        {{ HTML::style('css/bootsnipp.css'); }}
        {{ HTML::style('css/global.css'); }}


    </head>


    <body>
    	<section>


            {{--*/ $orden = 0 /*--}}
            {{--*/ $listaMenu = Session::get('listaMenu') /*--}}

            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header"> 
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                  </button>

                  {{ HTML::link('/bienvenidos-coffee-and-arts', 'JFWEB' , array('class' => 'navbar-brand'))}}
                

                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">

                    @for ($i = 0; $i < count($listaMenu); $i++)

                        @if($orden != $listaMenu[$i]->OrdenGrupo)

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{$listaMenu[$i]->NombreGrupo}} 
                            <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menutop">
                        @endif
                                <li>
                                    {{ HTML::link('/'.$listaMenu[$i]->Pagina.'/'.Hashids::encode(substr($listaMenu[$i]->IdOpcion, -12)), $listaMenu[$i]->NombreOpcion)}}
                                    
                                </li>

                        {{--*/ $orden = $listaMenu[$i]->OrdenGrupo /*--}}

                        @if(!isset($listaMenu[$i+1]->OrdenGrupo))
                                    </ul>
                                </li>
                        @else
                            @if($listaMenu[$i+1]->OrdenGrupo != $orden)
                                    </ul>
                                </li>
                            @endif
                        @endif

                    @endfor

                    </ul>



                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span> 
                                <strong>{{Session::get('Usuario')[0]->Login}}</strong>
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="hidden-xs col-lg-4">
                                                <p class="text-center">
                                                    <span class="glyphicon glyphicon-user icon-size"></span>
                                                </p>
                                            </div>
                                            <div class="col-xs-12 col-lg-8">
                                                <p class="text-left"><strong>{{Session::get('Usuario')[0]->NombreRol}} </strong></p>
                                                <p class="text-left small">{{Session::get('Usuario')[0]->Nombre}} {{Session::get('Usuario')[0]->Apellido}} </p>

                                                <p class="text-left small">{{Session::get('zona')->Zona}} </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="navbar-login navbar-login-session">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                    <a href="{{ url('/cerrarsesion') }}" class="btn btn-danger btn-block">Cerrar Sesion</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>  


                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
            <p id='ipsocket' style='display:none;'>{{(string)Session::get('basedatos')['parametro'][4]['valor']}}</p>

    		@yield('section')



            {{ HTML::script('js/jquery-2.1.3.min.js'); }}
            {{ HTML::script('js/jquery-ui.min.js'); }}
            {{ HTML::script('js/bootstrap.min.js'); }}
            {{ HTML::script('js/validaciones.js'); }}
            {{ HTML::script('js/jquery.numeric.js'); }}

            @yield('script')

            {{ HTML::script('js/global.js'); }}

		</section>
    </body>

</html>


