(function( $ ){
    $(".order").click(function()
    {
        alert('change order event');
    });
//delete popup
    $(".delete").click(function(e)
    {
        e.preventDefault();
        var item_id = $(this).attr("data-id");
        $.popup("Delete?");
        $.popup.show();
        return false;
    });
//add button
    $(".add").click(function(e)
    {
        $(".lightbox").fadeIn(300);
        return false;
    });
// cancel lightbox
    $("#cancel-label").click(function(e)
    {
        $(".lightbox").fadeOut(300);
        return false;
    });
})( jQuery );