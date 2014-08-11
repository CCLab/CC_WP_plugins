<?php

/*---------------------------------*/
/*--- Settings page ---------------*/
/*---------------------------------*/

function cc_postcards_create_settings() {
	add_options_page('CC Postcards', 'CC Postcards', 'activate_plugins', 'cc_postcards', 'cc_postcards_generate_settings');
}
add_action('admin_menu', 'cc_postcards_create_settings');

function cc_postcards_generate_settings() {
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br/></div>
		<h2>CC Postcards - <?php _e('Konfiguracja', 'cc_postcards'); ?></h2>
		<form method="post" action="options.php">
		<?php settings_fields('cc_postcards_settings'); ?>
		<?php do_settings_sections('cc_postcards'); ?>
		<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

add_action('admin_print_scripts-settings_page_cc_postcards', 'cc_postcards_admin_scripts');
function cc_postcards_admin_scripts() {
	wp_enqueue_media();
	wp_enqueue_script('cc_postcards_settings', plugins_url('/js/cc-postcards-settings.js', __FILE__));
}

/*---------------------------------*/
/*--- Adding settings -------------*/
/*---------------------------------*/



function cc_postcards_settings_init() {
	register_setting( 'cc_postcards_settings', 'cc_postcards_settings', 'cc_postcards_settings_validate' );
	add_settings_section('cc_postcards_settings_main', __('Ustawienia podstawowe', 'cc_postcards'), 'cc_postcards_settings_main_text', 'cc_postcards');
	add_settings_field('cc_postcards_title', __('Tytuł strony z pocztówkami', 'cc_postcards'), 'cc_postcards_title_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_intro', __('Tekst nad listą pocztówek', 'cc_postcards'), 'cc_postcards_intro_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_call', __('Call to action', 'cc_postcards'), 'cc_postcards_call_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_pdf_pack', __('Paczka z plikami PDF', 'cc_postcards'), 'cc_postcards_pdf_pack_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_svg_pack', __('Paczka z plikami SVG', 'cc_postcards'), 'cc_postcards_svg_pack_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_message_sent', __('Komunikat o wysłanej wiadomości', 'cc_postcards'), 'cc_postcards_message_sent_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_sender_email', __('E-mail nadawcy', 'cc_postcards'), 'cc_postcards_sender_email_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_sender_name', __('Nazwa nadawcy', 'cc_postcards'), 'cc_postcards_sender_name_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_recaptcha_public', __('reCAPTCHA public key', 'cc_postcards'), 'cc_postcards_recaptcha_public_field', 'cc_postcards', 'cc_postcards_settings_main');
	add_settings_field('cc_postcards_recaptcha_private', __('reCAPTCHA private key', 'cc_postcards'), 'cc_postcards_recaptcha_private_field', 'cc_postcards', 'cc_postcards_settings_main');
}
add_action('admin_init', 'cc_postcards_settings_init');


function cc_postcards_settings_main_text() {

}

function cc_postcards_intro_field() {
	$options = get_option('cc_postcards_settings');
	echo '<textarea id="cc_postcards_intro_text" name="cc_postcards_settings[cc_postcards_intro]" rows="12" cols="100">'.$options[cc_postcards_intro].'</textarea>';
}

function cc_postcards_title_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="text" id="cc_postcards_title" name="cc_postcards_settings[cc_postcards_title]" size="50" value="'.$options[cc_postcards_title].'" />';
}

function cc_postcards_call_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="text" id="cc_postcards_call" name="cc_postcards_settings[cc_postcards_call]" size="50" value="'.$options[cc_postcards_call].'" />';
}

function cc_postcards_pdf_pack_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="hidden" id="cc_postcards_pdf_pack" name="cc_postcards_settings[cc_postcards_pdf_pack]" size="50" value="'.$options[cc_postcards_pdf_pack].'" />';
	?>
	<div>
		<strong><?php _e('Nazwa pliku:', 'cc_postcards'); ?></strong>
		<span id="cc_postcards_pdf_pack_name">
			<?php
			if($options[cc_postcards_pdf_pack]!=''){
				echo '<a href="'.wp_get_attachment_url($options[cc_postcards_pdf_pack]).'" target="_blank">'.basename ( get_attached_file($options[cc_postcards_pdf_pack] ) ).'</a>';
			}
			else
				echo '----------';
			?>
		</span>
	</div>
	<button class="button" id="upload_pdf_pack"><?php _e('Dodaj', 'cc_postcards'); ?></button>
	<button class="button" id="delete_pdf_pack"><?php _e('Usuń', 'cc_postcards'); ?></button>
	<?php
}

function cc_postcards_svg_pack_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="hidden" id="cc_postcards_svg_pack" name="cc_postcards_settings[cc_postcards_svg_pack]" size="50" value="'.$options[cc_postcards_svg_pack].'" />';
	?>
	<div>
		<strong><?php _e('Nazwa pliku:', 'cc_postcards'); ?></strong>
		<span id="cc_postcards_svg_pack_name">
			<?php
			if($options[cc_postcards_svg_pack]!=''){
				echo '<a href="'.wp_get_attachment_url($options[cc_postcards_svg_pack]).'" target="_blank">'.basename ( get_attached_file($options[cc_postcards_svg_pack] ) ).'</a>';
			}
			else
				echo '----------';
			?>
		</span>
	</div>
	<button class="button" id="upload_svg_pack"><?php _e('Dodaj', 'cc_postcards'); ?></button>
	<button class="button" id="delete_svg_pack"><?php _e('Usuń', 'cc_postcards'); ?></button>
	<?php
}

function cc_postcards_message_sent_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="text" id="cc_postcards_message_sent" name="cc_postcards_settings[cc_postcards_message_sent]" size="50" value="'.$options[cc_postcards_message_sent].'" />';
}

function cc_postcards_sender_email_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="text" id="cc_postcards_sender_email" name="cc_postcards_settings[cc_postcards_sender_email]" size="50" value="'.$options[cc_postcards_sender_email].'" />';
}

function cc_postcards_sender_name_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="text" id="cc_postcards_sender_name" name="cc_postcards_settings[cc_postcards_sender_name]" size="50" value="'.$options[cc_postcards_sender_name].'" />';
}

function cc_postcards_recaptcha_public_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="text" id="cc_postcards_recaptcha_public" name="cc_postcards_settings[cc_postcards_recaptcha_public]" size="50" value="'.$options[cc_postcards_recaptcha_public].'" />';
}

function cc_postcards_recaptcha_private_field() {
	$options = get_option('cc_postcards_settings');
	echo '<input type="text" id="cc_postcards_recaptcha_private" name="cc_postcards_settings[cc_postcards_recaptcha_private]" size="50" value="'.$options[cc_postcards_recaptcha_private].'" />';
}

function cc_postcards_settings_validate($input) {
	return $input;
}
?>