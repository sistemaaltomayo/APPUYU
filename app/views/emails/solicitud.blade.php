<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <style type="text/css">
        	section{
        		width: 100%;
        		background: #E8E8E8;
        		padding: 0px;
        		margin: 0px;
        	}

        	.panelcontainer{
        		width: 50%;
        		background: #fff;
        		margin: 0 auto;


        	}
        	.panelhead{
        		background: #08257C;
        		padding-top: 10px;
        		padding-bottom: 10px;
        		color: #fff;
        		text-align: center;
        		font-size: 1.2em;
        	}
        	.panelbody,.panelbodycodigo{
        		padding-left: 15px;
        		padding-right: 15px;
        	}
            .panelbodycodigo h3 small{
                color: #08257C;
            }

        </style>

    </head>


    <body>
    	<section>
    		<div class='panelcontainer'>
    			<div class="panel">
                    <div class='panelbodycodigo'>

                        @if($IdUsuarioMod == '') 
                            <h3> Creación de Solicitud:   <small>{{$Correlativo}}</small></h3>
                        @else
                            <h3> Se Modifico la Solicitud:   <small>{{$Correlativo}}</small></h3>
                        @endif

                        
                        
                    </div>

    				<div class="panelhead">Solicitud de Personal</div>
    				<div class='panelbody'>
    					<h3>Motivo : 					<small>{{$MotivoSolicitud}}</small></h3>
                        @if($IdMotivoRemplazo != '0') 

                            {{--*/ $reemplazo = PERMotivoReemplazo::where('Id','=',$IdMotivoRemplazo)->first() /*--}}
                            {{--*/ $usuario = tbUsuarioLocal::where('Id','=',$IdUsuario)->first() /*--}}

                            <h3>Personal de Reemplazo :     <small>{{$usuario->Nombre}} {{$usuario->Apellido}}</small></h3>
                            <h3>Motivo Reemplazo :          <small>{{$reemplazo->Nombre}}</small></h3>
                        @else
                            <h3>Autorización :              <small>{{$Autorizacion}}</small></h3>                        
                        @endif

    				</div>
    				<div class="panelhead">Datos del Cargo</div>
    				<div class='panelbody'>
    					<h3>Cargo o puesto a ocupar : 	<small>{{$Cargo}}</small></h3>
    					<h3>Area : 						<small>{{$NombreLocal}}</small></h3>
    					<h3>Número Vacantes : 			<small>{{$NumeroVacantes}}</small></h3>
    					<h3>Edad : 						<small>{{$EdadInicio}} - {{$EdadFin}}</small></h3>
    					<h3>Perfil del Puesto : 		<small>{{$PerfilPuesto}}</small></h3>
    					<h3>Funciones del Puesto : 		<small>{{$FuncionesPuesto}}</small></h3>
    					<h3>Hora de Trabajo : 			<small>{{$HorariosTrabajo}}</small></h3>
    					<h3>Sueldo : 					<small>{{$Sueldo}}</small></h3>
    					<h3>Observacion : 				<small>{{$Observacion}}</small></h3>
    				</div>
    			</div>
    						

    		</div>
		</section>
    </body>

</html>


