jQuery(function ($) {
	function toggle_thumb_content() {
		if($('#cc_you_can_work_category').val()=='work')
			$('#cc_you_can_work_thumbnail_content_container').fadeIn();
		else {
			$('#cc_you_can_work_thumbnail_content_container').fadeOut();
			//$('#cc_you_can_work_thumbnail_content').val('');
		}
	}
	$(document).ready(function() {
		toggle_thumb_content();

		$('#cc_you_can_work_category').change(toggle_thumb_content);

		$('#cc-sortable').sortable({
			update: function() {
				$('#cc_you_can_order').val(JSON.stringify($('#cc-sortable').sortable('toArray')));
			}
		});
		$('#cc_you_can_order').val(JSON.stringify($('#cc-sortable').sortable('toArray')));

	});
});