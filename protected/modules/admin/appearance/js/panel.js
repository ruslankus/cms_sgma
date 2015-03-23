(function( $ ){
/* Popup */
$(".add-label").click(function(e){
	e.preventDefault();
	console.log('made click');
	$("body").css({"overflow":"hidden"});
	$(".popup-box").fadeIn(300);
	$(".popup-box > .popup").animate({"margin-top":"80px"},300);
});
$(".popup-cancel").click(function(e){
	e.preventDefault();
	console.log('made click');
	$("body").css({"overflow":"auto"});
	$(".popup-box").fadeOut(300);
	$(".popup-box > .popup").animate({"margin-top":"65px"},300);
});
/* User options */
$(".wrapper > a.user").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".wrapper > .user-open").toggle("blind",300);
		
});
/* Language selection */
$(".wrapper > .langlist > a").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".wrapper > .langlist > ul").toggle("blind",300);
});
/* Checkbox */
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

$('[id^="checkall_"]').each(function(){
	$(this).toggleAll();
	});
/*
 * @param name - string
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
/* Sidebar */
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
/* Sidebar tree */
	$( '.root li' ).each( function() {
        if( $( this ).children( 'ul' ).length > 0 )
            $( this ).addClass( 'hasChild hasChildIndicator' );     
    });
	$( '.root li.hasChild' ).hover( function( ) { $( this ).addClass("jactive"); $( this ).children( 'ul' ).show( 'slide', 300 ); }, function( ) { $( this ).removeClass("jactive"); $( this ).children( 'ul' ).hide( 'slide', 300 ); });
/* */
/* Editor */
$(".editor > .tab-line > span").bind("click", function(e){
	$(this).addClass("active");
	$(this).siblings().removeClass("active");
	var tab_id = $(this).attr("data-for");
	var cont = $(".editor > .editor-content > div[data-content="+tab_id+"]");
	if(!cont.is(":visible"))
		cont.fadeIn(300);
	cont.siblings().hide();
});
/* Editor get default lang */
$("#editor_language_input").val($(".editor-language > li.active").attr("data-language"));
/* Editor language change */
$(".editor-language > li").click(function(e){
	e.preventDefault();
	if($(this).hasClass("active")) {
		$(".editor-language > li").each(function(){
			if (!$(this).hasClass("active"))
				$(this).toggle("blind",300);
		});
	} else {
		var lang_id = $(this).attr("data-language");
		console.log(lang_id);
		$("#editor_language_input").val(lang_id);
		$(this).addClass("active");
		$(this).siblings().removeClass("active");
		$(".editor-language > li").each(function(){
			if (!$(this).hasClass("active"))
				$(this).hide("blind",300);
		});
	}
});
})( jQuery );