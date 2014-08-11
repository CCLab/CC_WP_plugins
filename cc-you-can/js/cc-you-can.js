jQuery(function ($) {
	var rows = 0;
	var works = 0;
	function cc_you_can_resize_thumbnails() {
		var container = $('#cc-you-can-thumbnails').width();
		if(container>800) {
			rows = 5;
		}
		else if(container>640) {
			rows = 4;
		} 
		else if(container>480) {
			rows = 3;
		}
		else if(container>320) {
			rows = 2;
		}
		else {
			rows = 1;
		}

		var thumb_width = Math.floor(container/rows)-4-10;
		var double_thumb_width = thumb_width*2+4+10;
		var thumb_height = Math.ceil(thumb_width*1.29);
		$('.cc-you-can-work-thumbnail').width(thumb_width);
		if(rows!=1)
			$('.cc-you-can-work-thumbnail-work').width(double_thumb_width);
		//$('.cc-you-can-work-thumbnail').height(thumb_height);
		
		var i = 0;
		works = 0;
		$('.cc-you-can-work-thumbnail').each(function(){
			if(!$(this).hasClass('cc-you-can-work-thumbnail-work')) {
				works+=1;
				var mt = $(this).height()-20-100-11-$('.cc-you-can-title', this).height();
				$('.cc-you-can-title', this).css('margin-top', mt+'px');
			}
			else {
				works+=2;
				if(container>320) {
					var tw = $(this).width()-130-30;
					$('.cc-you-can-title', this).width(tw);
				}
				else {
					var mt = $(this).height()-20-100-11-$('.cc-you-can-title', this).height();
					if($('.cc-you-can-thumb-content', this).is(':visible')) {
						mt += $('.cc-you-can-thumb-content', this).outerHeight()+7;
					}
					$('.cc-you-can-title', this).css('margin-top', mt+'px');
				}
			}
			i++;
		});

		var footer_sum = $('#cc-you-can-cc').width()+10+$('#cc-you-can-nck').width()+20+$('#cc-you-can-webchefs').width()+10+$('#cc-you-can-vivid').width();
		if(container>640) {
			$('#cc-you-can-footer-text').width(container-footer_sum-50);
			$('#cc-you-can-footer-text').css('margin', '0px 20px');
		}
	}

	function cc_you_can_tooltips() {
		$('a.cc-you-can-tooltip').hover(
			function(){
				var tooltip = $('<div class="cc-you-can-tooltip-box"><div class="cc-you-can-tooltip-title">'+$(this).text()+'</div><div class="cc-you-can-tooltip-content">'+$(this).data('cc-tooltip')+'</div></div>').appendTo('body').fadeIn();
			},
			function(){
				$('.cc-you-can-tooltip-box').fadeOut().remove();
		}).mousemove(function(e) {
			var mousex = e.pageX+10;
        	var mousey = e.pageY+10;
        	$('.cc-you-can-tooltip-box').css({ top: mousey, left: mousex });
		});
		$('a.cc-you-can-tooltip').click(function(event) {
			event.preventDefault();
		});
	}

	function cc_you_can_sizes() {
		if($('#cc-you-can-wrapper').width()>320) {
			$('.cc-you-can-work-thumbnail-work .cc-you-can-icon').css('float', 'left');
			$('.cc-you-can-work-thumbnail-work .cc-you-can-title').css({
				'float' : 'left',
				'margin-left' : '10px',
				'margin-top' : '20px'
    		});
    		$('.cc-you-can-work-thumbnail-work .cc-you-can-thumb-content').css('display', 'block');
		}
		else {
			$('.cc-you-can-work-thumbnail-work .cc-you-can-icon').css('float', 'none');
			$('.cc-you-can-work-thumbnail-work .cc-you-can-title').css({
				'float' : 'none',
				'width' : 'auto',
				'margin-left' : '10px',
				'margin-top' : '0px'
    		});
    		$('.cc-you-can-work-thumbnail-work .cc-you-can-thumb-content').css({'display' : 'none'});
		}

		if($('#cc-you-can-footer').width()<640) {
			$('#cc-you-can-footer-bottom .cc-you-can-footer-logo').css({'float' : 'none', 'display' : 'inline-block'});
			$('#cc-you-can-footer-bottom #cc-you-can-footer-text').css({'padding' : '10px', 'width' : '100%'});
    		$('#cc-you-can-footer-bottom #cc-you-can-logos-1').css({'text-align' : 'center', 'width' : '100%'});
    		$('#cc-you-can-footer-bottom #cc-you-can-logos-2').css({'text-align' : 'center', 'width' : '100%'});
		}
		else {
			$('#cc-you-can-footer-bottom .cc-you-can-footer-logo').css({'float' : 'left', 'display' : 'block'});
			$('#cc-you-can-footer-bottom #cc-you-can-footer-text').css({'padding' : '0px'});
    		$('#cc-you-can-footer-bottom #cc-you-can-logos-1').css({'text-align' : 'left', 'width' : 'auto'});
    		$('#cc-you-can-footer-bottom #cc-you-can-logos-2').css({'text-align' : 'left', 'width' : 'auto'});
		}
	}

	$(document).ready(function() {
		cc_you_can_resize_thumbnails();
		cc_you_can_sizes();
		cc_you_can_tooltips();
		$(window).resize(cc_you_can_resize_thumbnails);
		$(window).resize(cc_you_can_sizes);

		$('.cc-you-can-work-thumbnail').click(function(){
			var id = $(this).data('id');
			
			if(!$('.cc-you-can-popup').hasClass('cc-you-can-popup-'+id)) {
				var order = Math.floor(($(this).data('order')/rows)-0.1)+1;
				var parent = $(this);
				order = order * rows;

				if(order>works)
					order=works;
				
				var data = {
					action: 'cc_you_can_data',
					work_id: id
				};
				$.post(ajax_object.ajax_url, data, function(response) {
					$('.cc-you-can-arrow').css('display', 'none');
					$('.cc-you-can-popup').slideUp('fast', function(){
						$(this).remove();
					});
					$('.cc-you-can-green').removeClass('cc-you-can-green');
					$('#cc-you-can-thumbnail-'+order).after(response);
					$('.cc-you-can-popup').slideDown();
					$('.cc-you-can-arrow', parent).slideDown('fast', function(){
						if($('#cc-you-can-thumbnails').width()>320)
							var offset_chg = 100;
						else
							var offset_chg = 0;
						$('html, body').animate({
							scrollTop: $(parent).offset().top-offset_chg
						}, 700);
					});
					
					
					$(parent).addClass('cc-you-can-green');
					$('.cc-you-can-popup').width($('#cc-you-can-thumbnails').width()-14);
					
					cc_you_can_tooltips();
					$('.cc-you-can-popup-close').click(function(){
						$('.cc-you-can-arrow').css('display', 'none');
						$('.cc-you-can-popup').slideUp('fast', function(){
							$(this).remove();
						});
						$('.cc-you-can-green').removeClass('cc-you-can-green');
					});
				});
			}
			else {
				$('.cc-you-can-arrow').css('display', 'none');
				$('.cc-you-can-popup').slideUp('fast', function(){
					$(this).remove();
				});
				$('.cc-you-can-green').removeClass('cc-you-can-green');
			}
		});
	});

	$(window).load(function(){
		cc_you_can_resize_thumbnails();
		cc_you_can_sizes();
	});
});