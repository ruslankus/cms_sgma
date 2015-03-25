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
/*
$('.add-label').click(function(e)
{
	e.preventDefault();
	
    $.input({
		'placeholder'	: 'Label name',
		'validate'	: function() {
							if (this.value.length<3) { return "Name is too short"; }
							else if (this.value.length>20) { return "Name is too long"; }
							return true;
						},
		'confirmed'	: function() {
						console.log("#"+this.value+" created.");
						}
        });
});*/
$('.add-label').click(function(e)
{
	e.preventDefault();
	var prefix = $(this).data('prefix');
	var link = '/'+ prefix +'/admin/Translation/AddAdminLabel';
    $.ajax({ type: "post",url:link}).done(function(data){
        
        obj = jQuery.parseJSON(data);

		var html = obj.html;
		$.popup(html);
		$.popup.show();

    });
});

    
 $(document).on('click','.add-label-popup',function(e){
     var prefix = $(this).data('prefix');
     var value = $('#label-popup').val();
     var link = '/'+ prefix +'/admin/Translation/UniqueCeckAdminLabel';
    $.ajaxSetup({async:false});
    $.ajax({ type: "post",url:link,data:{label:value}}).done(function(data){
        
        obj = jQuery.parseJSON(data);

        if(obj.status=="success")
        {        

        }
       
        if(obj.status=="error")
        {
           $('.add-label-err').html(obj.err_txt);

           e.preventDefault();
            
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
$('#search-label-form').submit(function(e)
{
	value = $(this).children("input[type=text]").val();
	console.log(value);
	e.preventDefault();
	return false;
});
})( jQuery );