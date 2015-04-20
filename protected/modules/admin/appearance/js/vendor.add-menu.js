$(document).ready(function() {
// Add to main menu
    $(".menu-content > .tab-line > span").bind("click", function(e){
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
        var tab_id = $(this).attr("data-lang");
        var cont = $(".menu-content > .inner-content .tabs table[data-tab="+tab_id+"]");
        if(!cont.is(":visible"))
            cont.fadeIn(300);
        cont.siblings().hide();
    });

    $(".del").click(function()
    {
        var href = $(this).attr('href');
        var message = $(this).data('message');
        var yesLabel = $(this).data('yes');
        var noLabel = $(this).data('no');

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

    /*
    $(document).on("click", ".delete", function()
    {
        if ($(this).hasClass("active"))
        {
            var data_id = $(this).attr("data-id");
            var link = "_handles/popup-confirm.html";
            $.popup({"url":link});
            $.popup.show();
        }
        return false;
    });
    */
    
});
