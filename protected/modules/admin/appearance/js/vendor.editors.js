(function( $ ){
/* Editor */
$("textarea").textarea({width : "100%"});

$(".editor > .tab-line > span").bind("click", function(e){
	$(this).addClass("active");
	$(this).siblings().removeClass("active");
	var tab_id = $(this).attr("data-for");
	var cont = $(".editor > .editor-content > div[data-content="+tab_id+"]");
	if(!cont.is(":visible"))
		cont.fadeIn(300);
	cont.siblings().hide();
});

/* Language */
$("#styled-language-editor").select();

$("#styled-language-editor").on("change", function(){
	console.log(this.value);
});
})( jQuery );