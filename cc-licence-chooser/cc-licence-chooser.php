<?php  
/* 
Plugin Name: CC Licence Chooser
Version: 0.1 
Description: Creative Commons Licence Chooser for Centrum Cyfrowe. To use LC please use <strong> [cc_licence_chooser] </strong> shortcode. <br> To <strong> reset </strong> to default content please activate and deactivate the plugin. <br> 
If you want to change the content go to Dashboard -> Settings -> CC licence chooser. 
Author URI: http://www.webchefs.pl/ 
Plugin URI: http://www.webchefs.pl/ 
*/

/*-------------------*/
/* Inits / Shortcode */
/*-------------------*/

require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-settings.php';
require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-front.php';

/* ----------------- */
/* Script and Styles */
/* ----------------- */

// Front End

function cc_licence_chooser_script_styles() {
    wp_register_script('cc-licence-chooser-js-front', plugins_url( '/js/cc-licence-chooser-js-front.js', __FILE__ ));
    wp_register_script('modernirie8', plugins_url( '/js/modernizr.custom.23501.js', __FILE__ ));

    wp_register_style('cc-licence-chooser-css-front', plugins_url( '/css/cc-licence-chooser-css-front.css', __FILE__ ));
    wp_register_style('cc-licence-chooser-css-front-fonts', 'http://fonts.googleapis.com/css?family=Ubuntu:200,300,600,700&subset=latin-ext');
    
    wp_enqueue_script('jquery');
    wp_enqueue_script('modernirie8', array( 'jquery' ));

    wp_enqueue_script('cc-licence-chooser-js-front', array( 'jquery' ));
    wp_localize_script('cc-licence-chooser-js-front', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ));
    

    wp_enqueue_style('cc-licence-chooser-css-front');
    wp_enqueue_style('cc-licence-chooser-css-front-fonts');
}


add_action( 'wp_enqueue_scripts', 'cc_licence_chooser_script_styles' );

// Back End

function cc_licence_chooser_admin_script_styles(){
    wp_register_script('cc-licence-chooser-js-admin', plugins_url( '/js/cc-licence-chooser-js-admin.js', __FILE__ ));
    wp_register_style('cc-licence-chooser-css-admin', plugins_url( '/css/cc-licence-chooser-css-admin.css', __FILE__ ));

    wp_enqueue_script('cc-licence-chooser-js-admin', array( 'jquery' ));
    wp_enqueue_script('jquery-ui-tabs', array('jquery') );
    wp_enqueue_script('jquery-ui-accordion', array('jquery') );
    wp_enqueue_style('cc-licence-chooser-css-admin');
}

add_action( 'admin_init', 'cc_licence_chooser_admin_script_styles', 1 );

// default content

require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-default-content/cc-licence-chooser-default-content-welcome-screen.php';

// licence outcomes
require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-default-content/cc-licence-chooser-default-outcome-by.php';
require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-default-content/cc-licence-chooser-default-outcome-by-sa.php';
require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-default-content/cc-licence-chooser-default-outcome-by-nd.php';
require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-default-content/cc-licence-chooser-default-outcome-by-nc.php';
require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-default-content/cc-licence-chooser-default-outcome-by-nc-sa.php';
require_once dirname( __FILE__ ) .'/php/cc-licence-chooser-default-content/cc-licence-chooser-default-outcome-by-nc-nd.php';

// install default content and leave it there

function cc_licence_chooser_load_content() { 

    $ff_asoc = array(
        "cc-licence-chooser-welcome-screen" => cc_licence_chooser_default_welcome()
        );
    for($i=1;$i<7;$i++) {
        switch($i) {
            case 1 : 
            $cc_licence = 'by';
            break;

            case 2 : 
            $cc_licence = 'by_sa';
            break;

            case 3 : 
            $cc_licence = 'by_nc';
            break;

            case 4 : 
            $cc_licence = 'by_nd';
            break;

            case 5 : 
            $cc_licence = 'by_nc_sa';
            break;

            case 6 : 
            $cc_licence = 'by_nc_nd';
            break;
        }
        $ff_asoc["cc-licence-chooser-outcome-" . $i] = call_user_func('cc_licence_chooser_default_outcome_' . $cc_licence);
    }
    foreach ($ff_asoc as $option => $content) {
        
            update_option($option, $content);
    }
}

register_activation_hook( __FILE__ , cc_licence_chooser_load_content);

?>