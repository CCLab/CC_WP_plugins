jQuery(function ($) {
	$(document).ready(function() {
		var file_frame;

		$('#delete_pdf_pack').click(function(event) {
			event.preventDefault();
			$('#cc_postcards_pdf_pack').val('');
			$('#cc_postcards_pdf_pack_name').text('----------');
		});

		$('#delete_svg_pack').click(function(event) {
			event.preventDefault();
			$('#cc_postcards_svg_pack').val('');
			$('#cc_postcards_svg_pack_name').text('----------');
		});

		$('#upload_pdf_pack').live('click', function( event ){
			event.preventDefault();
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: false 
			});

			file_frame.on( 'select', function() {
				attachment = file_frame.state().get('selection').first().toJSON();
				$('#cc_postcards_pdf_pack').val(attachment.id);
				$('#cc_postcards_pdf_pack_name').html('<a href="'+attachment.url+'" target="_blank">'+attachment.filename+'</a>');
			});
			file_frame.open();
		});

		$('#upload_svg_pack').live('click', function( event ){
			event.preventDefault();
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: false 
			});

			file_frame.on( 'select', function() {
				attachment = file_frame.state().get('selection').first().toJSON();
				$('#cc_postcards_svg_pack').val(attachment.id);
				$('#cc_postcards_svg_pack_name').html('<a href="'+attachment.url+'" target="_blank">'+attachment.filename+'</a>');
			});
			file_frame.open();
		});
	});
});