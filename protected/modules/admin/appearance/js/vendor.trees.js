(function( $ ){
// Trees
$.build_tree = function() {
	var tree_content = $(document).find(".inner-table");
	tree_content.each(function(){
		var $this = $(this);
		var $nodes = $("<i>",{"class":"nodes"}).prependTo($this);
		var $parents = [];
		var $root_id = $this.find(".row.root").attr("data-id");
		
		$this.find(".row").each(function() {
			if (!$(this).hasClass("root"))
			{
				var parent_id = $(this).attr("data-parent");
				var $this_elem = $(this);
				var this_elem = $(this).find(".name");
				var padding = 14;
				var child_padding = 0;
				if (parent_id != 0)
					{
						child_padding = $this.find(".row[data-id="+parent_id+"]").children(".name").css("padding-left").replace("px", "");
						var padding = +padding + +child_padding;
					}
				this_elem.css({"padding-left":padding+"px"});
				this_elem.prepend('<i class="list-item"></i> ');
				
				$parents.push($this.find(".row[data-parent="+$this_elem.attr("data-parent")+"]:first").attr("data-parent"));
			}
		});
		$parents = $parents.filter(function(item, pos) { return $parents.indexOf(item) == pos; })
		$.each($parents, function(index, value) {
			var first = $this.find(".row[data-parent="+value+"]:first").find(".name > i.list-item");
			var last = $this.find(".row[data-parent="+value+"]:last").find(".name > i.list-item");
			var distance = last.offset().top - first.offset().top;
				if (value === $root_id) { distance = +distance + +15; } else { distance = +distance + +30; }
			$('<i>',{"class":"node"}).css({"height":distance+"px", "bottom":"5px", "left":"0px"}).appendTo(last);
		});
	});
};

// Draggable blocks
$.build_sort = function()
{
	var $sortable = $(document).find(".sortable");

    var previous_order = [];
    var new_order = [];

    var $swapped = $("<input>",{"id":"swapped-ids","type":"hidden"}).appendTo($sortable);

	var $handle = $(document).find(".sortable > .menu-table > .draggable");
	$sortable.sortable({
      connectWith: $sortable,
      handle: $handle,
      forcePlaceholderSize: true,
      placeholder: "sort-placeholder",
	  key: "key",
	  attribute: "data-sort",
      start: function(e,ui)
      {
          previous_order = $(this).sortable('toArray',{key : "order", attribute : "data-menu"});
      },
	  stop: function(e,ui)
      {
          new_order = $(this).sortable('toArray',{key : "order", attribute : "data-menu"});

          var _p_order = [];
          var _n_order = [];

          for(var i = 0; i < previous_order.length; i++){if(previous_order[i] != ""){_p_order.push(previous_order[i]);}}
          for(var y = 0; y < new_order.length; y++){if(new_order[y] != ""){_n_order.push(new_order[y]);}}

          console.log(_p_order);
          console.log(_n_order);

          var result = {'previous':_p_order,'new':new_order};
          var json = JSON.stringify(result);

          $swapped.val(json).trigger("change");
      }
    });
};

$.enable_handlers = function() { $.build_tree(); $.build_sort(); };

$(document).ready(function() {
	$.enable_handlers();
});

// Sorting change event
 $(document).on("change",".sortable",function(){$.enable_handlers();});

})( jQuery );