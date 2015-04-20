$(document).ready(function() {

    /**
     * Switch between field languages
     */
    $(document).on('click','.lng-switcher',function(){
        var id = $(this).data('id');

        $(this).parent().find('.lng-switcher').removeClass('active');
        $(this).addClass('active');

        $(this).parent().parent().find('input').removeClass('active');
        $(this).parent().parent().find('#'+id).addClass('active');

        return false;
    });

    /**
     * Submit event
     */
    $(document).on('submit','.ajax-form-saving',function(){

        ajaxSubmit('.ajax-form-saving');

        return false;
    });

});

/**
 * Performs submit by ajax
 * @param formSelector
 */
function ajaxSubmit(formSelector)
{
    var params = {};
    var action = $(formSelector).attr('action');

    $(formSelector).find('input, textarea, select').each(function(index,element){
        params[$(element).attr('name')] = $(element).val();
    });

    $.preLoader.show();

    var request = $.ajax({
        method: "POST",
        url: action,
        data: params
    });

    request.done(function(msg) {
        $.preLoader.hide();
    });

    request.fail(function(jqXHR,textStatus) {
        alert( "Request failed: " + textStatus);
        $.preLoader.hide();
    });
}