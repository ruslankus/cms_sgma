$(document).ready(function() {
    $(document).on('click','.links-pages',function(e){
    	e.preventDefault();
    	alert(123);
    	/*
    	var id = ;
    	var curr_page = $(this).data('page');
		var prefix = $(this).data('prefix');
		var link = '/'+ prefix +'/admin/contacts/RequestsAjax/'+id;
		$(".contacts-box").load(link,{curr_page:curr_page});
		*/
    });
});