<?php  
/* 
Plugin Name: CC You Can
Version: 0.1 
Description: How can you use other people's works? - plugin for Centrum Cyfrowe. To use this plugin please use <strong>[cc-you-can]</strong> shortcode.
Author: webchefs
Author URI: http://www.webchefs.pl/ 
Plugin URI: http://www.webchefs.pl/ 
*/

/* Version check */  
global $wp_version;  
  
$exit_msg = 'This plugin requires WordPress 3.5 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress"> Please update!</a>';
  
if (version_compare($wp_version, "3.5", "<"))  
{  
 exit($exit_msg);  
}  

require_once dirname( __FILE__ ) .'/adm/cc-you-can-post-type.php';
require_once dirname( __FILE__ ) .'/adm/cc-you-can-shortcodes.php';

function cc_you_can_install() {
	add_theme_support( 'post-thumbnails' ); 
	add_image_size('cc_you_can_thumb', 260, 200, false);

	$titles[0] = "Utwór";
	$titles[1] = "Utwór dostępny w otwartej przestrzeni publicznej";
	$titles[2] = "Projekt architektoniczny";
	$titles[3] = "Egzemplarz utworu";
	$titles[4] = "Baza danych";
	$titles[5] = "Program komputerowy";
	$titles[6] = "Domena publiczna";
	$titles[7] = "Licencja CC BY";
	$titles[8] = "Licencja CC BY SA";
	$titles[9] = "Licencja CC BY ND";
	$titles[10] = "Licencja CC BY NC";
	$titles[11] = "Licencja CC BY NC SA";
	$titles[12] = "Licencja CC BY NC ND";

	$files[0] = 'utwor';
	$files[1] = 'utwor_przestrzen';
	$files[2] = 'projekt_architektoniczny';
	$files[3] = 'egzemplarz_utworu';
	$files[4] = 'baza_danych';
	$files[5] = 'program_komputerowy';
	$files[6] = 'domena_publiczna';
	$files[7] = 'ccby';
	$files[8] = 'ccbysa';
	$files[9] = 'ccbynd';
	$files[10] = 'ccbync';
	$files[11] = 'ccbyncsa';
	$files[12] = 'ccbyncnd';

	$subtitles[0] = "niezależnie od źrodła jego pochodzenia";
	$subtitles[1] = "na drogach, ulicach, placach i w ogrodach";
	$subtitles[2] = "lub architektoniczno-urbanistyczny";
	$subtitles[3] = "np. płyta CD, książka w druku, film DVD";
	$subtitles[4] = "";
	$subtitles[5] = "";
	$subtitles[6] = "";
	$subtitles[7] = "";
	$subtitles[8] = "";
	$subtitles[9] = "";
	$subtitles[10] = "";
	$subtitles[11] = "";
	$subtitles[12] = "";

	$tooltips[0] = "każdy przejaw działalności twórczej o indywidualnym charakterze np. film, tekst, zdjęcie, grafika, rzeźba, program komputerowy, baza danych";
	$tooltips[1] = "";
	$tooltips[2] = "";
	$tooltips[3] = "";
	$tooltips[4] = "";
	$tooltips[5] = "";
	$tooltips[6] = "utwory do którego prawa majątkowe wygasły lub nigdy nie były chronione, bo zostały stworzone przed powstaniem prawa autorskiego";
	$tooltips[7] = "";
	$tooltips[8] = "";
	$tooltips[9] = "";
	$tooltips[10] = "";
	$tooltips[11] = "";
	$tooltips[12] = "";

	$types[0] = "work";
	$types[1] = "type";
	$types[2] = "type";
	$types[3] = "type";
	$types[4] = "type";
	$types[5] = "type";
	$types[6] = "public";
	$types[7] = "license";
	$types[8] = "license";
	$types[9] = "license";
	$types[10] = "license";
	$types[11] = "license";
	$types[12] = "license";

	$thumb_texts[0] = "Większość utworów chronionych prawem autorskim, niezależnie od źródła ich pochodzenia możesz bez zgody twórcy bezpłatnie wykorzystywać w ramach tzw. dozwolonego użytku na <span>określonych zasadach</span>.";
	$thumb_texts[1] = "";
	$thumb_texts[2] = "";
	$thumb_texts[3] = "";
	$thumb_texts[4] = "";
	$thumb_texts[5] = "";
	$thumb_texts[6] = "";
	$thumb_texts[7] = "";
	$thumb_texts[8] = "";
	$thumb_texts[9] = "";
	$thumb_texts[10] = "";
	$thumb_texts[11] = "";
	$thumb_texts[12] = "";


	$can[0] = 	'<ul>
					<li>pobierać, kopiować na własny użytek</li>
					<li>kopiami możesz dzielić się ze swoimi najbliższymi (rodziną i znajomymi)</li>
					<li>[cc-tooltip tooltip_text="używać fragmentu lub drobnego utworu w całości we własnym utworze (cel musi być uzasadniony analizą krytyczną, nauczaniem lub prawem gatunku a cytat i jego autor musi być wyraźnie oznaczony)"]cytować[/cc-tooltip]</li>
					<li>śpiewać, recytować, odtwarzać publicznie podczas bezpłatnych imprez szkolnych i akademickich, ceremonii religijnych i oficjalnych uroczystości państwowych</li>
				</ul>
				<ul>
					<li>instytucje edukacyjne i oświatowe mogą w celach edukacyjnych i naukowych tworzyć kopie fragmentów każdego utworu (oprócz baz danych i programów komputerowych)</li>
				</ul>';

	$can[1] = 	'<ul>
					<li>robić ich kopie- zdjęcia, rysunki, szkice, filmy itp. na własny użytek</li>
					<li>kopiami możesz dzielić się ze swoimi najbliższymi (rodziną i znajomymi)</li>
					<li>z kopii korzystać w celach komercyjnych np. ich zdjęcia możesz sprzedawać jako kartki pocztowe, umieścić w przewodniku, nakręcić film, w którym się pojawią</li>
					<li>kopie udostępniać publicznie  w sieci (np. na stronie, blogu, otwartym profilu na FB)</li>
				</ul>';

	$can[2] = 	'<ul>
					<li>pobierać, kopiować na własny użytek</li>
					<li>kopiami możesz dzielić się ze swoimi najbliższymi (rodziną i znajomymi)</li>
					<li>[cc-tooltip tooltip_text="używać fragmentu lub drobnego utworu w całości we własnym utworze (cel musi być uzasadniony analizą krytyczną, nauczaniem lub prawem gatunku a cytat i jego autor musi być wyraźnie oznaczony)"]cytować[/cc-tooltip]</li>
				</ul>
				<ul>
					<li>instytucje edukacyjne i oświatowe mogą w celach edukacyjnych i naukowych tworzyć kopie fragmentów projektów architektonicznych i arch-urbanistycznych</li>
				</ul>';
	$can[3] = 	'<ul>
					<li>kopiować na własny użytek</li>
					<li>kopiami możesz dzielić się ze swoimi najbliższymi (rodziną i znajomymi)</li>
					<li>[cc-tooltip tooltip_text="używać fragmentu lub drobnego utworu w całości we własnym utworze (cel musi być uzasadniony analizą krytyczną, nauczaniem lub prawem gatunku a cytat i jego autor musi być wyraźnie oznaczony)"]cytować[/cc-tooltip]</li>
					<li>odsprzedać</li>
				</ul>
				<ul>
					<li>instytucje edukacyjne i oświatowe mogą w celach edukacyjnych i naukowych tworzyć kopie fragmentów egzemplarzy utworów (oprócz baz danych i programów komputerowych)</li>
					<li>biblioteki, archiwa i szkoły mogą wypożyczać nieodpłatnie egzemplarze utworów (oprócz baz danych i programów komputerowych)</li>
				</ul>';
	$can[4] = 	'<ul>
					<li>pobierać, kopiować na własny użytek</li>
					<li>kopiami możesz dzielić się ze swoimi najbliższymi (rodziną i znajomymi)</li>
				</ul>';
	$can[5] = 	'<p>Posiadając egzemplarz programu komputerowego lub będąc jego licencjobiorcą w zakresie, w jakim jest to niezbędne MOŻESZ korzystać z programu komputerowego aby:</p>
				<ul>
					<li>tworzyć jego kopie w całości lub części</li>
					<li>tłumaczyć, przystosowywać, zmieniać </li>
					<li>poprawiać błędy</li>
					<li>testować go pod kątem zakażenia wirusami oraz usuwać wirusy</li>
					<li>zmieniać parametry programu wywołane zmianą standardów lub wymogów</li>
					<li>dostosować go do wymogów nowych wersji sprzętu komputerowego </li>
				</ul>';
	$can[6] = 	'<ul>
					<li>kopiować</li>
					<li>tworzyć opracowania, tłumaczenia, przeróbki</li>
					<li>rozpowszechniać </li>
					<li>przedstawiać i wykonywać</li>
					<li>korzystać w celach komercyjnych </li>
				</ul>';
	$can[7] = 	'<ul>
					<li>kopiować</li>
					<li>tworzyć opracowania, tłumaczenia, przeróbki</li>
					<li>rozpowszechniać </li>
					<li>przedstawiać i wykonywać</li>
					<li>korzystać w celach komercyjnych</li>
				</ul>';
	$can[8] = 	'<ul>
					<li>kopiować</li>
					<li>tworzyć opracowania, tłumaczenia, przeróbki, modyfikacje</li>
					<li>rozpowszechniać </li>
					<li>przedstawiać i wykonywać</li>
					<li>korzystać w celach komercyjnych </li>
				</ul>';
	$can[9] = 	'<ul>
					<li>kopiować</li>
					<li>tworzyć opracowania, tłumaczenia, przeróbki, modyfikacje</li>
					<li>rozpowszechniać </li>
					<li>przedstawiać i wykonywać</li>
				</ul>';
	$can[10] =	 '<ul>
					<li>kopiować</li>
					<li>tworzyć opracowania, tłumaczenia, przeróbki, modyfikacje</li>
					<li>rozpowszechniać </li>
					<li>przedstawiać i wykonywać</li>
				</ul>';
	$can[11] =	 '<ul>
					<li>kopiować</li>
					<li>rozpowszechniać </li>
					<li>przedstawiać i wykonywać</li>
					<li>używać ten utwór do celów komercyjnych</li>
				</ul>';
	$can[12] =	 '<ul>
					<li>kopiować</li>
					<li>rozpowszechniać </li>
					<li>przedstawiać i wykonywać</li>
				</ul>';

	$cant[0] = "<ul>
					<li>udostępniać publicznie w sieci (np. na stronie, blogu, otwartym profilu na FB)</li>
					<li>udostępniać publicznie w sieci Twoich przeróbek, tłumaczenia, adaptacje cudzych utworów </li>
					<li>modyfikować, zmieniać, przekształcać</li>
					<li>korzystać w celach komercyjnych</li>
				</ul>";
	$cant[1] = "<ul>
					<li>kopii wystawić jako dzieła artystycznego</li>
				</ul>";
	$cant[2] = "<ul>
					<li>budować wg cudzego projektu architektonicznego lub architektoniczno-urbanistycznego</li>
				</ul>";
	$cant[3] = "";
	$cant[4] = "";
	$cant[5] = "<ul>
					<li>pobierać, kopiować na własny użytek niezależnie od źródła pochodzenia</li>
					<li>kopiami dzielić się ze swoimi najbliższymi (rodziną i znajomymi)</li>
					<li>udostępniać publicznie  w sieci (np. na stronie, blogu, otwartym profilu na FB)</li>
				</ul>";
	$cant[6] = "";
	$cant[7] = "";
	$cant[8] = "";
	$cant[9] = "<ul>
					<li>używać tego utworu do celów komercyjnych</li>
				</ul>";
	$cant[10] = "<ul>
					<li>używać tego utworu do celów komercyjnych</li>
				</ul>";
	$cant[11] = "<ul>
					<li>tworzyć opracowań, tłumaczeń, przeróbek, modyfikacji</li>
				</ul>";
	$cant[12] = "<ul>
					<li>tworzyć opracowań, tłumaczeń, przeróbek, modyfikacji</li>
					<li>używać tego utworu do celów komercyjnych</li>
				</ul>";

	$condition[0] = "";
	$condition[1] = "";
	$condition[2] = "";
	$condition[3] = "";
	$condition[4] = "";
	$condition[5] = "";
	$condition[6] = "";
	$condition[7] = "<ul>
						<li>oznaczenie autora oryginału </li>
					</ul>";
	$condition[8] = "<ul>
						<li>oznaczenie autora oryginału</li>
						<li>opracowania, tłumaczenia, przeróbki, modyfikacje musisz udostępnić musisz udostępnić na takiej samej licencji (CC BY SA)</li>
					</ul>";
	$condition[9] = "<ul>
						<li>oznaczenie autora oryginału </li>
					</ul>";
	$condition[10] = "<ul>
						<li>oznaczenie autora oryginału</li>
						<li>opracowania, tłumaczenia, przeróbki, modyfikacje musisz udostępnić na licencji CC NC BY SA</li>
					</ul>";
	$condition[11] = "<ul>
						<li>oznaczenie autora oryginału </li>
					</ul>";
	$condition[12] = "<ul>
						<li>oznaczenie autora oryginału </li>
					</ul>";

	$additional[0] = "";
	$additional[1] = "";
	$additional[2] = "";
	$additional[3] = "";
	$additional[4] = "<p>powyższe zasady nie dotyczą elektronicznych baz danych, z których korzystać możesz tylko do własnego użytku naukowego niezwiązanego z pracą zarobkową</p><p>Biblioteki, archiwa i szkoły NIE MOGĄ wypożyczać nieodpłatnie egzemplarzy baz danych</p>
		<p>Instytucje naukowe i oświatowe NIE MOGĄ w celach edukacyjnych i naukowych tworzyć kopii fragmentów baz danych</p>";
	$additional[5] = "<p>Biblioteki, archiwa i szkoły NIE MOGĄ wypożyczać nieodpłatnie egzemplarzy programów komputerowych</p>
		<p>Instytucje naukowe i oświatowe NIE MOGĄ w celach edukacyjnych i naukowych tworzyć kopii fragmentów programów komputerowych</p>";
	$additional[6] = "";
	$additional[7] = "";
	$additional[8] = "";
	$additional[9] = "";
	$additional[10] = "";
	$additional[11] = "";
	$additional[12] = "";

	$cc_you_can_dir = plugin_dir_path( __FILE__ );
	$wp_upload_dir = wp_upload_dir();

	for($i=0; $i<13; $i++) {
		
		if(get_page_by_title($titles[$i], 'OBJECT', 'cc_you_can_work')) {
			continue;
		}
		else {
			$post_args = array(
				'post_title' => $titles[$i],
				'post_status' => 'publish',
				'post_type' => 'cc_you_can_work',
				'post_author' => ''
			);

			$post_id = wp_insert_post($post_args);

			update_post_meta($post_id, 'cc_you_can_work_you_can', $can[$i]);
			update_post_meta($post_id, 'cc_you_can_work_you_cant', $cant[$i]);
			update_post_meta($post_id, 'cc_you_can_work_condition', $condition[$i]);
			update_post_meta($post_id, 'cc_you_can_work_additional_info', $additional[$i]);
			update_post_meta($post_id, 'cc_you_can_work_subtitle', $subtitles[$i]);
			update_post_meta($post_id, 'cc_you_can_work_tooltip', $tooltips[$i]);
			update_post_meta($post_id, 'cc_you_can_work_thumbnail_content', $thumb_texts[$i]);
			update_post_meta($post_id, 'cc_you_can_work_category', $types[$i]);
			update_post_meta($post_id, 'cc_you_can_order', $i+1);

			$new_png = $wp_upload_dir['path'].'/'.$files[$i].'.png';
			$old_png = $cc_you_can_dir.'/img/icons/'.$files[$i].'.png';
			copy($old_png, $new_png);

			$png_filename = $new_png;

			$png_filetype = wp_check_filetype(basename($png_filename), null);

			$png_attachment = array (
				'guid' => $wp_upload_dir['url'] . '/' . basename( $png_filename ), 
				'post_mime_type' => $png_filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($png_filename)),
				'post_content' => '',
				'post_status' => 'inherit'
			);

			$png = wp_insert_attachment( $png_attachment, $png_filename, $post_id);

			$attach_data = wp_generate_attachment_metadata( $png, $png_filename );
			wp_update_attachment_metadata( $png,  $attach_data );
			add_post_meta($post_id, '_thumbnail_id', $png, true);
		}
	}
}

