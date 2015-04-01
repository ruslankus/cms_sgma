$(document).ready(function() {

    //adding new registration (when selecting)
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

    // handle clicks delete buttons and move arrows
    $(document).on("click", ".delete, .move", function()
    {
        //register widget - action url
        var url = $(this).attr('href');

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

        return false;
    });

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