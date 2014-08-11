<?php

/*-------------------------*/
/* Postcard post type      */
/*-------------------------*/
function cc_postcards_create_sent_postcard() {
	$labels = array(
		'menu_name' => 			__('Wysłane pocztówki', 'cc_postcards'),
		'name' => 				__('Wysłane pocztówki', 'cc_postcards'),
		'singular_name' => 		__('Wysłana pocztówka', 'cc_postcards'),
		);

	$args = array(
		'labels' => $labels,
		'description' => 'Wysłane pocztówki',
		'public' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => null,
		'show_ui' => false,
		'show_in_nav_menus' => false,
		'hierarchical' => false,
		'supports' => array(
			'title',
			'editor',
		),
		'capability_type' => 'post',
		);

	register_post_type('cc_sent_postcard', $args);
}
add_action('init', 'cc_postcards_create_sent_postcard' );
?>