function refreshAjax(){
    //$("#tablediv").html('');
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
}


function refreshTable(data){
    //alert(data);
    $("#tablediv").html('');
    $("#container2").remove();

    var content = "<div id='container2'><img src='"+document.location.origin+"/assets/images/loading8.gif' id='loading-indicator' name='loading-indicator' style='display:none' />";
    content += "<button class='btn btn-default' id='refresh' type='button' name='refresh' onclick='refreshAjax()'>Refresh</button> ";


    content += "<table class='table table-bordered table-hover' id='testtable' name='testtable'>"
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
    content += "<button class='btn btn-default' id='refresh2' type='button' name='refresh2' onclick='refreshAjax()'>Refresh</button></div> ";

    $('#container').append(content);
}


$( document ).ready(function() {

    refreshAjax();
});


