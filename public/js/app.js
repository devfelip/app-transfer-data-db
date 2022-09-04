$(function(){
    function populate_tables(){
        conn = $("#txtConnection").val();
        host = $("#txtHost").val();
        port = $("#txtPort").val();
        database = $("#txtDatabase").val();
        username = $("#txtUsername").val();
        pass = $("#txtPassword").val();

        dropdown_tables = $("#txtTables");
        dropdown_tables.empty();
        dropdown_tables.append('<option selected="true">Selecione uma tabela</option>');
        dropdown_tables.prop('selectedIndex', 0);        

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/select/'+conn+'/'+host+'/'+port+'/'+database+'/'+username+'/'+pass+'/',
            beforeSend: function () {
                if(!conn || !host || !port || !database || !username || !pass)
                    return false;
                //$("#dados").html("Aguarde um momento!");
            },
            success: function (data) {
                $.each(data, function (key, entry) 
                {
                    dropdown_tables.append($('<option></option>')
                          .attr('value', entry.table_name)
                          .text(entry.table_name));
                });
            },
            error: function() {
                console.log('Não foi possivel conectar!');
             }
        });
    }



    $("#txtPassword").focusout(function(){
        populate_tables();
    });
});