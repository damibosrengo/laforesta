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
                $('#boxForm_directo').slideDown(700);
                $('#CostosInsumoDirectoForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoDirectoForm_nombre').val(insumo.nombre);
                break;
            }
            case TIPO_INSUMO_LINEAL:
            {
                $('#boxForm_lineal').slideDown(700);
                $('#CostosInsumoLinealForm_unidad option:eq('+insumo.id_unidad+')').prop('selected','selected');
                $('#CostosInsumoLinealForm_unidad').prop('disabled','disabled');
                $('#CostosInsumoLinealForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoLinealForm_nombre').val(insumo.nombre);
                break;
            }
            case TIPO_INSUMO_SUPERFICIE:
            {
                $('#boxForm_superficie').slideDown(700);
                $('#CostosInsumoSuperficieForm_unidad option:eq('+insumo.id_unidad+')').prop('selected','selected');
                $('#CostosInsumoSuperficieForm_unidad').prop('disabled','disabled');
                $('#CostosInsumoSuperficieForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoSuperficieForm_nombre').val(insumo.nombre);
                break;
            }
        }

    }
}

function submitInsumoDirecto(){
    var nombre = $('#CostosInsumoDirectoForm_nombre').val();
    var idinsumo = $('#CostosInsumoDirectoForm_idInsumo').val();
    var cantidad = $('#CostosInsumoDirectoForm_cantidad').val();
    if (cantidad.length == 0){
        alert('Ingrese la cantidad a utilizar');
        return false;
    } else if (isNaN(cantidad)){
        alert('Ingrese una cantidad a utilizar válida');
        return false;
    }
    var tdNombre = $('<td>' + nombre + '</td>');
    var tdCantidad = $('<td>'+ cantidad + '</td>');
    var tdLkDelete = $('<td><a href="javascript: deleteInsumoList(' + idinsumo +')">Quitar</a></td>');
    var tr = $('<tr id="tr_'+idinsumo+'"></tr>');
    tr.append(tdNombre);
    tr.append(tdCantidad);
    tr.append(tdLkDelete);
    $("#insumos_list").append(tr);
    cancelAddInsumo();
    return false;
}

function submitInusmoLineal(){
    var nombre = $('#CostosInsumoLinealForm_nombre').val();
    var idinsumo = $('#CostosInsumoLinealForm_idInsumo').val();
    var unidad = $("#CostosInsumoLinealForm_unidad option:selected").html();
    var cantidad = $('#CostosInsumoLinealForm_cantidad').val();
    if (cantidad.length == 0){
        alert('Ingrese la cantidad a utilizar');
        return false;
    } else if (isNaN(cantidad)){
        alert('Ingrese una cantidad a utilizar válida');
        return false;
    }
    var tdNombre = $('<td>' + nombre + '</td>');
    var tdCantidad = $('<td>'+ cantidad + ' ' + unidad + '</td>');
    var tdLkDelete = $('<td><a href="javascript: deleteInsumoList(' + idinsumo +')">Quitar</a></td>');
    var tr = $('<tr id="tr_'+idinsumo+'"></tr>');
    tr.append(tdNombre);
    tr.append(tdCantidad);
    tr.append(tdLkDelete);
    $("#insumos_list").append(tr);
    cancelAddInsumo();
    return false;

}

function submitInsumoSuperficie(){
    var nombre = $('#CostosInsumoSuperficieForm_nombre').val();
    var idinsumo = $('#CostosInsumoSuperficieForm_idInsumo').val();
    var cantidad = $('#CostosInsumoSuperficieForm_cantidad').val();
    var unidad = $("#CostosInsumoSuperficieForm_unidad option:selected").html();
    var largo = $('#CostosInsumoSuperficieForm_largo').val();
    var ancho = $('#CostosInsumoSuperficieForm_ancho').val();
    if (cantidad.length == 0){
        alert('Ingrese la cantidad a utilizar');
        return false;
    } else if (isNaN(cantidad)){
        alert('Ingrese una cantidad a utilizar válida');
        return false;
    }
    if (largo.length == 0){
        alert('Ingrese el largo a utilizar');
        return false;
    } else if (isNaN(largo)){
        alert('Ingrese el largo a utilizar válido');
        return false;
    }
    if (ancho.length == 0){
        alert('Ingrese el ancho a utilizar');
        return false;
    } else if (isNaN(ancho)){
        alert('Ingrese el ancho a utilizar válido');
        return false;
    }
    var tdNombre = $('<td>' + nombre + '</td>');
    var tdCantidad = $('<td>'+ cantidad +' (' + largo + ' x ' + ancho + ' ' + unidad + ')</td>');
    var tdLkDelete = $('<td><a href="javascript: deleteInsumoList(' + idinsumo +')">Quitar</a></td>');
    var tr = $('<tr id="tr_'+idinsumo+'"></tr>');
    tr.append(tdNombre);
    tr.append(tdCantidad);
    tr.append(tdLkDelete);
    $("#insumos_list").append(tr);
    cancelAddInsumo();
    return false;
}