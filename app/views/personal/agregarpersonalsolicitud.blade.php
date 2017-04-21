@extends('template')
@section('style')
 	{{ HTML::style('/css/select/bootstrap-select.min.css') }}
    {{ HTML::style('/css/cssPersonal.css') }}
@stop

@section('section')

<div class="mensaje-error"></div>

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<div class="msj"></div>
	<h4 style="text-align:center;">Agregar Personal Solicitud</h4>
</div>


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

	  	<div class="terminopersonal paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
	  		
			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Terminos y Condiciones del Puesto a Postular</h3>
					</div>


					<div class="panel-body">

						<div class="scrollbar col-xs-11" id="style-2">
								<h3>Términos y Condiciones de Uso</h3>
								<p>1.  El Aviso Legal y su Aceptación</p>

								El presente aviso legal (en adelante, el “Aviso Legal”) regula el uso del servicio del sitio web de Internet de la Bolsa de Trabajo de la Pontificia Universidad Católica del Perú (en adelante, “BTPUCP”) (http://www.btpucp.pucp.edu.pe) (en adelante, el “El Sitio”) que BTPUCP, con domicilio en la ciudad de Lima, distrito de San Miguel (Perú), pone a disposición de los Usuarios de Internet.

								La utilización del Sitio atribuye la condición de Usuario del Sitio (en adelante, el “Usuario”) e implica la aceptación plena y sin reservas de todas y cada una de las disposiciones incluidas en este Aviso Legal en la versión publicada por BTPUCP en el momento mismo en que el Usuario acceda al Sitio. En consecuencia, el Usuario debe leer atentamente el presente Aviso Legal en cada una de las ocasiones en que se proponga utilizar el Sitio, ya que el Aviso Legal puede sufrir modificaciones.

								Asimismo, la utilización del Sitio se encuentra sometida a todos los avisos, reglamentos de uso e instrucciones, puestos en conocimiento del Usuario por BTPUCP, que sustituyen, completan y/o modifican el presente Aviso Legal.

								“Contenido” significa toda clase de bases de datos que se encuentre disponible o accesible en el Sitio, sin importar su modalidad de expresión (medio impreso o en forma de medios magnéticos, ópticos o similares, mensaje de datos, foros, chats, software, bases de datos, material multimedia, textos propios, gráficos y todas y cada una de las características que se encuentran en el sitio).

								2.  Objeto

								A través del Sitio, BTPUCP facilita a los Usuarios el acceso y la utilización de diversos contenidos o servicios (en adelante, los “Contenidos y/o Servicios”) puestos a disposición por BTPUCP, en relación a temas laborales de alumnos y ex alumnos de la Pontificia Universidad Católica del Perú.

								3.  Condiciones de Acceso y Utilización del Sitio

								3.1 Carácter gratuito del acceso y utilización del Sitio

								El Acceso a los Contenidos y/o Servicios que se ofrecen en el Sitio son de carácter gratuito para los Usuarios.

								3.2. Obligación de hacer un uso correcto del Sitio y de los Servicios

								El Usuario se compromete a utilizar el Sitio y los Contenidos de conformidad con la Ley, el presente Aviso Legal, las Condiciones Particulares de ciertos Contenidos y/o Servicios y demás avisos, reglamentos de uso e instrucciones puestos en su conocimiento, así como de acuerdo con el orden público, la moral y las buenas costumbres.

								A tal efecto, el Usuario se abstendrá de utilizar cualquiera de los Contenidos y/o Servicios con fines o efectos ilícitos, prohibidos por la Ley, lesivos de los derechos e intereses de terceros, o que de cualquier forma puedan dañar, inutilizar, sobrecargar, deteriorar o impedir la normal utilización de los Contenidos y/o Servicios, los equipos informáticos o los documentos, archivos y toda clase de contenidos almacenados en cualquier equipo informático de BTPUCP, de otros Usuarios o de cualquier Usuario de Internet.

								4.  Sobre la Información Legal.

								La información contenida en Sitio no pretende ser una respuesta legal a un tema particular, por lo que el Usuario no deberá entender que la información presentada en el Sitio absuelve una consulta particular o resuelve una duda legal específica, ni podrá ser utilizado como argumento de defensa en ningún tipo de procedimiento administrativo o proceso judicial.

								5.  No Licencia de Signos Distintivos

								Todas las marcas, nombres comerciales o signos distintivos, sea cual fuere la clase que distinguen, que se aprecian o mencionan en el Sitio le pertenecen a sus respectivos titulares quienes mantienen los derechos de propiedad industrial sobre los referidos signos, sin que pueda entenderse que el uso o acceso al Sitio y/o a los Contenidos y/o Servicios atribuya al Usuario derecho alguno sobre las citadas marcas, nombres comerciales y/o signos distintivos.

						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Nombre Completo: </span>
							  	{{Form::text('nombretermino','', array('class' => 'form-control control', 'placeholder' => 'Nombre', 'id' => 'nombretermino', 'maxlength' => '200'))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">DNI: </span>
							  	{{Form::text('dnitermino','', array('class' => 'solonumero form-control control', 'placeholder' => 'DNI', 'id' => 'dnitermino', 'maxlength' => '8'))}}
						</div>

						<div class="col-xs-6" style="text-align:center;">
							<input type="submit" id="btnaceptocondicion" name='1' class="btnaceptocondicion btn btn-primary" value="Acepto">
						</div>

						<div class="col-xs-6" style="text-align:center;">
							<input type="submit" id="btnaceptocondicion" name='0'  class="btnaceptocondicion btn btn-danger" value="No Acepto">
						</div>

					</div>
				</div>
			</div>


	  </div>







	  	<div class="perosonalregistro paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" >
	  		<!--style='display:none;'-->
			{{Form::open(array('method' => 'POST', 'url' => '/insertar-solicitud-personal/', 'files' => true))}}

			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Datos Personales</h3>
					</div>
					<div class="panel-body">

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Nombre Completo: </span>
							  	{{Form::text('nombre','', array('class' => 'form-control control', 'placeholder' => 'Nombre', 'id' => 'nombre', 'maxlength' => '200', 'disabled'=>'disabled'))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">DNI: </span>
							  	{{Form::text('dni','', array('class' => 'form-control control', 'placeholder' => 'DNI', 'id' => 'dni', 'maxlength' => '8' ,'disabled'=>'disabled'))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Fecha Nacimiento: </span>
							{{  Form::date('fechanacimiento','',array('class' => 'form-control control', 'id' => 'fechanacimiento')) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Dirección: </span>
							{{Form::text('direccion','', array('class' => 'form-control control', 'placeholder' => 'Dirección', 'id' => 'direccion', 'maxlength' => '200' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Provincia: </span>
							{{ Form::select('provincia', $comboprovincia, array(),['class' => 'selectpicker form-control control' , 'id' => 'provincia' , 'data-live-search' => 'true']) }}
						</div>

						<div class="ajaxdistrito input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Distrito: </span>
							{{ Form::select('distrito', array(), array(),['class' => 'selectpicker form-control control' , 'id' => 'distrito' , 'data-live-search' => 'true']) }}
						</div>


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Teléfono: </span>
							{{Form::text('telefono','', array('class' => 'solonumero form-control control', 'placeholder' => 'Telefono', 'id' => 'telefono', 'maxlength' => '15' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Celular: </span>
							{{Form::text('celular','', array('class' => 'solonumero form-control control', 'placeholder' => 'Celular', 'id' => 'celular', 'maxlength' => '15' ))}}						    
						</div>

					</div>
				</div>


				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">GRADO DE INSTRUCCION ALCANZADO</h3>
					</div>
					<div class="panel-body">






					</div>
				</div>

	
			</div>

			<input type="hidden" name="idsolicitudpersonal" id="idsolicitudpersonal" >
			<input type="hidden" name="idsolicitud" id="idsolicitud" value='{{$idSolicitud}}'>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btninsertarsolicitudpersonal" class="btn btn-primary" value="Guardar">
			</div>
			{{Form::close()}}

	  </div>



	</div>	
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
@section('script')

	{{ HTML::script('js/select/bootstrap-select.min.js'); }}



    <script>

	$('.selectpicker').selectpicker();

    $("#provincia").change(function(e) {


		    var codprovincia = $('#provincia').val();

			$.ajax(
            {
                url: "/APPUYU/ajax-select-distrito",
                type: "POST",
                data: { codprovincia : codprovincia },

            }).done(function(pagina) 
            {
            	$(".ajaxdistrito").html(pagina);

            }); 

    });

	$(".btnaceptocondicion").click(function(e) {

		var aleatorio = Math.floor((Math.random() * 500) + 1);
	 	var alertaMensajeGlobal='';
	 	idsolicitud = $('#idsolicitud').val();
	 	termino     = $(this).attr("name");
	 	nombre      = $('#nombretermino').val();
	 	dni      	= $('#dnitermino').val()

		
		if(!valVacio($('#nombretermino').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Nombre es obligatorio<br>';}
		if(!valVacio($('#dnitermino').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo DNI  es obligatorio<br>';}
        if(!CantidadNumeros($('#dnitermino').val(),8)){ alertaMensajeGlobal+='<strong>Error!</strong>El campo DNI debe tener 8 digitos<br>';}
      


		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);
			return false;

		}else{	

			$("#modalcargando").modal();

			$.ajax(
            {
                url: "/APPUYU/agregar-personal-termino-solicitud-ajax",
                type: "POST",
                data: { idsolicitud : idsolicitud, termino : termino, nombre : nombre, dni : dni },

            }).done(function(pagina) 
            {

            	$('#modalcargando').modal('hide');

				
                $('.terminopersonal').css("display", "none");
                $('.perosonalregistro').attr("style", "display: block !important");


                $('#nombre').val(nombre);
                $('#dni').val(dni);
	    		msj="<div class='rd"+aleatorio+" alert alert-success  alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Registrado Correctamente </strong></div>";
	    		$(".msj").append(msj);
            	setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);


            }); 

		}


	});









	$( ".selectmotivosolicitud" ).change(function() {
	  
	  
	    if (this.value!=0) {

	    	if (this.value=='LIM01CEN000000000001'){

			    $('.paneltop .reemplazopersonal').css("display", "block");
			    $('.paneltop .autorizacion').css("display", "none");
			    $("#autorizacion").val("");

			}else{

			    $('.paneltop .reemplazopersonal').css("display", "none");
			    $('.paneltop .autorizacion').css("display", "block");

			    $("#usuarior option[value='0']").prop("selected", true);
			    $("#motivoreemplazo option[value='0']").prop("selected", true);

			}
		} else{
			$('.paneltop .reemplazopersonal').css("display", "none");
			$('.paneltop .autorizacion').css("display", "none");
		}


	});




	$("#btninsertarsolicitudpersonal").click(function(e) {

	 	var alertaMensajeGlobal='';
		
	 	if(!valSelect($('#motivosolicitud').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Motivo seleccionado es invalido<br>';}

		if(valSelect($('#motivosolicitud').val(),0)){ 

			if($('#motivosolicitud').val()=='LIM01CEN000000000001'){

				if(!valSelect($('#usuarior').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Personal de Reemplazo seleccionado es invalido<br>';}

				if(!valSelect($('#motivoreemplazo').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Motivo Reemplazo seleccionado es invalido<br>';}

			}else{
					if(!valVacio($('#autorizacion').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Autorización es obligatorio<br>';}

			}	

		}	


	 	if(!valSelect($('#tipousuario').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Cargo o puesto a ocupar seleccionado es invalido<br>';}
	 	if(!valSelect($('#local').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Area seleccionado es invalido<br>';}
	 	if(!numeroentre($('#numerovacantes').val(),1,10)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Número Vacantes debe ser de 1 a 10<br>';}

	 	if(!numeromayor($('#edadinicio').val(),18)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Edad debe ser mayor a 18<br>';}
	 	if(!numeromayor($('#edadfin').val(),18)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Edad debe ser mayor a 18<br>';}

		if(!valVacio($('#perfilpuesto').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Perfil del Puesto es obligatorio<br>';}
		if(!valVacio($('#funcionpuesto').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Funciones del Puesto es obligatorio<br>';}
		if(!valVacio($('#horatrabajo').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Hora de Trabajo es obligatorio<br>';}

	 	if(!numeromayor($('#sueldo').val(),1)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Sueldo debe ser mayor a 0<br>';}



		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);
			return false;
		}else{	
			$("#modalcargando").modal();
			return true; 
		}


	});

    </script>

@stop