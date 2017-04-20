<div>

	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th> </th>
				<th>V</th>
				<th>A</th>
				<th>M</th>
                <th>T</th>
                <th>+</th>
			</tr>
		</thead>
		<tbody>
            @foreach($listaRolOpciones as $item)
			<tr>

				<td class='nombreOpcion'>{{$item->Nombre}}</td>
				<td>
                    <input type="checkbox" class="check{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}" onclick="checkpermiso(this,'{{Hashids::encode(substr($item->IdOpcion, -12))}}','{{$item->IdRol}}','Ver')" name="{{$item->IdOpcion}}" id="Ver{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}"  @if ($item->Ver == 1) checked @endif>
                </td>
				<td>
                    <input type="checkbox" class="check{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}" onclick="checkpermiso(this,'{{Hashids::encode(substr($item->IdOpcion, -12))}}','{{$item->IdRol}}','Anadir')" name="{{$item->IdOpcion}}" id="Anadir{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}" @if ($item->Anadir == 1) checked @endif>
                </td>
				<td>
                    <input type="checkbox" class="check{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}" onclick="checkpermiso(this,'{{Hashids::encode(substr($item->IdOpcion, -12))}}','{{$item->IdRol}}','Modificar')" name="{{$item->IdOpcion}}" id="Modificar{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}" @if ($item->Modificar == 1) checked @endif>
                </td>

                <td>
                    <input type="checkbox" class="check{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}" onclick="checkpermiso(this,'{{Hashids::encode(substr($item->IdOpcion, -12))}}','{{$item->IdRol}}','Todas')" name="{{$item->IdOpcion}}" id="Todas{{Hashids::encode(substr($item->IdOpcion, -12))}}{{$item->IdRol}}" @if ($item->Todas == 1) checked @endif>
                </td>
                <td class='tdplus'>
                    @if (in_array($item->Id, $arrayplus, true)) 
                        <button type="button" id='{{$item->Id}}' class="btnplus btn btn-success" data-toggle="modal" data-target="#opcionplus"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                    @endif
                </td>
			</tr>
            @endforeach

		</tbody>
	</table>

    <div>
        <p class="text-muted">V = Ver | A = Agregar | M = Modificar | T = Todo</p>

    </div>

</div>



<!--  Modal para Opciones Plus -->

<div class="modal fade" id="opcionplus" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="permisomsjplus">
            
          </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title tituloopcionplus" style="text-align:center;"></h4>
        </div>
        <div class="modal-body ">

            <div class="row">
                <div class="tablaopcionplus col-xs-12 col-lg-12">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

<script>

$('.btnplus').on('click', function(event){

    var idRolOpcion  = $(this).attr('id');
    var nombreOpcion = $(this).parent().siblings('.nombreOpcion').html();
    var Rol          = $('.tabsroles').children('.active').children('a').html();
    $('#opcionplus .tituloopcionplus').html(nombreOpcion+' <small>'+Rol+'</small>');
    
    $.ajax(
    {
        url: "/APPCOFFEE/listar-ajax-permisos-plus",
        type: "POST",
        data: "idRolOpcion="+idRolOpcion,
    }).done(function(pagina) 
    {
        $(".tablaopcionplus").html(pagina);
    });

});

</script>