
$( document ).ready(function() {


/**********************************************  AUTHENTIFICATION *************************************************/

    $('#btnguardarpersonal').on('click', function(event){

		var alertaMensajeGlobal='';
		var tab=0;
		
		if(!valVacio($('#nombre').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Nombre es obligatorio<br>';}
		if(!valVacio($('#apellido').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Apellido es obligatorio<br>';}
		if(!valVacio($('#login').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Usuario es obligatorio<br>';}
		if(!valVacio($('#clave').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Contraseña es obligatorio<br>';}
		if(!valSelect($('#rol').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Rol seleccionado es invalido<br>';}
        if(!valVacio($('#dni').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo DNI es obligatorio<br>';}
        if(!CantidadNumeros($('#dni').val(),8)){ alertaMensajeGlobal+='<strong>Error!</strong>El campo DNI debe tener 8 digitos<br>';}
      
		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);

			return false;
		}else{	
			return true; 
		}


    });

    $('#btnguardarrol').on('click', function(event){

		var alertaMensajeGlobal='';
		var tab=0;
		
		if(!valVacio($('#nombre').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Nombre es obligatorio<br>';}

		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);

			return false;
		}else{	
			return true; 
		}


    });




    $('#btnmodificarpersonal').on('click', function(event){

		var alertaMensajeGlobal='';
		var tab=0;
		
		if(!valVacio($('#nombre').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Nombre es obligatorio<br>';}
		if(!valVacio($('#apellido').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Apellido es obligatorio<br>';}
		if(!valVacio($('#login').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Usuario es obligatorio<br>';}
		if(!valSelect($('#rol').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Rol seleccionado es invalido<br>';}
        if(!valVacio($('#dni').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo DNI es obligatorio<br>';}
        if(!CantidadNumeros($('#dni').val(),8)){ alertaMensajeGlobal+='<strong>Error!</strong>El campo DNI debe tener 8 digitos<br>';}
      

		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);

			return false;
		}else{	
			return true; 
		}


    });

    $('#btnmodificarrol').on('click', function(event){

		var alertaMensajeGlobal='';
		var tab=0;
		
		if(!valVacio($('#nombre').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Nombre es obligatorio<br>';}

		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);

			return false;
		}else{	
			return true; 
		}


    });


    $('.selectrolper').on('click', function(event){


        $('.tab-content .tab-pane').each(function(){
            $(this).html("");
        });

    	var idRol = $(this).attr("id");

    	if(idRol!='LIM01CEN000000000001'){

    	    $.ajax(
	        {
	            url: "/APPCOFFEE/listar-ajax-permisos",
	            type: "POST",
	            data: "idRol="+idRol,
	        }).done(function(pagina) 
	        {
                //console.log("hola");
	            $("#tab"+idRol).html(pagina);
	        });

    	}

    });

    $('.selectint').change(function(){

    	var imput2 = $(this).siblings('.campo2');
    	console.log(imput2.val());
		if($(this).val()==6){//6 = entre
			$(imput2).attr("style", "display: block !important");
		}else{//MENSUAL

		    $(imput2).attr("style", "display: none !important");

		}


    });


/*****************************************************************************************************************/

/**********************************************  INVENTARIO  CAFETERIA ******************************************************/


     $(".btnagregarstock").click(function(e) {

        var idopcion = $('#idopcion').html();

        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);

        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');

        var suma = parseFloat(stock) + parseFloat($(puntero).parent().siblings('#totalstock').html());

        $(this).parent().parent().siblings('.alerterror').html("");

        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }  
        else{
            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-primary');
                    $(this).children('.fa-floppy-o').css("display", "none");
                    $(this).children('.loader').css("display", "block");
                    $(this).parent().parent().siblings('.alertstock').css("display", "none");


                    $.ajax(
                    {
                        url: "/APPCOFFEE/insertar-stock-inventario",
                        type: "POST",
                        data: "idstock="+$(this).attr('id')+"&stock="+suma,
                    }).done(function(pagina) 
                    {

                        if(pagina==1){

                            $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                            $("#S"+array[1]).html(suma.toFixed(3));
                            $(puntero).parent().siblings('#plusstock').val('');
                            $(puntero).addClass('btn-success');
                            $(puntero).removeClass('btn-primary');
                            $(puntero).children('.fa-check').css("display", "inline-block");
                            $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                            $(puntero).children('.loader').css("display", "none");
                            $('#insertarinventarionormal #plusstock').focus();
                            $('#insertarinventariomanu #plusstock').focus();
                            //alert("#S"+array[1]);
                            $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                        }else{
                            window.location.href = '/APPCOFFEE/getion-inventario-cafeteria/'+idopcion;
                        }
                        
                    }); 
            }  
        }


     });


     $(".btndisminuirstock").click(function(e) {


        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);
        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');

        var suma =  parseFloat($(puntero).parent().siblings('#totalstock').html()) - parseFloat(stock);
        
        $(this).parent().parent().siblings('.alerterror').html("");


        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }else{

            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
            
                $(this).removeClass('btn-success');
                $(this).addClass('btn-primary');
                $(this).children('.fa-floppy-o').css("display", "none");
                $(this).children('.loader').css("display", "block");
                $(this).parent().parent().siblings('.alertstock').css("display", "none");


                $.ajax(
                {
                    url: "/APPCOFFEE/insertar-stock-inventario",
                    type: "POST",
                    data: "idstock="+$(this).attr('id')+"&stock="+suma,
                }).done(function(pagina) 
                {

                    if(pagina==1){
                        $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                        $("#S"+array[1]).html(suma.toFixed(3));
                        $(puntero).parent().siblings('#plusstock').val('');
                        $(puntero).addClass('btn-success');
                        $(puntero).removeClass('btn-primary');
                        $(puntero).children('.fa-check').css("display", "inline-block");
                        $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                        $(puntero).children('.loader').css("display", "none");
                        $('#insertarinventarionormal #plusstock').focus();
                        $('#insertarinventariomanu #plusstock').focus();
                        $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                    }else{
                        window.location.href = '/APPCOFFEE/getion-inventario-cafeteria/'+idopcion;
                    }
                    
                });  
            }
        }
     });


     $(".btneditstock").click(function(e) {

        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);
        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');

        var suma = parseFloat(stock);
        $(this).parent().parent().siblings('.alerterror').html("");

        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }else{

            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
            
                $(this).removeClass('btn-success');
                $(this).addClass('btn-primary');
                $(this).children('.fa-floppy-o').css("display", "none");
                $(this).children('.loader').css("display", "block");
                $(this).parent().parent().siblings('.alertstock').css("display", "none");


                $.ajax(
                {
                    url: "/APPCOFFEE/insertar-stock-inventario",
                    type: "POST",
                    data: "idstock="+$(this).attr('id')+"&stock="+suma,
                }).done(function(pagina) 
                {

                    if(pagina==1){
                        $("#S"+array[1]).html(suma.toFixed(3));
                        $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                        $(puntero).parent().siblings('#plusstock').val('');
                        $(puntero).addClass('btn-success');
                        $(puntero).removeClass('btn-primary');
                        $(puntero).children('.fa-check').css("display", "inline-block");
                        $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                        $(puntero).children('.loader').css("display", "none");
                        $('#insertarinventarionormal #plusstock').focus();
                        $('#insertarinventariomanu #plusstock').focus();

                        $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                    }else{
                        window.location.href = '/APPCOFFEE/getion-inventario-cafeteria/'+idopcion;
                    }
                    
                }); 
            } 
        }


     });


     $("#insertarusuarios").click(function(e) {

        
        var idopcion = $('#idopcion').html();
        var usuarios ="";
        var idtomaweb = $('#idtomaweb').val();
        var select = "0";
        var valselect = "";

        $("#usuariosagregados li").each(function(index){

            valselect= $("#C-"+$(this).attr('id')).val();
            usuarios = usuarios + $(this).attr('id')+'-'+valselect+ '*';

            if(valselect == 0){
                select="1";
                return false;
            }

        });

        if(select == 1){

            alert("Seleccione Ubicación.");

        }else{

            $("#modalcargando").modal();
            $.ajax(
            {
                url: "/APPCOFFEE/insertar-usuario-toma-inventario",
                type: "POST",
                data: "usuarios="+usuarios+"&idtomaweb="+idtomaweb,
            }).done(function(pagina) 
            {
                //console.log(pagina);
                window.location.href = '/APPCOFFEE/usuarios-exitoso/'+idopcion;

            }); 

        }


          
     });

     
    $(".primercierre").click( function(e) {
        e.preventDefault();
        var url = this.href;
          confirmar=confirm("¿DESEA CERRAR LA PRIMERA TOMA?"); 
        if (confirmar){
            location.href = url;
        } 
    });

    $(".segundocierre").click( function(e) {
        e.preventDefault();
        var url = this.href;
          confirmar=confirm("¿DESEA CERRAR LA SEGUNDA TOMA?"); 
        if (confirmar){
            location.href = url;
        } 
    });





/*****************************************************************************************************************/

/**********************************************  INVENTARIO  MARKET ******************************************************/




     $(".btnagregarstockA").click(function(e) {


        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);

        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');

        var suma = parseFloat(stock) + parseFloat($(puntero).parent().siblings('#totalstock').html());

        $(this).parent().parent().siblings('.alerterror').html("");

        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }  
        else{
            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-primary');
                    $(this).children('.fa-floppy-o').css("display", "none");
                    $(this).children('.loader').css("display", "block");
                    $(this).parent().parent().siblings('.alertstock').css("display", "none");

                    
                    $.ajax(
                    {
                        url: "/APPCOFFEE/insertar-stock-inventario-artesania",
                        type: "POST",
                        data: "idstock="+$(this).attr('id')+"&stock="+suma,
                    }).done(function(pagina) 
                    { 
                        if(pagina==1){
                            $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                            $("#S"+array[1]).html(suma.toFixed(3));
                            $(puntero).parent().siblings('#plusstock').val('');
                            $(puntero).addClass('btn-success');
                            $(puntero).removeClass('btn-primary');
                            $(puntero).children('.fa-check').css("display", "inline-block");
                            $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                            $(puntero).children('.loader').css("display", "none");
                            $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                            $('#plusstock').focus();
                        }else{
                            window.location.href = '/APPCOFFEE/getion-inventario-market/'+idopcion;
                        }
                        
                    }); 
            }  
        }


     });

     $(".btndisminuirstockA").click(function(e) {

        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);
        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');

        var suma =  parseFloat($(puntero).parent().siblings('#totalstock').html()) - parseFloat(stock);
        
        $(this).parent().parent().siblings('.alerterror').html("");


        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }else{

            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
            
                $(this).removeClass('btn-success');
                $(this).addClass('btn-primary');
                $(this).children('.fa-floppy-o').css("display", "none");
                $(this).children('.loader').css("display", "block");
                $(this).parent().parent().siblings('.alertstock').css("display", "none");


                $.ajax(
                {
                    url: "/APPCOFFEE/insertar-stock-inventario-artesania",
                    type: "POST",
                    data: "idstock="+$(this).attr('id')+"&stock="+suma,
                }).done(function(pagina) 
                {

                    if(pagina==1){
                        $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                        $("#S"+array[1]).html(suma.toFixed(3));
                        $(puntero).parent().siblings('#plusstock').val('');
                        $(puntero).addClass('btn-success');
                        $(puntero).removeClass('btn-primary');
                        $(puntero).children('.fa-check').css("display", "inline-block");
                        $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                        $(puntero).children('.loader').css("display", "none");
                        $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                        $('#plusstock').focus();
                    }else{
                         window.location.href = '/APPCOFFEE/getion-inventario-market/'+idopcion;
                    }
                    
                });  
            }
        }


     });



     $(".btneditstockA").click(function(e) {

        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);
        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');


        var suma = parseFloat(stock);


        $(this).parent().parent().siblings('.alerterror').html("");

        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }else{

            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
            
                $(this).removeClass('btn-success');
                $(this).addClass('btn-primary');
                $(this).children('.fa-floppy-o').css("display", "none");
                $(this).children('.loader').css("display", "block");
                $(this).parent().parent().siblings('.alertstock').css("display", "none");


                $.ajax(
                {
                    url: "/APPCOFFEE/insertar-stock-inventario-artesania",
                    type: "POST",
                    data: "idstock="+$(this).attr('id')+"&stock="+suma,
                }).done(function(pagina) 
                {

                    if(pagina==1){
                        $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                        $("#S"+array[1]).html(suma.toFixed(3));
                        $(puntero).parent().siblings('#plusstock').val('');
                        $(puntero).addClass('btn-success');
                        $(puntero).removeClass('btn-primary');
                        $(puntero).children('.fa-check').css("display", "inline-block");
                        $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                        $(puntero).children('.loader').css("display", "none");
                        $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                        $('#plusstock').focus();

                    }else{
                         window.location.href = '/APPCOFFEE/getion-inventario-market/'+idopcion;
                    }
                    
                }); 
            } 
        }


     });

     $("#insertarusuariosA").click(function(e) {
        
        var idopcion = $('#idopcion').html();
        var usuarios ="";
        var idtomaweb = $('#idtomaweb').val();

        $("#usuariosagregados li").each(function(index){
            usuarios = usuarios + $(this).attr('id')+ '*';
        });

        $("#modalcargando").modal();
        $.ajax(
        {
            url: "/APPCOFFEE/insertar-usuario-toma-inventario-artesania",
            type: "POST",
            data: "usuarios="+usuarios+"&idtomaweb="+idtomaweb,
        }).done(function(pagina) 
        {
            //console.log(pagina);
            window.location.href = '/APPCOFFEE/usuarios-exitoso-artesania/'+idopcion;
            //window.location.href = '/inventario/usuarios-exitoso-artesania';

        }); 
          
     });





/*****************************************************************************************************************/

/**********************************************  INVENTARIO  EMBARQUE ******************************************************/



     $(".btnagregarstockE").click(function(e) {

        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);

        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');

        var suma = parseFloat(stock) + parseFloat($(puntero).parent().siblings('#totalstock').html());

        $(this).parent().parent().siblings('.alerterror').html("");

        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }  
        else{
            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-primary');
                    $(this).children('.fa-floppy-o').css("display", "none");
                    $(this).children('.loader').css("display", "block");
                    $(this).parent().parent().siblings('.alertstock').css("display", "none");

                    
                    $.ajax(
                    {
                        url: "/APPCOFFEE/insertar-stock-inventario-embarque",
                        type: "POST",
                        data: "idstock="+$(this).attr('id')+"&stock="+suma,
                    }).done(function(pagina) 
                    { 
                        if(pagina==1){
                            $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                            $("#S"+array[1]).html(suma.toFixed(3));
                            $(puntero).parent().siblings('#plusstock').val('');
                            $(puntero).addClass('btn-success');
                            $(puntero).removeClass('btn-primary');
                            $(puntero).children('.fa-check').css("display", "inline-block");
                            $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                            $(puntero).children('.loader').css("display", "none");
                            $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                            $('#plusstock').focus();
                        }else{
                            window.location.href = '/APPCOFFEE/getion-inventario-embarque/'+idopcion;
                           // window.location.href = '/inventario/lista-toma-inventariocerro-embarque';
                        }
                        
                    }); 
            }  
        }


     });


     $(".btndisminuirstockE").click(function(e) {

        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);
        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');

        var suma =  parseFloat($(puntero).parent().siblings('#totalstock').html()) - parseFloat(stock);
        
        $(this).parent().parent().siblings('.alerterror').html("");


        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }else{

            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
            
                $(this).removeClass('btn-success');
                $(this).addClass('btn-primary');
                $(this).children('.fa-floppy-o').css("display", "none");
                $(this).children('.loader').css("display", "block");
                $(this).parent().parent().siblings('.alertstock').css("display", "none");


                $.ajax(
                {
                    url: "/APPCOFFEE/insertar-stock-inventario-embarque",
                    type: "POST",
                    data: "idstock="+$(this).attr('id')+"&stock="+suma,
                }).done(function(pagina) 
                {

                    if(pagina==1){
                        $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                        $("#S"+array[1]).html(suma.toFixed(3));
                        $(puntero).parent().siblings('#plusstock').val('');
                        $(puntero).addClass('btn-success');
                        $(puntero).removeClass('btn-primary');
                        $(puntero).children('.fa-check').css("display", "inline-block");
                        $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                        $(puntero).children('.loader').css("display", "none");
                        $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                        $('#plusstock').focus();
                    }else{
                        window.location.href = '/APPCOFFEE/getion-inventario-embarque/'+idopcion;
                        //window.location.href = '/inventario/lista-toma-inventariocerro-embarque';
                    }
                    
                });  
            }
        }


     });


     $(".btneditstockE").click(function(e) {

        var idopcion = $('#idopcion').html();
        var stock = $(this).parent().siblings('.stockingresado').val();
        var puntero = $(this);
        var idtabla = $(this).attr('id');
        var array = idtabla.split('*');


        var suma = parseFloat(stock);


        $(this).parent().parent().siblings('.alerterror').html("");

        if($(this).parent().siblings('.stockingresado').val()==""){

            $(this).parent().parent().siblings('.alerterror').html('<div class="alertstock alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Formato Errado</div>');

        }else{

            if(suma<0){

                $(this).parent().parent().siblings('.alerterror').html('<div class="alertnegativo alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> La Operación es Negativo</div>');

            }else{
            
                $(this).removeClass('btn-success');
                $(this).addClass('btn-primary');
                $(this).children('.fa-floppy-o').css("display", "none");
                $(this).children('.loader').css("display", "block");
                $(this).parent().parent().siblings('.alertstock').css("display", "none");


                $.ajax(
                {
                    url: "/APPCOFFEE/insertar-stock-inventario-embarque",
                    type: "POST",
                    data: "idstock="+$(this).attr('id')+"&stock="+suma,
                }).done(function(pagina) 
                {

                    if(pagina==1){
                        $(puntero).parent().siblings('#totalstock').html(parseFloat(suma).toFixed(3));
                        $("#S"+array[1]).html(suma.toFixed(3));
                        $(puntero).parent().siblings('#plusstock').val('');
                        $(puntero).addClass('btn-success');
                        $(puntero).removeClass('btn-primary');
                        $(puntero).children('.fa-check').css("display", "inline-block");
                        $(puntero).children('.fa-floppy-o').css("display", "inline-block");
                        $(puntero).children('.loader').css("display", "none");
                        $("#S"+array[1]).siblings('.descripcion').find('.digito').html("<i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>");

                        $('#plusstock').focus();

                    }else{
                        window.location.href = '/APPCOFFEE/getion-inventario-embarque/'+idopcion;
                        //window.location.href = '/inventario/lista-toma-inventariocerro-embarque';
                    }
                    
                }); 
            } 
        }


     });


     $("#insertarusuariosE").click(function(e) {
        
        var idopcion = $('#idopcion').html();        
        var usuarios ="";
        var idtomaweb = $('#idtomaweb').val();

        $("#usuariosagregados li").each(function(index){
            usuarios = usuarios + $(this).attr('id')+ '*';
        });

        $("#modalcargando").modal();
        $.ajax(
        {
            url: "/APPCOFFEE/insertar-usuario-toma-inventario-embarque",
            type: "POST",
            data: "usuarios="+usuarios+"&idtomaweb="+idtomaweb,
        }).done(function(pagina) 
        {
            //console.log(pagina);
            window.location.href = '/APPCOFFEE/usuarios-exitoso-embarque/'+idopcion;
            //window.location.href = '/inventario/usuarios-exitoso-embarque';

        }); 
          
     });




    $( "#sunidadorigen" ).change(function() {
      
        $.ajax(
        {
            url: "/APPCOFFEE/unidaddestinoajax",
            type: "POST",
            data: "idunidadorigen="+$(this).val(),
        }).done(function(pagina) 
        {

            $("#sunidaddestino").html(pagina);
        }); 

    });

     $("#convertirunidad").click(function(e) {

        var unidadorigen =  $("#unidadorigen").val();
        var sorigen =  $("#sunidadorigen").val();
        var sdestino =  $("#sunidaddestino").val();
        $(".error-unidad").css("display", "none");
        $(".error-unidad").html("");

        if(sorigen==0){

            $(".error-unidad").css("display", "block");
            $(".error-unidad").html("<strong>Error!</strong> Seleccione Unidad Origen");

        }else{

            if(sdestino==0){

            $(".error-unidad").css("display", "block");
            $(".error-unidad").html("<strong>Error!</strong> Seleccione Unidad Destino");

            }else{

                if(unidadorigen==""){

                    $(".error-unidad").css("display", "block");
                    $(".error-unidad").html("<strong>Error!</strong> Ingrese Origen");

                }else{

                    $.ajax(
                    {
                        url: "/APPCOFFEE/convertir-unidad",
                        type: "POST",
                        data: "idorigen="+sorigen+"&iddestino="+sdestino+"&unidadorigen="+unidadorigen,
                    }).done(function(pagina) 
                    {
                        
                        if(pagina=='EC'){

                            $(".error-unidad").css("display", "block");
                            $(".error-unidad").html("<strong>Error!</strong> Combinación de unidades no existe Intente otra combinación.");

                        }else{

                            $("#unidaddestino").html(pagina)
                        }
                        
                    }); 

                }


            }

        }

     });



    $('body').on('click', '.list-group .list-group-item', function () {
        $(this).toggleClass('active');
    });


    $('.list-arrows button').click(function () {
        var $button = $(this), actives = '';
        if ($button.hasClass('move-left')) {
            actives = $('.list-right ul li.active');
            actives.clone().appendTo('.list-left ul');
            actives.remove();
        } else if ($button.hasClass('move-right')) {
            actives = $('.list-left ul li.active');
            actives.clone().appendTo('.list-right ul');
            actives.remove();
        }
    });

    $('.dual-list .selector').click(function () {
        var $checkBox = $(this);
        if (!$checkBox.hasClass('selected')) {
            $checkBox.addClass('selected').closest('.well').find('ul li:not(.active)').addClass('active');
            $checkBox.children('i').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
        } else {
            $checkBox.removeClass('selected').closest('.well').find('ul li.active').removeClass('active');
            $checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
        }
    });


    $('[name="SearchDualList"]').keyup(function (e) {
        var code = e.keyCode || e.which;
        if (code == '9') return;
        if (code == '27') $(this).val(null);
        var $rows = $(this).closest('.dual-list').find('.list-group li');
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        $rows.show().filter(function () {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });


/*****************************************************************************************************************/

/**********************************************  GENERALES  ******************************************************/


	$('.decimal').numeric(".");


	$(".solonumero").keydown(function(event) {

	   if(event.shiftKey)
	   {
	        event.preventDefault();
	   }

	   if (event.keyCode == 9 || event.keyCode == 46 || event.keyCode == 8)    {
	   }
	   else {
	        if (event.keyCode < 95) {
	          if (event.keyCode < 48 || event.keyCode > 57) {
	                event.preventDefault();
	          }
	        } 
	        else {
	              if (event.keyCode < 96 || event.keyCode > 105) {
	                  event.preventDefault();
	              }
	        }
	      }
	});


/*****************************************************************************************************************/


});










