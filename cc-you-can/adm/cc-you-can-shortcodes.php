<?php
function cc_you_can_tooltip_shortcode ($atts, $content = null) {
	extract(shortcode_atts(array(
		'tooltip_text' => '',
	), $atts));

	return '<a href="#" class="cc-you-can-tooltip" data-cc-tooltip="'.$tooltip_text.'">'.$content.'</a>';
}

function cc_you_can_register_tooltip_button( $buttons ) {
   array_push( $buttons, "|", "cc_you_can_tooltip" );
   return $buttons;
}

function cc_you_can_add_tooltip_plugin( $plugin_array ) {
   $plugin_array['cc_you_can_tooltip'] = plugins_url( '/adm/js/cc-tooltip-shordcode.js' , dirname(__FILE__) );
   return $plugin_array;
}

function cc_you_can_tooltip_button() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'cc_you_can_add_tooltip_plugin' );
      add_filter( 'mce_buttons', 'cc_you_can_register_tooltip_button' );
   }

}

add_action('init', 'cc_you_can_tooltip_button');

function cc_you_can_register_shortcodes(){
   add_shortcode('cc-tooltip', 'cc_you_can_tooltip_shortcode');
   add_shortcode('cc-you-can', 'cc_you_can_thumbnails_shortcode');
}

function cc_you_can_thumbnails_shortcode () {
   $result = '<div id="cc-you-can-wrapper">';
   $result .= '<h1>'.__('W jaki sposób możesz korzystać z cudzych utworów?', 'cc_you_can').'</h1>';
   $result .= '<div id="cc-you-can-thumbnails" class="cc-you-can-clearfix">';
   $args = array(
         'post_type' => 'cc_you_can_work',
         'meta_key' => 'cc_you_can_order',
         'orderby' => 'meta_value_num',
         'order' => 'ASC', 
         'posts_per_page' => -1,
         );

   $q = new WP_Query($args);
   $i=1;
   while($q->have_posts()) {
      $q->the_post();
      $type = get_post_meta($q->post->ID, 'cc_you_can_work_category', true);
      if($type=='work')
         $i++;
      $result .= '<div class="cc-you-can-work-thumbnail-'.$type.' cc-you-can-work-thumbnail" id="cc-you-can-thumbnail-'.$i.'" data-order="'.$i.'" data-id="'.$q->post->ID.'">';
      if($type=='type' || $type=='public')
         $result .='<div class="cc-you-can-left-corner"></div>';
      if($type=='license' || $type=='public')
         $result .='<div class="cc-you-can-right-corner"></div>';
      $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($q->post->ID), 'cc_you_can_thumb' );
      $result .= '<div class="cc-you-can-icon" style="background-image: url('.$thumb[0].');">';
      $result .= '</div>';
      $result .= '<div class="cc-you-can-title"><h2>';
      $title_tooltip = get_post_meta($q->post->ID, 'cc_you_can_work_tooltip', true);
      if($title_tooltip!='')
         $result .= '<a href="#" class="cc-you-can-tooltip" data-cc-tooltip="'.$title_tooltip.'">'.get_the_title().'</a>';
      else
         $result .= get_the_title();
      $result .='</h2>';
      $subtitle = get_post_meta($q->post->ID, 'cc_you_can_work_subtitle', true);
      if($subtitle!='')
         $result .= '<p class="cc-you-can-subtitle">'.$subtitle.'</p>';
      $thumb_content = get_post_meta($q->post->ID, 'cc_you_can_work_thumbnail_content', true);
      if($thumb_content!='' && $type=='work')
         $result .= '<p class="cc-you-can-thumb-content">'.$thumb_content.'</p>';
      $result .= '</div>';
      $result .= '<div class="cc-you-can-arrow"></div>';
      $result .= '</div>';
      
      $i++;
   }
   $result .= '</div>';
   $result .= '<div id="cc-you-can-footer">';
   $result .= '<div id="cc-you-can-footer-legal-info">'.__('Aplikacja uwzględnia najczęstsze przypadki wykorzystywania cudzych utworów w ramach dozwolonego użytku. Więcej informacji w <a href="http://isap.sejm.gov.pl/Download?id=WDU19940240083&type=3">ustawie o prawie autorskim</a>', 'cc_you_can').'</div>';
   $result .= '<div id="cc-you-can-footer-license">'.__('Aplikacja dostępna jest na licencji <a href="http://creativecommons.org/licenses/by/3.0/pl/" target="_blank">Creative Commons Uznanie Autorstwa 3.0</a>', 'cc_you_can').'</div>';
   $result .= '<div id="cc-you-can-footer-bottom" class="cc-you-can-clearfix">';
   $result .= '<div id="cc-you-can-logos-1">';
   $result .= '<a href="http://www.centrumcyfrowe.pl/" id="cc-you-can-cc" class="cc-you-can-footer-logo"></a>';
   $result .= '<a href="http://www.nck.pl/" id="cc-you-can-nck" class="cc-you-can-footer-logo"></a>';
   $result .= '</div>';
   $result .= '<span id="cc-you-can-footer-text">'.__('Dofinansowano ze środków Narodowego Centrum Kultury w ramach Programu Narodowego Centrum Kultury – Kultura – Interwencje', 'cc_you_can').'</span>';
   $result .= '<div id="cc-you-can-logos-2">';
   $result .= '<a href="http://www.webchefs.pl/" id="cc-you-can-webchefs" class="cc-you-can-footer-logo"></a>';
   $result .= '<a href="http://www.vividstudio.pl/" id="cc-you-can-vivid" class="cc-you-can-footer-logo"></a>';
   $result .= '</div>';
   $result .= '</div>';
   $result .= '</div>';
   $result .= '</div>';

   return $result;
}



add_action( 'init', 'cc_you_can_register_shortcodes');
?>