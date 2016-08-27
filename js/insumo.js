
function setTipo(idTipo){
    hideAll();
    switch (idTipo){
        case TIPO_INSUMO_DIRECTO:
        {
            enableBase('Directo');
            break;
        }
        case TIPO_INSUMO_LINEAL:
        {
            enableBase('Lineal');
            showLineal();
            break;
        }
        case TIPO_INSUMO_SUPERFICIE:
        {
            enableBase('Superficie');
            showSuperficie();
            break;
        }
    }
}

function hideAll(){
    $("#insumo-form fieldset").hide();
    $('.boxinput_ini').css('display','none');
    $("#insumo-form input, #insumo-form select, #insumo-form textarea").each(function(){
        var input = $(this);
        input.attr('disabled','disabled');
    });

    $('#Insumo_id_tipo').removeAttr('disabled');
}

function enableBase(sufix){
    $("#insumo-form fieldset").show();
    $('#box_nombre, #box_descripcion, #box_costo_base, #box_habilitado, #box_submit').css('display','block');
    $('#Insumo'+sufix+'_nombre, #Insumo'+sufix+'_descripcion, #Insumo'+sufix+'_costo_base, #Insumo'+sufix+'_habilitado, #Insumo_submit').removeAttr('disabled');
    $('#Insumo_nombre, #Insumo_descripcion, #Insumo_costo_base, #Insumo_habilitado').removeAttr('disabled');
}


function showLineal(){
    $('#box_unidad, #box_cantidad_total').css('display','block');
    $('#InsumoLineal_id_unidad, #InsumoLineal_cantidad_total').removeAttr('disabled');
    $('#Insumo_id_unidad, #Insumo_cantidad_total').removeAttr('disabled');
}

function showSuperficie(){
    $('#box_unidad, #box_largo, #box_ancho').css('display','block');
    $('#InsumoSuperficie_id_unidad, #InsumoSuperficie_largo, #InsumoSuperficie_ancho').removeAttr('disabled');
    $('#Insumo_id_unidad, #Insumo_largo, #Insumo_ancho').removeAttr('disabled');
}