$(document).ready(function() {
    
    
    //$("textarea").textarea({width : "100%"});
    
    /*
     * Language onchange event
    */
    $("#styled-language-editor").on('change',function(){
        pageId = $("#styled-language-editor option:selected").data("page");
        lngId = $(this).val();
    	getContent(pageId,lngId);
        console.log(this);
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



function getContent(pageId,lngIg){
    console.log(pageId);
   $.ajaxSetup({async:false});
   $('.inner-editor').load('/en/admin/contacts/editcontent/',{ pageId:pageId, lngId:lngId});
    
}//getContent