$(document).ready(function(e) {

    $('.send-data').click(function(){
        var id_q = '#'+$(this).data('id');
        var id = $(id_q+' .wid-id').val();
    	var prefix = $(id_q+' .lang_prefix').val();
    	var email = $(id_q+' .email').val();
    	var text = $(id_q+' .text').val();
    	var code = $(id_q+' .code').val();
        var name = $(id_q+' .name').val();
        var link = '/'+ prefix +'/mail/AjaxMailWidgetCheck/'+id;
        $.ajaxSetup({async:false});
        $.ajax({ type: "post",url:link,data:{email:email,text:text,code:code,name:name}}).done(function(data){
            
            obj = jQuery.parseJSON(data);
            console.log(obj);
            $(id_q+' .form-result').html(obj.result);
            $(id_q+' #code').val('');
            $(id_q+' a ').click();
        });
        return false;     
    });
}); 