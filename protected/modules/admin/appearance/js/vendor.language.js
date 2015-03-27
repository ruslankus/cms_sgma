(function( $ ){
	/*
	 * Language box
	*/

	/*
	 * Popup with input
	*/ 

	$('.add-label').click(function(e)
	{
		e.preventDefault();
		var prefix = $(this).data('prefix');
		
		var link = '/'+ prefix +'/admin/Translation/AddAdminLanguageAjax';
	    $.ajax({ type: "post",url:link}).done(function(data){
	        
	        obj = jQuery.parseJSON(data);

			var html = obj.html;
			$.popup(html);
			$.popup.show();

	    });
		
	});

	    
	 $(document).on('click','.add-label-popup',function(e){
	     var prefix = $(this).data('prefix'); 
	     var lang_name = $('#label-popup').val();
		 var lang_prefix = $('#label-popup').val();
/*
	     var link = '/'+ prefix +'/admin/Translation/UniqueCeckAdminlanguageAjax';
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
*/	     
	    
	 });
	/*
	 * Confirm alerts
	*/
	$(document).on("click",".delete",function(e)
	{
		e.preventDefault();
		var prefix = $(this).data('prefix');
		var labelId = $(this).data('id');
		var labelName = $(this).data('label');
		var link = '/'+ prefix +'/admin/Translation/DelAdminLabelAjax';
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
	$(document).on("click",".save",function(e)
	{
		e.preventDefault();
		var id = $(this).data('id');
		var prefix = $(this).data('prefix');
		var value = $("#tr-"+id).val();
		var curr_lng = $('#styled-language').val;
		var link = '/'+ prefix +'/admin/Translation/SaveAdminLabelAjax/'+id;

	    $.ajax({ type: "post",url:link,data:{value:value}}).done(function(data){        

	    });

	});


    /**
     * When clicked on pagination page
     */
    $(document).on('click','.links-pages',function(e){
    	e.preventDefault();
    	var curr_page = $(this).data('page');
    	var search_val = $('#search_label').val();  
		var lng = $('#styled-language').val();
		var prefix = $(this).data('prefix');
		var link = '/'+ prefix +'/admin/Translation/AdminAjax';
		$(".translation-list").load(link,{lng : lng, search_val : search_val, curr_page:curr_page});

    });

})( jQuery );