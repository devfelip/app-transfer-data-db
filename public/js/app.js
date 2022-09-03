$(function(){
    function populate_tables(){
        dropdown_tables = $("#txtTables");
        dropdown_tables.empty();
        dropdown_tables.append('<option selected="true">Selecione uma tabela</option>');
        dropdown_tables.prop('selectedIndex', 0);        

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/select/'+$("#txtConnection").val(),
            beforeSend: function () {
                //$("#dados").html("Aguarde um momento!");
            },
            success: function (data) {
                $.each(data, function (key, entry) 
                {
                    dropdown_tables.append($('<option></option>')
                          .attr('value', entry.table_name)
                          .text(entry.table_name));
                });
            }
        });
    }

    $("#txtPassword").focusout(function(){
        populate_tables();
    });
    //populate_tables();
});