$(document).ready(function() {

    // On submit event
    $(document).on('submit', ".main-form-trl", function()
	{
        //fields of form
        var fields = {};
        //action url
        var url = $(this).attr('action');

        //fill array of fields
        $(this).find('input, textarea').each(function(){
            if($(this).attr('name') != undefined)
            {
                fields[$(this).attr('name')] = $(this).val();
            }
        });

        //show pre-loader
        $.preLoader.show();

        //send form-data to action
        var request = $.ajax({
            url: url,
            data: fields,
            method: 'POST'
        });

        //if success
        request.done(function(data){
            $(".table-of-trl").html(data);
            $.preLoader.hide();
            $('.notification').css({visibility:'hidden'});
        });

        //if failed
        request.fail(function(jqXHR,textStatus) {
            alert( "Request failed: " + textStatus);
            $.preLoader.hide();
        });

        return false;
	});

    // When changing content
    $(document).on('keypress','input, textarea',function(){
        $('.notification').css({visibility:'visible'});
    });

    // Changing language
    $(document).on('change','#styled-language-editor',function(){

        var url = $(this).val();

        //show pre-loader
        $.preLoader.show();

        //reload content
        var request = $.ajax({url: url});

        //if success
        request.done(function(data){
            $(".table-of-trl").html(data);
            $.preLoader.hide();
            $('.notification').css({visibility:'hidden'});
        });

        //if failed
        request.fail(function(jqXHR,textStatus) {
            alert( "Request failed: " + textStatus);
            $.preLoader.hide();
        });
    });

});//document ready