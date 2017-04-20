{{--*/ $contador = 0 /*--}}
{{--*/ $contadoradio = 1 /*--}}
{{--*/ $prueba = "true" /*--}}
{{--*/ $agrupamiento = 0 /*--}}
{{--*/ $inicioagrupamiento = 0 /*--}}

@foreach($listaProductoNota as $item)
	{{--*/ $checked = "" /*--}}
	{{--*/ $inicioagrupamiento = $listaProductoNota[0]->Agrupamiento/*--}}

	@if($arrayradio!="")
		@for ($i = 0; $i < count($arrayradio)-1; $i++)
			@if($arrayradio[$i]==$item->Id)
		    	{{--*/ $checked = "checked" /*--}}
		    	{{--*/ $i = count($arrayradio) /*--}}
		    @else
		    	{{--*/ $checked = "" /*--}}
		    @endif
		@endfor
	@endif
	<div class="radio">
	  <label>
	    <input type="radio" name="radio{{$item->Agrupamiento}}{{$contadoradio}}" value="{{$item->Id}}" {{$checked}}>
	    {{$item->Descripcion}}
	  </label>
	</div>

	{{--*/ $agrupamiento = $item->Agrupamiento /*--}}
	@if(!isset($listaProductoNota[$contador+1]->Agrupamiento))
			<hr style="color: #0056b2;" />
			{{--*/ $contadoradio = $contadoradio + 1 /*--}}
	@else
    	@if($listaProductoNota[$contador+1]->Agrupamiento != $agrupamiento)
    		<hr style="color: #0056b2;" />
    		{{--*/ $contadoradio = $contadoradio + 1 /*--}}
    	@endif
	@endif
	{{--*/ $contador = $contador + 1 /*--}}

@endforeach	
<p id="contadoradio" style="display:none;">{{$contadoradio-1}}</p>
<div class='input-group'>
	<input type='text' class='form-control' value="{{$text}}" maxlength='160' placeholder='Detalle del pedido...'/>
	<span class='input-group-btn'>
		<button class='btn btn-default' type='button' onclick=btngm(this,{{$inicioagrupamiento}},'{{$idProducto}}')>
		<span class='glyphicon glyphicon-ok' aria-hidden=true></span>
		</button>
	</span>
</div>
