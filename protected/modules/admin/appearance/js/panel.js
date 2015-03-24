(function( $ ){
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
	$( '.root li.hasChild' ).hover( function( ) { $( this ).addClass("jactive"); $( this ).children( 'ul' ).show( 'slide', 300 ); }, function( ) { $( this ).removeClass("jactive"); $( this ).find( 'ul' ).hide( 'slide', 300 ); });
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

/* custom select */
$.fn.select = function()
	{
		var $this = this;
		var wrapper = $("<div></div>",{class:"wrap-select"});
		wrapper.addClass($this.attr("class"));
		wrapper.insertBefore($this);
		var container = $("<ul>",{class:"select"}).appendTo(wrapper);
		var default_find = false;
		$this.hide();
		$this.children("option").each(function(i)
		{
			var item = $("<li>"+$(this).html()+"</li>").css({"background-image":"url("+$(this).attr("data-image")+")"}).attr("value",$(this).val()).appendTo(container);
			if ($(this).attr("selected") == "selected") { item.addClass("selected"); default_find = true; }
		});
		if (default_find == false) { container.find("li:first").addClass("selected"); }
		
		container.find("li").click(function(){
			if ($(this).hasClass("selected"))
			{
				container.find("li").each(function()
					{
						if (!$(this).hasClass("selected"))
							$(this).toggle("blind",300);
					});
			}
			else {
				$this.val($(this).attr("value")).trigger("change");
				$(this).addClass("selected");
				$(this).siblings().removeClass("selected");
				container.find("li").each(function()
					{
						if (!$(this).hasClass("selected"))
							$(this).hide("blind",300);
					});
			}
		});
	}
/* Language */
$("#styled-language-editor").select();

$("#styled-language-editor").on("change", function(){
	console.log(this.value);
});
})( jQuery );