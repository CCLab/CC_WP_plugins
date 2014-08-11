<?php  
/* 
Plugin Name: CC Postcards
Version: 0.1 
Description: Simple e-postcards plugin for Centrum Cyfrowe
Author: webchefs
Author URI: http://www.webchefs.pl/ 
Plugin URI: http://www.webchefs.pl/ 
*/

/* Version check */  
global $wp_version;  
  
$exit_msg = 'This plugin requires WordPress 3.5 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress"> Please update!</a>';
  
if (version_compare($wp_version, "3.4", "<"))  
{  
 exit($exit_msg);  
}  

require_once dirname( __FILE__ ) .'/adm/cc-postcards-postcard-type.php';
require_once dirname( __FILE__ ) .'/adm/cc-postcards-sent-postcard-type.php';
require_once dirname( __FILE__ ) .'/adm/cc-postcards-settings.php';

function cc_postcards_install() {
	$cc_postcards_page = array(
		'post_title' => __('Pocztówki', 'cc_postcards'),
		'post_content' => '',
		'post_status' => 'publish',
		'post_type' => 'page',
		'post_author' => ''
		);

	$post_id = wp_insert_post($cc_postcards_page);
	update_option('cc_postcards_page_id', $post_id);

	if(get_option('cc_postcards_installed')!='1') {
		$wp_upload_dir = wp_upload_dir();
		$cc_postcards_dir = plugin_dir_path( __FILE__ );	
	
		$new_pdf = $wp_upload_dir['path'].'/pocztowki_CC.pdf';
		$old_pdf = $cc_postcards_dir.'/tpl/files/pocztowki_CC.pdf';
		copy($old_pdf, $new_pdf);
	
		$new_svg = $wp_upload_dir['path'].'/pocztowki_CC.zip';
		$old_svg = $cc_postcards_dir.'/tpl/files/pocztowki_CC.zip';
		copy($old_svg, $new_svg);
	
		
		$pdf_filename  = $new_pdf;
		$svg_filename = $new_svg;
	
		$pdf_filetype = wp_check_filetype(basename($pdf_filename), null);
		$svg_filetype = wp_check_filetype(basename($svg_filename), null);
	
		
	
		$pdf_attachment = array (
			'guid' => $wp_upload_dir['url'] . '/' . basename( $pdf_filename ), 
			'post_mime_type' => $pdf_filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($pdf_filename)),
			'post_content' => '',
			'post_status' => 'inherit'
		);
	
		$svg_attachment = array (
			'guid' => $wp_upload_dir['url'] . '/' . basename( $svg_filename ), 
			'post_mime_type' => $svg_filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($svg_filename)),
			'post_content' => '',
			'post_status' => 'inherit'
		);
	
	
		$pdf = wp_insert_attachment( $pdf_attachment, $pdf_filename);
		$svg = wp_insert_attachment( $svg_attachment, $svg_filename);
	
		$default_settings = array(
			'cc_postcards_title' => "Co nas uwiera w prawie autorskim?",
			'cc_postcards_intro' => "Prawo autorskie ma za zadanie chronić twórców – potrafi jednak uwierać każdego. Wybraliśmy dziewięć spośród wielu przykładów tego, w jaki sposób ono „nie działa”: nie spełnia swojej roli, przeszkadza i ogranicza dostęp do edukacji i kultury. Szukamy odpowiedzi na pytanie o to, co uwiera w prawie autorskim twórców, bibliotekarzy, uczniów i nauczycieli, przedsiębiorców, animatorów kultury, muzealników, zwykłych ludzi. A co uwiera w nim Ciebie?",
			'cc_postcards_call' => "Wybierz pocztówkę, dodaj swój komentarz i dziel się nimi z kim tylko chcesz!",
			'cc_postcards_pdf_pack' => $pdf,
			'cc_postcards_svg_pack' => $svg,
			'cc_postcards_message_sent' => "Twoja wiadomość została wysłana. Dzięki!",
			'cc_postcards_sender_email' => "",
			'cc_postcards_sender_name' => "",
			'cc_postcards_recaptcha_public' => "",
			'cc_postcards_recaptcha_private' => "",
			);
	
		update_option('cc_postcards_settings', $default_settings);
	
		$posts_content[0] = '<p>Prawo ma za zadanie chronić - potrafi jednak również uwierać.Tak jest w przypadku prawa autorskiego, oddziaływującego na obieg treści i informacji w internecie.</p><p>Bowiem prawo autorskie zestarzało się - zmieniane jedynie kosmetycznie i często wyłącznie po to, by wzmocnić jego dotychczasowy kształt, sięgający korzeniami XIX wieku. Tymczasem w świecie podłączonym do internetu minęły lata świetlne.</p><p>Spośród wielu przykładów kłopotów z prawem autorskim wybraliśmy dziewięć krótkich historii, w którch prawo autorskie "nie działa": nie spełnia swojej roli, przeszkadza w realizowaniu tak podstawowych praw jak swobody wyrażania siebie czy dostępu do edukacji i kultury.</p><p>Szukamy odpowiedzi na pytanie, co uwiera w prawie autorskim - twórców, bibliotekarzy, uczniów i nauczycieli, przedsiębiorców, animatorów kultury, muzealników, zwykłych ludzi.</p><p>Wejdź na <a href="www.centrumcyfrowe.pl/conasuwiera" target="_blank">www.centrumcyfrowe.pl/conasuwiera</a> i powiedz nam, co Ciebie uwiera w prawie autorskim oraz ściągnij cyfrowe wersje naszych pocztówek.</p><p>Centrum Cyfrowe Projekt: Polska pracuje na r zec z zmiany społecznej i zwiększenia zaangażowania obywatelskiego poprzez wykorzystanie nowych technologii oraz otwarte dzielenie się wiedzą i zasobami informacyjnymi. Realizujemy badnia oraz analizy dot. prawa autorskiego, obiegów kultury, nowoczesnej edukacji i otwartych modeli rządzenia.</p>';
		$posts_content[1] = '<p>Ściągamy plik z muzyką, zapisujemy na twardym dysku, a następnie udostępniamy naszym 400 znajomym na Facebooku.</p><p>Nawet jeżeli w pliku nie ma informacji, że jest on chroniony prawem autorskim, to musimy to założyć. Jest tak dlatego, że prawo autorskie chroni każdy utwór bez wymogu jego rejestracji lub oznaczenia. Ściągnięcie pliku zamieszczonego w sieci jest dozwolone do użytku osobistego. O użytku osobistym mówimy, gdy dzielimy się „egzemplarzem” utworu z rodziną oraz osobami pozostającymi z nami „w stosunku towarzyskim”.</p><p>Egzemplarz utworu to jego utrwalenie na fizycznym nośniku. Prawnicy nie są zgodni, czy egzemplarz to też plik, choć plik też zawsze jest utrwalony na jakimś nośniku. „Stosunek towarzyski” to również niejasne pojęcie, zwłaszcza w sytuacjach granicznych. Na pewno nie jest dozwolone w ramach użytku osobistego umieszczanie plików online w sposób umożliwiający każdemu dostęp do nich (np. wrzucenie do sieci p-2-p). Ale czy mieści się w nim udostępnienie pliku 400 znajomym z Facebooka?</p><p>Dlatego postulujemy, aby prawo zezwalało na niekomercyjne korzystanie z plików dostępnych w Sieci. Idealnie, po zmianach, prawnie dopuszczalne byłoby to, co teraz robimy na granicy prawa, czyli ściąganie, kopiowanie, zmienianie, dzielenie się utworami pod warunkiem, że nie osiągamy z tego tytułu korzyści majątkowej.</p>';
		$posts_content[2] = '<p>Nakręciłeś telefonem krótki filmik i wrzucasz go do serwisu społecznościowego. Po dwóch dniach filmik został obejrzany tysiące razy, a obok niego pojawiają się reklamy. Piszesz do administratora serwisu, że nie podoba się Tobie to, że zgarnia pieniądze z reklam, które ludzie oglądają przy filmie. Na co administrator powołuje się na regulamin, zgodnie z którym rzeczywiście ma do tego prawo.</p><p>Wszyscy widzimy, że coś tu nie jest w porządku. Najprawdopodobniej chciałbyś decydować o tym, czy, kto i jak może zarabiać na Twojej twórczości. Chcesz mieć również wpływ na swój ewentualny udział w tych przychodach. Być może zdziwi Cię informacja, że prawo autorskie od dawna Ci to gwarantuje. Chroni ono tak samo twórczość firmowaną przez wielkie wytwórnie, jak i Twój krótki filmik. Niestety, tzw. „user generated content” w praktyce nie uczestniczy w podziale zysków.</p><p>Dlatego prawo musi zadbać o twórców/producentów materiałów zamieszczanych w sieci. Chodzi tu zarówno o osoby prywatne, amatorskich twórców, jak i tych, którzy w wytworzenie atrakcyjnych treści zainwestowali pieniądze. Rozwiązaniem tego problemu nie jest „dokręcanie śruby” prawa autorskiego i powszechna inwigilacja aktywności każdego użytkownika w sieci. Dostawcy usług internetowych, twórcy oraz użytkownicy są naszym zdaniem w stanie wypracować lepsze rozwiązanie. To kwestia prawa, ale również modeli biznesowych.</p><p>Postulujemy debatę nad rozwiązaniami, które zapewniałyby użytkownikowi swobodę w korzystaniu z treści online, ale nie lekceważyły twórców, producentów lub wydawców tych treści. To możecie być Wy lub Wasi znajomi.</p>';
		$posts_content[3] = '<p>Znajdujesz w sieci muzykę, która idealnie nadawałaby się jako podkład do Twojego filmiku z poprzedniego przykładu. Wiesz już, że filmik, który zdobył dużą popularność, będziesz chciał pokazywać nie tylko w Internecie, ale też na festiwalach filmowych. Chcesz legalnie zdobyć muzykę do niego jednak nie wiesz, kto jest jej autorem. Szukasz w sieci, pytasz znajomych, piszesz nawet do ZAiKSu: organizacji która reprezentuje twórców. Nikt nie wie, kto jest autorem idealnie pasującej melodii.</p><p>Właśnie zetknąłeś się z utworem „osieroconym”. W przypadku takich utworów nie wiadomo od kogo uzyskać licencję, a bez licencji nie można z nich korzystać. Trzeba założyć, że nadal obowiązują do nich prawa autorskie, nawet jeśli nie mamy jak tego sprawdzić. Muzyka w pewnym sensie „marnuje się”, nie może posłużyć do stworzenia nowego utworu.</p><p>Postulujemy stworzenie ram prawnych dla korzystania z utworów osieroconych. Oczywiście przy poszanowaniu interesów autorów, gdyby się odnaleźli.</p>';
		$posts_content[4] = '<p>Znalazłeś w końcu muzykę którą możesz wykorzystać w swoim filmie. Znowu umieszczasz go w sieci. Po jakimś czasie Twoja skrzynka mailowa pełna jest pytań dotyczących możliwości korzystania z filmu. Pani Ala pyta czy może go umieścić na stronie www swojego klubu, Pan Bogdan pyta czy może stworzyć instalację wideo, której film będzie centralnym punktem. Pan Czesław pyta, czy może go włączyć do prezentacji dla studentów. Firma Danton chciałaby wykorzystać fragment filmu w swojej reklamie.</p><p>Odpowiedzi i określanie warunków korzystania z filmu zajmują Ci całe dnie. O ile rozumiesz sens negocjowania warunków komercyjnego wykorzystania, to Ali, Bogdanowi i Czesławowi zostawiłbyś chętnie swobodę działania.</p><p>Dlatego proponujemy: skorzystaj z licencji Creative Commons. Licencja CC – do wyboru 6 rożnych wariantów - to informacja o tym, co użytkownicy mogą robić z Twoim utworem.</p><p>Możesz udzielić wolnej licencji i wówczas firma Danton będzie mogła wykorzystać Twój film komercyjnie. Mozesz też zastrzec, ze korzystać z filmu można tylko do celów niekomercyjnych.</p>';
		$posts_content[5] = '<p>Ze znajomymi tworzysz portal internetowy, na którym chcecie publikować klasykę literatury polskiej w atrakcyjnym opracowaniu graficznym, do pobrania za opłatą. Macie zamiar publikować tylko utwory z domeny publicznej – takie, do których prawa autorskie wygasły i każdy może z nich swobodnie korzystać.</p><p>Mylicie się jednak, jeżeli sądzicie, że z utworów tych możecie korzystać całkowicie bezpłatnie. Prawo autorskie wprowadza obowiązek zapłaty za korzystanie z dzieł znajdujących się w domenie publicznej. Jeżeli Wasz pomysł okaże się trafiony i zaczniecie zarabiać, będziecie musieli odprowadzić 5-8% od wpływów ze sprzedaży utworów na Fundusz Promocji Twórczości.</p><p>To podatek za korzystanie z twórczości, która jest już dobrem wspólnym i powinna być dostępna bez ogranizeń. Postulujemy zniesienie opłat za korzystanie z domeny publicznej.</p>';
		$posts_content[6] = '<p>Chcesz st worzyć w Internecie serwis , który będzie łączył i wizualizował dane gromadzone przez różne instytucje publiczne – np. informacje o pogodzie, stanie dróg, korkach, itp. Zwracasz się do właściwych instytucji z prośbą o udostępnienie interesujących Cię materiałów. Otrzymujesz kilkanaście różnych odpowiedzi, a każda stawia inne warunki. Nie jesteś w stanie spełnić wszystkich warunków jednocześnie, do tego instytucje wyznaczają bardzo wysokie opłaty za wykorzystanie informacji. Rezygnujesz z realizacji pomysłu.</p><p>Postulujemy, aby wszelkie treści wytworzone za publiczne środki były dostępne dla wszystkich bez ograniczeń. Chodzi tu zarówno o dane publiczne – jak statystyki zbierane przez GUS czy dane meteorologiczne zbierane przez IMGW – jak i o finansowane publicznie treści: artykuły naukowe, materiały edukacyjne, dzieła. Co za tym idzie, instytucje publiczne powinny dbać o to by nabywać uprawnienia do materiałów, które powstają na ich zamówienie za publiczne pieniądze. A następnie udostępniać je bez ograniczeń.</p>';
		$posts_content[7] = '<p>Chcesz wydać „Króla Maciusia I” Janusza Korczaka. Wiesz, że Janusz Korczak zginął w Treblince w 1942 roku. Nie miał żadnych spadkobierców. W takim wypadku prawa autorskie odziedziczył Skarb Państwa. Zgłaszasz się zatem do Ministerstwa Skarbu Państwa (MSP) z prośbą o licencje. MSP odpowiada jednak, że nie może udzielić licencji bo prawa autorskie do dzieł Korczaka przekazało Instytutowi Książki . Dobra wiadomość jest taka , że Ministerstwo wie, co się dzieje z Korczakiem. Nie funkcjonuje bowiem prawidłowa inwentaryzacja wszystkich praw dziedziczonych przez państwo i MSP zazwyczaj nie orientuje się, do jakich utworów ma prawa. Natomiast zła wiadomość jest taka, że utwory Korczaka należące do państwa (czyli w pewnym uproszczeniu do nas wszystkich) nie są dostępne dla każdego bez ograniczeń. Zostały one powierzone Instytutowi Książki, który udziela na nie odpłatnych licencji wybranym podmiotom.</p><p>Postulujemy by Skarb Państwa i instytucje państwowe (takie jak Instytut Książki) nie ograniczały domeny publicznej, a wręcz przeciwnie, aby uwalniały do niej posiadane przez siebie treści. W tym celu należy wprowadzić ustawową możliwość zrzekania się praw autorskich, co dziś w Polsce jest niedozwolone. W ten sposób uprawnieni (tu: Skarb Państwa) będą mogli samodzielnie zasilać domenę publiczną, zamiast zmuszać społeczeństwo do czekania 70 lat od śmierci twórcy. Ewentualnie, postulujemy nałożenie obowiązku udostępniania utworów dziedziczonych przez Skarb Państwa na wolnej licencji Creative Commons Uznanie autorstwa.</p>';
		$posts_content[8] = '<p>W Filmotece Narodowej znajdujesz doskonały niemy film przedwojenny. Postanawiasz zdigitalizować film we własnym zakresie, dodać kolor i dialogi. Zadowolony z efektu prezentujesz film na festiwalu, po czym dostajesz list od prawnika, w którym czytasz że, „rozpowszechniasz opracowanie bez zezwolenia twórcy” i w związku z tym musisz zapłacić odszkodowanie na rzecz syna pana Ernesta, autora scenariusza. Ponadto wnuczka pana Fryderyka, nieżyjącego już reżysera filmu żąda, abyś nie rozpowszechniał swojego filmu ponieważ „narusza on prawo do integralności dzieła”. Chodzi o zasadę prawa autorskiego dającą posiadaczowi praw kontrolę nad wszelkimi przeróbkami utworu.</p><p>Jesteś zdziwiony. Przecież minęło już tyle lat od wyprodukowania filmu - więc dlaczego jeszcze ktoś „ściga Cię” za naruszenia praw? Jest tak dlatego, że czas trwania praw autorskich to 70 lat po śmierci autora (!). W przypadku filmów 70 lat liczy się od śmierci ostatniego z „kluczowych” współtwórców: głównego reżysera, autora scenariusza, kompozytora muzyki, autora dialogów.</p><p>Ponadto, niektóre prawa autorskie, tak zwane „osobiste” – tak jak prawo chroniące integralność - nigdy nie wygasają. Po śmierci autora trwają one nadal, a wskazane w ustawie osoby są upoważnione do ich wykonywania.</p><p>Postulujemy radykalne skrócenie czasu trwania autorskich praw majątkowych. A także, aby ograniczyć prawo do integralności tak, aby autor nie mógł bez ważnego powodu zakazać upubliczniania „remiksu” swojego dzieła, szczególnie jeśli ma ono charakter niekomercyjny.</p>';
		$posts_content[9] = '<p>Prowadzisz małą knajpkę. Zastanawiasz się w jakie kategorie najlepiej ułożyć w jadłospisie podawane u Ciebie dania. W końcu znajdujesz podpowiedź w zamieszczonym w sieci menu innej restauracji. Kopiujesz jego układ i zamieszczasz w swoim menu. Po jakimś czasie dostajesz list z wezwaniem do zapłaty odszkodowania za bezumowne wykorzystanie czyjegoś utworu, czyli: menu tamtej restauracji.</p><p>Żeby było jasne, nie skopiowałeś wyszukanej grafiki menu, a jedynie układ dań. I tak – w świetle obecnych przepisów – prawnik może Ci zarzucić, że skopiowałeś „oryginalny układ dań, który jest przejawem indywidualnej twórczości”, a więc utworem w rozumieniu prawa. Zakres prawa autorskiego jest dziś rozszerzany na obszary, których wcześniej nikt nie licencjonował. I czasem zbliża się niebezpiecznie blisko licencjonowania samych idei, pomysłów – czego przez wieki unikano.</p><p>Postulujemy debatę o rewizji pojęcia utworu, które uległo daleko idącej trywializacji. Prawo autorskie powinno obowiązywać w rozsądnych granicach, tak by niepotrzebnie nie utrudniało swobodnego korzystania ze wszelkich treści.</p>';
	
		$filenames[0]='CC_01';
		$filenames[1]='CC_02';
		$filenames[2]='CC_03';
		$filenames[3]='CC_04';
		$filenames[4]='CC_05';
		$filenames[5]='CC_06';
		$filenames[6]='CC_07';
		$filenames[7]='CC_08';
		$filenames[8]='CC_09';
		$filenames[9]='CC_10';

		add_theme_support( 'post-thumbnails' ); 
		add_image_size('cc_postcards_thumb', 164, 234, false);
	
	
		for($i=0; $i<10; $i++) {
			$post_args = $cc_postcards_page = array(
				'post_title' => $filenames[$i],
				'post_content' => $posts_content[$i],
				'post_status' => 'publish',
				'post_type' => 'cc_postcard',
				'post_author' => ''
			);
	
			$post_id = wp_insert_post($post_args);
	
			$new_pdf = $wp_upload_dir['path'].'/'.$filenames[$i].'.pdf';
			$old_pdf = $cc_postcards_dir.'/tpl/files/'.$filenames[$i].'.pdf';
			copy($old_pdf, $new_pdf);
	
			$new_png = $wp_upload_dir['path'].'/'.$filenames[$i].'.png';
			$old_png = $cc_postcards_dir.'/tpl/files/'.$filenames[$i].'.png';
			copy($old_png, $new_png);
	
			
			$pdf_filename  = $new_pdf;
			$png_filename = $new_png;
	
			$pdf_filetype = wp_check_filetype(basename($pdf_filename), null);
			$png_filetype = wp_check_filetype(basename($png_filename), null);
	
			$wp_upload_dir = wp_upload_dir();
	
			$pdf_attachment = array (
				'guid' => $wp_upload_dir['url'] . '/' . basename( $pdf_filename ), 
				'post_mime_type' => $pdf_filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($pdf_filename)),
				'post_content' => '',
				'post_status' => 'inherit'
			);
	
			$png_attachment = array (
				'guid' => $wp_upload_dir['url'] . '/' . basename( $png_filename ), 
				'post_mime_type' => $png_filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($png_filename)),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			
			$pdf = wp_insert_attachment( $pdf_attachment, $pdf_filename, $post_id);
			update_post_meta( $post_id, 'cc_postcard_pdf', $pdf);
	
			$png = wp_insert_attachment( $png_attachment, $png_filename, $post_id);

			$attach_data = wp_generate_attachment_metadata( $png, $png_filename );
			wp_update_attachment_metadata( $png,  $attach_data );
			add_post_meta($post_id, '_thumbnail_id', $png, true);


			
		}}

	update_option('cc_postcards_installed', '1');

}

