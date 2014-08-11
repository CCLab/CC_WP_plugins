jQuery(function ($) {
	function do_ajax(post_id) {
		$.ajax({
			type: 'post',
			url: cc_data.url,
			dataType: 'json',
			data: {action: 'cc_postcards_data', postcard_id: post_id},
			success: function(response) {
				if(response.error!=1) {
					$('#view-window .postcard-container .postcard-image').attr('src', response.img);
					$('#view-window .postcard-container .postcard-text .cnt').html(response.postcardcontent);
					
					$('#send-window .postcard-text .cnt').html(response.postcardcontent);
					$('#send-window .postcard-image').attr('src', response.img);
					$('#send-window #postcard_id').val(post_id);
					$('.postcard-buttons .postcard-button.download-button').attr('href', response.pdf);
					var fb_url = "https://www.facebook.com/sharer/sharer.php?u="+response.url;
					var tt_url = "https://twitter.com/intent/tweet?url="+response.url;
					var gp_url = "https://plus.google.com/share?url="+response.url;
					$('.postcard-button.share-button.fb').attr('href', fb_url);
					$('.postcard-button.share-button.tt').attr('href', tt_url);
					$('.postcard-button.share-button.gp').attr('href', gp_url);
					
					$('#print-text').html(response.postcardcontent);
					$('#print-image img').attr('src', response.img);

					$('#print-postcard-content').removeClass('no-p');
					$('#print-main-content').addClass('no-p');

					$('body,html').animate({
						scrollTop: 0
					}, 800);
					$('#view-window').fadeIn();
					expander();
				}
			}
		});
	}

	function expander() {
		$('#expander').height(0);
		if($('#view-window').css('display')=='block'){
			var y = $('#view-window').height();
		}
		if($('#send-window').css('display')=='block') {
			var y = $('#send-window').height();
		}
		var x = $('#black-border').height();
		var x1 = (y+180)-x+180;
		$('#expander').height(x1);
	}

	$(document).ready(function() {
		
		$('.close-window').click(function(){
			$(this).parents('.modal-window').fadeOut();
			var clean = {backgroundColor : "#50d10c", borderColor: "#50d10c"};
			$('#recaptcha_response_field').css(clean);
			$('#cc_postcards_se').css(clean);
			$('#cc_postcards_re').css(clean);
			$('#cc_postcards_sn').css(clean);
			$('#cc_postcards_rn').css(clean);
			$('#expander').height(0);

			if($(this).parents('.modal-window').attr('id')=='send-window'){
				$('#view-window').fadeIn(function(){
					expander();
				});
			}
			$('#print-main-content').removeClass('no-p');
			$('#print-postcard-content').addClass('no-p');

			$('#view-window .postcard-text').css('display', 'none');
			$('#view-window .postcard-container .postcard-image').fadeIn();
			$('#sent-postcard-window .postcard-text').css('display', 'none');
			$('#sent-postcard-window .postcard-container .postcard-image').fadeIn();
			$('.postcard-button.read-button').css('background-color', '#fff');
			window.history.pushState("", "Postcard", $('body').attr('data-permalink'));
		});
		
		if($('.postcard.opened').length > 0) {
			do_ajax($('.postcard.opened').attr('data-id'));
		}

		$('.postcard').click(function(){
			do_ajax($(this).attr('data-id'));	
			window.history.pushState("", "Postcard", $(this).attr('data-permalink'));
		});	

		var side=0;
		$('.postcard-button.read-button').toggle(
			function(){
				$('#view-window .postcard-container .postcard-image').css('display', 'none');
				$('#view-window .postcard-text').fadeIn();
				$('#sent-postcard-window .postcard-container .postcard-image').css('display', 'none');
				$('#sent-postcard-window .postcard-text').fadeIn();
				if($('body').hasClass('mobile')) {
					$('#view-window .postcard-container').css('border', 'none');
					$('body,html').animate({
						scrollTop: 0
					}, 800);
				}
				$(this).css('background-color', '#50d10c');
				expander();
				side=1;
			},
			function(){
				$('#view-window .postcard-text').css('display', 'none');
				$('#view-window .postcard-container .postcard-image').fadeIn();
				$('#sent-postcard-window .postcard-text').css('display', 'none');
				$('#sent-postcard-window .postcard-container .postcard-image').fadeIn();
				$(this).css('background-color', '#fff');
				if($('body').hasClass('mobile')) {
					$('#view-window .postcard-container').css('border', '1px solid #000');
					$('body,html').animate({
						scrollTop: 0
					}, 800);
				}
				expander();
				side=0;
			}
		);

		$('.postcard-button.print-button').click(function(){
			window.print();
		});

		$('#view-window .postcard-button.send-button').click(function(){
			$('#view-window').fadeOut();
			$('#send-window').fadeIn(500, function(){expander();});
			$('body,html').animate({
				scrollTop: 0
			}, 800);
		});

		/*$('.postcard-container').hover(
			function(){
				if(!$('body').hasClass('mobile')) {
					$('.postcard-container .postcard-image').css('display', 'none');
					$('.postcard-container .postcard-text').fadeIn();
					expander();
				}
			},
			function(){
				if(!$('body').hasClass('mobile')) {
					if(side==0) {
						$('.postcard-container .postcard-text').css('display', 'none');
						$('.postcard-container .postcard-image').fadeIn();
						expander();
					}
				}
			}
		);*/

		$('#send-postcard').click(function(event){
			event.preventDefault();
			var error = {
				backgroundColor : "red",
				borderColor: "red"
			};
			var ch = $('#recaptcha_challenge_field').val();
			var res = $('#recaptcha_response_field').val();
			var sn = $('#cc_postcards_sn').val();
			var se = $('#cc_postcards_se').val();
			var rn = $('#cc_postcards_rn').val();
			var re = $('#cc_postcards_re').val();
			var msg = $('#cc_postcards_msg').val();
			var pcid = $('#postcard_id').val();

			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

			var validationError = 0;

			if(!emailReg.test(se) || se=='') {
				$('#cc_postcards_se').css(error);
				validationError = 1;
			}
			if(!emailReg.test(re) || re=='') {
				$('#cc_postcards_re').css(error);
				validationError = 1;
			}
			if(rn==''){
				$('#cc_postcards_rn').css(error);
				validationError = 1;
			}
			if(re=='') {
				$('#cc_postcards_sn').css(error);
				validationError = 1;
			}

			if(validationError==1) {
				Recaptcha.reload();
				return;
			}

			$.ajax({
				type: 'post',
				url: cc_data.url,
				dataType: 'json',
				data: {
					action: 'cc_postcards_recaptcha', 
					challenge: ch, 
					response: res,
					rn: rn,
					re: re,
					sn: sn,
					se: se,
					msg: msg,
					pcid: pcid},
				success: function(response) {
					var info='';
					if(response.resp==1){
						info=cc_data.success;
					}
					else {
						if(response.error=='recaptcha') {
							$('#recaptcha_response_field').css(error);
							info='';
						}
						else {
							info=cc_data.mailerror;
						}
					}

					if(info!='') {
						$('#info-content').text(info);
						$('#info-window').fadeIn();
						$('#send-window').fadeOut();
						$('body,html').animate({
							scrollTop: 0
						}, 800);
						var rn = $('#cc_postcards_rn').val('');
						var re = $('#cc_postcards_re').val('');
						var msg = $('#cc_postcards_msg').val('');
						$('#print-main-content').removeClass('no-p');
						$('#print-postcard-content').addClass('no-p');
						expander();
					}
					Recaptcha.reload();
				}
			});
		});


		Recaptcha.create(
			cc_data.recaptcha,
			"recaptcha",
			{
				theme: "custom",
				custom_theme_widget: 'recaptcha_widget',
				callback: Recaptcha.focus_response_field
			}
		);
	});
});