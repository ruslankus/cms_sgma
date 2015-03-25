$.fn.textarea = function(options){
        var settings = $.extend({
            width : "950px",
            height : "300px",
          fonts : ["Times New Roman","Arial","Comic Sans MS","Courier New","Monotype Corsiva","Tahoma"],
          headings : ["h1","h2","h3","h4","h5","h6"],
		  font_sizes : ["1","2","3","4","5","6","7"]
        },options);
        return this.each(function(){
            var $this = $(this).hide();
			
       var containerDiv = $("<div/>",{
		"class"	:	"inlu-editor",
           css : {
               width : settings.width ,
               height : settings.height
           }
       });
       $this.after(containerDiv); 
	   
       var editor = $("<iframe/>",{
           frameborder : "0" 
       }).appendTo(containerDiv).get(0);
       editor.contentWindow.document.open();
       editor.contentWindow.document.close();
       editor.contentWindow.document.designMode="on";
	   
	   
       var buttonPane = $("<div/>",{ "class" : "editor-btns"}).prependTo(containerDiv);
		/*
			Simple text formating buttons
		*/
		var SimpleText = $("<div/>",{"class" : "btn-list"}).appendTo(buttonPane);
		$("<span/>",{"class" : "bold", text : "B",  data : {commandName : "bold"},click : CommandToggle }).appendTo(SimpleText);
		$("<span/>",{"class" : "italic", text : "I",  data : {commandName : "italic"},click : CommandToggle }).appendTo(SimpleText);
		$("<span/>",{"class" : "underline", text : "U",  data : {commandName : "underline"},click : CommandToggle }).appendTo(SimpleText);
		$("<span/>",{"class" : "subscript",  text : "x", data : {commandName : "subscript"},click : CommandToggle }).appendTo(SimpleText);
		$("<span/>",{"class" : "superscript", text : "x",  data : {commandName : "superscript"},click : CommandToggle }).appendTo(SimpleText);
		$("<span/>",{"class" : "strike", text : "S",  data : {commandName : "strikeThrough"},click : CommandToggle }).appendTo(SimpleText);
		/*
			Adding font list
		*/
		var selectFont = $("<select/>",{"class":"btn-list fonts",data : {commandName : "FontName"},change : CommandToggle}).appendTo(buttonPane );  
        $.each(settings.fonts,function(i,v){ $("<option/>",{value : v,text : v}).appendTo(selectFont); });
		/*
			Adding font size list
		*/
		var selectFontSize = $("<select/>",{"class":"btn-list",data : {commandName : "FontSize"},change : CommandToggle}).appendTo(buttonPane );  
        $.each(settings.font_sizes,function(i,v){ $("<option/>",{value : v,text : v}).appendTo(selectFontSize); });
		/*
			Text align and lists
		*/
		var TextAlign = $("<div/>",{"class" : "btn-list"}).appendTo(buttonPane);
		$("<span/>",{"class" : "list-ordered", text : "O",  data : {commandName : "insertOrderedList"},click : CommandToggle }).appendTo(TextAlign);
		$("<span/>",{"class" : "list-unordered", text : "U",  data : {commandName : "insertUnorderedList"},click : CommandToggle }).appendTo(TextAlign);
		$("<span/>",{"class" : "jleft", text : "L",  data : {commandName : "justifyLeft"},click : CommandToggle }).appendTo(TextAlign);
		$("<span/>",{"class" : "jright", text : "R",  data : {commandName : "justifyRight"},click : CommandToggle }).appendTo(TextAlign);
		$("<span/>",{"class" : "jcenter", text : "C",  data : {commandName : "justifyCenter"},click : CommandToggle }).appendTo(TextAlign);
		$("<span/>",{"class" : "jfull", text : "F",  data : {commandName : "justifyFull"},click : CommandToggle }).appendTo(TextAlign);
		/*
			Creating undo/redo buttons
		*/
		var undoRedo = $("<div/>",{"class" : "btn-list"}).appendTo(buttonPane);
		$("<span/>",{"class" : "undo",data : {commandName : "undo"},click : CommandAction }).appendTo(undoRedo);
		$("<span/>",{"class" : "redo",data : {commandName : "redo"},click : CommandAction }).appendTo(undoRedo);

		/*
			Adding HEADING list
		*/
		var selectHeading = $("<select/>",{"class":"btn-list",data : {commandName : "heading"},change : CommandToggle}).appendTo(buttonPane ); 
		$("<option/>",{value : '',text : 'Heading'}).appendTo(selectHeading);
        $.each(settings.headings,function(i,v){ $("<option/>",{value : v,text : v}).appendTo(selectHeading); });	
		
		
	/*
	 * "toggle" komandų paleidimas.
	*/
    function CommandToggle (e) {
            $(this).toggleClass("selected");
            var contentWindow = editor.contentWindow;
            contentWindow.focus();
            contentWindow.document.execCommand($(this).data("commandName"), false, this.value || "");
            contentWindow.focus();
            return false;
    }
	/*
	 * "Action" komandų paleidimas.
	*/
    function CommandAction (e) {
            var contentWindow = editor.contentWindow;
            contentWindow.focus();
            contentWindow.document.execCommand($(this).data("commandName"), false, this.value || "");
            contentWindow.focus();
            return false;
    }
	/*
	 * Žemiau esančios funkcijos aktyvuoja mygtuką 
	 * jei parinktas tekstas yra su šio mygtuko savybėmis,
	 * kitaip - deaktyvuoja.
	 * 
	 * @param button - DOM element (span)
	*/
		function CommandState(button)
		{
			if (editor.contentWindow.document.queryCommandState(button.data("commandName")) == true)
				button.addClass("selected");
			else
				button.removeClass("selected");
		}
	/*
	 * @param select - DOM element (select)
	*/
		function CommandValue(select)
		{
			var value = editor.contentWindow.document.queryCommandValue(select.data("commandName"));
			if (value)
				select.find("option[value="+value+"]").attr("selected","selected");
			else
				select.find("option:first-of-type").attr("selected","selected");
		}
		var frame = $("iframe").contents();
		frame.on("click",function(){
			buttonPane.find("span").each(function() {
				CommandState($(this));
			});
			buttonPane.find("select").each(function() {
				CommandValue($(this));
			});
		});
    });
};