register_activation_hook(__FILE__, cc_postcards_install);

function cc_postcards_uninstall() {
	if(get_option('cc_postcards_page_id')!='')
		wp_delete_post(get_option('cc_postcards_page_id'), true);
}

register_deactivation_hook(__FILE__, cc_postcards_uninstall);


/*-------------------------*/
/* Post thumbnails support */
/*-------------------------*/
function cc_postcards_thumbnail_support () {
	add_theme_support( 'post-thumbnails' ); 
	add_image_size('cc_postcards_thumb', 164, 234, false);
}
add_action('after_setup_theme', cc_postcards_thumbnail_support);


function cc_postcards_theme_redirect() {
	global $wp;
	$cc_postcards_dir = dirname(__FILE__);
	$cc_postcards_page_id = get_option('cc_postcards_page_id');
	$post_data = get_post($cc_postcards_page_id, ARRAY_A);
	$slug = $post_data['post_name'];

	if($wp->query_vars['page_id']==$cc_postcards_page_id || $wp->query_vars['pagename']==$slug ||  $wp->query_vars["post_type"] == 'cc_postcard') {
		cc_postcards_do_theme_redirect($cc_postcards_dir . '/tpl/cc-postcards-tpl.php');
	}
}
add_action('template_redirect', 'cc_postcards_theme_redirect');

