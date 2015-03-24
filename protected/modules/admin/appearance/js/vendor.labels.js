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
	var prefix = $(this).data('prefix');
	var link = '/'+ prefix +'/admin/Translation/AddAdminLabel';
    $.ajax({ type: "post",url:link}).done(function(data){
        
        obj = jQuery.parseJSON(data);
        var html = obj.html;
        $.popup(html);
        $.popup.show();
        return false;   
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
	$.popup("čia html delete");
	$.popup.show();
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


$(document).on('click','.button.add-popup',function(e){
	
	var value = $('#label-input').val();
	var prefix = $(this).data('prefix');
    var link = '/'+ prefix +'/admin/Translation/UniqueCeckAdminLabel';
    $.ajaxSetup({async:false});
    $.ajax({ type: "post",url:link,data:{label:value}}).done(function(data){
        
        obj = jQuery.parseJSON(data);

        if(obj.status=="success")
        {        

        }
       
        if(obj.status=="error")
        {
           console.log(obj);
           $('.add-label-err').html(obj.err_txt);
           e.preventDefault();
            
        }
       
    });
       

});

})( jQuery );