$(document).ready(function(e) {

    $('.send-data').click(function(){
        var id = '#'+$(this).data('id');
    	var prefix = $(id+' .lang_prefix').val();
    	var email = $(id+' .email').val();
    	var text = $(id+' .text').val();
    	var code = $(id+' .code').val();
        var name = $(id+' .name').val();
        var link = '/'+ prefix +'/mail/AjaxMailWidgetCheck';
        $.ajaxSetup({async:false});
        $.ajax({ type: "post",url:link,data:{email:email,text:text,code:code,name:name}}).done(function(data){
            
            obj = jQuery.parseJSON(data);
            console.log(obj);
            $(id+' .form-result').html(obj.result);
            $(id+' #code').val('');
            $(id+' a ').click();
        });
        return false;     
    });
}); 