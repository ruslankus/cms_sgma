(function( $ ){
    $(".order").click(function()
    {
        alert('change order event');
    });
//delete popup
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
//add button
    $(".add").click(function(e)
    {
        $(".lightbox.add-box").fadeIn(300);
        return false;
    });
// cancel lightbox
    $("#cancel-label").click(function(e)
    {
        $(".lightbox").fadeOut(300);
        return false;
    });
})( jQuery );