<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>Coffee And Arts - Sistema Multiplataforma</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <link rel="icon" href="{{asset('img/logo.ico')}}"/>
        {{ HTML::style('css/bootstrap.min.css'); }}
        {{ HTML::style('css/font-awesome.min.css'); }}
        {{ HTML::style('css/global.css'); }}


    </head>

    <body id="page-top" class="index fondologin">


    	<section id="section">
            <div class="container">    
                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                        <div class="panel panel-info" >
                                <div class="panel-heading fondoaltomayo">
                                    <div class="panel-title" style='text-align:center;'>
                                        {{ HTML::image('img/logo.png', 'logo altomayo') }}
                                    </div>
                                </div>     

                                <div style="padding-top:30px" class="panel-body" >

                                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                                        
                                        {{Form::open(array('method' => 'POST', 'url' => '/login'))}}
                                                    
                                            <div style="margin-bottom: 25px" class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                                                {{Form::text('usuario','', array('class' => 'form-control', 'placeholder' => 'usuario', 'id' => 'usuario'))}}
                                        
                                            </div>
                                                
                                            <div style="margin-bottom: 25px" class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>

                                                {{Form::password('clave', array('class' => 'form-control', 'placeholder' => 'clave', 'id' => 'clave'))}}

                                            </div>

                                            <div style="margin-bottom: 15px" >
                                                <button class="btn btn-lg btn-primary" type="submit" style="font-size: 15px;width:100%;">Ingresar</button>
                                            </div>

                                                @if(isset($alertaMensajeGlobal) && $alertaMensajeGlobal!='')
                                                      <div class="alert alert-danger">
                                                            <strong>¡Error!</strong>
                                                            {{$alertaMensajeGlobal}}
                                                      </div>
                                                @endif
                                        {{Form::close()}}  



                                    </div>                     
                                </div>  
                    </div>
                </div>
		</section>
    </body>




    @yield('jquery')

</html>


