$(document).ready(function() {

// Sorting change event
$(document).on("change","#swapped-ids",function(){

    //TODO: Ajax reloading of all table
	console.log("swapped "+this.value);
	return false;
});

// Delete menu label event
$(document).on("click", ".delete", function()
	{
        //e.preventDefault();
		var popup_link = $(this).data('popup');
        var href = $(this).attr('href');

		$.popup({"url":popup_link});
		$.popup.show();
		return false;
	});


// move label up
$(document).on("click", ".go-up", function()
	{
        var href = $(this).attr('href');
        //TODO: Ajax reloading of all table
        alert(href);
        return false;
	});

$(document).on("click", ".go-down", function()
	{
        var href = $(this).attr('href');
        //TODO: Ajax reloading of all table
        alert(href);
        return false;
	});

// for popup confirm
$(document).on("click", ".unique-class-name", function(){

    var href = $(this).attr('href');
    //TODO: Ajax reloading of all table
    alert(href);
    $.popup.hide();

	return false;
});

// for input submits
$(document).on("submit", ".unique-class-name", function(){
	console.log("ok");
	return false;
});

});