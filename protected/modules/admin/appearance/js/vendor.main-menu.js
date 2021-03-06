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
$(document).on("table-update",".sortable",function(){
    $.enable_handlers();
});

// Delete menu label event
$(document).on("click", ".delete", function()
	{
        var href = $(this).attr('href');
        var message = $(this).data('message');
        var yesLabel = $(this).data('yes');
        var noLabel = $(this).data('no');

        $.dialogBoxEx({
            buttons: [

                //cancel button settings
                {label:noLabel,click:function(){$.dialogBoxEx.hide();},classes:'button cancel'},

                //confirm button settings
                {label:yesLabel,click:function(){
                    var request = $.ajax({url: href});
                    $.preLoader.show();
                    request.done(function(msg){
                        if(msg == 'OK')
                        {
                            $.dialogBoxEx.hide();
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

                    return false;

                },classes:'button confirm'}

            ],
            message: message
        });

        $.dialogBoxEx.show();

		return false;
	});

// move label up
$(document).on("click", ".move-item", function()
	{
        var href = $(this).attr('href');
        var request = $.ajax({url: href});
        $.preLoader.show();
        request.done(function(msg){
            if(msg == 'OK')
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
        $('.sortable').html(data).trigger('table-update');
        $.preLoader.hide();
    });

    request.fail(function(jqXHR,textStatus) {
        alert( "Request failed: " + textStatus);
        $.preLoader.hide();
    });
};