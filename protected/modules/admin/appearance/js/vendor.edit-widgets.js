$(document).ready(function() {
//undo button
$(".undo").click(function()
	{
		console.log("undo");
		return false;
	});//end undo button
//delete button
$(".del").click(function()
	{
		data_id = $(this).attr("data-id");
		console.log("delete"+data_id);
		return false;
	});//end delete button
// delete widget row
$(document).on("click", ".delete", function()
	{	
		data_id = $(this).attr("data-id");
		console.log("delete"+data_id);
		return false;
	});//end delete widget row
});//end ready