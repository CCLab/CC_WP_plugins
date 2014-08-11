<?php

function cc_you_can_create_work() {
	$labels = array(
		'menu_name' => 			__('Rodzaje utworów/licencji', 'cc_you_can'),
		'name' => 				__('Rodzaje utworów/licencji', 'cc_you_can'),
		'singular_name' => 		__('Rodzaj utworu/licencja', 'cc_you_can'),
		'add_new' => 			__('Dodaj rodzaj utworu', 'cc_you_can'),
		'add_new_item' => 		__('Dodaj rodzaj utworu', 'cc_you_can'),
	    'edit_item' => 			__('Edytuj', 'cc_you_can'),
		'new_item' => 			__('Nowy rodzaj utworu / licencja', 'cc_you_can'),
		'view_item' => 			__('Zobacz', 'cc_you_can'),
		'search_items' =>	 	__('Szukaj', 'cc_you_can'),
		'not_found' =>  		__('Nie znaleziono niczego', 'cc_you_can'),
		'not_found_in_trash' => __('Nie znaleziono w koszu', 'cc_you_can'),
		);

	$args = array(
		'labels' => $labels,
		'description' => 'Rodzaje utworów/licencji',
		'public' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => null,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'hierarchical' => false,
		'supports' => array(
			'title',
			'revisions',
			'thumbnail',
			'custom-fields'
		),
		'capability_type' => 'post',
		);

	register_post_type('cc_you_can_work', $args);
}
add_action('init', 'cc_you_can_create_work' );


function cc_you_can_add_work_metaboxes() {
	add_meta_box('cc_you_can_content_metabox', __('Informacje o utworze / licencji', 'cc_you_can'), 'cc_you_can_content_metabox_inner', 'cc_you_can_work', 'normal', 'high');
	add_meta_box('cc_you_can_settings_metabox', __('Ustawienia', 'cc_you_can'), 'cc_you_can_settings_metabox_inner', 'cc_you_can_work', 'side', 'default');
}
add_action('add_meta_boxes', 'cc_you_can_add_work_metaboxes');


function cc_you_can_content_metabox_inner($post) {
	$keys = array(	'cc_you_can_work_you_can',
					'cc_you_can_work_you_cant',
					'cc_you_can_work_condition',
					'cc_you_can_work_additional_info');

	?>
	<p><?php _e('Wypełnij poszczególne działy korzystając z poniższych pól.', 'cc_you_can'); ?></p>
	<p><?php _e('W okienku "Ustawienia", które znajduje się w bocznym panelu, możesz doać podtytuł oraz treść podpowiedzi do tytułu. W przypadku kategorii "Utwór" możesz dodać także treść kafelka.', 'cc_you_can'); ?></p>
	<?php
	for($i=0; $i<sizeof($keys); $i++) {
		$values[$keys[$i]]=get_post_meta($post->ID, $keys[$i], true);
	}

	$names = array(	__('Możesz', 'cc_you_can'), 
					__('Nie możesz', 'cc_you_can'),
					__('Warunek', 'cc_you_can'),
					__('Dodatki', 'cc_you_can') );

	$settings = array( 'media_buttons' => false );

	for($i=0; $i<4; $i++) {
		echo '<h2 class="cc-you-can-editor-title">'.$names[$i].'</h2>';
		wp_editor( $values[$keys[$i]], $keys[$i], $settings );
	}

	echo '<input type="hidden" name="cc_you_can_content_metabox_noncename" id="cc_you_can_content_metabox_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__).$post->ID).'" />';
}


function cc_you_can_content_metabox_save($post_id) {
	global $post;
	if (!wp_verify_nonce($_POST['cc_you_can_content_metabox_noncename'], plugin_basename(__FILE__).$post->ID)) {
    	return $post->ID;
 	}
 	$keys = array(	'cc_you_can_work_you_can',
					'cc_you_can_work_you_cant',
					'cc_you_can_work_condition',
					'cc_you_can_work_additional_info');

	for($i=0; $i<sizeof($keys); $i++) {
		update_post_meta($post_id, $keys[$i], $_POST[$keys[$i]]);
	}
}
add_action( 'save_post', 'cc_you_can_content_metabox_save');


