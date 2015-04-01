$(document).ready(function() {
    
    
    //$("textarea").textarea({width : "100%"});
    //CKEDITOR.replace( 'name', {customConfig: 'config.js'});
    
    /*
     * Language onchange event
    */
    $(document).on('change',"#styled-language-editor",function()
    {
        pageId = $("#styled-language-editor option:selected").data("page");
        lngId = $(this).val();
        $('.inner-editor').html("<div class=\"loader\" style=\"display: block;\"></div>");
    	getContent(pageId,lngId);
        console.log(this);
        
    	$(document).find("#edit").ckeditor() // reattach editor to textarea after ajax load.done;	
        
        
    });
    
    
    // Undo event
    $(".undo").click(function(){
	
		console.log("undo");
		return false;
	});
    
    
    // On submit event
    $(document).on('submit', "#content-form", function()
	{
        $objForm = $('#content-form').serializeArray();
        console.log($(this).serializeArray());
        $('.inner-editor').html("<div class=\"loader\" style=\"display: block;\"></div>");
        saveContent($objForm);
        
        
        return false;
	});
    
    
});//document ready



function getContent(pageId,lngIg){
    console.log(pageId);
    $.ajaxSetup({async:false});
    $('.inner-editor').load('/en/admin/pages/editcontent/',{ pageId:pageId, lngId:lngId});
    
}//getContent


function saveContent($objForm){
    $.ajaxSetup({async:false});
    $('.inner-editor').load('/en/admin/pages/savecontent/',$objForm);  
    
    $(document).find("#edit").ckeditor() // reattach editor to textarea after ajax load.done;  
}