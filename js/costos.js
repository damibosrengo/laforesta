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
    var girar = $('#CostosInsumoSuperficieForm_girar').val();
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
    addInsumoToList(idinsumo,cantidad,nombre,unidad,largo,ancho,girar);
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

function mergeInsumoList(list,obj){
    var flagExists = false;
    $.each(list,function(index, item){
       if (!flagExists) {
           var itemObj = $.parseJSON(item);
           if (itemObj.idInsumo == obj.idInsumo) {
               if (obj.cortes != undefined && obj.cortes.length > 0) {
                   itemObj.cortes.push(obj.cortes[0]);
               } else {
                   itemObj.cantidad = parseFloat(itemObj.cantidad) + parseFloat(obj.cantidad);
               }
               list.splice(index, 1);
               list.push(JSON.stringify(itemObj));
               flagExists = true;
           }
       }
    });

    if (!flagExists){
        list.push(JSON.stringify(obj));
    }
    return list;
}

function addInsumoToList(idinsumo,cantidad,nombre,unidad,largo,ancho,girar){
    var obj = {};
    obj.idInsumo=idinsumo;
    obj.cantidad=cantidad;
    obj.nombre=nombre;

    if (largo.length > 0 || ancho.length > 0){
        var corte = {};
        corte.cantidad = obj.cantidad;
        corte.largo = largo;
        corte.ancho = ancho;
        corte.girar = girar;
        obj.cantidad = 0;
        obj.cortes = [];
        obj.cortes.push(JSON.stringify(corte));
    }

    if (unidad.length > 0){
        obj.unidad=unidad;
    }
    var insumosList = $("#insumos_list_field").val();
    if (insumosList.length > 0) {
        var objList = $.parseJSON(insumosList);
        objList = mergeInsumoList(objList,obj);
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
                if (item.cortes != undefined && item.cortes.length > 0) {
                    var tdCantidad = '';
                    $.each(item.cortes,function(cIndex,cItem){
                        var cte = $.parseJSON(cItem);
                        if (cte.girar == '1'){
                            girar = 'Si';
                        } else {
                            girar = 'No';
                        }
                        tdCantidad += cte.cantidad + ' (' +  cte.largo + ' x ' +  cte.ancho + ' ' +  item.unidad + ', girar '+ girar +");<br> ";
                    })
                    tdCantidad = $('<td>' + tdCantidad + '</td>');
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

function checkCalculo(){
    if (!checkInsumos()){
        return false;
    }
    var porcentaje = $("#porcentaje").val()
    if (porcentaje.length > 0){
        if (isNaN(porcentaje)){
            alert('El porcentaje ingresado no es válido');
            return false;
        }
        if ($("#porcentaje_concepto").length == 0){
            alert('Debe especificar el concepto del porcentaje añadido');
            return false;
        }
    }
    var fijo = $("#fijo").val();
    if (fijo.length > 0){
        if (isNaN(fijo)){
            alert('El costo fijo ingresado no es válido');
            return false;
        }
        if ($("#fijo_concepto").length == 0){
            alert('Debe especificar el concepto del costo fijo añadido');
            return false;
        }
    }
    return true;
}

function quitarExtra(indexExtra){
    var extrasList = $("#extras_list_field").val();
    var list = $.parseJSON(extrasList);
    list.splice(indexExtra,1);
    $("#extras_list_field").val(JSON.stringify(list));
    $("#submit-calculo").submit();
}