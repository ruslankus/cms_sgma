(function( $ ){

    $.dialogBoxEx = function(params)
    {
        if(!$('.popup-box').length){

            var randDialogIndex = Math.floor((Math.random() * 9999) + 1);

            var markup = [
                '<div class="popup-box">',
                '<div class="popup-content">',
                '</div></div>'
            ].join('');

            $(markup).hide().appendTo('body');

            if(typeof params.message !== 'undefined')
            {
                $(".popup-box > .popup-content").html('<span class="message">'+params.message+'</span>');
            }

            if (typeof params.buttons !== 'undefined' && params.buttons.length > 0)
            {
                for(var i = 0; i < params.buttons.length; i++)
                {
                    var button = params.buttons[i];

                    var label = typeof button.label !== 'undefined' ? button.label : '';
                    var click = typeof button.click !== 'undefined' ? button.click : function(){return true;};
                    var url = typeof button.url !== 'undefined' ? button.url : '#';
                    var id = 'added_button_'+i+'_'+randDialogIndex;
                    var classes = typeof button.classes !== 'undefined' ? button.classes : 'button confirm';

                    $(".popup-box > .popup-content").append('<a id="'+id+'" href="'+url+'" class="'+classes+'">'+label+'</a>');
                    $('#'+id).click(click);
                }
            }
        }
        return true;
    };

    $.dialogBoxEx.show = function(){
        $("body").css({"overflow":"hidden"});
        $('.popup-box').fadeIn();
        var top = ($(window).height()-$(".popup-box > .popup-content").height())/2;
        $(".popup-box > .popup-content").animate({"margin-top":top+"px"},300);
    };

    $.dialogBoxEx.hide = function(){
        $('.popup-box').fadeOut(function(){
            $(this).remove();
            $("body").css({"overflow":"auto"});
        });
    };

})( jQuery );