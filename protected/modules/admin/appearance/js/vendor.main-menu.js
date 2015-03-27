$(document).ready(function() {

// Sorting change event
$(document).on("change","#orders",function(){

    var request = $.ajax({
        method: "POST",
        url: $('#ajax-swap-link').val(),
        data: { orders: this.value}
    });

    request.done(function(msg) {
        if(msg == 'OK')
        {
            ajaxRefreshTable();
        }
    });

    request.fail(function(jqXHR,textStatus) {
        alert( "Request failed: " + textStatus);
    });

	return false;
});

// Table reloaded event
$(document).find('.sortable').change(function(){
    $.enable_handlers();
});

// Delete menu label event
$(document).on("click", ".delete", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		var link = "_handles/popup-confirm.html#"+data_id;
		$.popup({"url":link});
		$.popup.show();
		return false;
	});

// Delete menu label event
$(document).on("click", ".edit", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		$.popup("edit "+data_id+" ?");
		$.popup.show();
		return false;
	});

// move label up
$(document).on("click", ".go-up", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		console.log(data_id+" up");
		$(".sortable").load("_handles/main-menu.html", function() { $.enable_handlers(); });
		return false;
	});

$(document).on("click", ".go-down", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		console.log(data_id+" down");
		$(".sortable").load("_handles/main-menu.html", function() { $.enable_handlers(); });
		return false;
	});



});// end document ready


/**
 * Refresh table of menu items
 */
var ajaxRefreshTable = function()
{
    var request = $.ajax({url: $('#ajax-refresh-link').val()});

    request.done(function(data){
        $('.sortable').html(data).trigger('change');
    });
};