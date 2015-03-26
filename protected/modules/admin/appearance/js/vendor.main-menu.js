$(document).ready(function() {

// Sorting change event
$(document).on("change","#swapped-ids",function(){

    var lnk = $("#ajax-swap-link").val();


    $.ajax({
        method:'POST',
        url:lnk,
        data: {'orders':$(this).val()},
        context: document.body
    }).done(
        function(data)
        {
            if(data == 'OK')
            {
                //refresh
                ajaxRefresh();
            }
        }
    );

	return false;
});

// Delete menu label event
$(document).on("click", ".delete", function()
	{
        //e.preventDefault();
		var popup_link = $(this).data('popup');
        var href = $(this).attr('href');

		$.popup({"url":popup_link});
		$.popup.show();
		return false;
	});


// move label up
$(document).on("click", ".go-up", function()
	{
        var href = $(this).attr('href');
        //TODO: Ajax reloading of all table
        alert(href);
        return false;
	});

$(document).on("click", ".go-down", function()
	{
        var href = $(this).attr('href');
        //TODO: Ajax reloading of all table
        alert(href);
        return false;
	});

// for popup confirm
$(document).on("click", ".unique-class-name", function(){

    //get deleting url
    var href = $(this).attr('href');

    //delete by ajax
    $.ajax({
        url: href,
        context: document.body
    }).done(
        function(data)
        {
            //if returned ok
            if(data == 'OK')
            {
                //refresh
                ajaxRefresh();
            }
        }
    );

    //hide popup
    $.popup.hide();

	return false;
});

// for input submits
$(document).on("submit", ".unique-class-name", function(){
	console.log("ok");
	return false;
});

});


/**
 * Refresh list of items by ajax
 */
var ajaxRefresh = function()
{
    $.ajax({
        url: $("#ajax-refresh-link").val(),
        context: document.body
    }).done(
        function(data)
        {
            jQuery('.sortable').html(data).trigger('change');
        }
    );
};