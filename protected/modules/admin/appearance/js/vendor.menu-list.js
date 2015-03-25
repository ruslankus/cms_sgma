(function( $ ){
$(".order").click(function()
	{
		alert('change order event');
	});
//delete popup
$(".delete").click(function(e)
	{
		e.preventDefault();
		var item_id = $(this).attr("data-id");
		$.popup("Delete?");
		$.popup.show();
		return false;
	});
//add button
$(".add").click(function(e)
	{
		e.preventDefault();
		$.popup({"url":"handle.html"});
		$.popup.show();
		return false;
	});
// for popup confirm
$(document).on("click", ".unique-class-name", function(e){
	e.preventDefault();
	console.log("ok");
	return false;
});
// for input submits
$(document).on("submit", ".unique-class-name", function(e){
	e.preventDefault();
	console.log("ok");
	return false;
});
})( jQuery );