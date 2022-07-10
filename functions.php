<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

function my_custom_logo() { ?>
     <style type="text/css">
     	body.login {
			
		}
         #login h1 a, .login h1 a {
            background-image: none;
            content: 'Login to Beams by Design';
			color: #000;
			font-family: 'Roboto', sams-serif;
			text-indent: 0;
			width: 300px;
			height: auto;
			text-transform: uppercase;
			font-weight: 300;
         }
     </style>
 <?php } 
add_action( 'login_enqueue_scripts', 'my_custom_logo' );

// Hide Admin from Customers
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url_title() {
    return 'Beams by Design';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

// Check if user is logged in on proposals page
add_action( 'template_redirect', 'redirect_if_user_not_logged_in' );
function redirect_if_user_not_logged_in() {
	if (!is_user_logged_in()) {
		if(is_post_type_archive('proposal') or is_singular('proposal')) {
			$homeURL = get_bloginfo('url');
			wp_redirect($homeURL . '/wp-login.php', 301); 
			exit;
		}
	}
}

// create menu
function create_prop_menu($items, $args) {
	// var_dump($args);
	$homeURL = get_bloginfo('url');
	if( $args->menu == 'menu' ){
		if(is_user_logged_in()) {
			$proposals = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2" id="menu-item-2">'
						.'<a class="elementor-item" href="' . $homeURL . '/proposal">Proposals</a></li>';
			$account = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3" id="menu-item-3">'
						.'<a class="elementor-item" href="' . wp_logout_url() . '">Logout</a></li>';
		} else {
			$inquiry = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1" id="menu-item-1">'
						.'<a class="elementor-item" href="' . $homeURL . '/">Inquiry</a></li>';
			$account = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4" id="menu-item-4">'
						.'<a class="elementor-item" href="' . $homeURL . '/wp-login.php">Login</a></li>';
		}
		$items = $inquiry . $proposals . $account;
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'create_prop_menu', 10, 2 );

function gf_enqueue_required_files() {
    GFCommon::log_debug( __METHOD__ . '(): running.' );
    if ( is_singular('proposal')) {
        gravity_form_enqueue_scripts( 3, true );
    }
}
add_action( 'get_header', 'gf_enqueue_required_files' );

include_once('inc/cpt-proposal.php');
include_once('inc/functions-gf.php');
include_once('inc/shortcodes-proposals.php');
include_once('inc/functions-acf.php');