$(document).ready(function() {
 /*
  $(".banners-box").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
 
  });
 */
  $(".banners-box").owlCarousel({
       navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
 
      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
    });
  $(".item").capslide({caption_color : '#FFFFFF', caption_bgcolor : '#002296', overlay_bgcolor : '#002296', border : '', showcaption : true});
});