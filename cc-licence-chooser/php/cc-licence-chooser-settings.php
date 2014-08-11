<?php

/*---------------------------------*/
/*--- Settings page ---------------*/
/*---------------------------------*/


function cc_licence_chooser_create_settings() {
	$hook = add_options_page('CC Licence Chooser', 'CC Licence Chooser', 'activate_plugins', 'cc_licence_chooser', 'cc_licence_chooser_generate_settings');
}
add_action('admin_menu', 'cc_licence_chooser_create_settings');

function cc_licence_chooser_generate_settings() {
	cc_licence_chooser_settings_main_text();
	?>
	<form method="post" action="options.php">
		<? settings_fields( 'cc-licence-chooser-settings' ); ?>
	<div id="cc-licence-tabs">
		<h2 class="nav-tab-wrapper">
			<ul>
				<li><a href="#tabs-1" class="nav-tab"><?_e('Ekran powitalny', 'cc-license-chooser') ?></a></li>
				<li><a href="#tabs-2" class="nav-tab"><?_e('Podgląd pytań', 'cc-license-chooser') ?></a></li>
				<li><a href="#tabs-3" class="nav-tab"><?_e('Możliwe przypadki ', 'cc-license-chooser') ?></a></li>
			</ul>
		</h2>
		<div id="tabs-1" class="postbox-container">
			<? cc_licence_chooser_welcome_screen(); ?>
		</div>
		<div id="tabs-2" class="postbox-container">
			<? cc_licence_chooser_json_steps(); ?>
		</div>
		<div id="tabs-3" class="postbox-container">
			<? cc_licence_chooser_outcome_editors(); ?>
		</div>
	</div>
	<div class="clear"> </div>
		<input type="submit" id="cc-save-changes" class="button-primary" name="cc-save-settings" value="<?_e('Zapisz Zmiany', 'cc-licence-chooser') ?>" />
		<p> <strong> <?_e('Aby zresetować zmiany zdeaktywuj i aktywuj ponownie plugin - zostanie wczytany domyślny kontent. ', 'cc-licence-chooser') ?> </strong> </p>
	</form>
	<?
}

/*---------------------------------*/
/*--- Adding settings -------------*/
/*---------------------------------*/



function cc_licence_chooser_welcome_screen() {
	$wp_ed_content = get_option('cc-licence-chooser-welcome-screen');	
	wp_editor($wp_ed_content, 'cc-licence-chooser-welcome-screen', array( 'teeny' => false, 'textarea_name' => 'cc-licence-chooser-welcome-screen', 'wpautop' => false, 'tinymce' => false ));
}

function cc_licence_chooser_outcome_editors() {
	echo '<h3>' . __('Poniższe pola prezentują 6 możliwych wyników dla licencji CC. Każdy ekran można zmodyfikować przy minimalnej znajomości języka HTML. ','cc-licence-chooser') . '</h3>';
	echo '<div id="cc-licence-accordion" class="postbox">';
	for($i=1;$i<7;$i++) {
	switch ($i) {
		case 1 : 
			echo '<h3>  1: CC-BY </h3>';
		break;

		case 2 : 
			echo '<h3>  2: CC-BY-SA </h3>';
		break;

		case 3 : 
			echo '<h3>  3: CC-BY-NC </h3>';
		break;

		case 4 : 
			echo '<h3>  4: CC-BY-ND </h3>';
		break;

		case 5 : 
			echo '<h3>  5: CC-BY-NC-SA </h3>';
		break;

		case 6 : 
			echo '<h3>  6: CC-BY-NC-ND </h3>';
		break;
	}
	echo '<div>';
	echo '<div class="cc-wp-editor-wrap">';
		$wp_ed_content = get_option('cc-licence-chooser-outcome-' . $i);	
		wp_editor($wp_ed_content, 'cc-licence-chooser-outcome-' . $i, array( 'teeny' => true, 'textarea_name' => 'cc-licence-chooser-outcome-' . $i , 'wpautop' => false, 'tinymce' => false ));
	echo '</div>';
	echo '</div>';

	}
	echo '</div>';
}


function cc_licence_chooser_settings_main_text() {
	echo '<div class="wrap">';
	echo '<div id="icon-options-general" class="icon32"> <br> </div>';
	echo '<h2>' . __('Konfiguracja i zmiana treści dla CC Licence Chooser', 'cc-license-chooser') . '</h2>';
	echo '<p>' . __(' Aby wstawić kreator wyboru licencji na dowolną stronę proszę zastosować shortcode <strong> [cc_licence_chooser] </strong> . <br/> Kreator jest responsywny, lecz część jego zachowania determinuje szablon graficzny używany na stronie - sugerujemy wstawianie kreatora na stronach bez menu bocznego - sidebar. <br/> Podobnie jest również z jego wyglądem - niektóre rzeczy mogą zostać ndapisane przez szablon pomimo tego iż elementy kreatora mają przypisane unikalne id i klasy css. ', 'cc-licence-chooser') . ' <p>';
	echo '</div>';
}

// Generate JSON steps
require_once dirname( __FILE__ ) .'/cc-licence-chooser-json-steps.php';

function cc_licence_chooser_settings_init() {
	register_setting( 'cc-licence-chooser-settings', 'cc-licence-chooser-welcome-screen', 'cc_licence_chooser_settings_validate' );
	// Outcome_fields
	for($i=1;$i<7;$i++) {
	register_setting( 'cc-licence-chooser-settings', 'cc-licence-chooser-outcome-' . $i, 'cc_licence_chooser_settings_validate' );
	}
	
}
add_action('admin_init', 'cc_licence_chooser_settings_init');

function cc_licence_chooser_settings_validate($input) {
	return $input;
}

?>