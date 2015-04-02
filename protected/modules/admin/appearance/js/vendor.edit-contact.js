$(document).ready(function() {
    
    
    $("#edit").ckeditor();
    
    /*
     * Language onchange event
    */
    $("#styled-language-editor").on('change',function(){
        var prefix = $(this).data('prefix');
        var pageId = $(this).data("page");
        var lngId = $(this).val();
    	getLangValues(pageId,lngId,prefix);
      
    	//$(document).find("textarea").textarea({width : "100%"}); // reattach editor to textarea after ajax load.done;	
    });
    // Undo event
    $(".undo").click(function(){
	
		console.log("undo");
		return false;
	});
// On submit event

    $(document).on("click", "#save-content", function()
	{
		$console.log(this)
        return false;
	});
    
   
// delete img

    $(document).on("click", ".del-image", function()
    {
        var prefix = $(this).data('prefix');
        var id = $(this).data('id');
        $.ajaxSetup({async:false});
        var link = "/"+prefix+"/admin/contacts/DelImageAjax/"+id;
        $.ajax({ type: "post",url:link}).done(function(data){
            obj = jQuery.parseJSON(data);
            if(obj.status=="deleted"){
                $('.contact-img').hide();
            }
        });
        return false;
    });

});//document ready



function getLangValues(pageId,lngId,prefix){
   var title = '';
   var text = '';
   var meta = '';
   $.ajaxSetup({async:false});
   var link = "/"+prefix+"/admin/contacts/EditContentAjax/"+pageId;
    $.ajax({ type: "post",url:link,data:{lngId:lngId}}).done(function(data){
        obj = jQuery.parseJSON(data);
        if(obj.title)
        {
            title = obj.title; 
        }
        if(obj.text)
        {
            text = obj.text; 
        }
        if(obj.meta)
        {
            meta = obj.meta; 
        }

        $('#title').val(title);
        $('#edit').val(text);
        $('#meta').val(meta);

        if(obj.image)
        {
            $('.contact-img img').attr("src",obj.image.src);
            $('.del-image').data('id',obj.image.id);
            $('.contact-img').show();
        }
        else
        {
            $('.contact-img').hide();
        }

        console.log(obj);

    });    
}//getContent