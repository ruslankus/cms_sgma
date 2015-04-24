$(document).ready(function() {

    /**
     * Switch between field languages
     */
    $(document).on('click','.lng-switcher',function(){
        var id = $(this).data('id');

        $(this).parent().find('.lng-switcher').removeClass('active');
        $(this).addClass('active');

        $(this).parent().parent().find('input, textarea').removeClass('active');
        $(this).parent().parent().find('#'+id).addClass('active');

        return false;
    });

    /**
     * Submit event
     */
    $(document).on('submit','.ajax-form-saving',function(){

        ajaxSubmit('.ajax-form-saving');

        return false;
    });

    /**
     * When clicked on 'add local image'
     */
    $(document).on('click','.add-image',function(){

        var url = $(this).data('images'); //listing all images - url
        var urlAssignImage = $(this).data('update'); //assign new image - url
        var urlDeleteImage = $(this).data('delete'); //delete added image - url

        var block = $('.lightbox'); //box for images

        var itemId = $(this).data('item'); //item id (product's etc.)
        var fieldId = $(this).data('field'); //field id

        //find image on form related with this button
        var imageRelated = $(this).parent().find('img');
        var deleteButton = $(this).parent().find('.delete');

        //load all images to box
        var request = $.ajax({url: url});

        //when loaded all images
        request.done(function(msg) {

            //push all contents to block
            block.html(msg);
            //show light-box
            block.fadeIn();

            //when clicked on 'cancel' - close light box
            block.find('.cancel-images').click(function(){
                block.fadeOut(300);
                return false;
            });

            //when clicked on image
            block.find('.selectable-image').click(function(){

                //get url and image id
                var imageId = $(this).data('id');
                var url = $(this).attr('src');

                //hide light-box
                block.fadeOut(300);

                //show pre-loader
                $.preLoader.show();

                //reassign image of field by ajax
                var requestUpdate = $.ajax({url:urlAssignImage+'/id/'+itemId+'/fid/'+fieldId+'/iid/'+imageId});

                //when ajax finished
                requestUpdate.done(function(imageRelId) {
                    if(imageRelId != '')
                    {
                        //related image stuff (change image instantly)
                        $(imageRelated).attr('src',url);
                        $(deleteButton).addClass('active');

                        //change deleting url
                        $(deleteButton).attr('href',urlDeleteImage+'/id/'+imageRelId);
                    }
                    $.preLoader.hide();
                });

                //when ajax failed
                requestUpdate.fail(function(jqXHR,textStatus) {
                    alert( "Request failed: " + textStatus);
                    $.preLoader.hide();
                });

            });

        });

        //when listing images failed
        request.fail(function(jqXHR,textStatus) {
            alert( "Request failed: " + textStatus);
        });

        return false;
    });



    /**
     * When pressed on 'delete image'
     */
    $(document).on('click','.delete-btn',function(){

        if($(this).hasClass('active'))
        {
            var noImageUrl = $('.no-image-url').val();
            var link = $(this);
            var imageRelated = $(this).parent().find('img');

            $.preLoader.show();

            var request = $.ajax({url:$(this).attr('href')});

            request.done(function(msg) {
                $.preLoader.hide();
                link.attr('href','#');
                link.removeClass('active');
                imageRelated.attr('src',noImageUrl);
            });

            request.fail(function(jqXHR,textStatus) {
                alert( "Request failed: " + textStatus);
                $.preLoader.hide();
            });

        }

        return false;
    });


    /**
     * Validates numerical fields
     */
    $(document).on('keyup keydown','.numeric_field',function(e){
        return checkSymbols(e);
    });


    /**
     * Show date-picker for date-fields
     */
    $('.ui-datepicker').datepicker();

});

/**
 * Performs submit by ajax
 * @param formSelector
 */
function ajaxSubmit(formSelector)
{
    var params = {};
    var action = $(formSelector).attr('action');

    $(formSelector).find('input, textarea, select').each(function(index,element){
        params[$(element).attr('name')] = $(element).val();
    });

    $.preLoader.show();

    var request = $.ajax({
        method: "POST",
        url: action,
        data: params
    });

    request.done(function(msg) {
        $.preLoader.hide();
    });

    request.fail(function(jqXHR,textStatus) {
        alert( "Request failed: " + textStatus);
        $.preLoader.hide();
    });
}

var checkSymbols = function(e)
{
    var available_keys = [97, 98, 99, 100, 101, 102, 103, 104, 105, 96, 8, 37, 39, 46, 49, 50, 51, 52, 53, 54, 55, 56, 57, 48];
    console.log(e.keyCode);
    return (jQuery.inArray(e.keyCode,available_keys) != -1);
};