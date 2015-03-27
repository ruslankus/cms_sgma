(function($){
/*
 * User opened
*/
$(".wrapper > a.user").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".wrapper > .user-open").toggle("blind",300);
		
});
/*
 * Main language list open
*/
$(".wrapper > .langlist > a").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".wrapper > .langlist > ul").toggle("blind",300);
});
/*
 * Toggle all checkboxes
*/
$.fn.toggleAll = function() {
	var checkbox = this;
	this.change(function() {
		if(checkbox.is(':checked'))
			checkbox.parent().parent().parent().find(".cell.checkbox > input[type=checkbox]").prop("checked", true);
		else
			checkbox.parent().parent().parent().find(".cell.checkbox > input[type=checkbox]").prop("checked", false);
	});
	//this.prop('checked', true);
}
/*
 * Sidebar
*/
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
if (getCookie("inluMenu") == "minimazed")
	{
		$(".wrapper > .menu").addClass("minimized");
		$(".wrapper > .menu > .bar.d").hide();
		$(".wrapper > .logo").hide();
		if(!$("aside").hasClass("minimized"))
			$("aside").addClass("minimized");
	}
$(".wrapper > .menu").click(function(e){
	e.preventDefault();
	$(this).children(".bar.d").fadeToggle(300);
	$(this).parent().children(".logo").fadeToggle(300);
	if($(this).hasClass("minimized"))
		{
			$("aside").animate({"width":"202px"}, 300);
			$(this).removeClass("minimized");
			$("aside > ul.root > li > a").each(function() {
				$(this).children("span").delay(200).fadeIn(100);
				if($(this).parent().hasClass("hasChild"))
					$( this ).parent().addClass( 'hasChildIndicator' ); 
			});
			document.cookie="inluMenu=maximazed; path=/"; // Write menu status to cookie.
		}
	else
		{
			$("aside").animate({"width":"51px"}, 300);
			$(this).addClass("minimized");
			$("aside > ul.root > li > a").each(function() {
				$(this).children("span").fadeOut(100);
				if($(this).parent().hasClass("hasChild"))
					$( this ).parent().removeClass( 'hasChildIndicator' ); 
			});
			document.cookie="inluMenu=minimazed; path=/"; // Write menu status to cookie.
		}	
});
/*
 * Sidebar tree
*/
$( '.root li' ).each( function() {
        if( $( this ).children( 'ul' ).length > 0 )
            $( this ).addClass( 'hasChild hasChildIndicator' );     
    });
	$( '.root li.hasChild' ).hover( function( ) { $( this ).addClass("jactive"); $( this ).children( 'ul' ).show( 'slide', 300 ); }, function( ) { $( this ).removeClass("jactive"); $( this ).find( 'ul' ).hide( 'slide', 300 ); });



/*
 * Custom confirm box
*/
$.confirm = function(params){

        if($('.popup-box').length){
            return false;
        }
		
        var markup = [
            '<div class="popup-box">',
            '<div class="popup-confirm" id="popup-content">',
            '<span class="message">',params.message,'</span>',
			'<a href="#" class="button cancel">Cancel</a>',
			'<a href="#" class="button confirm">Confirm</a>',
			'<div class="clearfix"></div>',
            '</div></div></div>'
        ].join('');

        $(markup).hide().appendTo('body').fadeIn();
		$("body").css({"overflow":"hidden"});
		$(".popup-box > .popup-confirm").animate({"margin-top":"80px"},300);
		
		$(".popup-box > .popup-confirm > .confirm").click(function(e){
			e.preventDefault();
			params.confirm();
            $.confirm.hide();
            return false;
		});
		$(".popup-box > .popup-confirm > .cancel").click(function(e){
			e.preventDefault();
            $.confirm.hide();
            return false;
		});
		
    }
/*
 * Custom confirm box
*/
$.input = function(params){

        if($('.popup-box').length){
            return false;
        }
		var $this = this;
        var markup = [
            '<div class="popup-box">',
            '<div class="popup-input" id="popup-content">',
            '<input type="text" value="" id="popup-input-value" placeholder="',params.placeholder,'"/>',
            '<span class="errorMessage"></span>',
			'<a href="#" class="button cancel">Cancel</a>',
			'<a href="#" class="button confirm">Confirm</a>',
			'<div class="clearfix"></div>',
            '</div></div></div>'
        ].join('');

        $(markup).hide().appendTo('body').fadeIn();
		$("body").css({"overflow":"hidden"});
		$(".popup-box > .popup-input").animate({"margin-top":"80px"},300);
		
		$(".popup-box > .popup-input > .confirm").click(function(e){
			params.value = $(".popup-box > .popup-input > #popup-input-value").val();
			e.preventDefault();
			var validates = params.validate();
			if ( validates !== true) { $(".popup-box > .popup-input > .errorMessage").html(validates); }
			else { params.confirmed();  $.confirm.hide(); }
            return false;
		});
		$(".popup-box > .popup-input > .cancel").click(function(e){
			e.preventDefault();
            $.confirm.hide();
            return false;
		});
		
    }
/* Popup */
$.popup = function(params){
        if(!$('.popup-box').length){
            var markup = [
            '<div class="popup-box">',
            '<div class="popup-content">',
            '</div></div>'
			].join('');
			$(markup).hide().appendTo('body');
        }
		if (typeof params.url !== 'undefined') { $(".popup-box > .popup-content").load(params.url); }
		else { $(".popup-box > .popup-content").html(params); }
		return true;
    }
	$.popup.show = function(){
		$("body").css({"overflow":"hidden"});
		$('.popup-box').fadeIn();
		var top = ($(window).height()-$(".popup-box > .popup-content").height())/2;
		$(".popup-box > .popup-content").animate({"margin-top":top+"px"},300);
	}
	$.popup.hide = function(){
        $('.popup-box').fadeOut(function(){
            $(this).remove();
			$("body").css({"overflow":"auto"});
        });
	}
    $.confirm.hide = function(){
        $('.popup-box').fadeOut(function(){
            $(this).remove();
			$("body").css({"overflow":"auto"});
        });
    }
$(document).keyup(function(e) {
  if (e.keyCode == 27)
	  {
		$.confirm.hide();
	  }
});
$(document).on("click", ".popup-content a.cancel",function(e){
	e.preventDefault();
	$.popup.hide();
});
})(jQuery);