(function( $ ){
	/*
		menu icon + sidebar
	*/
	$.fn.menu = function() {
		var sidebar = $(".sidebar");
		/*
			Mobile. When clicked on menu icon shows/hides
			sidebar. Rotates menu icon indicator.
		*/
		this.click( function( e )
			{
				e.preventDefault();
				$(this).toggleClass("menu-item-open");
				sidebar.toggle("blind",300);
				$(this).removeClass("menu-item-hover"); // class moving menu indicator up and down.
			});
		sidebar.find("ul > li").each( function() {
			if( $( this ).children( 'ul' ).length > 0 )
				$( this ).addClass( 'hasChild' );     
		});
		$( '.sidebar > ul > li.hasChild > a' ).click( function(e) {
			e.preventDefault();
			$( this ).parent().addClass("active");
			$( this ).parent().siblings().removeClass("active");
			$(".sidebar > ul > li.hasChild > ul").hide();
			$( this ).parent().children( 'ul' ).fadeIn( 300 );
		});
		$(".sidebar > ul > li.hasChild:first-of-type > ul").fadeIn( 300 );
		this.mouseover(function( e ){$(this).addClass("menu-item-hover");}).mouseout(function(){$(this).removeClass("menu-item-hover");});

	};
	/*
		fixes menu icon indicator and sidebar
	*/
	$.fn.menu_fix = function() {
		var sidebar = $(".sidebar");
		if ($(window).width() > 779)
			{
				this.addClass("menu-item-open");
				sidebar.show();
			}
		else if ($(window).width() < 780 && this.hasClass("menu-item-open") == false)
			{
				sidebar.hide();
			}
		else if ($(window).width() < 780 && this.hasClass("menu-item-open") == true)
			{
				sidebar.show();
			}
		/*
			shows mini-navigation of .active big navigation on page start.
		*/
		if ($(window).width() >= 1280)
			$(".sidebar > .mini > div").find("ul[data-mini='"+$(".sidebar > ul > li.active").attr("data-for")+"']").show();
	};
	
	/*
		banner slider
	*/
	$.fn.banner_slider = function() {
		var navigation = this.find(".thumbs .items");
		var content = this.find(".carousel .items");
		
		navigation.find("a:first").addClass("active");
		
		var maxScrollPosition = content.outerWidth() - this.find(".carousel").outerWidth();
		
		function toGalleryItem($targetItem){
			if($targetItem.length){
				var newPosition = $targetItem.position().left;
				if(newPosition <= maxScrollPosition){
					content.animate({
						left : - newPosition
					});
				} else {
					content.animate({
						left : - maxScrollPosition
					});
				};
			};
		};
		navigation.find("a").each(function(index){
			$(this).click(function(e){
				e.preventDefault();
				var $targetItem = content.find("a:nth-child("+(index+1)+")");
				toGalleryItem($targetItem);
				$(this).addClass("active");
				$(this).siblings().removeClass("active");
				activeElement = index+1;
			});
		});
	};
	/*
		products slider
	*/
	$.fn.products_slider = function() {
		var navigation = this.find(".nav");
		var content = this.find(".carousel .items");
		
		content.find("a:first").addClass("active");
		
		var maxScrollPosition = content.outerWidth() - this.find(".carousel").outerWidth();
		
		function toGalleryItem($targetItem){
			if($targetItem.length){
				var newPosition = $targetItem.position().left;
				if(newPosition <= maxScrollPosition){
					content.animate({
						left : - newPosition
					});
				} else {
					content.animate({
						left : - maxScrollPosition
					});
				};
			};
		};
		navigation.find(".back").click(function(e){
			var $targetItem = content.find(".active").prev();
			$targetItem.addClass("active");
			$targetItem.siblings().removeClass("active");
			toGalleryItem($targetItem);
		});
		navigation.find(".forward").click(function(e){
			var $targetItem = content.find(".active").next();
			$targetItem.addClass("active");
			$targetItem.siblings().removeClass("active");
			toGalleryItem($targetItem);
		});
	};
	$.fn.products_slider_fix = function() {
		var navigation = this.find(".thumbs .items");
		var content = this.find(".carousel .items");
		content.find("a:first").addClass("active");
		content.animate({left : "0"});
	};
	/*
		updates slider
	*/
	$.fn.updates_slider = function() {
		var navigation = this.find(".nav");
		var content = this.find(".carousel .items");
		
		content.find("div:first").addClass("active");
		
		var maxScrollPosition = content.outerWidth() - this.find(".carousel").outerWidth();
		
		function toGalleryItem($targetItem){
			if($targetItem.length){
				var newPosition = $targetItem.position().left;
				if(newPosition <= maxScrollPosition){
					content.animate({
						left : - newPosition
					});
				} else {
					content.animate({
						left : - maxScrollPosition
					});
				};
			};
		};
		navigation.find(".back").click(function(e){
			var $targetItem = content.find(".active").prev();
			$targetItem.addClass("active");
			$targetItem.siblings().removeClass("active");
			toGalleryItem($targetItem);
		});
		navigation.find(".forward").click(function(e){
			var $targetItem = content.find(".active").next();
			$targetItem.addClass("active");
			$targetItem.siblings().removeClass("active");
			toGalleryItem($targetItem);
		});
	};
	
	/*
		scrolls on top of page
	*/
	$.fn.go_to_top = function() {
		var go_to = this;
		$(window).bind("scroll",function(){
			if($(window).scrollTop() >= $("body > header").height()){go_to.show();}else{go_to.hide();}
		});
		this.click(function() {
			$('html, body').animate({
				scrollTop: $("header").offset().top
			}, 500);
		});
	};
	/* item slider */
		var itembar_navigation = $(".image-slider > .thumbs > .items");
		var itembar_content = $(".image-slider > .carousel");
		var itembar_navigation_arrows = $(".image-slider > .navi");
		var itembar_active_slide = itembar_content.find(".items > div:first");
		if (itembar_active_slide.length)
			{
				var itembar_active_slide_id = itembar_active_slide.attr("data-slide");
				console.log(itembar_active_slide_id);
				itembar_active_slide.addClass("active");
				itembar_navigation.find("a:first").addClass("active");
				
				itembar_maxpos = itembar_content.find(".items").outerWidth() - itembar_content.outerWidth();
				itembar_navigation.find("a").bind("click", function(e){
					e.preventDefault();
					itembar_active_slide = $(this);
					itembar_active_slide_id = $(this).attr("data-slide");
					itembar_active_slide.addClass("active");
					itembar_active_slide.siblings().removeClass("active");
					$(this).addClass("active");
					$(this).siblings().removeClass("active");
					var itembar_target = $(".image-slider > .carousel > .items > div[data-slide="+itembar_active_slide_id+"]");
					animateSlides(itembar_target,itembar_content.find(".items"));
				});
			}
		function animateSlides(target, content)
		{
			
			if (target.length)
			{
				var newpos = target.position().left;
					if (newpos <= content.width())
						content.animate({left: -newpos});
					else
						content.animate({left: -content.width()});
			}
		}
		itembar_navigation_arrows.find(".right").click(function(e)
			{
				e.preventDefault();
				var itembar_target = $(".image-slider > .carousel > .items > div[data-slide="+itembar_active_slide_id+"]").next();
				if(itembar_target.length)
					{
						animateSlides(itembar_target,itembar_content.find(".items"));
						itembar_active_slide = itembar_target;
						itembar_active_slide_id = itembar_target.attr("data-slide");
						itembar_active_slide.addClass("active");
						itembar_active_slide.siblings().removeClass("active");
						var next = $(".image-slider > .thumbs > .items > a[data-slide="+itembar_active_slide_id+"]");
						next.addClass("active");
						next.siblings().removeClass("active");
					}
			});
		itembar_navigation_arrows.find(".left").click(function(e)
			{
				e.preventDefault();
				var itembar_target = $(".image-slider > .carousel > .items > div[data-slide="+itembar_active_slide_id+"]").prev();
				if(itembar_target.length)
					{
						animateSlides(itembar_target,itembar_content.find(".items"));
						itembar_active_slide = itembar_target;
						itembar_active_slide_id = itembar_target.attr("data-slide");
						itembar_active_slide.addClass("active");
						itembar_active_slide.siblings().removeClass("active");
						var next = $(".image-slider > .thumbs > .items > a[data-slide="+itembar_active_slide_id+"]");
						next.addClass("active");
						next.siblings().removeClass("active");
					}
			});
	/* info bar */
		var infobar_navigation = $(".item-info-nav > li");
		var infobar_content = $(".page-list > .carousel");
		
		infobar_navigation.find("li:first").addClass("active");
		infobar_content.find("div:first").show();
		infobar_content.find("div:first").siblings().hide();
		//var infobar_maxpos = infobar_content.outerWidth() - infobar_content.find("div").outerWidth();
		infobar_navigation.bind("click",function(){
			$(this).addClass("active");
			$(this).siblings().removeClass("active");
			var infobar_target = infobar_content.find("div[data-page="+$(this).attr("data-for")+"]");
			infobar_target.siblings().hide();
			infobar_target.show();
			/*var infobar_newpos = infobar_target.position().left;
			if (infobar_newpos <= infobar_maxpos)
			{infobar_content.animate({left: - infobar_newpos}); console.log(infobar_newpos);}
			else
				infobar_content.animate({left: - infobar_maxpos});*/
		});
	/*
		show/hide faq articles
	*/
	$(".faq-item").each(function(i){
		if (i>0)
			$(this).find("article").hide();
		else
			$(this).find(".arrow").addClass("out");
	});
	$(".faq-item > h1").bind("click",function(){
		$(this).parent().find("article").toggle("blind",300);
		$(this).parent().find(".arrow").toggleClass("out");
		$(this).parent().siblings().find("article").hide("blind",300);
		$(this).parent().siblings().find(".arrow").removeClass("out");
	});
	/*
		show/hide lighbox
	*/
	$("#lightbox_box > .fluid-center > .box > .close").click(function(){
		$("#lightbox").hide();
		$("#lightbox_box").hide();
	});
	
	$(".open-box").bind("click",function(e){
		e.preventDefault();
		var shop_id = $(this).attr("data-shop");
		console.log("open "+shop_id);
		$("#lightbox").show();
		$("#lightbox_box").show();
		$('html, body').animate({
				scrollTop: $("#lightbox_box > .fluid-center > .box").offset().top
			}, 500);
	});
	/*
		fixes slides/menu when window is resized or phone flipped.
	*/
	/* language bar */
	$(".wrapper > .language").click(function(){
		$(this).toggleClass("menu-item-open");
		$(".wrapper > .language > ul").fadeToggle(300);
	});
		
	function fixes()
		{
			$(".nav-item.menu").menu_fix();
			var prod = $(".products > .carousel > .items");
			prod.find("a:first").addClass("active");
			prod.find("a:first").siblings().removeClass("active");
			prod.animate({left : "0"});
			var updates = $(".updates > .carousel > .items");
			updates.find("div:first").addClass("active");
			updates.find("div:first").siblings().removeClass("active");
			updates.animate({left : "0"});
		}
	/*
		run functions.
	*/
	$("header > .wrapper > .menu").menu();
	$("#go-to-top").go_to_top();
	$(".slider").banner_slider();
	$(".products").products_slider();
	$(".updates").updates_slider();
	
	fixes();
	
	var resizeTimer;
	$(window).resize(function(){
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(fixes, 100);
	});
})( jQuery );