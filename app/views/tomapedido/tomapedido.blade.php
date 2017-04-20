@extends('template')

@section('style')
	{{ HTML::style('css/fileinput.css'); }}
	{{ HTML::style('css/TablaBoostrap.css'); }}
@stop


@section('section')

<div class="container">
	<div class="row">
		<div class="col-xs-3">
		
		</div>
		<div class="col-xs-5 atendido">
			<div id="atendidomsj">
			</div>
		</div>
		<div class="col-xs-4 exitoso">
			<div id="exitoso" class="exitosomsj">
			  	@if($mensaje!=0)
					<div class='alert alert-success exitoso'><strong>Registro Exitoso</strong></div>
			  	@endif
			</div>	
		</div>
	</div>
</div>



<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<div class="permisomsj">

	</div>
	<h4 style="text-align:center;">TOMA PEDIDO </h4>
</div>

<div class="container containertoma" >

	<div class="row margenleft">

		<div class="col-xs-12 cabecerageneral">
			@foreach($listaMesa as $item)
			@if($item->IdEstado == "LIM01CEN000000000002")
				{{--*/ $active = "active" /*--}}
			@else
				{{--*/ $active = "" /*--}}
			@endif
			  <div class="col-al-6 col-fr-4 col-xs-3 col-md-2">
			  	   <ul class="ch-grid">
								<li>
									<div class="ch-item">				
										<div class="ch-info">
											<div class="ch-info-front ch-img-1 numero_mesa {{$active}}" name="{{$item->Numero}}" id="{{$item->Id}}" data-toggle="modal" data-target="#myModal">
												{{--*/ $posicion = strpos($item->Numero, "TG"); /*--}}
												{{--*/ $left = "" /*--}}
												@if($posicion !== FALSE)
													<span class="glyphicon glyphicon-flash" aria-hidden="true"></span>
													{{--*/ $left = "normal" /*--}}
												@endif
												<h2 class="{{$left}}"><strong>{{$item->Numero}}</strong></h2>
												@if($item->IdEstado == "LIM01CEN000000000002")
													<p class="mesalogin">{{$item->login}}</p>
												@endif
											</div>	
										</div>
									</div>
								</li>

			  		</ul>
			  </div>
			@endforeach
		</div>

	</div>

</div>








<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">COFFEE AND ARTS <span class="badge numeromesa"></span></h4>

      </div>

      <div class="modal-body">
        <div class="row">
	        <div class="col-xs-12 col-md-12 productos">
				<!-------->
				<div id="content">
				    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
				        <li class="active"><a href="#listaproducto" data-toggle="tab">Lista de Productos</a></li>
				        <li><a href="#bebidas " data-toggle="tab" onclick="cartajax('LIM01CEN000000000001*','cafes')">Bebidas</a></li>
				        <li><a href="#comidas " data-toggle="tab" onclick="cartajax('LIM01CEN000000000013*','sandwiches')">Comidas</a></li>
				    </ul>
				    <div id="my-tab-content" class="tab-content">
				        <div class="tab-pane active" id="listaproducto">

					        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
								<thead>
									<tr>
										<th>Codigo</th>
										<th>Descripcion</th>
										<th>Precio</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								@foreach($listaProducto as $item)
									<tr>
										<td>{{$item->codigoproducto}}</td>
										<td>{{$item->descripcion}}</td>
										<td style="text-align:right;">{{number_format($item->precio,2)}}</td>
										<td>
											<button type="submit" class="asignarproducto btn btn-default btn-sm" id="{{$item->codigoproducto}}/{{$item->descripcion}}/{{number_format( $item->precio,2)}}/{{$item->id}}">
											  <span class="glyphicon glyphicon-share-alt asignar" aria-hidden="true"></span>
											</button>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>

							
				        </div>
				        <div class="tab-pane" id="bebidas">
	  						<!--Sub Categorias-->
							<div id="content2">
							    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
							        <li class="active"><a href="#cafes" data-toggle="tab" onclick="cartajax('LIM01CEN000000000001*','cafes')">Cafés</a></li>
							        <li><a href="#mochafrappe" data-toggle="tab" onclick="cartajax('LIM01CEN000000000006*LIM01CEN000000000009*LIM01CEN000000000003*','mochafrappe')">Mochas-Frappés</a></li>
							        <li><a href="#jugo" data-toggle="tab" onclick="cartajax('LIM01CEN000000000008*LIM01CEN000000000010*','jugo')">Jugos</a></li>
							    	<li><a href="#infusiones" data-toggle="tab" onclick="cartajax('LIM01CEN000000000015*LIM01CEN000000000016*','infusiones')">Infusiones</a></li>
							    </ul>
							    <div id="my-tab-content1" class="tab-content">
							        <div class="tab-pane active" id="cafes">
					
							        </div>
							        <div class="tab-pane cartajax" id="mochafrappe">

							        </div>
							        <div class="tab-pane cartajax" id="jugo">

							        </div>
							        <div class="tab-pane cartajax" id="infusiones">

							        </div>						        							        							        
							    </div>
							</div>
							<!--Sub Categorias-->
				        </div>
				        <div class="tab-pane" id="comidas">
	  						<!--Sub Categorias-->
							<div id="content2">
							    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
							        <li class="active"><a href="#sandwiches" data-toggle="tab" onclick="cartajax('LIM01CEN000000000013*','sandwiches')">Sándwiches</a></li>
							        <li><a href="#empanadas" data-toggle="tab" onclick="cartajax('LIM01CEN000000000005*LIM01CEN000000000011*','empanadas')">Empanadas</a></li>
							        <li><a href="#ensaladas" data-toggle="tab" onclick="cartajax('LIM01CEN000000000027*','ensaladas')">Ensaladas</a></li>
							    	<li><a href="#postres" data-toggle="tab" onclick="cartajax('LIM01CEN000000000012*','postres')">Postres</a></li>
							    </ul>
							    <div id="my-tab-content1" class="tab-content">
							        <div class="tab-pane active" id="sandwiches">

							        </div>
							        <div class="tab-pane cartajax" id="empanadas">

							        </div>
							        <div class="tab-pane cartajax" id="ensaladas">

							        </div>	
							        <div class="tab-pane cartajax" id="postres">

							        </div>						        							        							        
							    </div>
						</div>
						<!--Sub Categorias-->
				        </div>
				    </div>
				</div>
			</div>

    	    <div class="col-xs-12 col-md-12">
    	    	@foreach($listaMesa as $item)
    	    	<div id="lista{{$item->Numero}}" style="display:none">
    	    			<div style="text-align:center;margin:7px auto;">Cargando Mesa

    	    				<img src="/APPCOFFEE/img/guardando.gif" class="cargando" style="display:block;"/>

    	    			</div>
					    <table id="js-tabla{{$item->Numero}}" class="table" >
							<tbody>
								<tr>
									<th style="display:none;"></th>
									<th>Descripcion</th>
									<th style="text-align:center;">Precio</th>
									<th style="text-align:center;">Cantidad</th>
									<th style="text-align:center;">SubTotal</th>
									<th></th>
									<th style="display:none;"></th>
									<th style="display:none;"></th>
								</tr>
							</tbody>
						</table>
						<table id="totalm{{$item->Numero}}" class="table" >
							<tbody>
								<tr>
									<th>Total</th>
									<th style="text-align:right;padding-right: 69px;"><label for="lblcantidad" id="total{{$item->Numero}}">0.00</label></th>
								</tr>
							</tbody>
						</table>
				</div>	
				@endforeach	
	        </div>
	        </div>
        </div>

            
      <div class="cargando"><img src="/APPCOFFEE/img/cargando.gif" alt="cargando"></div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="guardar();">Guardar</button>
      </div>

    </div>
  </div>
</div>

<div id="mensajellama">
</div>
<audio class="player" id="audio" style="display:none;">
  <source id="mp3" type="audio/mpeg">
</audio>
<audio class="player2"  >
  <source src="/APPCOFFEE/audio/alerta.mp3" type="audio/mpeg">
  no soporta audio
</audio>
<div class="mesas" style="display:none;">{{$mesas}}</div>
<div class="mactiva" style="display:none;"></div>
<div class="idmesa" style="display:none;"></div>
<div class="tipo" style="display:none;">0</div><!-- 0 empleado - 1 cliente-->

@stop

@section('script')

	
	{{ HTML::script('js/fileinput.js'); }}
	{{ HTML::script('js/jquery.dataTables.js'); }}
	{{ HTML::script('js/E_bootstrap.js'); }}
	{{ HTML::script('js/fancywebsocket.js'); }}


	<script type="text/javascript">

		$(document).ready(function(){
			setTimeout(function(){ $(".exitoso").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 10000);
			$('#tabs').tab();
		});


		$(function(){
		    window.prettyPrint && prettyPrint()
		    $(document).on('click', '.yamm .dropdown-menu', function(e) {
		      e.stopPropagation()
		    })
		});


		function cartajax(id,nombre){

			$.ajax(
		    {
		        url: "/APPCOFFEE/cartajax",
		        type: "POST",
		        data: "id="+id,//+"&id="+id,
		    }).done(function(pagina) 
		    {
		        $('#'+nombre).html(pagina);
		    });	
		}


		function actualizarruc(){

			var mtotal = $(".mactiva").html();
			var swruc = 0;
			var idpedido = $("#idpedidoo"+mtotal).html();
			var tabla=document.getElementById('js-tabla'+mtotal);
			var numerodoc=$("#txtnd"+mtotal).val();
			var razonsocial=$("#txtrz"+mtotal).val();

			$(".avisoruc").css("display", "none");

			if(numerodoc.length==0){swruc=1;}
		    if(numerodoc.length==8){swruc=1;}
		    if(numerodoc.length==11){swruc=1;}

			if(idpedido==""){
				$(".avisoruc").css("display", "block");
				$(".avisoruc").css("color", "#a94442");
				$(".avisoruc").html("<strong>Error!</strong> Aún no tiene Pedido")	
			}else{
					if(swruc==0){
						$(".avisoruc").css("display", "block");
						$(".avisoruc").css("color", "#a94442");
						$(".avisoruc").html("<strong>Error!</strong> Ingrese 8(DNI) ó 11(RUC) Digitos")
						$("#txtnd"+mtotal).focus();
					}else{
						$.ajax(
					    {
					        url: "/APPCOFFEE/actualizarruc",
					        type: "POST",
					        data: "numerodoc="+numerodoc+"&razonsocial="+razonsocial+"&idpedido="+idpedido,
					    }).done(function(pagina) 
					    {
							$(".avisoruc").css("display", "block");
							$(".avisoruc").css("color", "#468847");
							$(".avisoruc").html("<strong>¡Bien hecho!</strong> Modificado Satisfactoriamente");
							$("#txtnd"+mtotal).focus();
					    });
					}
			}


		}

		function notapedido(iddetallepedido,obj){
			
			var hijo  = $(obj).siblings('.msjdet').find('li').find('.yamm-content');
			hijo.html("");
			$.ajax(
		    {
		        url: "/APPCOFFEE/mostrarnotaajax",
		        type: "POST",
		        data: "iddetallepedido="+iddetallepedido,//+"&detalle="+tabla.html(),
		    }).done(function(pagina) 
		    {
		        hijo.html(pagina);
		    });

		}


		$(".numero_mesa").on('click', function(){
				var name= $(this).attr('name');
				var id= $(this).attr('id');
				var mesas = $(".mesas").html();
				var arraymesa = mesas.split(",");

				for (i = 0; i < arraymesa.length-1; i++) {
				    $("#lista"+arraymesa[i]).css("display", "none");
				}
				$("#lista"+name).css("display", "block");
				$(".mactiva").html(name);
				$(".numeromesa").html(name);
				$(".idmesa").html(id);
			    $.ajax(
			    {
			        url: "/APPCOFFEE/listaproductoajax",
			        type: "POST",
			        data: "numero="+name+"&idmesa="+id
			    }).done(function(pagina) 
			    {
			        $("#lista"+name).html(pagina);
			    });
		});

	    $(".asignarproducto").click(function(e) {

	    	var btnaumdis="";
	    	var btndetalle="";
			var btnelimina="";

	    	var sw=0;
	    	var sumatotal=0.0;
	    	var cad="";
	    	var m = $(".mactiva").html();
	    	var data = $(this).attr('id');
			var arr = data.split('/');
			var tabla=document.getElementById('js-tabla'+m);
			var mtotal=m;
			$(".tooltip").css("opacity", "0");

			
			for (var i=1;i<tabla.rows.length;i++) {
				if (tabla.rows[i].cells[0].innerHTML==arr[0]) {sw=1;
					$("#t"+m+"cantidad"+arr[0]).html(parseInt($("#t"+m+"cantidad"+arr[0]).html())+1);
				}				
			}
			
			if (sw==0) {
				btnaumdis="<label for=lblcantidad id=t"+m+"cantidad"+arr[0]+" class=cantidad>1</label><button type=submit  class='btn-aumento btn btn-default btn-sm' onclick=aumentar('t"+m+"cantidad"+arr[0]+"','"+arr[0]+"','"+arr[2]+"')><span class='glyphicon glyphicon-plus aumento' aria-hidden=true></span></button>&nbsp;&nbsp;<button type=submit class='btn-aumento btn btn-default btn-sm' onclick=disminuir('t"+m+"cantidad"+arr[0]+"','"+arr[0]+"','"+arr[2]+"')><span class='glyphicon glyphicon-minus aumento' aria-hidden=true></span></button>";
		        btnelimina="<button type=submit  class='btn-aumento btn btn-default btn-sm' id='btneliminar' onclick=eliminar('t"+m+"fila"+arr[0]+"')><span class='glyphicon glyphicon-remove eliminar' aria-hidden=true></span></button>";
				btndetalle="<ul class='nav navbar-nav navbar-left'><li class='dropdown'><button type='button' class='btn-aumento btn btn-default btn-sm' onclick=detajax('"+arr[3]+"',this) data-toggle='dropdown' class='dropdown-toggle'><span class='glyphicon glyphicon-comment' aria-hidden=true></span></button><ul class='dropdown-menu msjdet'><li><div class='yamm-content'></div></li></ul></li></ul>";

		        cad="<tr id=t"+m+"fila"+arr[0]+"><td style=display:none;>"+arr[0]+"</td><td>"+arr[1]+"</td><td style=text-align:right;>"+arr[2]+"</td><td style=text-align:right;>"+btnaumdis+"</td><td id=t"+m+"subtotal"+arr[0]+" style=text-align:right;>"+arr[2]+"</td><td></td><td class='yamm'>"+btndetalle+"&nbsp;&nbsp;"+btnelimina+"</td><td style=display:none>"+arr[3]+"</td><td style=display:none class='detalletext'></td></tr>";
		        m="#js-tabla"+m+" "+"tr:last";
		        $(m).after(cad);
	        }else{
	        	$("#t"+m+"subtotal"+arr[0]).html(parseFloat(parseFloat($("#t"+m+"cantidad"+arr[0]).html())*parseFloat(arr[2])).toFixed(2));
	        }
	        for (var j=1;j<tabla.rows.length;j++) {
	        	sumatotal=parseFloat(sumatotal)+parseFloat(tabla.rows[j].cells[4].innerHTML);
			}
			$("#total"+mtotal).html(sumatotal.toFixed(2));

	    });

		function aumentar(id,codigo,precio) {

			$(".tooltip").css("opacity", "0");
			var mtotal = $(".mactiva").html();
			var tabla=document.getElementById('js-tabla'+mtotal);
			var sumatotal=0.0;


			$("#"+id).html(parseInt($("#"+id).html())+1);
			$("#t"+mtotal+"subtotal"+codigo).html(parseFloat(parseFloat($("#t"+mtotal+"cantidad"+codigo).html())*parseFloat(precio)).toFixed(2));

			for (var j=1;j<tabla.rows.length;j++) {
	        	sumatotal=parseFloat(sumatotal)+parseFloat(tabla.rows[j].cells[4].innerHTML);
			}
			$("#total"+mtotal).html(sumatotal.toFixed(2));

		}
		function disminuir(id,codigo,precio){

			$(".tooltip").css("opacity", "0");
			if(parseInt($("#"+id).html())>1){
				var mtotal = $(".mactiva").html();
				var tabla=document.getElementById('js-tabla'+mtotal);
				var sumatotal=0.0;

				$("#"+id).html(parseInt($("#"+id).html())-1);
				$("#t"+mtotal+"subtotal"+codigo).html(parseFloat(parseFloat($("#t"+mtotal+"cantidad"+codigo).html())*parseFloat(precio)).toFixed(2));

				for (var j=1;j<tabla.rows.length;j++) {
		        	sumatotal=parseFloat(sumatotal)+parseFloat(tabla.rows[j].cells[4].innerHTML);
				}
				$("#total"+mtotal).html(sumatotal.toFixed(2));

			}
		}

		function eliminar(idfila){

			$(".tooltip").css("opacity", "0");
			var mtotal = $(".mactiva").html();
			var tabla=document.getElementById('js-tabla'+mtotal);
			var sumatotal=0.0;

			$("#"+idfila).remove();

			for (var j=1;j<tabla.rows.length;j++) {
	        	sumatotal=parseFloat(sumatotal)+parseFloat(tabla.rows[j].cells[4].innerHTML);
			}
			$("#total"+mtotal).html(sumatotal.toFixed(2));
			
		}
		
		function guardar(){

			var mtotal = $(".mactiva").html();
			var sw=0;var swruc=0;
			var idmesa = $(".idmesa").html();
			var tabla=document.getElementById('js-tabla'+mtotal);
			var codigo="";var precio="";var subtotal="";var descripcion="";
			var cantidad="";var idproducto="";var detalletexto="";
			var nombrecli=$("#txt"+mtotal).val();
			var numerodoc=$("#txtnd"+mtotal).val();
			var razonsocial=$("#txtrz"+mtotal).val();
			var idpedido = $("#idpedidoo"+mtotal).html();
	   		var numerodoc=$("#txtnd"+mtotal).val();
	   		$(".tooltip").css("opacity", "0");
			$(".avisoruc").css("display", "block");

			for (var i=1;i<tabla.rows.length;i++) {
				if(tabla.rows[i].cells[0].innerHTML!=""){
					sw=1;
					codigo=codigo+tabla.rows[i].cells[0].innerHTML+",";
					descripcion=descripcion+tabla.rows[i].cells[1].innerHTML+",";
					precio = precio + tabla.rows[i].cells[2].innerHTML+",";
					subtotal = subtotal + tabla.rows[i].cells[4].innerHTML+",";
					idproducto = idproducto + tabla.rows[i].cells[7].innerHTML+",";
					detalletexto = detalletexto + tabla.rows[i].cells[8].innerHTML+",";
					cantidad= cantidad + $("#t"+mtotal+"cantidad"+tabla.rows[i].cells[0].innerHTML).html()+",";				
				}
			}

			if(numerodoc.length==0){swruc=1;}
		    if(numerodoc.length==8){swruc=1;}
		    if(numerodoc.length==11){swruc=1;}
		    
			if(sw==0){
					location.reload();
					//window.location.href = '/APPCOFFEE/getion-toma-pedido';
			}else{
				if( nombrecli == ""){
					$("#txt"+mtotal).focus();
					$(".tooltip").css("opacity", "1");
				}else{
					if(swruc==0){
						$(".avisoruc").css("display", "block");
						$(".avisoruc").css("color", "#a94442");
						$(".avisoruc").html("<strong>Error!</strong> Ingrese 8(DNI) ó 11(RUC) Digitos")
						$("#txtnd"+mtotal).focus();
					}else{
						$(".tooltip").css("opacity", "0");
						$(".cargando").css("display", "block");
						$.ajax({
						type: "POST",
						url: "/APPCOFFEE/insertarconajax",
						data: "codigo="+codigo+"&descripcion="+descripcion+"&cantidad="+cantidad+"&mesa="+mtotal+"&precio="+precio+"&subtotal="+subtotal+"&idmesa="+idmesa+"&idproducto="+idproducto+"&idpedido="+idpedido+"&detalletexto="+detalletexto+"&nombrecli="+nombrecli+"&numerodoc="+numerodoc+"&razonsocial="+razonsocial,
						dataType:"html",
						success: function(data) 
						{
						 	send(data);
						 	location.reload();
							//window.location.href = '/usuario/tomapedido';
						}
						});
					}
				}

			}	

		}

		function eliminarajax(iddetalle){

				$(".tooltip").css("opacity", "0");
				var arrayiddetalle = iddetalle.split("/");
				var mtotal = $(".mactiva").html();
				var tabla=document.getElementById('js-tabla'+mtotal);
				var sumatotal=0.0;
				var iddetped = arrayiddetalle[0];
				var idpedido = arrayiddetalle[3];

				$("#"+arrayiddetalle[1]).remove();

				for (var j=1;j<tabla.rows.length;j++) {
			        	sumatotal=parseFloat(sumatotal)+parseFloat(tabla.rows[j].cells[4].innerHTML);
				}
				$("#total"+mtotal).html(sumatotal.toFixed(2));
				$.ajax(
			    {
			    	type: "POST",
			        url: "/APPCOFFEE/eliminarproductoajax",
			        data: "iddetalle="+arrayiddetalle[0]+"&codigoeli="+iddetped+"&sumatotal="+sumatotal+"&idpedido="+idpedido,
			        dataType:"html",
			   	success: function(data) 
				{
				 	send(data);
				}
				});
		}

		function btngm(obj,agrupamiento,idproducto){

				var nota="";
				$(".tooltip").css("opacity", "0");
			    var padre = $(obj).parent().parent().parent().parent().parent().parent('.dropdown');
			    var texto = $(obj).parent().parent('.input-group').find(".form-control");
			    var hijo  = $(padre).find('.btn-aumento');
			    var icono = $(hijo).find(".glyphicon-comment");
			    var tabla = $(padre).parent().parent('.yamm').siblings('.detalletext');
			    var contadorradio = $(obj).parent().parent().parent('.yamm-content').find("#contadoradio");
			    
				padre.removeClass("open");
				hijo.attr("aria-expanded","false");
				for (i=1; i<=contadorradio.html(); i++)
					{
						if($('input:radio[name=radio'+agrupamiento+i+']').is(':checked')) { 
							nota=nota+($('input:radio[name=radio'+agrupamiento+i+']:checked').val())+'*';
						}	
						agrupamiento=agrupamiento+1;
					}		
				tabla.html(nota+'/'+$(texto).val());
				if($(texto).val()=="" && nota==""){
					$(icono).css("color", "#2e6da4");
				}else{
					$(icono).css("color", "red");
				}
		}

		function detajax(idproducto,obj){

			var padre = $(obj).parent().parent().parent();
			var tabla = $(padre).siblings('.detalletext');
			var hijo  = $(obj).siblings('.msjdet').find('li').find('.yamm-content');
			hijo.html("");
			$.ajax(
		    {
		        url: "/APPCOFFEE/productodetajax",
		        type: "POST",
		        data: "idproducto="+idproducto+"&detalle="+tabla.html(),
		    }).done(function(pagina) 
		    {
		        hijo.html(pagina);
		    });

		}

		function carta(objeto){

	    	var sw=0;
	    	var sumatotal=0.0;
	    	var cad="";
	    	var m = $(".mactiva").html();
	    	var data = $(objeto).attr('id');

			var arr = data.split('/');
			var tabla=document.getElementById('js-tabla'+m);
			var mtotal=m;
			$(".tooltip").css("opacity", "0");

			
			for (var i=1;i<tabla.rows.length;i++) {
				if (tabla.rows[i].cells[0].innerHTML==arr[0]) {sw=1;
					$("#t"+m+"cantidad"+arr[0]).html(parseInt($("#t"+m+"cantidad"+arr[0]).html())+1);
				}				
			}
			
			if (sw==0) {
				btnaumdis="<label for=lblcantidad id=t"+m+"cantidad"+arr[0]+" class=cantidad>1</label><button type=submit  class='btn-aumento btn btn-default btn-sm' onclick=aumentar('t"+m+"cantidad"+arr[0]+"','"+arr[0]+"','"+arr[2]+"')><span class='glyphicon glyphicon-plus aumento' aria-hidden=true></span></button>&nbsp;&nbsp;<button type=submit class='btn-aumento btn btn-default btn-sm' onclick=disminuir('t"+m+"cantidad"+arr[0]+"','"+arr[0]+"','"+arr[2]+"')><span class='glyphicon glyphicon-minus aumento' aria-hidden=true></span></button>";
		        btnelimina="<button type=submit  class='btn-aumento btn btn-default btn-sm' id='btneliminar' onclick=eliminar('t"+m+"fila"+arr[0]+"')><span class='glyphicon glyphicon-remove eliminar' aria-hidden=true></span></button>";
				btndetalle="<ul class='nav navbar-nav navbar-left'><li class='dropdown'><button type='button' class='btn-aumento btn btn-default btn-sm' onclick=detajax('"+arr[3]+"',this) data-toggle='dropdown' class='dropdown-toggle'><span class='glyphicon glyphicon-comment' aria-hidden=true></span></button><ul class='dropdown-menu msjdet'><li><div class='yamm-content'></div></li></ul></li></ul>";

		        cad="<tr id=t"+m+"fila"+arr[0]+"><td style=display:none;>"+arr[0]+"</td><td>"+arr[1]+"</td><td style=text-align:right;>"+arr[2]+"</td><td style=text-align:right;>"+btnaumdis+"</td><td id=t"+m+"subtotal"+arr[0]+" style=text-align:right;>"+arr[2]+"</td><td></td><td class='yamm'>"+btndetalle+"&nbsp;&nbsp;"+btnelimina+"</td><td style=display:none>"+arr[3]+"</td><td style=display:none class='detalletext'></td></tr>";
		        m="#js-tabla"+m+" "+"tr:last";
		        $(m).after(cad);
	        }else{
	        	$("#t"+m+"subtotal"+arr[0]).html(parseFloat(parseFloat($("#t"+m+"cantidad"+arr[0]).html())*parseFloat(arr[2])).toFixed(2));
	        }
	        for (var j=1;j<tabla.rows.length;j++) {
	        	sumatotal=parseFloat(sumatotal)+parseFloat(tabla.rows[j].cells[4].innerHTML);
			}
			$("#total"+mtotal).html(sumatotal.toFixed(2));

			var hermano = $(objeto).siblings('.glyphicon-ok');
			$(".carta .glyphicon-ok").css("display", "none");
			$(hermano).css("display", "block");
	    	var btnaumdis="";
	    	var btndetalle="";
			var btnelimina="";

		}

	</script>

@stop