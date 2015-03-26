$(document).ready(function() {

// Sorting change event
$(document).on("change","#swapped-ids",function(){

    //TODO: Ajax reloading of all table
	console.log("swapped "+this.value);

	return false;
});

// Delete menu label event
$(document).on("click", ".delete", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		var link = "_handles/popup-confirm.html#"+data_id;
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
		$(".sortable").load("_handles/main-menu.html", function() { $.enable_handlers(); });
		return false;
	});

$(document).on("click", ".go-down", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		console.log(data_id+" down");
		$(".sortable").load("_handles/main-menu.html", function() { $.enable_handlers(); });
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