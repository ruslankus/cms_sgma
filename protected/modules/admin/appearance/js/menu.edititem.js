$('document').ready(function(){

    $('.load-items-selector').change(function(){

        var url = $('#add-item-form').data('update_url')+'/id/'+$(this).val();

        $.ajax({
            url: url,
            context: document.body
        }).done(
            function(data)
            {
                $('#loadable-selector').html(data);
            }
        );

    });

});