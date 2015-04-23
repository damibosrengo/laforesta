function showFormInsumo(){
    $.ajax({
        method: "POST",
        url: urlGetInsumo,
        data: {name: $('#insumo').val()}
    })
        .done(function( data ) {
           if (data.length > 0) {
               buildForm($.parseJSON(data));
           } else {
               alert('No se encontró el insumo '+ $('#insumo').val());
           }
        });

}

function cancelAddInsumo(){
    $('#boxForm_superficie').hide();
    $('#boxForm_lineal').hide();
    $('#boxForm_directo').hide();
    $('#add_insumo').show();
    $('#insumo').val('');
}

function buildForm(insumo){
    if (insumo.habilitado == '1'){
        $('#add_insumo').hide();
        switch (insumo.id_tipo){
            case TIPO_INSUMO_DIRECTO:
            {
                $('#boxForm_directo').slideDown(800);
                $('#CostosInsumoDirectoForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoDirectoForm_nombre').val(insumo.nombre);
                break;
            }
            case TIPO_INSUMO_LINEAL:
            {
                $('#boxForm_lineal').slideDown(800);
                $('#CostosInsumoLinealForm_unidad option:eq('+insumo.id_unidad+')').prop('selected','selected');
                $('#CostosInsumoLinealForm_unidad').prop('disabled','disabled');
                $('#CostosInsumoLinealForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoLinealForm_nombre').val(insumo.nombre);
                break;
            }
            case TIPO_INSUMO_SUPERFICIE:
            {
                $('#boxForm_superficie').slideDown(800);
                $('#CostosInsumoSuperficieForm_unidad option:eq('+insumo.id_unidad+')').prop('selected','selected');
                $('#CostosInsumoSuperficieForm_unidad').prop('disabled','disabled');
                $('#CostosInsumoSuperficieForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoSuperficieForm_nombre').val(insumo.nombre);
                break;
            }
        }

    }
}