/**********************************************  AUTHENTIFICATION *************************************************/


function mostrar(valor){

	$('.dia-semana').css("display", "none");
	$('.dia').css("display", "none");
	$('.hora').css("display", "none");
	

    if (valor==1){
		$('.hora').css("display", "block");
	}else{
	    if(valor==2){
	        $('.dia-semana').css("display", "block");
	        $('.hora').css("display", "block");
		}else{
		    $('.dia').css("display", "block");  
		    $('.hora').css("display", "block");
		}
	}
}



function checkpermiso(puntero,idopcion,idrol,nombreacc){

	var checkcadena = "";
    var msj= "";

	var aleatorio = Math.floor((Math.random() * 500) + 1);
	if($(puntero).is(':checked')){ 
		checkcadena = validarrellono(nombreacc,idopcion,true,idrol);
		$.ajax(
        {
            url: "/APPCOFFEE/activar-ajax-permisos",
            type: "POST",
            data: "idrol="+idrol+"&idopcion="+idopcion+"&checkcadena="+checkcadena+"&accion=1",

        }).done(function(pagina) 
        {

            if(pagina==1){
            	msj="<div class='rd"+aleatorio+" alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Actualización exitosa </strong></div>";
        		$(".permisomsj").append(msj);
        	}else{

        		msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong> Actualización rechazada (SP)</strong></div>";
        		$(".permisomsj").append(msj);
        	}

        }); 

    } else {  

    	checkcadena = validarrellono(nombreacc,idopcion,false,idrol);

        $.ajax(
        {
            url: "/APPCOFFEE/activar-ajax-permisos",
            type: "POST",
            data: "idrol="+idrol+"&idopcion="+idopcion+"&checkcadena="+checkcadena+"&accion=0",

        }).done(function(pagina) 
        {

            if(pagina==1){
            	
            	msj="<div class='rd"+aleatorio+" alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Actualización exitosa </strong></div>";
        		$(".permisomsj").append(msj);

        	}else{

        		msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong> Actualización rechazada (SP)</strong></div>";
        		$(".permisomsj").append(msj);

        	}

        });

    } 

    setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);


}


function validarrellono(accion,idopcion,estado,idrol){

	cadenamodificar = '';
	if (accion=='Todas') {
		$(".check"+idopcion+idrol).prop("checked", estado);
		cadenamodificar = 'Ver,Anadir,Modificar,Eliminar,Todas';
	}else{

		if (accion=='Ver') {

			if(estado==false){
				cadenamodificar = 'Ver,Anadir,Modificar,Eliminar,Todas';
				$(".check"+idopcion+idrol).prop("checked", estado);
			}else{
				cadenamodificar = 'Ver';
			}
		}else{

			if(estado==false){
				if($("#Anadir"+idopcion+idrol).is(':checked') || $("#Modificar"+idopcion+idrol).is(':checked')){
					cadenamodificar = 'Todas,'+accion;
				}else{
					$("#Ver"+idopcion+idrol).prop("checked", estado);
					cadenamodificar = 'Ver,'+accion;
				}
				$("#Todas"+idopcion+idrol).prop("checked", estado);
			}else{

				$("#Ver"+idopcion+idrol).prop("checked", estado);
				cadenamodificar = 'Ver,'+accion;

			}






		}
	}

	return cadenamodificar;
}

/*****************************************************************************************************************/