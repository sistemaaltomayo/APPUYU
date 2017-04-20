var FancyWebSocket = function(url)
{
	var callbacks = {};
	var ws_url = url;
	var conn;
	
	this.bind = function(event_name, callback)
	{
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;
	};
	
	this.send = function(event_name, event_data)
	{
		this.conn.send( event_data );
		return this;
	};
	
	this.connect = function() 
	{
		
		if ( typeof(MozWebSocket) == 'function' )
		this.conn = new MozWebSocket(url);
		else
		this.conn = new WebSocket(url);
		
		this.conn.onmessage = function(evt)
		{
			dispatch('message', evt.data);
		};
		
		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};
	
	this.disconnect = function()
	{
		this.conn.close();
	};
	
	var dispatch = function(event_name, message)
	{


		if(message == null || message == "")//aqui es donde se realiza toda la accion
			{
			}
			else
			{
				var JSONdata    = JSON.parse(message); //parseo la informacion
				
				switch(JSONdata[0].actualizacion)//que tipo de actualizacion vamos a hacer(un nuevo mensaje, solicitud de amistad nueva, etc )
				{
					case '1':
					actualiza_mensaje(message);
					break;
					case '2':
					actualiza_solicitud(message);
					break;
					case '3':
					elimina_cocina(message);
					break;
					case '4':
					llamar_mesero(message);
					break;
					case '5':
					estado_atendido(message);
					break;
					
				}
				//aqui se ejecuta toda la accion
			}
	}
};

var Server;
function send( text ) 
{
    Server.send( 'message', text );
}



$(document).ready(function() 
{

	Server = new FancyWebSocket('ws://'+$('#ipsocket').html().trim()+':12345');
    Server.bind('open', function()
	{
    });
    Server.bind('close', function( data ) 
	{
    });
    Server.bind('message', function( payload ) 
	{
    });
    Server.connect();
});



