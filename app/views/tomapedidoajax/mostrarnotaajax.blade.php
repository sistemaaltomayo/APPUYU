@foreach($listaNota as $item)
	@if($item->Descripcion!="")
	<h5><b>*</b><em> {{$item->Descripcion}}</em></h5>
	@endif
@endforeach	
@if(count($listaNota)>0 && $listaNota[0]->detped!="")
<h5><b>nota:</b><em>  {{$listaNota[0]->detped}}</em></h5>
@else
<h5><em>********  No hay Nota ********</em></h5>
@endif
