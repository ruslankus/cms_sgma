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
		
		var link = '/'+ prefix +'/admin/TranslationSite/AddAdminLanguageAjax';
	    $.ajax({ type: "post",url:link}).done(function(data){
	        
	        obj = jQuery.parseJSON(data);

			var html = obj.html;
			$.popup(html);
			$.popup.show();

	    });
		
	});

	    
	 $(document).on('click','.add-label-popup',function(e){
	     var prefix = $(this).data('prefix'); 
	     var lang_name = $('#label_name').val();
		 var lang_prefix = $('#label_prefix').val();
		 console.log('prefix = '+prefix+' name = '+lang_name+' lang_prefix = '+lang_prefix);
	     var link = '/'+ prefix +'/admin/TranslationSite/UniqueCeckAdminlanguageAjax';
	    $.ajaxSetup({async:false});
	    $.ajax({ type: "post",url:link,data:{lang_name:lang_name,lang_prefix:lang_prefix}}).done(function(data){
	        
	        obj = jQuery.parseJSON(data);

	        if(obj.status=="success")
	        {        

	        }
	       
	        if(obj.status=="error")
	        {
	        	if(obj.err_name_txt)
	        	{
	        		$('.add-lang-name-err').html(obj.err_name_txt);
	        	} 
	        	else
	        	{
	        		$('.add-lang-name-err').html('');
	        	}

	        	if(obj.err_prefix_txt)
	        	{
	        		$('.add-lang-prefix-err').html(obj.err_prefix_txt);
	        	}
	        	else
	        	{
	        		$('.add-lang-prefix-err').html('');
	        	}

	           e.preventDefault();
	            
	        }
	       
	    });    
	    
	 });
	/*
	 * Confirm alerts
	*/
	$(document).on("click",".delete",function(e)
	{
		e.preventDefault();
		var prefix = $(this).data('prefix');
		var langId = $(this).data('id');
		var lang_name = $("#lang-"+langId+" input[name='lang_name']").val();
		var link = '/'+ prefix +'/admin/TranslationSite/DelAdminLanguageAjax/'+langId;
	    $.ajax({ type: "post",url:link,data:{lang_name : lang_name}}).done(function(data){        
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
		var lang_name = $("#lang-"+id+" input[name='lang_name']").val();
		var lang_prefix = $("#lang-"+id+" input[name='lang_prefix']").val();
		var link = '/'+ prefix +'/admin/TranslationSite/SaveAdminLanguageAjax/'+id;
	    $.ajaxSetup({async:false});
	    $.ajax({ type: "post",url:link,data:{lang_name:lang_name,lang_prefix:lang_prefix}}).done(function(data){
	        
	        obj = jQuery.parseJSON(data);

	       
	        if(obj.save==false)
	        {
	        
	        	$("#lang-"+id+" .errorMessage").html(obj.err_txt);
	        	$("#lang-"+id+" .errorMessage").show();
	        }
	        else
	        {
	        	$("#lang-"+id+" .errorMessage").hide();
	        	$("#lang-"+id+" input").attr('disabled',true);

	        }
	       
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
		var link = '/'+ prefix +'/admin/TranslationSite/AdminAjax';
		$(".translation-list").load(link,{lng : lng, search_val : search_val, curr_page:curr_page});

    });

	$(document).on("click",".edit",function(e)
	{
		$('.translate-row input').attr('disabled',true);
		var id = $(this).data('id');
		$("#lang-"+id+" input").removeAttr('disabled');

	});
})( jQuery );