jQuery('document').ready(function(){

    jQuery('#type_id').change(function(){

        var link = jQuery(this).data('link') + '/' + jQuery(this).val();

        jQuery.ajax({
            url: link,
            context: document.body
        }).done(
            function(data)
            {
                jQuery('.loadable-by-type').html(data);
            }
        );

    });

});