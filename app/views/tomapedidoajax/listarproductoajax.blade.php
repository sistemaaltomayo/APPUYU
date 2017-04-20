<div class="row">
	<div class="col-xs-12 ruc">
		<div class="col-ruc col-al-12 col-xs-4">
			<div class="input-group">
			  <input type="text" id="txtnd{{$numero}}" class="form-control numerodocumento" placeholder="Num. Documento" maxlength="11" value="@if(isset($listaProductoA[0]->IdPedido) && $listaProductoA[0]->IdPedido!=''){{$listaProductoA[0]->numerodocumento}}@endif">
			  <span class="input-group-addon" id="basic-addon2">
			       <span class="glyphicon glyphicon-registration-mark" aria-hidden="true" style="color:#286090"></span>
			  </span>
			</div>
		</div>
		<div class="col-ruc col-al-12 col-xs-7">
			<div class="input-group" >
			  <input type="text" id="txtrz{{$numero}}" class="form-control razonsocial" placeholder="RAZÓN SOCIAL" value="@if(isset($listaProductoA[0]->IdPedido) && $listaProductoA[0]->IdPedido!=''){{$listaProductoA[0]->razonsocial}}@endif">
			  <span class="input-group-addon" id="basic-addon2">
			       <span class="glyphicon glyphicon-book" aria-hidden="true" style="color:#286090"></span>
			  </span>
			</div>
		</div>
		<div class="col-ruc col-al-12 col-xs-1">
				<button type="button" class="btn btn-default" onclick="actualizarruc()"aria-label="Left Align">
				  <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
				</button>
		</div>
		<p class="avisoruc" style="display:none;"></p>
		       
	</div>
	<div class="col-xs-12">
		<div class="input-group" style="width:50%;margin-left:15px;">
		  <input type="text" id="txt{{$numero}}" class="form-control" placeholder="Nombre" maxlength="5" value="@if(isset($listaProductoA[0]->IdPedido) && $listaProductoA[0]->IdPedido!=''){{$listaProductoA[0]->nomcli}}@endif">
		  <span class="input-group-addon" id="basic-addon2">
		       <span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#286090"></span>
		  </span>
		</div>
	</div>

</div>

<div class="tooltip bottom" role="tooltip">
      <div class="tooltip-arrow"></div>
      <div class="tooltip-inner">
        Ingrese Nombre
      </div>
</div>

<br>
<table id="js-tabla{{$numero}}" class="table" >
	<tbody>
		<tr>
			<th style="display:none;"></th>
			<th width="32%">Descripcion</th>
			<th width="9%" style="text-align:center;">Precio</th>
			<th width="21%" style="text-align:center;">Cantidad</th>
			<th width="9%" style="text-align:center;">SubTotal</th>
			<th width="9%"></th>
			<th width="20%"></th>
			<th style="display:none;"></th>
			<th style="display:none;"></th>
		</tr>
		@foreach($listaProductoA as $item)
			<tr id='tb{{$numero}}fila{{$item->Id}}'>
				<td style="display:none;"></td>
				<td>{{$item->Descripcion}}</td>
				<td style="text-align:right;">{{number_format( ($item->PrecioExtendido/$item->Cantidad),2)}}</td>
				<td style="text-align:right;">
				<b>{{number_format($item->Cantidad,2)}}</b>

				</td>
				<td style="text-align:right;">{{number_format($item->PrecioExtendido,2)}}</td>
				<td width="100px" style="text-align:center;" class="mensaje">
					@if($item->Activo==0)
					    <span class="label label-success">En Cocina</span>				
					@else
						@if($item->Activo==1)
						<span class="label label-warning">Preparando</span>
						@else
						<span class="label label-danger">Atendido</span>						
						@endif
					@endif
				</td>
				<td class="botones">
					<ul class='nav navbar-nav navbar-left'>
						<li class='dropdown'>
							<button type='button' class='btn-aumento btn btn-default btn-sm' onclick="notapedido('{{$item->IdDetallePedido}}',this)" data-toggle='dropdown' class='dropdown-toggle'>
								<span class='glyphicon glyphicon-comment' style="@if($item->detped != "" || $item->EstadoNota>0)color:red;@elsecolor:#2e6da4;@endif" aria-hidden=true></span>
							</button>
							
							<ul class='dropdown-menu msjdet'>
								<li>
									<div class='yamm-content'>

									</div>
								</li>
							</ul>
						</li>
					</ul>&nbsp;&nbsp;
					@if($item->Activo==0)
					<button type="submit" class="btn-aumento btn btn-default btn-sm eliminarpedido" onclick="eliminarajax('{{$item->Id}}/tb{{$numero}}fila{{$item->Id}}/{{$item->CodigoProducto}}{{(int)($item->Cantidad)}}{{$numero}}{{str_replace(" ","",str_replace("-","",str_replace(":","",date_format(date_create($item->FechaCrea), 'Y-m-d H:i:s'))))}}/{{$item->IdPedido}}')"><span class="glyphicon glyphicon-remove eliminar" aria-hidden="true"></span></button>
					@endif
				</td>
				<td style="display:none"></td>
				<td style="display:none"></td>
			</tr>
		@endforeach
	</tbody>
</table>

<table id="totalm{{$numero}}" class="table" >
	<tbody>
		<tr>
			<th width="62%">Total</th>
			<th width="9%" style="text-align:right;">
			<label for="lblcantidad" id="total{{$numero}}">@if(isset($listaProductoA[0]->TotalMN) && $listaProductoA[0]->TotalMN!=''){{number_format($listaProductoA[0]->TotalMN,2)}}@else 0.00 @endif</label>
			</th>
			<th width="29%"></th>
			<!--<th width="@if(isset($listaProductoA[0]->TotalMN) && $listaProductoA[0]->TotalMN!='') 140px @else 63px @endif">
			</th>-->
		</tr>
	</tbody>
</table>

<div id="idpedidoo{{$numero}}" style="display:none;">@if(isset($listaProductoA[0]->IdPedido) && $listaProductoA[0]->IdPedido!=''){{$listaProductoA[0]->IdPedido}}@endif</div>
<script>
	$(".numerodocumento").keydown(function(event) {
        numero(event);
    });

    $('.razonsocial').keyup(function() {
        this.value = this.value.toUpperCase();
    });
</script>