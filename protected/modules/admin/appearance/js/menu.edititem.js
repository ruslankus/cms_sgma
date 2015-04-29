$('document').ready(function(){

    /**
     * When changing type
     */
    $(document).on('change','.load-items-selector',function(){

        var url = $('#add-item-form').data('update_url')+'/id/'+$(this).val();

        $.ajax({
            url: url,
            context: document.body
        }).done(
            function(data)
            {
                $('#loadable-selector').html(data);
                UpdateLink(null);
            }
        );

    });

    /**
     * When changing content item
     */
    $(document).on('change','#MenuItemForm_content_item_id',function(){
        UpdateLink($(this).val());
    });

});

/**
 * Gets link for menu item by AJAX
 * @constructor
 */
var UpdateLink = function(val){

    var type_id = $('.load-items-selector').val();
    var item_id = $('#idem_id').val();
    var object_id = val !== null ? val : $('#MenuItemForm_content_item_id').val();

    if(type_id !== undefined && item_id !== undefined && object_id !== undefined)
    {
        var url = $('#get_link_id').val()+'/id/'+item_id+'/type/'+type_id+'/obj/'+object_id;

        $.ajax({
            url: url,
            context: document.body
        }).done(
            function(data)
            {
                $('#link_field_ajax').val(data);
            }
        );
    }

};