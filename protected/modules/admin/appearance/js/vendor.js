(function($){
/*
 * User opened
*/
$(".wrapper > a.user").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".wrapper > .user-open").toggle("blind",300);
});//end user opened
/*
 * Main language list open
*/
$(".wrapper > .langlist > a").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".wrapper > .langlist > ul").toggle("blind",300);
});//end language list
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
	}//end toggle checkbox
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
});//end sidebar
/*
 * Sidebar tree
*/
$( '.root li' ).each( function() {
        if( $( this ).children( 'ul' ).length > 0 )
            $( this ).addClass( 'hasChild hasChildIndicator' );     
    });
	$( '.root li.hasChild' ).hover( function( ) { $( this ).addClass("jactive"); $( this ).children( 'ul' ).show( 'slide', 300 ); }, function( ) { $( this ).removeClass("jactive"); $( this ).find( 'ul' ).hide( 'slide', 300 ); });
//end sider tree
/*
 * Custom select box
*/
/*
 * Popup
*/
	$.popup = function(params){
        if(!$('.popup-box').length){
            var markup = [
            '<div class="popup-box">',
            '<div class="popup-content">',
            '</div></div>'
			].join('');
			$(markup).hide().appendTo('body');
        }
		if($.type(params) !== "object")
		{
			$(".popup-box > .popup-content").html(params);
		}
		else
		{
			if (typeof params.url !== 'undefined') { $(".popup-box > .popup-content").load(params.url, function(){$('.popup-box > .popup-content').append('<a class="popup-close" href="#"></a>');if(params.show==true){$.popup.onshow();}}); }
			else if (typeof params.html !== 'undefined') { $(".popup-box > .popup-content").html(params.html);if(params.show==true){$.popup.onshow();}}
			else { $(".popup-box > .popup-content").html("Parameters empty.");}
		}
		$('.popup-box > .popup-content').append('<a class="popup-close" href="#"></a>');
		return true;
    }
	$.popup.show = function(){
		$("body").css({"overflow":"hidden"});
		$('.popup-box').fadeIn();
		var top = ($(window).height())/2-$(".popup-box > .popup-content").height() - 150;
		$(".popup-box > .popup-content").animate({"margin-top":top+"px"},300);
	}
	$.popup.onshow = function(){
		$("body").css({"overflow":"hidden"});
		$('.popup-box').fadeIn();
		var top = ($(window).height())/2-$(".popup-box > .popup-content").height();
		$(".popup-box > .popup-content").animate({"margin-top":top+"px"},300);
	}
	$.popup.hide = function(){
        $('.popup-box').fadeOut(function(){
            $(this).remove();
			$("body").css({"overflow":"auto"});
        });
	}//end popup functions
//popup disable on ESC
$(document).keyup(function(e) {
  if (e.keyCode == 27)
	  {
		$.popup.hide();
	  }
});//end popup disable on ESC
//popup disable on click
$(document).on("click", ".popup-content .cancel",function(e){
	e.preventDefault();
	$.popup.hide();
});
$(document).on("click", ".popup-content .popup-close",function(e){
	e.preventDefault();
	$.popup.hide();
});//end popup disable on click
/*
 * File upload input
*/
$.fileUploadInput = function()
{
	var $input = $(document).find("input[type=file]");
	$input.each(function(){
		var $this = $(this);
		var label = $("<span/>",{"class":"file"}).html($input.attr("data-label")).prependTo($this.parent());
		var input = $("<input/>",{"class":"file","type":"text","id":$input.attr("id")}).prependTo($this.parent());
		$this.css({"position":"absolute","top":"-99999px"});
		input.on("click",function() { $this.click(); });
		label.on("click",function() { $this.click(); });
		$this.on("change", function() { input.val($this.val().split('\\').pop()); });
	})
};//end file upload input
$.fileUploadInput();
})(jQuery);