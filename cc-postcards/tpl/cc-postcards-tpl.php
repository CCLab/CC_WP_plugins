<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php $cc_tpl_dir = plugin_dir_url( __FILE__ ); ?>
		<title><?php bloginfo('name'); ?> - <?php _e('Pocztówki', 'cc_postcards'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,700,300italic,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo $cc_tpl_dir ?>css/fonts.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $cc_tpl_dir ?>css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $cc_tpl_dir ?>css/bootstrap-responsive.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $cc_tpl_dir ?>css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $cc_tpl_dir ?>css/responsive.css" type="text/css" />
		<?php $options = get_option('cc_postcards_settings'); ?>
		<?php wp_enqueue_script('jquery');?>
		<?php wp_enqueue_script('bootstrap', $cc_tpl_dir.'js/bootstrap.min.js'); ?>
		<?php wp_enqueue_script('cc_postcards_custom', $cc_tpl_dir.'js/custom.js'); ?>
		<?php wp_localize_script('cc_postcards_custom', 'cc_data', 
		array( 
			'url' => admin_url('admin-ajax.php'), 
			'recaptcha' => $options['cc_postcards_recaptcha_public'],
			'mailerror' => __('Wystąpił problem z wysłaniem wiadomośći, spróbój później.', 'cc_postcards'),
			'success' => $options['cc_postcards_message_sent'] ) ); ?>
		
		<?php if($options['cc_postcards_recaptcha_public']!='') {
			?>
			<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
			<?php
		}
		?>
		<meta property="og:title" content="<?php echo $options['cc_postcards_title']; ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo get_permalink( $post->ID ); ?>" />
		<?php
		if ('cc_postcard' == get_post_type()) {
			the_post();
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'cc_postcards_thumb' );
			?>
			<meta property="og:image" content="<?php echo $thumb[0]; ?>" />
        	<meta property="og:description" content="<?php echo get_the_excerpt(); ?>" />
			<?php
		} else {
			?>
			<meta property="og:description" content="<?php echo $options['cc_postcards_intro']; ?>" />
			<meta property="og:image" content="<?php echo $cc_tpl_dir ?>img/ccpp.png" />
			<?php
		}

		?>
	</head>
	<body <?php if(wp_is_mobile()) echo 'class="mobile"';?> data-permalink="<?php echo get_permalink(); ?>">

	<?php
	if($_GET['i'] && $_GET['h']) {
		$hash = get_post_meta( $_GET['i'], 'cc_postcards_hash', true);
		

		if($hash==$_GET['h']) {
			$id=get_post_meta( $_GET['i'], 'cc_postcards_pcid', true);
			$sn=get_post_meta( $_GET['i'], 'cc_postcards_sn', true);
			$se=get_post_meta( $_GET['i'], 'cc_postcards_se', true);
			$rn=get_post_meta( $_GET['i'], 'cc_postcards_rn', true);
			$re=get_post_meta( $_GET['i'], 'cc_postcards_re', true);
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$pdf = wp_get_attachment_url(get_post_meta($id, 'cc_postcard_pdf', true));

			$message_post = get_post($_GET['i']);
			$message = $message_post->post_content;
			$message = apply_filters('the_content', $message);
			$message = str_replace(']]>', ']]&gt;', $message);

			$url = get_permalink($id);
			?>
			<div id="sent-postcard-window" class="modal-window">
				<div class="modal-window-content">
					<div class="close-window"></div>
					<div class="row-fluid">
						<div class="span6 postcard-container">
							<img class="postcard-image" src="<?php echo $thumb[0];?>" alt="" />
							<div class="postcard-text">
								<div class="cnt"><?php echo $content; ?></div>
								<div class="license">
									<?php _e('Nasze materiały są dostępne na licencji Creative Commons Uznanie autorstwa, do swobodnego dzielenia się z innymi. <br /> <a target="_blank" href="http://creativecommons.org/licenses/by/3.0/pl/">http://creativecommons.org/licenses/by/3.0/pl/</a>', 'cc_postcards');?>
								</div>
							</div>
						</div>
						<div class="span5 offset1 postcard-buttons">
							<div class="message">
								<p><strong><?php _e('Od:', 'cc_postcards');?> </strong><?php echo $sn.' ('.$se.')';?></p>
								<p><strong><?php _e('Do:', 'cc_postcards');?> </strong><?php echo $rn.' ('.$re.')';?></p>
								<strong><?php _e('Wiadomość:', 'cc_postcards');?> </strong>
								<?php echo $message; ?></div>
							<a href="<?php echo $pdf; ?>" target="_blank" class="postcard-button download-button"><span class="cc-icon"></span><?php _e('pobierz pdf'); ?></a>
							<a href="#" class="postcard-button read-button"><span class="cc-icon"></span><?php _e('czytaj'); ?></a>
							<!--<a href="#" class="postcard-button print-button"><span class="cc-icon"></span><?php _e('drukuj'); ?></a>-->
							<div class="social-buttons">
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url;?>" target="_blank" class="postcard-button share-button fb">f</a>
								<a href="https://plus.google.com/share?url=<?php echo $url;?>" target="_blank" class="postcard-button share-button gp">g+</a>
								<a href="https://twitter.com/intent/tweet?url=<?php echo $url;?>" target="_blank" class="postcard-button share-button tt">t</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	?>
	<div id="view-window" class="modal-window">
		<div class="modal-window-content">
			<div class="close-window"></div>
			<div class="row-fluid">
				<div class="span6 postcard-container">
					<img class="postcard-image" src="" alt="" />
					<div class="postcard-text">
						<div class="cnt"></div>
						<div class="license">
							<?php _e('Nasze materiały są dostępne na licencji Creative Commons Uznanie autorstwa, do swobodnego dzielenia się z innymi. <br /> <a target="_blank" href="http://creativecommons.org/licenses/by/3.0/pl/">http://creativecommons.org/licenses/by/3.0/pl/</a>', 'cc_postcards');?>
						</div>
					</div>
				</div>
				<div class="span5 offset1 postcard-buttons">
					<a href="#" target="_blank" class="postcard-button download-button"><span class="cc-icon"></span><?php _e('pobierz pdf'); ?></a>
					<a href="#" class="postcard-button read-button"><span class="cc-icon"></span><?php _e('czytaj'); ?></a>
					<a href="#" class="postcard-button print-button"><span class="cc-icon"></span><?php _e('drukuj'); ?></a>
					<a href="#" class="postcard-button send-button"><span class="cc-icon"></span><?php _e('wyślij'); ?></a>
					<div class="social-buttons">
						<a href="#" target="_blank" class="postcard-button share-button fb">f</a>
						<a href="#" target="_blank" class="postcard-button share-button gp">g+</a>
						<a href="#" target="_blank" class="postcard-button share-button tt">t</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="info-window" class="modal-window">
		<div class="modal-window-content">
			<div class="close-window"></div>
			<div class="row-fluid">
				<div class="span12" id="info-content"></div>
			</div>
		</div>
	</div>
	<div id="send-window" class="modal-window">
		<div class="modal-window-content">
			<div class="close-window"></div>
			<div class="row-fluid">
				<div class="span12">
					<div class="postcard-text">
						<div class="cnt"></div>
						<div class="license">
							<?php _e('Nasze materiały są dostępne na licencji Creative Commons Uznanie autorstwa, do swobodnego dzielenia się z innymi. <br /> <a target="_blank" href="http://creativecommons.org/licenses/by/3.0/pl/">http://creativecommons.org/licenses/by/3.0/pl/</a>', 'cc_postcards');?>
						</div>
					</div>
				</div>	
			</div>
			<div class="row-fluid">
				<div class="span4">
					<img class="postcard-image" src="" alt="" />
				</div>
				<div class="span7 offset1 form">
					<form action="">
						<input type="hidden" id="postcard_id" name="postcard_id" />
						<div class="row-fluid">
							<div class="span3 group"><?php _e('nadawca', 'cc_postcards'); ?></div>
							<div class="span2 rght field"><?php _e('imię', 'cc_postcards'); ?></div>
							<div class="span7"><input name="cc_postcards_sn" id="cc_postcards_sn" type="text"></input></div>
						</div>
						<div class="row-fluid">
							<div class="span2 offset3 rght field"><?php _e('e-mail', 'cc_postcards'); ?></div>
							<div class="span7"><input name="cc_postcards_se" id="cc_postcards_se" type="text"></input></div>
						</div>
						<div class="row-fluid space">
							<div class="span3 group"><?php _e('odbiorca', 'cc_postcards'); ?></div>
							<div class="span2 rght field"><?php _e('imię', 'cc_postcards'); ?></div>
							<div class="span7"><input name="cc_postcards_rn" id="cc_postcards_rn" type="text"></input></div>
						</div>
						<div class="row-fluid">
							<div class="span2 offset3 rght field"><?php _e('e-mail', 'cc_postcards'); ?></div>
							<div class="span7"><input name="cc_postcards_re" id="cc_postcards_re" type="text"></input></div>
						</div>
						<div class="row-fluid space">
							<div class="span3 group"><?php _e('dodaj komentarz', 'cc_postcards'); ?></div>
							<div class="span7 offset2"><textarea name="cc_postcards_msg" id="cc_postcards_msg" rows="5"></textarea></div>
						</div>
						<div class="row-fluid space">
							<div class="span3 group"><?php _e('przepisz kod', 'cc_postcards'); ?></div>
							<div class="span7 offset2" id="recaptcha">
								<div id="recaptcha_widget">
									<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
									<div id="recaptcha_image"></div>
									<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
									<div id="recaptcha_reload"><a href="javascript:Recaptcha.reload()"><?php _e('inny obrazek', 'cc_postcards'); ?></a></div>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span7 offset5"><a href="#" id="send-postcard" class="postcard-button send-button"><span class="cc-icon"></span><?php _e('wyślij'); ?></a></div>
						</div>
						
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container" id="black-border">
		<div class="row">
			<div class="span5 offset1" id="page-title"><h1><?php echo $options['cc_postcards_title']; ?></h1></div>
			<div class="span2 offset3">
				<a href="http://centrumcyfrowe.pl/" target="_blank" id="ccpp"></a>
			</div>
		</div>
		<div class="row">
			<div class="span4" id="title-border-left"></div>
			<div class="span8 hidden-phone" id="title-border-right"></div>
		</div>
		<div class="row">
			<div class="span10 offset1" id="intro-text">
				<?php echo $options['cc_postcards_intro']; ?>
			</div>
		</div>
		<div class="row">
			<div class="span10 offset1" id="instruction-text">
				<?php echo $options['cc_postcards_call']; ?>
			</div>
		</div>

		<div class="row" id="postcards-thumbs">
			<div class="span10 offset1">
				<div class="row">
					<?php
					$postcard_id = $post->ID;
					$args = array(
						'post_type' => 'cc_postcard',
						'orderby' => 'title', 
						'order' => 'ASC',
						'posts_per_page' => -1,
						);
					
					$pc_q = new WP_Query($args);

					while($pc_q->have_posts()) {
						$pc_q->the_post();
						$opened = "";
						if($pc_q->post->ID==$postcard_id) 
							$opened = " opened";
						?>
						<div class="span2">
							<div class="postcard<?php echo $opened;?>" data-permalink="<?php echo get_permalink(); ?>" data-id="<?php echo $pc_q->post->ID; ?>">
								<?php the_post_thumbnail('cc_postcards_thumb'); ?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>

		<?php if($options['cc_postcards_pdf_pack']!='') {
			?>
			<div class="row" id="main-download-button">
				<div class="span5 offset1">
					<a href="<?php echo wp_get_attachment_url($options[cc_postcards_pdf_pack]); ?>" class="cc-button">
						<span class="cc-icon pdf-icon"></span>
						<span class="cc-button-content">
							<strong>
								<?php _e('pobierz komplet pocztówek', 'cc_postcards');?>
							</strong> (pdf)
						</span>
					</a>
				</div>
			</div>
			<?php
		}
		?>

		<?php if($options['cc_postcards_svg_pack']!='') {
			?>
			<div class="row" id="main-download-button">
				<div class="span5 offset1">
					<a href="<?php echo wp_get_attachment_url($options[cc_postcards_svg_pack]); ?>" class="cc-button">
						<span class="cc-icon svg-icon"></span>
						<span class="cc-button-content">
							<strong>
								<?php _e('zremiksuj nasze pocztówki', 'cc_postcards');?>
							</strong> (svg)
						</span>
					</a>
				</div>
			</div>
			<?php
		}
		?>
		<div class="row">
			<div class="span12" id="expander"></div>
		</div>
		<div class="row">
			<div class="span10 offset1">
				<div id="creative-commons">
					<?php _e('Nasze materiały są dostępne na licencji Creative Commons Uznanie autorstwa<br/> <a target="_blank" href="http://creativecommons.org/licenses/by/3.0/pl/">http://creativecommons.org/licenses/by/3.0/pl/</a>', 'cc_postcards');?>
				</div>
				<div id="postcards-author">
					<?php _e('Projekt pocztówek: <a href="http://piotrekchuchla.com">piotrekchuchla.com</a>', 'cc_postcards');?>
				</div>
			</div>
		</div>
		<div class="row" id="footer">
			<div class="span9 offset1"><?php _e('Dofinansowano ze środków Narodowego Centrum Kultury w ramach Programu Narodowego Centrum Kultury – Kultura – Interwencje', 'cc_postcards');?></div>
			<div class="span1">
				<div id="nck-logo"></div>
			</div>
		</div>
	</div>
	<div id="print">
		<div id="print-title" style="padding-bottom: 5pt; border-bottom: 1pt solid #000; margin-bottom: 40pt;">
			<h1 style="margin: 2pt; padding: 0pt;"><?php echo $options['cc_postcards_title']; ?></h1>
		</div>
		<div id="print-main-content">
			<div>
				<?php echo $options['cc_postcards_intro']; ?>
			</div>
			<div style="font-weight: 700; padding-top: 10pt">
				<?php echo $options['cc_postcards_call']; ?>
			</div>
			<div style="padding-top: 10pt;">
			<?php
			$args = array(
				'post_type' => 'cc_postcard',
				'orderby' => 'title', 
				'order' => 'ASC',
				'posts_per_page' => -1,
				);
			
			$pc_q = new WP_Query($args);

			while($pc_q->have_posts()) {
				$pc_q->the_post();
				$attr = array('style' => 'margin: 10pt; border: 2pt solid #000;');
				?>
				<?php the_post_thumbnail('cc_postcards_thumb', $attr); ?>
				<?php
			}
			?>
			</div>
		</div>
		<div id="print-postcard-content" class="no-p">
			<div id="print-image" style="text-align: center;"><img src="" style="width: 230pt; height: auto; border: 2pt solid #000;" /></div>
			<div id="print-text"></div>
			<div>
				<?php _e('Nasze materiały są dostępne na licencji Creative Commons Uznanie autorstwa, do swobodnego dzielenia się z innymi. <br /> <a href="http://creativecommons.org/licenses/by/3.0/pl/">http://creativecommons.org/licenses/by/3.0/pl/</a>', 'cc_postcards');?>
			</div>
		</div>
		<div id="print-footer" style="border-top: 1pt solid #000; padding-top: 10pt; margin-top: 30pt;">
			<div class="print-logos" style="text-align: center;">
				<img style="margin-right: 50pt;" src="<?php echo $cc_tpl_dir ?>img/nck.png" height="50" alt="nck">
				<img src="<?php echo $cc_tpl_dir ?>img/ccpp.png"  height="50" alt="centrum cyfrowe">
			</div>
			<div style="padding-top: 10pt"><?php _e('Dofinansowano ze środków Narodowego Centrum Kultury w ramach Programu Narodowego Centrum Kultury – Kultura – Interwencje', 'cc_postcards');?>
			</div>
		</div>
	</div>
	<div id="credits" class="container">
		<div class="row">
			<div class="span6 offset6">
				
				<div id="code">KODOWANIE:<a href="http://www.webchefs.pl" target="_blank" class="logo"></a></div>
				<div id="graphics">GRAFIKA:<a href="http://www.vividstudio.pl" target="_blank" class="logo"></a></div>
			</div>
		</div>
	</div>
	<?php wp_footer(); ?> 
	</body>
</html>