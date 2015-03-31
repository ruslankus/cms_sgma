$(document).ready(function() {
    $(document).on('click','.links-pages',function(e){
    	e.preventDefault();
    	var curr_page = $(this).data('page');
		var prefix = $(this).data('prefix');
		var link = '/'+ prefix +'/admin/contacts/IndexAjax';
		$(".contacts-box").load(link,{curr_page:curr_page});
		
    });

    $(document).on('click','.delete',function(e){
    	e.preventDefault();
    	var id = $(this).data('id');
		var prefix = $(this).data('prefix');
		var name = $('#name-'+id).html();
		var link = '/'+ prefix +'/admin/contacts/DeleteContactAjax/'+id;
	    $.ajax({ type: "post",url:link,data:{name:name}}).done(function(data){
	        obj = jQuery.parseJSON(data);
			var html = obj.html;
			$.popup(html);
			$.popup.show();

	    });
		
    });
});