function cc_you_can_settings_metabox_inner($post) {
	$keys = array(	'cc_you_can_work_category',
					'cc_you_can_work_subtitle',
					'cc_you_can_work_tooltip',
					'cc_you_can_work_thumbnail_content',
					'cc_you_can_order');

	for($i=0; $i<sizeof($keys); $i++) {
		$values[$keys[$i]]=get_post_meta($post->ID, $keys[$i], true);
	}

	$categories = array('work', 'public', 'type', 'license');
	$categories_names = array( __('Utwór', 'cc_you_can'), __('Domena publiczna', 'cc_you_can'), __('Rodzaj utworu', 'cc_you_can'), __('Licencja', 'cc_you_can'));

	?>
	<div class="cc-you-can-options-div">	
		<strong>Typ obiektu:</strong><br/>
		<select name="cc_you_can_work_category" id="cc_you_can_work_category">
			<?php
			for($i=0; $i<4; $i++) {
				if($values['cc_you_can_work_category']==$categories[$i])
					echo '<option value="'.$categories[$i].'" selected="selected">'.$categories_names[$i].'</option>';
				else
					echo '<option value="'.$categories[$i].'">'.$categories_names[$i].'</option>';
			}
			?>
		</select>
	</div>
	<div class="cc-you-can-options-div">
		<strong><?php _e('Podtytuł:', 'cc_you_can'); ?></strong><br/>
		<input type="text" name="cc_you_can_work_subtitle" id="cc_you_can_work_subtitle" value="<?php echo $values['cc_you_can_work_subtitle'];?>">
	</div>
	<div class="cc-you-can-options-div">
		<strong><?php _e('Podpowiedź do tytułu:', 'cc_you_can'); ?></strong><br/>
		<textarea name="cc_you_can_work_tooltip" id="cc_you_can_work_tooltip" rows="5"><?php echo $values['cc_you_can_work_tooltip'];?></textarea>
	</div>
	<div class="cc-you-can-options-div" id="cc_you_can_work_thumbnail_content_container"> 
		<strong><?php _e('Treść kafelka:', 'cc_you_can'); ?></strong><br/>
		<small><?php _e('Możesz użyć znacznika &lt;span&gt; aby wyróżnić tekst na zielono.', 'cc_you_can'); ?></small><br/>
		<textarea name="cc_you_can_work_thumbnail_content" id="cc_you_can_work_thumbnail_content" rows="5"><?php echo $values['cc_you_can_work_thumbnail_content'];?></textarea>
	</div>
	<input type="hidden" name="cc_you_can_order" value="<?php echo $values['cc_you_can_order']; ?>">
	<?php
	echo '<input type="hidden" name="cc_you_can_settings_metabox_noncename" id="cc_you_can_settings_metabox_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__).$post->ID).'" />';
}

function cc_you_can_settings_metabox_save($post_id) {
	global $post;
	if (!wp_verify_nonce($_POST['cc_you_can_settings_metabox_noncename'], plugin_basename(__FILE__).$post->ID)) {
    	return $post->ID;
 	}

	$keys = array(	'cc_you_can_work_category',
					'cc_you_can_work_subtitle',
					'cc_you_can_work_tooltip',
					'cc_you_can_work_thumbnail_content',
					'cc_you_can_order');

	for($i=0; $i<sizeof($keys); $i++) {
		$values[$keys[$i]]=get_post_meta($post->ID, $keys[$i], true);
	}

	for($i=0; $i<sizeof($keys); $i++) {
		update_post_meta($post_id, $keys[$i], $_POST[$keys[$i]]);
	}
}

add_action( 'save_post', 'cc_you_can_settings_metabox_save');

function cc_you_can_add_submenu_page() {
	add_submenu_page('edit.php?post_type=cc_you_can_work', __('Kolejność', 'cc_you_can'), __('Kolejność', 'cc_you_can'), 'edit_posts', 'cc_you_can_order', 'cc_you_can_order_page');
}
add_action ('admin_menu', 'cc_you_can_add_submenu_page');


function cc_you_can_order_page() {
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br/></div>
		<h2><?php _e('Kolejność wyświetlania', 'cc_you_can'); ?></h2>
		<form method="post" action="">
		<p><?php _e('Przeciągnij elementy, aby zmienić ich kolejność wyświetlania.', 'cc_you_can'); ?></p>
		<?php submit_button(); ?>
		<ul id="cc-sortable">
		<?php
		if($_POST['cc_you_can_order']!='') {
			$posts=json_decode(stripslashes($_POST['cc_you_can_order']));
			for($i=0; $i<sizeof($posts); $i++) {
				update_post_meta($posts[$i], 'cc_you_can_order', $i+1);
			}
		}

		$args = array(
			'post_type' => 'cc_you_can_work',
			'meta_key' => 'cc_you_can_order',
			'orderby' => 'meta_value_num',
			'order' => 'ASC', 
			'posts_per_page' => -1,
			);
					
		$q = new WP_Query($args);

		while($q->have_posts()) {
			$q->the_post();
			$category = get_post_meta($q->post->ID, 'cc_you_can_work_category', true);
			if($category == 'work')
				$category = __('utwór', 'cc_you_can');
			else if($category == 'type')
				$category = __('rodzaj utworu', 'cc_you_can');
			else if($category=='public')
				$category = __('domena publiczna', 'cc_you_can');
			else 
				$category = __('licencja');
			echo '<li class="ui-state-default" id="'.$q->post->ID.'">'.get_the_title().'<span class="cc_you_can_order_type">'.$category.'</span></li>';
		}
		?>
		</ul>
		<?php submit_button(); ?>
		<textarea id="cc_you_can_order" name="cc_you_can_order"></textarea>
		</form>
	</div>
	<?php
}


function cc_you_can_load_admin_styles() {
        wp_register_style( 'cc_you_can_admin_css', plugins_url( 'css/cc-you-can-post-type.css' , __FILE__ ));
        wp_enqueue_style( 'cc_you_can_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'cc_you_can_load_admin_styles' );


function cc_you_can_load_admin_scripts() {
        wp_register_script( 'cc_you_can_admin_js', plugins_url( 'js/cc-you-can-post-type.js' , __FILE__ ));
        wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'cc_you_can_admin_js' );
}
add_action( 'admin_enqueue_scripts', 'cc_you_can_load_admin_scripts' );


function cc_you_can_set_works_order($wp_query) {  
	if (is_admin()) {  
		$post_type = $wp_query->query['post_type'];  

		if ( $post_type == 'cc_you_can_work') {  
			$wp_query->set('meta_key', 'cc_you_can_order'); 
			$wp_query->set('orderby', 'meta_value_num');  
			$wp_query->set('order', 'ASC');  
		}  
	}  
}  
add_filter('pre_get_posts', 'cc_you_can_set_works_order'); 

?>