$(document).ready(function() {
// Add to main menu
$(".add").click(function()
	{
		
		return false;
	});
// Sorting change event
$(document).on("change","#sortable-order",function(){
	console.log("new order "+this.value);
	return false;
});
// Delete menu label event
$(document).on("click", ".delete", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		var link = "handle.html#"+data_id;
		$.popup({"url":link});
		$.popup.show();
		return false;
	});
// Delete menu label event
$(document).on("click", ".edit", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		$.popup("edit "+data_id+" ?");
		$.popup.show();
		return false;
	});
// move label up
$(document).on("click", ".go-up", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		console.log(data_id+" up");
		$(".sortable").load("test-tree.html", function() { $.enable_handlers(); });
		return false;
	});	
$(document).on("click", ".go-down", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		console.log(data_id+" down");
		$(".sortable").load("test-tree.html");
		return false;
	});
// for popup confirm
$(document).on("click", ".unique-class-name", function(){
	console.log("ok");
	return false;
});
// for input submits
$(document).on("submit", ".unique-class-name", function(){
	console.log("ok");
	return false;
});
});