register_activation_hook(__FILE__, cc_you_can_install);

function cc_you_can_uninstall() {
	
}

register_deactivation_hook(__FILE__, cc_you_can_uninstall);


/*-------------------------*/
/* Post thumbnails support */
/*-------------------------*/
function cc_you_can_thumbnail_support () {
	add_theme_support( 'post-thumbnails' ); 
	add_image_size('cc_you_can_thumb', 260, 200, false);
}
add_action('after_setup_theme', cc_you_can_thumbnail_support);



/*-------------------------*/
/* Ajax                    */
/*-------------------------*/
if(is_admin()) {
	add_action('wp_ajax_cc_you_can_data', 'cc_you_can_ajax_data');
	add_action('wp_ajax_nopriv_cc_you_can_data', 'cc_you_can_ajax_data');
}

function cc_you_can_ajax_data() {
	$id = $_POST['work_id'];
	$can = get_post_meta($id, 'cc_you_can_work_you_can', true);
	$cant= get_post_meta($id, 'cc_you_can_work_you_cant', true);
	$condition = get_post_meta($id, 'cc_you_can_work_condition', true);
	$additional_info = get_post_meta($id, 'cc_you_can_work_additional_info', true);

	$result = '<div class="cc-you-can-popup cc-you-can-popup-'.$id.'">';
	$result .= '<div class="cc-you-can-popup-close"></div>';
	if($can!='') {
		$result .= '<div class="cc-you-can-popup-can">';
		$result .= '<div class="cc-you-can-popup-title"><span class="cc-you-can-popup-icon"></span>'.__('możesz', 'cc_you_can').'</div>';
		$result .= '<div class="cc-you-can-popup-content">'.do_shortcode(wpautop($can)).'</div>';
		$result .= '</div>';
	}
	if($cant!='') {
		$result .= '<div class="cc-you-can-popup-cant">';
		$result .= '<div class="cc-you-can-popup-title"><span class="cc-you-can-popup-icon"></span>'.__('nie możesz', 'cc_you_can').'</div>';
		$result .= '<div class="cc-you-can-popup-content">'.do_shortcode(wpautop($cant)).'</div>';
		$result .= '</div>';
	}
	if($condition!='') {
		$result .= '<div class="cc-you-can-popup-condition">';
		$result .= '<div class="cc-you-can-popup-title"><span class="cc-you-can-popup-icon"></span>'.__('warunek', 'cc_you_can').'</div>';
		$result .= '<div class="cc-you-can-popup-content">'.do_shortcode(wpautop($condition)).'</div>';
		$result .= '</div>';
	}
	if($additional_info!='') {
		$result .= '<div class="cc-you-can-popup-additional">';
		$result .= '<div class="cc-you-can-popup-content">'.do_shortcode(wpautop($additional_info)).'</div>';
		$result .= '</div>';
	}
	$result .= '</div>';
	echo $result;
	die();
}

function theme_name_scripts() {
	wp_enqueue_style('cc-you-can-styles', plugins_url( 'css/cc-you-can.css' , __FILE__ ));
	wp_enqueue_style('cc-you-can-fonts', 'http://fonts.googleapis.com/css?family=Ubuntu:400,700&subset=latin,latin-ext');
	wp_enqueue_script('jquery');
	wp_enqueue_script('cc-you-can-scipts', plugins_url( 'js/cc-you-can.js' , __FILE__ ), array());
	wp_localize_script('cc-you-can-scipts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ));
	wp_enqueue_script('cc-you-can-element-query', plugins_url( 'js/elementQuery.min.js' , __FILE__ ), array());
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

?>