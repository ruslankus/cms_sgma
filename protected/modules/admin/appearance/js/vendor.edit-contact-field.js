$(document).ready(function() {
    
    
    $("#edit").ckeditor();
    
    /*
     * Language onchange event
    */
    $("#styled-language-editor").on('change',function(){
        var prefix = $(this).data('prefix');
        var fieldId = $(this).data('field');
        var lngId = $(this).val();
        console.log(this)
        getLangValues(fieldId,lngId,prefix);
      
        //$(document).find("textarea").textarea({width : "100%"}); // reattach editor to textarea after ajax load.done; 
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



function getLangValues(fieldId,lngId,prefix){
   var name = '';
   var value = '';
   $.ajaxSetup({async:false});
   var link = "/"+prefix+"/admin/contacts/editfield/"+fieldId;
   $('.inner-content').load(link,{lngId:lngId});
    
}//getContent


function saveFieldValues($objPost,fieldId,prefix){
    
    
    var link = "/"+prefix+"/admin/contacts/EditContactFieldAjax/"+fieldId;
    $('.inner-content').load(link,$objPost);
}