
function setTipo(idTipo){
    hideAll();
    switch (idTipo){
        case TIPO_INSUMO_DIRECTO:
        {
            enableBase();
            break;
        }
        case TIPO_INSUMO_LINEAL:
        {
            enableBase();
            showLineal();
            break;
        }
        case TIPO_INSUMO_SUPERFICIE:
        {
            enableBase();
            showSuperficie();
            break;
        }
    }
}

function hideAll(){
    $('.boxinput_ini').css('display','none');
    $("#insumo-form input, #insumo-form select, #insumo-form textarea").each(function(){
        var input = $(this);
        input.attr('disabled','disabled');
    });

    $('#Insumo_id_tipo').removeAttr('disabled');
}

function enableBase(){
    $('#box_nombre, #box_descripcion, #box_costo_base, #box_habilitado, #box_submit').css('display','block');
    $('#Insumo_nombre, #Insumo_descripcion, #Insumo_costo_base, #Insumo_habilitado, #Insumo_submit').removeAttr('disabled');
}


function showLineal(){
    $('#box_unidad, #box_cantidad_total').css('display','block');
    $('#Insumo_id_unidad, #Insumo_cantidad_total').removeAttr('disabled');
}

function showSuperficie(){
    $('#box_unidad, #box_largo, #box_ancho').css('display','block');
    $('#Insumo_id_unidad, #Insumo_largo, #Insumo_ancho').removeAttr('disabled');
}