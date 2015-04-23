$(document).ready(function() {

    $(document).on("click", ".delete", function()
	{
		var image_id = $(this).data('id');
		if(typeof image_id !== "undefined")
		{
			var prefix = $(this).data('prefix');
			var contact_id = $(this).data('contact_id');
	        $.ajaxSetup({async:false});
	        var link = "/"+prefix+"/admin/contacts/DelImageAjax/"+image_id;
	        
	        $.ajax({ type: "post",url:link,data:{contact_id:contact_id}}).done(function(data){
	            obj = jQuery.parseJSON(data);
					var html = obj.html;
					$.popup(html);
					$.popup.show();
	        });
	        
		}
		console.log(this);
        return false;
	});
    
    
    
     $(".add-image").click(function(e)
    {
        
        var page_id = $(this).data('page');
        var prefix = $(this).data('prefix');
        
        $block = $(".lightbox");
        $block.load('/'+ prefix +'/admin/contacts/addlocalimage/' + page_id);
        console.log(page_id);
        $block.fadeIn(300);
        return false;
    });//end add button  
    
    
    
    $(document).on("click", ":checkbox", function()
    {
        if( 1  >= $( "input:checked" ).length){
            return true;
        }else{
            return false;
        }
        
        
    });
    
        $(document).on("click", ".cancel-images", function()
  	{
		$(".lightbox").fadeOut(300);
		return false;
	});//end cancel lightbox
    
    
    
});