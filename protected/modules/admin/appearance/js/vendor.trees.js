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

// Dragabble blocks
$.build_sort = function()
{
	var toarray = [];
	var $sortable = $(document).find(".sortable");
	var $order = $("<input>",{"id":"sortable-order","type":"hidden"}).appendTo($sortable);
	var $handle = $(document).find(".sortable > .menu-table > .draggable");
	$sortable.sortable({
      connectWith: $sortable,
      handle: $handle,
      forcePlaceholderSize: true,
      placeholder: "sort-placeholder",
	  key: "key",
	  attribute: "data-sort",
	  stop: function(e,ui) {
		var data = $(this).sortable('toArray',{key : "order", attribute : "data-menu"});
		$order.val(data).trigger("change");
		}
    });
};

$.enable_handlers = function() { $.build_tree(); $.build_sort(); };
$(document).ready(function() {
	$.enable_handlers();
});
})( jQuery );