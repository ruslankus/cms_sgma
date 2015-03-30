(function( $ ){

    $.preLoader = function()
    {
        this.show();
    };

    $.preLoader.show = function()
    {
        var body = $("body");
        var html = '<div id="pre-load-overlay"><div id="floatingCirclesG"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div></div>';
        body.append(html);
//        $('#pre-load-overlay').hide().fadeIn();
    };

    $.preLoader.hide = function()
    {
        $('#pre-load-overlay').remove();
    }

})( jQuery );
