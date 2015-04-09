var qnt = 0;

(function( $ ){

    /**
     * When changing type
     */
    $(document).on('change','#AttrFieldForm_type_id',function(){

        var id = $(this).data('show_variants_for');

        if(id == $(this).val())
        {
            $('.hidden-selector').css({'visibility':'visible'});
            $('.hidden-selector input').css({'display':'block'});
        }
        else
        {
            $('.hidden-selector').css({'visibility':'hidden'});
            $('.hidden-selector input').css({'display':'none'});
        }
    });

    /**
     * Adding fields
     */
    $(document).on('click','.add-select-option-button',function(){

        var name_option_name = $(this).data('oname');
        var placeholder_name = $(this).data('ploname');
        var name_option_value = $(this).data('oval');
        var placeholder_value = $(this).data('ploval');
        var name_input_delete = $(this).data('delname');

        qnt++;

        var html = '' +
            '<div class="input-block">' +
            '<input placeholder="'+placeholder_name+'" class="input-name" name="'+name_option_name+'['+qnt+']" type="text">' +
            '<input placeholder="'+placeholder_value+'" class="input-value" name="'+name_option_value+'['+qnt+']" type="text">' +
            '<input class="input-delete" class="input-delete" type="submit" value="'+name_input_delete+'">' +
            '<div style="clear: both"></div>' +
            '</div>';

        $('.field-in-addable').append(html);

        if($('.input-block').length > 1)
        {
            $('.input-delete').css({'visibility':'visible'});
        }

        return false;
    });

    /**
     * Deleting fields
     */
    $(document).on('click','.input-delete',function(){
        $(this).parent().remove();

        if($('.input-block').length < 2)
        {
            $('.input-delete').css({'visibility':'hidden'});
        }

        return false;
    });


})( jQuery );