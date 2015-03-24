(function( $ ){
/*
 * Toggle all checkboxs
*/
$('[id="checkall_products"]').each(function(){
	$(this).toggleAll();
	});
/*
 * Confirm alerts
*/
$('.delete-product').click(function(e)
{
	e.preventDefault();
	var data_id = $(this).attr('data-id');
    var elem = $(this).closest('.list-row');

    $.confirm({
		'message'	: 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
		'confirm'	: function() {
                        elem.fadeOut();
						console.log("#"+data_id+" deleted.");
						}
        });
});
$('.delete-all-products').click(function(e)
{
	e.preventDefault();
	var value = [];
	$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
			value[i] = $(this).val();
		});
	
    var elem = $(this).closest('.translate-row');

    $.confirm({
		'message'	: 'You are about this items <b>'+value+'</b>',
		'confirm'	: function() {
                        elem.fadeOut();
						console.log("#"+value+" deleted.");
						}
        });
});
})( jQuery );