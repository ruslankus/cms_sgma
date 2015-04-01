$(document).ready(function() {

$(document).on("change",".selector-of-widget",function(){

    //get dada from selected option
    var values = $(this).val();
    var valArr = values.split(',');

    //get all ID's
    var regType = valArr[0];
    var widId = valArr[1];
    var posId = valArr[2];

    //register widget - action url
    var url = $('#ajax-register-link').val();
    url += '/rt/'+regType+'/id/'+widId+'/pos/'+posId;

    //request
    var request = $.ajax({url: url});

    $.preLoader.show();
    request.done(function(data){
        if(data == 'OK')
        {
            ajaxRefreshTable();
        }
        else
        {
            $.preLoader.hide();
        }
    });

    request.fail(function(jqXHR,textStatus) {
        alert( "Request failed: " + textStatus);
        $.preLoader.hide();
    });
});

//delete button
$(".del").click(function()
	{
		data_id = $(this).attr("data-id");
		console.log("delete"+data_id);
		return false;
	});//end delete button
// delete widget row
$(document).on("click", ".delete", function()
	{	
		data_id = $(this).attr("data-id");
		console.log("delete"+data_id);
		return false;
	});//end delete widget row
});//end ready

/**
 * Refresh table of menu items
 */
var ajaxRefreshTable = function()
{
    var request = $.ajax({url: $('#ajax-refresh-link').val()});

    request.done(function(data){
        $('.inner-content').html(data).trigger('updated');
        $.preLoader.hide();
    });

    request.fail(function(jqXHR,textStatus) {
        alert( "Request failed: " + textStatus);
        $.preLoader.hide();
    });
};