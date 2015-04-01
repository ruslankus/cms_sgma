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
    
    
});//document ready



function getLangValues(pageId,lngId,prefix){
   $.ajaxSetup({async:false});
   var link = "/"+prefix+"/admin/contacts/EditContentAjax/"+pageId;
    $.ajax({ type: "post",url:link,data:{lngId:lngId}}).done(function(data){
        obj = jQuery.parseJSON(data);
        $('#title').val(obj.title);
        $('#edit').val(obj.text);
        $('#meta').val(obj.meta);
        console.log(obj);

    });    
}//getContent