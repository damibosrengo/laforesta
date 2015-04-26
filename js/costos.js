function showFormInsumo(e,ui){
    $.ajax({
        method: "POST",
        url: urlGetInsumo,
        data: {name: ui.item.value}
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
    $("#CostoInsumoDirecto")[0].reset();
    $("#CostoInsumoLineal")[0].reset();
    $("#CostoInsumoSuperficie")[0].reset();
    $('#boxForm_superficie').hide();
    $('#boxForm_lineal').hide();
    $('#boxForm_directo').hide();
    $('#insumo').val('');
}

function buildForm(insumo){
    if (insumo.habilitado == '1'){
        switch (insumo.id_tipo){
            case TIPO_INSUMO_DIRECTO:
            {
                $('#boxForm_directo').slideDown(600);
                $('#CostosInsumoDirectoForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoDirectoForm_nombre').val(insumo.nombre);
                break;
            }
            case TIPO_INSUMO_LINEAL:
            {
                $('#boxForm_lineal').slideDown(600);
                $('#CostosInsumoLinealForm_unidad option:eq('+insumo.id_unidad+')').prop('selected','selected');
                $('#CostosInsumoLinealForm_unidad').prop('disabled','disabled');
                $('#CostosInsumoLinealForm_idInsumo').val(insumo.id_insumo);
                $('#CostosInsumoLinealForm_nombre').val(insumo.nombre);
                break;
            }
            case TIPO_INSUMO_SUPERFICIE:
            {
                $('#boxForm_superficie').slideDown(600);
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
    addInsumoToList(idinsumo,cantidad,nombre,'','','');
    renderList();
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
    addInsumoToList(idinsumo,cantidad,nombre,unidad,'','');
    renderList();
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
    addInsumoToList(idinsumo,cantidad,nombre,unidad,largo,ancho);
    renderList();
    cancelAddInsumo();
    return false;
}

function checkInsumos(){
    var insumosList = $("#insumos_list_field").val();
    if (insumosList.length > 0){
        return true;
    } else {
        alert('Debe agregar al menos algún insumo para obtener un cálcuo');
    }
    return false;
}

function addInsumoToList(idinsumo,cantidad,nombre,unidad,largo,ancho){
    var obj = {};
    obj.idInsumo=idinsumo;
    obj.cantidad=cantidad;
    obj.nombre=nombre;

    if (largo.length > 0){
        obj.largo=largo;
    }
    if (ancho.length > 0){
        obj.ancho=ancho;
    }
    if (unidad.length > 0){
        obj.unidad=unidad;
    }
    var insumosList = $("#insumos_list_field").val();
    if (insumosList.length > 0) {
        var objList = $.parseJSON(insumosList);
        objList.push(JSON.stringify(obj));
        $("#insumos_list_field").val(JSON.stringify(objList));
    } else {
        var newVal = [];
        newVal.push(JSON.stringify(obj));
        $("#insumos_list_field").val(JSON.stringify(newVal));
    }
}

function deleteInsumoList(index) {
    var insumosList = $("#insumos_list_field").val();
    if (insumosList.length > 0) {
        var objList = $.parseJSON(insumosList);
        objList.splice(index, 1);
        $("#insumos_list_field").val(JSON.stringify(objList));
    }
    renderList();
}

function renderList(){
    $("#insumos_list").empty();
    var insumosList = $("#insumos_list_field").val();
    if (insumosList.length > 0) {
        var objList = $.parseJSON(insumosList);
        $.each(objList,function (index,item)
            {
                item =  $.parseJSON(item);
                var tdNombre = $('<td>' + item.nombre + '</td>');
                if (item.largo != undefined) {
                    var tdCantidad = $('<td>' + item.cantidad + ' (' +  item.largo + ' x ' +  item.ancho + ' ' +  item.unidad + ')</td>');
                } else if(item.unidad != undefined) {
                    var tdCantidad = $('<td>'+  item.cantidad + ' ' +  item.unidad + '</td>');
                } else {
                    var tdCantidad = $('<td>'+  item.cantidad + '</td>');
                }
                var tdLkDelete = $('<td><a href="javascript: deleteInsumoList(' + index + ')">Quitar</a></td>');
                var tr = $('<tr id="tr_' +  item.idInsumo + '"></tr>');
                tr.append(tdNombre);
                tr.append(tdCantidad);
                tr.append(tdLkDelete);
                $("#insumos_list").append(tr);
            });
    }
}