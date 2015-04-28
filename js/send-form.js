/**
    * Get data from contact widget and send to AjaxContactFormMail controller 
    * and display result message
    */ 
$(document).ready(function(e) {
    $('.send-data').click(function(){
    	var prefix = $('#lang_prefix').val();
    	var email = $('#email').val();
    	var text = $('#text').val();
    	var code = $('#code').val();
        var name = $('#name').val();
        var link = '/'+ prefix +'/mail/AjaxContactFormMail';
        $.ajaxSetup({async:false});
        $.ajax({ type: "post",url:link,data:{email:email,text:text,code:code,name:name}}).done(function(data){            
            obj = jQuery.parseJSON(data);
            console.log(obj);
            $('.form-result').html(obj.result);
            $('#code').val('');
            $("#yw0_button").click();
        });
        return false;     
    });
});