function actualiza_mensaje(message)
{
	var JSONdata    = JSON.parse(message);

	var tipo = JSONdata[0].tipo;
	var listaProductoC = JSONdata[0].listaProductoC;
	var mesa = JSONdata[0].mesa;
	var nombrecli = JSONdata[0].nombrecli;
	var idUsuario = JSONdata[0].idUsuario;
	var cad="";var atender="";var color="";var codigounico="";var btndetetalle ="";var btnatender="";
	

	//console.log(JSONdata[0].xml);
	if(JSONdata[0].listaPedido==true){
		for (i = 0; i < listaProductoC.length; i++) {
			
			atender=listaProductoC[i].CodigoProducto+"**"+parseInt(listaProductoC[i].Cantidad)+"**"+mesa+"**"+listaProductoC[i].FechaCrea.replace(" ","/")+'**'+listaProductoC[i].Id;
			codigounico=listaProductoC[i].Id;
			if(listaProductoC[i].detped!="" || listaProductoC[i].EstadoNota>0){color="color:red;";}else{color="color:#2e6da4;";}
			btndetetalle = "<ul class='nav navbar-nav navbar-left'><li class='dropdown'><button type='button' class='btn-detalle btn btn-default btn-sm' onclick=notapedido('"+listaProductoC[i].IdDetallePedido+"',this) data-toggle='dropdown' class='dropdown-toggle'><span class='glyphicon glyphicon-comment' style="+color+" aria-hidden=true></span></button><ul class='dropdown-menu msjdet'><li><div class='yamm-content'></div></li></ul></li></ul>";
			btnatender = "<button type='submit' id='"+atender+"' class='btn btn-default btn-sm' onclick=atender('"+atender+"');><span class='glyphicon glyphicon-share-alt asignar' aria-hidden=true></span></button>";

		    cad=cad+"<tr id="+codigounico+"><td style='display:none;'>"+listaProductoC[i].CodigoProducto+"</td><td style='display:none;'>"+listaProductoC[i].FechaCrea.replace(" ","/")+"</td><td width=50%>"+listaProductoC[i].Descripcion+"</td><td width=14% style='text-align:center'><span class='badge cantidadcocina'>"+parseInt(listaProductoC[i].Cantidad)+"</span></td><td width=14% style='text-align:center'><span class='label label-default mesacocina'>"+nombrecli+"</span></td><td width=22% style='text-align:center'>"+btndetetalle+"&nbsp;&nbsp;"+btnatender+"</td></tr>";

		}

		if(mesa.indexOf('TG') != -1){
			$("#mesarapida").append(cad);
		}else{
			$("#tablacocina").append(cad);
		}
        
        
        $('.player')[0].play();
	}

}
function actualiza_solicitud(message)
{

	var JSONdata    = JSON.parse(message);
		var codigo = JSONdata[0].codigo;
		var descripcion = JSONdata[0].descripcion;
		var cantidad = JSONdata[0].cantidad;
		var mesa = JSONdata[0].mesa;
		var cad="";
		var idDetPed = JSONdata[0].IdDetPed;

		console.log(JSONdata[0].fechaP);
		var padre = $("#js-tabla"+mesa).children('tbody').children("#tb"+mesa+"fila"+idDetPed);

		cad=cad+"<tr id="+idDetPed+"><td width=55%>"+descripcion+"</td><td width=15% style='text-align:center'><span class='badge cantidadcocina'>"+cantidad+"</span></td><td width=15% style='text-align:center'><span class='label label-default mesacocina'>"+mesa+"</span></td><td width='15%'' style='text-align:center'><button type='submit' class='btn btn-default btn-sm' onclick=servido('"+idDetPed+"','"+mesa+"');><span class='glyphicon glyphicon-cutlery asignar' aria-hidden='true'></span></button></td></tr>";
		

		if(mesa.indexOf('TG') != -1){
			$("#tablaclienter").append(cad);
		}else{
			$("#tablacliente").append(cad);
		}

	 	$("#"+idDetPed).remove();

	 	// Eliminar el eliminar
	 	padre.children(".botones").children(".eliminarpedido").remove();

	 	//Cambiar mensaje a preparando
	 	
	 	padre.children(".mensaje").children("span").css("background-color", "#f0ad4e");
	 	padre.children(".mensaje").children("span").html("Preparando");
	 	$('.player2')[0].play();

	 	 	//mensaje de atendido
	 	var mensaje="<div class='alert alert-info alert"+mesa+"'><strong>¡Mesa "+mesa+"! "+descripcion+"</strong></div>"
		$(".alert"+mesa).remove();
		$("#atendidomsj").append(mensaje);
		setTimeout(function(){ $(".alert"+mesa).fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 10000);

}

function elimina_cocina(message)
{
	var JSONdata    = JSON.parse(message);
	var codigo = JSONdata[0].codigo;
	$("#"+codigo).remove();
}

function llamar_mesero(message)
{
	var JSONdata    = JSON.parse(message);
	var mesa = JSONdata[0].numero;
	var mensaje="<div class='alert alert-info alert"+mesa+"'><strong>¡Mesa "+mesa+"!</strong></div>"
	$(".alert"+mesa).remove();
	$("#mensajellama").append(mensaje);
	setTimeout(function(){ $(".alert"+mesa).fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 10000);
	$('.player')[0].play();
}

function estado_atendido(message)
{
	var JSONdata    = JSON.parse(message);
	var mesa = JSONdata[0].mesa;
	var idDetPed = JSONdata[0].iddetped;
	//console.log("entro");
	var padre = $("#js-tabla"+mesa).children('tbody').children("#tb"+mesa+"fila"+idDetPed);
 
 	//Cambiar mensaje a preparando	
 	padre.children(".mensaje").children("span").css("background-color", "#d9534f");
 	padre.children(".mensaje").children("span").html("Atendido");

	if(mesa.indexOf('TG') != -1){
		$('#tablaclienter #'+idDetPed).remove();
	}else{
		$('#tablacliente #'+idDetPed).remove();
	}
 	

}
