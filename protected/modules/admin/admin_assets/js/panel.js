(function( $ ){
/* User options */
$(".items a.user").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".items > .user-open").toggle("blind",300);
		
});
/* Language selection */
$(".langlist > a").click(function(e){
	e.preventDefault();
	$(this).toggleClass("active");
	$(".langlist > ul").toggle("blind",300);
});
/* Sidebar */
$(".left-zone > .menu").click(function(e){
	e.preventDefault();
	$(this).children(".bar.d").fadeToggle(300);
	if($(this).hasClass("minimized"))
		{
			$("aside").animate({"width":"202px"}, 300);
			$(this).removeClass("minimized");
			$("aside > ul.root > li > a").each(function() {
				$(this).children("span").delay(200).fadeIn(100);
				if($(this).parent().hasClass("hasChild"))
					$( this ).parent().addClass( 'hasChildIndicator' ); 
			});
		}
	else
		{
			$("aside").animate({"width":"51px"}, 300);
			$(this).addClass("minimized");
			$("aside > ul.root > li > a").each(function() {
				$(this).children("span").fadeOut(100);
				if($(this).parent().hasClass("hasChild"))
					$( this ).parent().removeClass( 'hasChildIndicator' ); 
			});
		}	
});
/* Sidebar tree */
	$( '.root li' ).each( function() {
        if( $( this ).children( 'ul' ).length > 0 )
            $( this ).addClass( 'hasChild hasChildIndicator' );     
    });
	$( '.root li.hasChild' ).hover( function( ) { $( this ).addClass("active"); $( this ).children( 'ul' ).show( 'slide', 300 ); }, function( ) { $( this ).removeClass("active"); $( this ).children( 'ul' ).hide( 'slide', 300 ); });
/* */
})( jQuery );