$(document).ready(function() {
    $(document).on("click", ".action-reset", function()
	{
		var prefix = $(this).data('prefix');
		var link = '/'+ prefix +'/admin/settings/AjaxResetPositionsConfirm';
	    $.ajax({ type: "post",url:link}).done(function(data){        
	        obj = jQuery.parseJSON(data);
			var html = obj.html;
			$.popup(html);
			$.popup.show();

	    });
	    return false;
	});
    /*
	$(document).on("click", ".reset-confirm",function(e)
	{
		var prefix = $(this).data('prefix');
		var link = '/'+ prefix +'/admin/settings/AjaxResetPositions';

		$.ajaxSetup({async:false});
	    $.ajax({ type: "post",url:link}).done(function(data){        
	        obj = jQuery.parseJSON(data);
	        var res=obj;
	        if(obj.error==1)
	        {
				e.preventDefault();	    
			}
	
	    }); 
		
	});
	*/
    
});