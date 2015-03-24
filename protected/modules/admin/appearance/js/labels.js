(function( $ ){
/* Popup */
$(".add-label").click(function(e){
	e.preventDefault();
	$("body").css({"overflow":"hidden"});
	$(".popup-box").fadeIn(300);
	$(".popup-box > .popup-input").fadeIn(300).animate({"margin-top":"80px"},300);
	return false;
});
$(".action.delete").click(function(e){
	e.preventDefault();
	var object_id = $(this).attr("data-actfor");
	$(".popup-box > .popup-confirm .message > #object").html(object_id);
	$("body").css({"overflow":"hidden"});
	
	$(".popup-box").fadeIn(300);
	$(".popup-box > .popup-confirm").fadeIn(300).animate({"margin-top":"80px"},300);
	return false;
});

/*-- cancel for all popups --*/
$(".popup-cancel").click(function(e){
	e.preventDefault();
	console.log('made click');
	$("body").css({"overflow":"auto"});
	$(".popup-box").fadeOut(300);
	$(".popup-box > .popup-input").animate({"margin-top":"65px"},300).fadeOut(300);
	$(".popup-box > .popup-confirm").animate({"margin-top":"65px"},300).fadeOut(300);
});
$(document).keyup(function(e) {
  if (e.keyCode == 27)
	  {
		console.log('made click');
		$("body").css({"overflow":"auto"});
		$(".popup-box").fadeOut(300);
		$(".popup-box > .popup-input").animate({"margin-top":"65px"},300).fadeOut(300);
		$(".popup-box > .popup-confirm").animate({"margin-top":"65px"},300).fadeOut(300);
	  }
});

/* Language */
$("#styled-language").select();

$("#styled-language").on("change", function(){
	console.log(this.value);
});

/* search */

$('.search-label-button').click(function(e){
	alert('search');
	return false;
});


})( jQuery );