(function( $ ){

    $.preLoader = function()
    {
        this.show();
    };

    $.preLoader.show = function()
    {
        var body = $("body");
        var html = '<div id="pre-load-overlay" style="position: fixed; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.6); padding: 0; margin: 0; left: 0; top: 0"><div id="floatingCirclesG" style="position: absolute; left: 50%; right: 50%; top: 50%; bottom: 50%;"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div></div>';
        body.append(html);
//        $('#pre-load-overlay').hide().fadeIn();
    };

    $.preLoader.hide = function()
    {
        $('#pre-load-overlay').remove();
    }

})( jQuery );
