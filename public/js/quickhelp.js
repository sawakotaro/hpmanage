$(function(){
	// make quickhelp;
	var $help = $('<div class="quickhelp_window" style="display:none; position:absolute;">');
	$('body').append($help);

	$('.quickhelp').each(function(){
		var $span = $(this);
		var $mark = $('<img src="/images/quickhelp.png" width="16" height="16" />');
		$mark.css('vertical-align', 'middle');
		$mark.css('margin', '1px');
		$mark.css('cursor', 'pointer');
		$mark.hover(
			(function($mark, html){
				return function(){
					$help.html(html);
					var left = $mark.offset().left - $help.outerWidth() / 2 + $mark.outerWidth() / 2;
					if(left < 0) left = 0;
					if($('body').outerWidth() < (left + $help.outerWidth())) left = $('body').outerWidth() - $help.outerWidth();
					$help.css('left', left);
					$help.css('top', $mark.offset().top - $help.outerHeight());
					$help.show();
				};
			})($mark, $span.html()),
			function(){
				$help.hide();
			}
		);
		$span.after($mark);
		$span.remove();
	});
});