function cc_postcards_do_theme_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}


/*-------------------------*/
/* Ajax                    */
/*-------------------------*/
if(is_admin()) {
	add_action('wp_ajax_cc_postcards_data', 'cc_postcards_ajax_data');
	add_action('wp_ajax_nopriv_cc_postcards_data', 'cc_postcards_ajax_data');
}

function cc_postcards_ajax_data() {
	$id=$_POST['postcard_id'];
	$args = array(
    	'post_type' => 'cc_postcard',
    	'posts_in' => array($id),
    	);
	$query = new WP_Query($args);
	if($query->have_posts()) {
		$query->the_post();
		$result['error']=$id;
		$result['url']=get_permalink($id);
		$content_post = get_post($id);
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$result['postcardcontent']=$content;
		$result['pdf']=wp_get_attachment_url(get_post_meta($id, 'cc_postcard_pdf', true));
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
		$result['img']=$thumb[0];
	}
	else
		$result['error']=1;
	$result = json_encode($result);
    die($result);
}

if(is_admin()) {
	add_action('wp_ajax_cc_postcards_recaptcha', 'cc_postcards_recaptcha');
	add_action('wp_ajax_nopriv_cc_postcards_recaptcha', 'cc_postcards_recaptcha');
}

require_once dirname( __FILE__ ) .'/adm/recaptchalib.php';

