@foreach($listaCarta as $item)
<div class="carta col-al-6 col-xs-3 col-sm-2">
	<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	@if($item->Largo!=0)
		<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
  	@endif
	<h6 class="asignarproducto" id="{{$item->codigoproducto}}/{{$item->descripcion}}/{{number_format( $item->precio,2)}}/{{$item->id}}" onclick="carta(this)"><b>{{number_format($item->precio,2)}}</b><p><small>{{$item->descripcion}}</small></p></h6>	
</div>	
@endforeach
