$(document).ready(function(){
//check if at least one checkbox is checked.
    $("input[type=checkbox]").click(function(e){
    	if ($(".images input[type=checkbox]:checked").length > 0)
    	{
    		$(".delete-images").prop("disabled",false);
    	}	else { $(".delete-images").prop("disabled", true); }
    		
    	});//end undo button
    //delete button
    
    $(".add-images").on("click", function() {
        
        $block = $(".lightbox");
        $.ajaxSetup({async:false});
        $block.load('/en/admin/gallery/uploadfile');
        $obj = $block.find("input[type=file]");
        fileUploadInput($obj);
    	$block.fadeIn(300);
    	//$(".lightbox #upload-images").fadeIn(300);
    	return false;
    });//click
    
    $(document).on("click",'.cancel', function() {
        console.log(this);
    	$(".lightbox").fadeOut(300);
        $(".lightbox").html("");
    	//$(".lightbox .content").fadeOut(300);
    	return false;
    });
    
    
    $('.lightbox').on('click',"#save-lightbox",function(){
         $('.errorMessage').html('');
        //validatiob
        var result = true;
        var fileValue = $("#file-input").val();
        if(fileValue == ''){
              $('.errorMessage').html('upload file');
                result = false;
                return false;    
        }
        
        var inputs = $('.text-field');
        inputs.each(function(){
            var $this = $(this);
            if($this.val() == ""){
                $('.errorMessage').html('field cannet be empty');
                result = false;
                return false;
            }
        });
        return result;
   });
    
    
    
});//end ready




fileUploadInput = function($obj)
{
	//var $input = $(document).find("input[type=file]");
	$obj.each(function(){
		var $this = $(this);
		var label = $("<span/>",{"class":"file"}).html($obj.attr("data-label")).prependTo($this.parent());
		var input = $("<input/>",{"class":"file","type":"text","id":$obj.attr("id")}).prependTo($this.parent());
		$this.css({"position":"absolute","top":"-99999px"});
		input.on("click",function() { $this.click(); });
		label.on("click",function() { $this.click(); });
		$this.on("change", function() { input.val($this.val().split('\\').pop()); });
	})
};//end file upload input