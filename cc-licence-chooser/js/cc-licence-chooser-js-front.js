jQuery(function ($) {
	$(document).ready(function() {
		$('.go-to-steps').on({
			click: goToSteps
		});
		$('.go-around-buttons').on({
			click: switchStepContent
		});
		// sidebar save
		$('#lc-cnt').parent().width() < 820 ? $('#lc-cnt').addClass('cc-narrow-parrent') : '' ;


	});
	
	goToSteps = function(){
		var ccClicker = $('h2.go-to-steps');
		$('html, body').animate({
			scrollTop: ccClicker.offset().top
		}, 1000, 'swing');
		$('#cc-steps-cnt').slideDown('slow');
		$('#lc-cnt #cc-licence-choser-top-ar').show();
	}
	switchStepContent = function(){
		var clicked = $(this);
		var toGetStepID;
		var toDo = clicked.attr('id');

		switch(toDo) {
			case 'cc-go-back' :
				toGetStepID = $('#alwaysVisible').attr('data-previd');			
				$('#cc-go-start').hide();
				$('#cc-go-yes').add($('#cc-go-no')).show();
				$('#cc-more-licences').hide();
			break;
			case 'cc-go-yes' :
				toGetStepID = $('#alwaysVisible').attr('data-yesid');
				$('#cc-go-back').fadeIn('slow');
			break;
			case 'cc-go-no' :
				toGetStepID = $('#alwaysVisible').attr('data-noid');
				$('#cc-go-back').fadeIn('slow');
			break;
			case 'cc-go-start' :
				toGetStepID = 'cc-firstAgree';
				clicked.hide();
			$('#cc-go-yes').add($('#cc-go-no')).show();
			$('#cc-more-licences').hide();
			break;
		}
		// alert(toGetStepID);
		var el = document.getElementById(toGetStepID);
		toGetStepID == 'cc-firstAgree' ? $('#cc-go-back').fadeOut('slow') : '' ;;
		console.info(toGetStepID);
		if (toGetStepID.match(/outcome/g)) {
			
			var data = {
				action: 'cc-licence-chooser-outcome',
				outcomeid: toGetStepID
			};
			$('.go-around-buttons').off();
			$('.go-to-steps').off();
			$('#alwaysVisible').addClass('cc-licence-loading');
			$.post(ajax_object.ajax_url, data, function(response) {
				$('#alwaysVisible').removeClass('cc-licence-loading');
				$('#alwaysVisible p').html(response);
				$('#alwaysVisible').attr('data-previd', $('#alwaysVisible').attr('data-thisid'));
				$('#cc-go-start').fadeIn('slow');
				$('#cc-go-yes').add($('#cc-go-no')).hide();
				$('#cc-more-licences').show();
				ajaxOutcomeRefresh();
			});
		} else {
			var arr = [];
			var hideYesNo = false;
			for (var i=0, attrs=el.attributes, l=attrs.length; i<l; i++){
				arr.push(attrs.item(i).nodeName);
				attrs.item(i).name != 'id' ? 
				$('#alwaysVisible').attr(attrs.item(i).name, attrs.item(i).value ) : '';
		    // hide buttons if can't use cc licence
		    attrs.item(i).value == 'cc-hide-buttons' ? hideYesNo = true : '' ;
		}
		hideYesNo ? $('#cc-yes-no-cnt').fadeOut('slow') : $('#cc-yes-no-cnt').fadeIn('slow');
		$('#alwaysVisible p').html($(el).find('p').html());	
	}
}

ajaxOutcomeRefresh = function() {
	$('#cc-opener-white-arrow').on({
			click: showHowTo
		});
	$('#cc-how-to-closer').on({
		click: hideSlideOpener
	});
	$('.go-around-buttons').on({
			click: switchStepContent
	});
	$('.go-to-steps').on({
			click: goToSteps
	});
	$('#lc-cnt h6 strong').on({
		click: function(){
			jQuery('#cc-opener-white-arrow').trigger('click');
		}
	});
}
hideSlideOpener = function() {
	$(this).fadeOut('slow');
	$('#cc-how-to-selected').slideUp('slow');
}
showHowTo = function() {
		$('#cc-how-to-selected').slideToggle('slow');
		$('#cc-how-to-closer').fadeToggle();
	}
});