<table class="table table-condensed table-hover">
	<thead>
		<tr>
		@foreach($listaRolOpcionPlus as $item)
			<th>{{$item->Nombre}}</th>
		@endforeach
			<th>Todos</th>
		</tr>
	</thead>
	<tbody>
		<tr id="listacheckplus">
		{{--*/ $todo = 0 /*--}}
        @foreach($listaRolOpcionPlus as $item)
        	@if($item->Activo==0) {{--*/ $todo = 1 /*--}}  @endif
			<td><input type="checkbox"  class='P{{$idrolopcion}}' name="T" id="N-{{$item->Id}}" @if ($item->Activo == 1) checked @endif></td>
        @endforeach
        	<td><input type="checkbox"  class='P{{$idrolopcion}}' name="T" id="T-{{$idrolopcion}}" @if ($todo == 0) checked @endif></td>
		</tr>
	</tbody>
</table>
{{ Form::hidden('identiti', $idrolopcion, array('id' => 'identiti')) }}
<script>

$('#listacheckplus input').on('click', function(event){

	var aleatorio = Math.floor((Math.random() * 500) + 1);
	var identiti  	= $('#identiti').val();
	var checkPLus  	= $(this).attr("id");
	var arraycadena = checkPLus.split('-');
	var accion 		= arraycadena[0];
	var idPlus 		= arraycadena[1];

	if($(this).is(':checked')){ 
		checkcadena = validarrellenoplus(accion,true,idPlus);
	}else{

		checkcadena = validarrellenoplus(accion,false,idPlus);
	}	

	$.ajax(
    {
        url: "/APPALTOMAYO/activar-ajax-permisos-plus",
        type: "POST",
        data: "identiti="+identiti+"&checkcadena="+checkcadena,
    }).done(function(pagina) 
    {
    	msj="<div class='rdp"+aleatorio+" alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Actualización exitosa </strong></div>";
		$(".permisomsjplus").append(msj);
    });

    setTimeout(function(){ $(".rdp"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);


});


function validarrellenoplus(accion,estado,idPlus){

	cadenamodificar = '';
	if (accion=='T') {
		$(".P"+idPlus).prop("checked", estado);
		cadenamodificar = recorrertablaplus();
	}else{
		if(estado==false){

				llenotodo(estado,'D');
				cadenamodificar = recorrertablaplus();

		}else{

				llenotodo(estado,'A');
				cadenamodificar = recorrertablaplus();
		}
	}

	return cadenamodificar;

}

function llenotodo(estado,accion){

	lleno = 0;
	$("#listacheckplus td").each(function (index) 
    {
    	arraycadena = $(this).find('input').attr("id").split('-');	
    	if($(this).find('input').is(':checked')){ 
    			if(arraycadena[0]!='T' && accion == 'D'){
    				lleno = 2 ;
    			}
    	}else{
    			if(arraycadena[0]!='T' && accion == 'A'){
    				lleno = 1 ;
    			}
    	}	
    })

	if(accion == 'A'){
		if(lleno==0){
	    	$( "input[name*='T']" ).prop("checked", estado);
	    }
	}

	if(accion == 'D'){
		if(lleno==2){
	    	$('#listacheckplus td:last input').prop("checked", estado);
	    }
	}
}

function recorrertablaplus(){

	var cadenacheck = '';
	var arraycadena  	= '';
	$("#listacheckplus td").each(function (index) 
    {
 		arraycadena = $(this).find('input').attr("id").split('-');
    	if($(this).find('input').is(':checked')){ 
    		if(arraycadena[0]!='T'){
    			cadenacheck = cadenacheck +  arraycadena[1] + ',';
    		}    		
    	}	
    })
	return cadenacheck;
}


</script>