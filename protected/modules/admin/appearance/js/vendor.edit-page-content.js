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
    
    
     $(document).on('click', "#edit-more", function(){
        
        lngId = $('.lngId').val();
        pageId = $('.pageId').val();
        $('.inner-editor').html("<div class=\"loader\" style=\"display: block;\"></div>");
        getContent(pageId,lngId);
        
        $(document).find("#edit").ckeditor() // reattach editor to textarea after ajax load.done; 
        return false;
     });
     
     
     $(document).on("click", ".delete", function()
	{
		var link_id = $(this).data('id');
		if(typeof link_id !== "undefined")
		{
			var prefix = $(this).data('prefix');
			var page_id = $(this).data('page');
	        $.ajaxSetup({async:false});
	        var link = "/"+prefix+"/admin/pages/DelImageAjax/"+link_id;
	        console.log(this);
	        $.ajax({ type: "post",url:link,data:"page_id="+ page_id}).done(function(data){
	            obj = jQuery.parseJSON(data);
					var html = obj.html;
					$.popup(html);
					$.popup.show();
	        });
	        
		}
		
        return false;
	});
        
        
        
    $(".add-image").click(function(e)
    {
        
        var page_id = $(this).data('page');
        var prefix = $(this).data('prefix');
        var el_count = $(this).data('count');
        $block = $(".lightbox");
        $block.load('/'+ prefix +'/admin/pages/loadfiles/' + page_id,{el_count:el_count});
        console.log(page_id);
        $block.fadeIn(300);
        return false;
    });//end add button  
    
    
    
    $(document).on("click", ".cancel-images", function()
  	{
		$(".lightbox").fadeOut(300);
		return false;
	});//end cancel lightbox
    
    $(document).on("click", ":checkbox", function()
    {
        var el_count = 5 - $('#el_count').val();
        
        if(el_count >= $( "input:checked" ).length){
            return true;
        }else{
            return false;
        }
        
        
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