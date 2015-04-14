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
        $console.log(this);
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
   var name = '';
   var value = '';
   $.ajaxSetup({async:false});
   var link = "/"+prefix+"/admin/contacts/EditContentAjax/"+pageId;
    $.ajax({ type: "post",url:link,data:{lngId:lngId}}).done(function(data){
        obj = jQuery.parseJSON(data);
        if(obj.name)
        {
            name = obj.name; 
        }
        if(obj.value)
        {
            value = obj.value; 
        }
        $('#name').val(name);
        $('#value').val(value);

        console.log(obj);

    });    
}//getContent