(function( $ ){
    /*
     * Toggle all checkboxes
     */
    $('[id="checkall_products"]').each(function(){
        $(this).toggleAll();
    });


    /**
     * When clicked on delete button (in item)
     */
    $(".delete").click(function(e)
    {
        var href = $(this).attr('href');
        var message = $(this).data('message');
        var yesLabel = $(this).data('yes');
        var noLabel = $(this).data('no');

        e.preventDefault();
        $.dialogBoxEx({
            buttons: [
                {label:noLabel,click:function(){$.dialogBoxEx.hide();},classes:'button cancel'},
                {label:yesLabel,url:href,classes:'button confirm'}
            ],
            message: message
        });
        $.dialogBoxEx.show();

        return false;
    });

    /**
     * When clicked on "delete selected items" (in top)
     */
    $(".delete-all").click(function(e)
    {
        var href = $(this).attr('href');
        var message = $(this).data('message');
        var yesLabel = $(this).data('yes');
        var noLabel = $(this).data('no');

        e.preventDefault();
        $.dialogBoxEx({
            buttons: [
                {label:noLabel,click:function(){$.dialogBoxEx.hide();},classes:'button cancel'},
                {label:yesLabel,classes:'button confirm',click:function(){

                    var form_html = '<form style="display: none;" method="post" action="'+href+'">';

                    $(".del-all-cb:checked").each(function(key, value){
                        form_html += '<input type="checkbox" checked name="'+$(this).attr('name')+'">';
                    });

                    form_html += '</form>';

                    $(form_html).appendTo($(document.body)).submit();

                    return false;
                }}
            ],
            message: message
        });
        $.dialogBoxEx.show();

        return false;
    });

})( jQuery );