(function( $ ){
/*
 * Toggle all checkboxs
*/
$('[id="checkall_region"]').each(function(){
	$(this).toggleAll();
	});
$('[id="checkall_offers"]').each(function(){
	$(this).toggleAll();
	});
/*
 * Confirm alerts
*/
$('.delete-region').click(function(e)
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
$('.delete-all-regions').click(function(e)
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
$('.delete-offer').click(function(e)
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
$('.delete-all-offers').click(function(e)
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