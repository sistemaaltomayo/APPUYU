
@extends('template')
@section('section')
    <!-- Header -->
    <header class="headervideo">
        <div class="homepage-hero-module">
            <div class="video-container">
                <div class="title-container">
                    <div class="headline">
                        <h1>ALFASWEB</h1>
                    </div>
                    <div class="description">
                        <div class="inner">Parecer diferentes es muy sencillo, lo difícil es serlo. En ALFASWEB nos implicamos en tu proyecto, 
                            con la mejor calidad y a los mejores precios.
                        </div>
                    </div>
                </div>
                <div class="filter"></div>
                <video autoplay loop class="fillWidth" poster="video/video.jpg">
                    <source src="video/header.mp4" type="video/mp4">
                    <source src="video/header.webm" type="video/webm">
                    <source src="video/header.ogg" type="video/ogg">
                    Tu navegador no soporta video
                </video>
            </div>
        </div>
    </header>
    
    <section id="servicio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center titulos">
                    <h2 class="titulo">SERVICIOS</h2>
                    <p class="subtitulo"><em>La planeación, diseño y desarrollo de proyectos a la medida es lo que mejor hacemos, lo que nos ha hecho famosos. 
                    Si quieres realizar un proyecto digital que se destaque, vamos a ser buenos amigos.</em></p>
                </div>
            </div>


            <div class="row">
                <div class="cuadro col-fr-12 col-xs-6  col-sm-6 col-md-4 col-lg-4">
                    <div class="col-lg-12">
                        <a href="{{ URL::asset('desarrollo/desarrollo-web')}}">

                            {{ HTML::image('img/servicios/desarrollomedida.png') }}
                            

                        </a>    
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h3>Desarrollo web a Medida</h3>
                        </div>
                        
                        <div class="detalle col-lg-12">
                            <a href="{{ URL::asset('desarrollo/desarrollo-web')}}">ver detalles</a>
                        </div>
                        <div class="col-lg-12">
                            <p class="descripcion">
                                Somos expertos en diseñar, 
                                programar y maquetar proyectos autogestionables a medida, 
                                especialmente los difíciles y es que nos encantan los retos.
                            </p>
                        </div>
                    </div>
                        
                </div>
                <div class="cuadro col-fr-12 col-xs-6  col-sm-6 col-md-4 col-lg-4">
                    <div class="col-lg-12">
                        <a href="{{ URL::asset('diseno/diseno-web')}}">

                            {{ HTML::image('img/servicios/disenoweb.png') }}
                            
                        </a>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h3>Diseño web</h3>
                        </div>
                        <div class="oferta col-lg-6">
                            <p><b><small>desde</small> S/. 599</b></p>
                        </div>
                        <div class="detalle col-lg-6">
                            <a href="{{ URL::asset('diseno/diseno-web')}}">ver detalles</a>
                        </div>
                        <div class="col-lg-12">
                            <p class="descripcion">
                                Todo lo que necesitas para tener una web sencilla 
                                con una apariencia profesional diseñada por un diseñador 
                                de prestigio, por muy poco dinero y en muy poco tiempo.
                            </p>
                        </div>
                    </div>      
                </div>
                <div class="cuadro col-fr-12 col-xs-6  col-sm-6 col-md-4 col-lg-4">
                    <div class="col-lg-12">
                        <a href="{{ URL::asset('tienda/tienda-online')}}">
                            {{ HTML::image('img/servicios/tienda.png') }}
                        </a>
                    </div>
                    <div class="col-lg-12">

                        <div class="col-lg-12">
                            <h3>Tienda Online</h3>
                        </div>
                        <div class="oferta col-lg-6">
                            <p><b><small>desde</small> S/. 1999</b></p>
                        </div>
                        <div class="detalle col-lg-6">
                            <a href="{{ URL::asset('tienda/tienda-online')}}">ver detalles</a>
                        </div>
                        <div class="col-lg-12">
                            <p class="descripcion">
                                Todo lo que necesitas para tener una web sencilla 
                                con una apariencia profesional diseñada por un diseñador 
                                de prestigio, por muy poco dinero y en muy poco tiempo.
                            </p>
                        </div>
                    </div>   
                </div>


                <!--<div class="cuadro col-fr-12 col-xs-6  col-sm-6 col-md-4 col-lg-4">
                    <div class="col-lg-12">
                        <img src="/WEBCODEADA/public/img/servicios/hosting.png">
                    </div>
                    <div class="col-lg-12">

                        <div class="col-lg-12">
                            <h3>Servicio de Hosting</h3>
                        </div>
                        <div class="oferta col-lg-6">
                            <p><b><small>desde</small> S/. 599</b></p>
                        </div>
                        <div class="detalle col-lg-6">
                            <a href="/WEBCODEADA/public/tienda/tienda-online">ver detalles</a>
                        </div>
                        <div class="col-lg-12">
                            <p class="descripcion">
                                El Servicio de Hosting o Alojamiento Web es el que provee el espacio y las condiciones 
                                necesarias para almacenar todo el contenido de una Web, cuentas de correo electrónico, 
                                cuentas FTP, bases de datos, y un cantidad de recursos que permiten el funcionamiento de una Web.
                            </p>
                        </div>
                    </div>   
                </div>-->

            </div>
        </div>
        <div class="row">
            <div class="herramientas col-al-12 col-fr-12 col-xs-12  col-sm-12 col-md-12 col-lg-12">
                <div class="top herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="fa fa-android fa-3x"></i>
                </div>
                <div class="top herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="fa fa-html5 fa-3x"></i>
                </div>
                <div class="top herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="fa fa-css3 fa-3x"></i>
                </div>
                <div class="top herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="fa fa-wordpress fa-3x"></i>
                </div>
                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="fa fa-git fa-3x"></i>
                </div>
                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="fa fa-github fa-3x"></i>
                </div>
                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="icon-php"></i>
                </div>
                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="icon-java-bold"></i>
                </div>
                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="icon icon-python"></i>
                </div>

                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="icon icon-nodejs"></i>
                </div>
                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="icon icon-postgres"></i>
                </div>
                <div class="herramienta col-al-3 col-fr-2 col-xs-2 col-sm-1 col-md-1 col-lg-1">
                    <i class="icon-mysql-alt"></i>
                </div>

            </div>
        </div>
    </section>


    <section id="portafolio" class="colorinicio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class='titulo'>PORTAFOLIO</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portafolio/altomayo.png" class="img-responsive" alt="">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portafolio/pexport.png" class="img-responsive" alt="">
                    </a>
                </div>

                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal5" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portafolio/servan.png" class="img-responsive" alt="">
                    </a>
                </div>

                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portafolio/cpu.jpg" class="img-responsive" alt="">
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portafolio/unprg.png" class="img-responsive" alt="">
                    </a>
                </div>


                <!--<div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal6" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portfolio/submarine.png" class="img-responsive" alt="">
                    </a>
                </div>-->
            </div>
        </div>
    </section>
    <!-- About Section -->



    <!-- About Section -->
    <section id="nosotros">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 text-center titulos">
                    <h2 class="titulo">NOSOTROS</h2>
                    <p class="subtitulo"><em>ALFASWEB es una empresa dedicada al desarrollo y al diseño de soluciones web y móvil</em></p>
                </div>
            </div>
            <div class="row">
                <div class="cuadro col-fr-12 col-xs-6  col-sm-6 col-md-4 col-lg-4">
                    <div class="icono col-lg-12">
                        <i class="fa fa-heart-o fa-5x"></i>
                    </div>
                    <div class="titulo col-lg-12">
                        <h3>PASIÓN</h3>
                    </div>
                    <div class="descripcion col-lg-12">
                        <p>Nuestro trabajo nos apasiona. 
                        Cada nuevo proyecto en el que nos involucramos 
                        nos trasmite motivación e ilusión, por eso siempre 
                        damos nuestra mejor versión :)</p>
                    </div>
                </div>
                <div class="cuadro col-fr-12 col-xs-6  col-sm-6 col-md-4 col-lg-4">
                    <div class="icono col-lg-12">
                        <i class="fa fa-line-chart fa-5x"></i>
                    </div>
                    <div class="titulo col-lg-12">
                        <h3>EXPERIENCIA</h3>
                    </div>
                    <div class="descripcion col-lg-12">
                        <p>Sabemos lo que hacemos. Y es que después de varios años 
                        trabajando con entusiasmo, hemos desaprendido y aprendido 
                        a diario. Aún seguimos aprendiendo, cada proyecto es una 
                        nueva aventura llena de experiencias.</p>
                    </div>
                </div>
                <div class="cuadro col-fr-12 col-xs-6  col-sm-6 col-md-4 col-lg-4">
                    <div class="icono col-lg-12">
                        <i class="fa fa-cogs fa-5x"></i>
                    </div>
                    <div class="titulo col-lg-12">
                        <h3>TECNOLOGÍA</h3>
                    </div>
                    <div class="descripcion col-lg-12">
                        <p>Somos creativos, conectores y apasionados por el diseño y la 
                        estrategia que funciona. Conectamos clientes con tecnología, 
                        productos con clientes a través de nuestros proyectos web, 
                        móvil y e-commerce.</p>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center titulos">
                <p class="subtitulo"><em>Somos tu perfecto aliado para el diseño web y desarrollo. Tu proyecto nos apasionará…</em></p>
            </div>
        </div>
        <div class="row">
            <div class="cuadrosomos col-fr-12 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="icono col-fr-12 col-xs-12  col-sm-4 col-md-4 col-lg-4">
                        <i class="fa fa-cogs fa-5x"></i>
                    </div>
                    <div class="titulo col-fr-12 col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3>Nos gustan los retos</h3>
                        </div>
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <p>
                                Con cada nuevo proyecto que nos exige esfuerzo y creatividad 
                                mejoramos nuestro conocimiento y experiencia, queremos seguir 
                                superándonos y creciendo ¡Esperamos tus retos!
                            </p>
                        </div>
                    </div>
            </div>
            <div class="cuadrosomos col-fr-12 col-xs-6  col-sm-6 col-md-6 col-lg-6">
                    <div class="icono col-fr-12 col-xs-12  col-sm-3 col-md-4 col-lg-4">
                        <i class="fa fa-paper-plane-o fa-5x"></i>
                    </div>
                    <div class="titulo col-fr-12 col-xs-12 col-sm-9 col-md-8 col-lg-8">
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3>¿Viajamos juntos? Queremos disfrutar de tu éxito.</h3>
                        </div>
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <p>
                                Los proyectos digitales de éxito no acaban en la entrega, 
                                ¡si no empiezan! El análisis y las mejoras evolutivas 
                                constantes son las acciones que mejor nos garantizan la 
                                consecución de los objetivos y metas de tu proyecto.
                            </p>
                        </div>
                    </div>
            </div>
            <div class="cuadrosomos col-fr-12 col-xs-6  col-sm-6 col-md-6 col-lg-6">
                    <div class="icono col-fr-12 col-xs-12  col-sm-3 col-md-4 col-lg-4">
                        <i class="fa fa-cube fa-5x"></i>
                    </div>
                    <div class="titulo col-fr-12 col-xs-12 col-sm-9 col-md-8 col-lg-8">
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3>Damos nuestra mejor versión</h3>
                        </div>
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <p>
                                Trabajar en lo que te apasiona es la clave de poder 
                                abordar cada Proyecto, cada tarea, y cada acción con 
                                motivación e ilusión… y lo mejor es que eso se refleja 
                                en los resultados finales de cada proyecto.
                            </p>
                        </div>
                    </div>
            </div>
            <div class="cuadrosomos col-fr-12 col-xs-6  col-sm-6 col-md-6 col-lg-6">
                    <div class="icono col-fr-12 col-xs-12  col-sm-3 col-md-4 col-lg-4">
                        <i class="fa fa-coffee fa-5x"></i>
                    </div>
                    <div class="titulo col-fr-12 col-xs-12 col-sm-9 col-md-8 col-lg-8">
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3>¡Cuéntanos! Seguro que nos encantará...</h3>
                        </div>
                        <div class="col-fr-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <p>
                                Si tienes una idea sobre un proyecto digital, ecommerce
                                llámanos y hablamos, podemos aconsejarte sin compromiso 
                                de la mejor manera de abordar el proyecto.
                            </p>
                        </div>
                    </div>
            </div>
        </div>

    </section>

    <!-- Contact Section -->
    <section class="colorinicio" id="contactame">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="titulo">CONTACTAME</h2>
                </div>
            </div>

        </div>
        <div class="container" style="margin-top:40px;">
            <div class="row">
                <div class="col-md-8">
                    <div class="wellcontactame well well-sm">
                        {{Form::open(array('method' => 'POST', 'url' => '/cliente/insertar-cliente'))}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        Nombre : </label>
                                        {{Form::text('nombre','', array('class' => 'form-control', 'placeholder' => 'Nombres Completos', 'id' => 'nombre', 'maxlength' => '100'))}}
                                </div>
                                <div class="form-group">
                                    <label for="email">
                                        Correo electrónico  : </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                        </span>
                                        <input type="email" class="form-control" name="correoelectronico" id="correoelectronico" placeholder="Correo electrónico" /></div>
                                </div>
                                <div class="form-group">
                                    <label for="name">
                                        Celular : </label>
                                        {{Form::text('celular','', array('class' => 'form-control numero', 'placeholder' => 'Celular', 'id' => 'celular', 'maxlength' => '9'))}}
                                </div>
                                <div class="form-group">
                                    <label for="subject">
                                        Paquete</label>
                                    {{ Form::select('paquete', $comboplan, $selectedplan,['class' => 'form-control control' , 'id' => 'paquete']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        Mensaje : </label>
                                    {{ Form::textarea('mensaje', null, ['class' => 'form-control','rows' => '9','cols' => '25','placeholder' => 'Indícanos lo más detallado posible tu idea para realizar la web ...', 'id' => 'mensaje', 'maxlength' => '2000']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right" id="enviaremail">
                                    Enviar</button>

                                    <div class="mensaje-error">
         
                                    </div>

                                           
                                    @if (Session::get('mensajecorrecto'))

                                        <div class="alert alert-success">
                                            {{Session::get('mensajecorrecto')}}
                                        </div>
                                        
                                    @endif
                                    


                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
                <div class="col-md-4" style="font-size:1.2em;">
                    <form>
                    <legend><span class="glyphicon glyphicon-globe"></span> Nuestra Oficina</legend>
                    <address>
                        
                        Leticia 691<br>
                        Chiclayo, Perú<br>
                        <abbr title="Phone">
                            P:</abbr>
                         #979820173
                    </address>
                    <address>
                        <strong>Correo para consultas : </strong><br><br>
                        <a href="mailto:#" style="color:#000;"><b>atencioncliente@alfasweb.com</b></a>
                    </address>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- Portfolio Modals -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Altomayo</h2>
                            <hr class="star-primary">
                            <img src="img/portafolio/altomayo.png" class="img-responsive img-centered" alt="">
                            <p>Pagina web Altomayo su desarrollo se realizó con php (framework laravel), css3, html5, javascript (jquery), mysql.</p>
                            <p>El paquete utilizado es <a href="{{ URL::asset('desarrollo/desarrollo-web')}}">desarrollo web a medida</a>, el tiempo aproximado fue de 2 meses.</p>
                            <ul class="list-inline item-details">
                                <li>Cliente:
                                    <strong><a href="http://www.cafealtomayo.com.pe/" target="_blank">Café altomayo</a>
                                    </strong>
                                </li>
                                <li>Fecha:
                                    <strong>Octubre 2015
                                    </strong>
                                </li>
                                <li>Servicio:
                                    <strong><a href="{{ URL::asset('desarrollo/desarrollo-web')}}">Desarrollo web a Medida</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Pexport</h2>
                            <hr class="star-primary">
                            <img src="img/portafolio/pexport.png" class="img-responsive img-centered" alt="">
                            <p>Desarrollo Web para atención de emergencia de la empresa Pexport su desarrollo se realizó con php (framework laravel), css3, html5, javascript (angular), sql server 2012. </p>
                            <p>El paquete utilizado es desarrollo web a medida, el tiempo aproximado es de 1 mes.</p>
                            <ul class="list-inline item-details">
                                <li>Cliente:
                                    <strong>Pexport
                                    </strong>
                                </li>
                                <li>Fecha:
                                    <strong>Julio 2015
                                    </strong>
                                </li>
                                <li>Servicio:
                                    <strong><a href="{{ URL::asset('desarrollo/desarrollo-web')}}">Desarrollo web a Medida</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>UNPRG</h2>
                            <hr class="star-primary">
                            <img src="img/portafolio/unprg.png" class="img-responsive img-centered" alt="">
                            <p>Desarrollo Web para la carga lectiva de docente de la institución UNPRG su desarrollo se realizó con java, css3, html5, javascript (jquery), oracle.</p>
                            <p>El paquete utilizado es <a href="{{ URL::asset('desarrollo/desarrollo-web')}}">desarrollo web a medida</a>, el tiempo aproximado fue de 7 meses.</p>
                            <ul class="list-inline item-details">
                                <li>Cliente:
                                    <strong><a href="http://aplicaciones.unprg.edu.pe/ModuloAutenticacion/indice.jsp" target="_blank">UNPRG</a>
                                    </strong>
                                </li>
                                <li>Fecha:
                                    <strong>junio 2013
                                    </strong>
                                </li>
                                <li>Servicio:
                                    <strong><a href="{{ URL::asset('desarrollo/desarrollo-web')}}">Desarrollo web a Medida</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>CPU</h2>
                            <hr class="star-primary">
                            <img src="img/portafolio/cpu.jpg" class="img-responsive img-centered" alt="">
                            <p>Desarrollo Web para la matricula online de la institución CPU su desarrollo se realizó con java (struts 2), css3, html5, javascript (jquery), oracle.</p>
                            <p>El paquete utilizado es <a href="{{ URL::asset('desarrollo/desarrollo-web')}}">desarrollo web a medida</a>, el tiempo aproximado fue de 4 meses.</p>
                            <ul class="list-inline item-details">
                                <li>Cliente:
                                    <strong><a href="http://cpu.unprg.edu.pe/cpu/index.php" target="_blank">CPU</a>
                                    </strong>
                                </li>
                                <li>Fecha:
                                    <strong>Enero 2014
                                    </strong>
                                </li>
                                <li>Servicio:
                                    <strong><a href="{{ URL::asset('desarrollo/desarrollo-web')}}">Desarrollo web a Medida</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Óptica Servan</h2>
                            <hr class="star-primary">
                            <img src="img/portafolio/servan.png" class="img-responsive img-centered" alt="">
                            <p>Pagina web óptica servan su desarrollo se realizó con php, css3, html5, javascript (jquery), mysql.</p>
                            <p>El paquete utilizado es <a href="{{ URL::asset('diseno/diseno-web-coorporativo')}}">Paquete Corporativo</a>, el tiempo aproximado fue de 2 meses.</p>
                            <ul class="list-inline item-details">
                                <li>Cliente:
                                    <strong>Óptica Servan
                                    </strong>
                                </li>
                                <li>Fecha:
                                    <strong>Agosto 2014
                                    </strong>
                                </li>
                                <li>Servicio:
                                    <strong><a href="{{ URL::asset('diseno/diseno-web-coorporativo') }}">Paquete Corporativo</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Project Title</h2>
                            <hr class="star-primary">
                            <img src="img/portfolio/submarine.png" class="img-responsive img-centered" alt="">
                            <p>Use this area of the page to describe your project. The icon above is part of a free icon set by <a href="https://sellfy.com/p/8Q9P/jV3VZ/">Flat Icons</a>. On their website, you can download their free set with 16 icons, or you can purchase the entire set with 146 icons for only $12!</p>
                            <ul class="list-inline item-details">
                                <li>Cliente:
                                    <strong><a href="http://startbootstrap.com">Altomayo</a>
                                    </strong>
                                </li>
                                <li>Fecha:
                                    <strong><a href="http://startbootstrap.com">Septiembre 2015</a>
                                    </strong>
                                </li>
                                <li>Servicio:
                                    <strong><a href="http://startbootstrap.com">Desarrollo web a Medida</a>
                                    </strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
</div>

        <div class="activeitem">        
            @if (Session::get('activeitemb'))
                    {{ Session::get('activeitemb') }}
            @endif
        </div>
@stop
@section('jquery')
<script>
    $(function() {
        var val=$('.activeitem').html();
        if(val.trim()!=""){
            $('html, body').stop().animate({
                scrollTop: $(val).offset().top
            }, 1500, 'easeInOutExpo');
        }
        if(val.trim()=="" || val.trim()=="#page-top"){
            $(".page-scroll").removeClass( "active");
        }
        
    });
</script>
@stop