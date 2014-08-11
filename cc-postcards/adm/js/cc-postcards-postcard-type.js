jQuery(function ($) {
	$(document).ready(function() {
	// Uploading files
	var file_frame;

	$('#delete_file').click(function(event) {
		event.preventDefault();
		$('#cc_postcard_pdf').val('');
		$('#file-name').text('----------');
	});

	$('#upload_file').live('click', function( event ){
		event.preventDefault();
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: $( this ).data( 'uploader_title' ),
			button: {
				text: $( this ).data( 'uploader_button_text' ),
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();
			$('#cc_postcard_pdf').val(attachment.id);
			$('#file-name').html('<a href="'+attachment.url+'" target="_blank">'+attachment.filename+'</a>');
		});

		// Finally, open the modal
		file_frame.open();
	});
	});
});