function cc_postcards_recaptcha() {
	$options = get_option('cc_postcards_settings');
	$key = $options['cc_postcards_recaptcha_private'];
	
	$challenge = $_POST['challenge'];
	$response = $_POST['response'];
	$ip = $_SERVER["REMOTE_ADDR"];
	
	$sn = $_POST['sn'];
	$se = $_POST['se'];
	$rn = $_POST['rn'];
	$re = $_POST['re'];
	$msg = $_POST['msg'];
	$pcid = $_POST['pcid'];



	$resp = recaptcha_check_answer ($key, $ip, $challenge, $response);
	if (!$resp->is_valid) {
		$result['resp']=0;
		$result['error']='recaptcha';
	}
	else {
		$result['resp']=1;

		$cc_sent_args = array(
			'post_title' => __('Pocztówka od ', 'cc_postcards').$sn,
			'post_content' => $msg,
			'post_status' => 'publish',
			'post_type' => 'cc_sent_postcard',
			'post_author' => ''
			);

		if($cc_sent_id = wp_insert_post($cc_sent_args)) {
			$hash = hash('md5', $msg.time());
			update_post_meta($cc_sent_id, 'cc_postcards_sn', $sn);
			update_post_meta($cc_sent_id, 'cc_postcards_se', $se);
			update_post_meta($cc_sent_id, 'cc_postcards_rn', $rn);
			update_post_meta($cc_sent_id, 'cc_postcards_re', $re);
			update_post_meta($cc_sent_id, 'cc_postcards_pcid', $pcid);
			update_post_meta($cc_sent_id, 'cc_postcards_hash', $hash);

			$r_url = get_permalink(get_option('cc_postcards_page_id')).'?i='.$cc_sent_id.'&h='.$hash;

			$msg = sprintf(__('%1$s wysłał do Ciebie pocztówkę z serii "%2$s"', 'cc_postcards'), $sn, $options['cc_postcards_title']).
				"\n\n".__('Treść wiadomości:', 'cc_postcards')."\n".$msg."\n\n".
				sprintf(__('Zobacz ją tutaj: %1$s', 'cc_postcards'), $r_url);
			$topic = sprintf(__('%1$s wysłał do Ciebie pocztówkę!', 'cc_postcards'), $sn);
			
			if($options['cc_postcards_sender_name']!='') {
				add_filter( 'wp_mail_from', 'cc_postcards_mail_from' );
			}

			if($options['cc_postcards_sender_email']!='') {
				add_filter( 'wp_mail_from_name', 'cc_postcards_mail_from_name' );
			}

			$mail = wp_mail( $re, $topic, $msg);
			if($mail==false) {
				$result['resp']=0;
				$result['error']='mail';
			}

			if($options['cc_postcards_sender_name']!='') {
				remove_filter( 'wp_mail_from', 'cc_postcards_mail_from' );
			}

			if($options['cc_postcards_sender_email']!='') {
				remove_filter( 'wp_mail_from_name', 'cc_postcards_mail_from_name' );
			}
		}
		else {
			$result['resp']=0;
			$result['error']='mail';
		}
	}
	$result = json_encode($result);
    die($result);
}

function cc_postcards_mail_from($email) {
	$options = get_option('cc_postcards_settings');
	return $options['cc_postcards_sender_email'];
}

function cc_postcards_mail_from_name($name) {
	$options = get_option('cc_postcards_settings');
	return $options['cc_postcards_sender_name'];
}



?>