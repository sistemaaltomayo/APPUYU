function valDni(valor)
{
    var expresion=/^[0-9]{8}$/;
    
    if(!expresion.test(valor))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valCantidad(valor,numero)
{
    if(valor.length!=numero)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function CantidadNumeros(valor,comparar)
{

    if(!(valor.length==comparar))
    {
        return false;
    }
    else
    {
        return true;
    }
}


function valRuc(valor)
{
    var expresion=/^[0-9]{11}$/;
    
    if(!expresion.test(valor))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valEntero(valor)
{
    var expresion=/^[0-9]+$/;
    
    if(!expresion.test(valor))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valDecimal(valor)
{
    var expresion=/^[0-9]+([\.]{1}[0-9]+)?$/;
    
    if(!expresion.test(valor))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valDosDecimales(valor)
{
    var expresion=/^[0-9]+([\.]{1}[0-9]{1,2})?$/;
    
    if(!expresion.test(valor))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valEmail(valor)
{
    var expresion=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    
    if(!expresion.test(valor))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valFechaYYYYMMDD(valor)
{
    var expresion=/^(1|2){1}[0-9]{3}[-./][0-9]{2}[-./][0-9]{2}$/;
    
    if(!expresion.test(valor))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valVacio(valor)
{
    
    if($.trim(valor)==="")
    {
        return false;
    }
    else
    {
        return true;
    }
}

function valSelect(valor,indice)
{
    if(valor==indice)
    {
        return false;
    }
    else
    {
        return true;
    }
}


function numeroentre(valor,x,y){

   if(valor>=x && valor<=y)
   {
        return true;
   }else{
        return false;
   }

}

function numeromayor(valor,x){

   if(valor>=x)
   {
        return true;
   }else{
        return false;
   }

}


function numero(evento){
   if(event.shiftKey)
   {
        event.preventDefault();
   }
 
   if (event.keyCode == 46 || event.keyCode == 8)    {
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
}





function errores(jqXHR,textStatus,responseText){

    var cadena = ''
    if (jqXHR === 0) {
        cadena = 'No conecta: Verificar la red';
    } else if (jqXHR == 404) {
        cadena = 'Página solicitada no encontrada [404]';
    } else if (jqXHR == 500) {
        cadena = 'Error interno del servidor [500]';
    } else if (textStatus === 'parsererror') {
        cadena = 'Error al analizar JSON solicitado';
    } else if (textStatus === 'timeout') {
        cadena = 'Error de tiempo de espera';
    } else if (textStatus === 'abort') {
        cadena = 'Petición de Ajax cancelada';
    } else {
        cadena = 'Error no detectado: ' + responseText;
    }

    return cadena;

}

