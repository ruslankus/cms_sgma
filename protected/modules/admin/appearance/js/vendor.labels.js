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
	var prefix = $(this).data('prefix');
	var labelId = $(this).data('id');
	var labelName = $(this).data('label');
	var link = '/'+ prefix +'/admin/Translation/DelAdminLabel';
    $.ajax({ type: "post",url:link,data:{id : labelId, name: labelName}}).done(function(data){        
        obj = jQuery.parseJSON(data);
		var html = obj.html;
		$.popup(html);
		$.popup.show();

    });
});


/*
 * Save
*/
$('.save').click(function(e)
{
	e.preventDefault();
	var id = $(this).data('id');
	var prefix = $(this).data('prefix');
	var value = $("#tr-"+id).val();
	var link = '/'+ prefix +'/admin/Translation/SaveAdminLabel/'+id;
    $.ajax({ type: "post",url:link,data:{value:value}}).done(function(data){        

    });
	
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