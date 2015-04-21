function showFormInsumo(){
    alert($('#insumo').val());
    //$.ajax({
    //    method: "POST",
    //    url: urlGetInsumo,
    //    data: {name: $('#insumo').val()}
    //})
    //    .done(function( msg ) {
    //        alert( "data insumo " + msg );
    //    });
    $('#boxForm_superficie').show();
}