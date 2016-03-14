$( document ).ready(function() {


    $("#refresh, #refresh2").click(function() {

        $("#tablediv").html('');
        $("#loading-indicator").show();
        $.ajax({
            type: "POST",
            url: "/index.php/test/refreshAjax",
            dataType: "json",
            success:function(data){
                $("#loading-indicator").hide();
                refreshTable(data);
            }
        });
    });

    function refreshTable(data){
        //alert(data);
        $("#tablediv").html('');


        var content = "<table class='table table-bordered table-hover' id='testtable' name='testtable'>"
        $.each(data.data, function(i, val){
            content += '<tr>';
            $.each(val, function(y, val2){
                $.each(val2, function(y, val3){
                    //console.log( val3 );
                    content +='<td>' + val3 + '</td>';
                })
            })
            content +='</tr>';
        })

        content +='<tr><td colspan="'+data.max+'">Итого строк: ' + data.count_rows + '</td>';
        content +='<td >' + data.count_all + '</td></tr></table>';
        $('#tablediv').append(content);
    }
});
