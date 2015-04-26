$(document).ready(function() {
    
    
    $("#edit").ckeditor();
    
    /*
     * Language onchange event
    */
    $("#styled-language-editor").on('change',function(){
        var prefix = $('#prefix').val();
        var fieldId = $('#field_id').val();
        var lngPrefix = $(this).val();
        console.log(this)
        getLangValues(fieldId,lngPrefix,prefix);
      
        //$(document).find("textarea").textarea({width : "100%"}); // reattach editor to textarea after ajax load.done; 
    });
    // Undo event
    $(".undo").click(function(){
    
        console.log("undo");
        return false;
    });
    
    
     $(document).on('click','#edit-more',function(){
      
        var prefix = $('#prefix').val();
        var fieldId = $('#field_id').val();
        var lngPrefix = $("#styled-language-editor").val();
        $('.inner-editor').html("<div class=\"loader\" style=\"display: block;\"></div>");
        getLangValues(fieldId,lngPrefix,prefix);
        
     });
    


    // On submit event
    $(document).on('click',"#save-data", function()
    {
        $objForm = $('#content-form').serializeArray();
        var fieldId =  $('#field_id').val();
        var prefix = $('#prefix').val();
       
        $('.inner-editor').html("<div class=\"loader\" style=\"display: block;\"></div>");
        saveFieldValues($objForm,fieldId,prefix);


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



function getLangValues(fieldId,lngPrefix,prefix){
   var name = '';
   var value = '';
   $.ajaxSetup({async:false});
   var link = "/"+prefix+"/admin/contacts/editfield/"+fieldId;
   $('.inner-content').load(link,{lngPrefix:lngPrefix});
    
}//getContent


function saveFieldValues($objPost,fieldId,prefix){
    
    
    var link = "/"+prefix+"/admin/contacts/EditContactFieldAjax/"+fieldId;
    $('.inner-content').load(link,$objPost);
}