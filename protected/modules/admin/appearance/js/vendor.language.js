(function( $ ){
/*
 * Language box
*/
$("#styled-language").select();

$("#styled-language").on("change", function(){
	console.log(this.value);
});
/*
 * Popup with input
*/
$('.add-label').click(function(e)
{
	e.preventDefault();
	
    $.input({
		'placeholder'	: 'Language',
		'validate'	: function() {
							if (this.value.length<3) { return "Name is too short"; }
							else if (this.value.length>20) { return "Name is too long"; }
							return true;
						},
		'confirmed'	: function() {
						console.log("#"+this.value+" created.");
						}
        });
});
/*
 * Confirm alerts
*/
$('.delete').click(function(e)
{
	e.preventDefault();
	var data_id = $(this).attr('data-id');
    var elem = $(this).closest('.translate-row');

    $.confirm({
		'message'	: 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
		'confirm'	: function() {
                        elem.fadeOut();
						console.log("#"+data_id+" deleted.");
						}
        });
});
/*
 * Save
*/
$('.save').click(function(e)
{
	var id = $(this).attr("data-id");
	var value = $(this).parent().parent().find(".translations > input").val();
	console.log(value);
	e.preventDefault();
	return false;
});
/*
 * Search submit
*/
$('#search-language-form').submit(function(e)
{
	value = $(this).children("input[type=text]").val();
	console.log(value);
	e.preventDefault();
	return false;
});
})( jQuery );