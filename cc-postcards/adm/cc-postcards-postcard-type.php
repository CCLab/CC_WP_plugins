<?php

/*-------------------------*/
/* Postcard post type      */
/*-------------------------*/
function cc_postcards_create_postcard() {
	$labels = array(
		'menu_name' => 			__('Pocztówki', 'cc_postcards'),
		'name' => 				__('Pocztówki', 'cc_postcards'),
		'singular_name' => 		__('Pocztówka', 'cc_postcards'),
		'add_new' => 			__('Dodaj pocztówkę', 'cc_postcards'),
		'add_new_item' => 		__('Dodaj pocztówkę', 'cc_postcards'),
	    'edit_item' => 			__('Edytuj pocztówkę', 'cc_postcards'),
		'new_item' => 			__('Nowa pocztówka', 'cc_postcards'),
		'view_item' => 			__('Zobacz pocztówkę', 'cc_postcards'),
		'search_items' =>	 	__('Szukaj pocztówek', 'cc_postcards'),
		'not_found' =>  		__('Nie znaleziono pocztówek', 'cc_postcards'),
		'not_found_in_trash' => __('Nie znaleziono w koszu', 'cc_postcards'),
		);

	$args = array(
		'labels' => $labels,
		'description' => 'Pocztówki',
		'public' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => null,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'hierarchical' => false,
		'supports' => array(
			'title',
			'revisions',
			'editor',
			'thumbnail',
			'excerpt',
		),
		'capability_type' => 'post',
		);

	register_post_type('cc_postcard', $args);
}
add_action('init', 'cc_postcards_create_postcard' );



/*-------------------------*/
/* Admin meta boxes 	   */
/*-------------------------*/
function cc_postcards_add_postcard_metabox() {
	add_meta_box('cc_postcard_metabox', 'Plik PDF', 'cc_postcards_inner_postcard_metabox', 'cc_postcard', 'normal', 'high');
}
add_action('add_meta_boxes', 'cc_postcards_add_postcard_metabox');


function cc_postcards_inner_postcard_metabox($post) {
	$keys = array('cc_postcard_pdf');
	for($i=0; $i<sizeof($keys); $i++) {
		$values[$keys[$i]]=get_post_meta($post->ID, $keys[$i], true);
	}

	?>
	<div style="padding-bottom: 10px;"><?php _e('Załaduj pocztówkę w wersji PDF. Plik ten będzie dostępny do pobrania dla użytkowników.', 'cc_postcards');?></div>
	<div style="padding-bottom: 10px;">
		<strong><?php _e('Załadowany plik:', 'cc_postcards'); ?> </strong>
		<span id="file-name">
			<?php
			if($values['cc_postcard_pdf']!="") {
				echo '<a href="'.wp_get_attachment_url($values['cc_postcard_pdf']).'" target="_blank">'.basename ( get_attached_file($values['cc_postcard_pdf'] ) ).'</a>';
			}
			else echo "----------";
			?>
		</span>
	</div>
	<button class="button" id="upload_file"><?php _e('Dodaj', 'cc_postcards'); ?></button>
	<button class="button" id="delete_file"><?php _e('Usuń', 'cc_postcards'); ?></button>

	<input type="hidden" id="cc_postcard_pdf" name="cc_postcard_pdf" value="<?php echo $values['cc_postcard_pdf'];?>"></input>

	<?php
	echo '<input type="hidden" name="cc_postcard_pdf_noncename" id="cc_postcard_pdf_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__).$post->ID).'" />';
}


function cc_postcards_save_postcard_postdata($post_id) {
	global $post;
	if (!wp_verify_nonce($_POST['cc_postcard_pdf_noncename'], plugin_basename(__FILE__).$post->ID)) {
    	return $post->ID;
 	}
 	$keys = array('cc_postcard_pdf');
	for($i=0; $i<sizeof($keys); $i++) {
		update_post_meta($post_id, $keys[$i], $_POST[$keys[$i]]);
	}
}
add_action( 'save_post', 'cc_postcards_save_postcard_postdata');


function cc_postcards_admin_script() {
    global $post_type;
    if( 'cc_postcard' == $post_type ) {
    	wp_enqueue_script('cc_postcards_postcard_type', plugins_url('js/cc-postcards-postcard-type.js', __FILE__));
	}
}
add_action( 'admin_print_scripts-post-new.php', 'cc_postcards_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'cc_postcards_admin_script', 11 );
?>