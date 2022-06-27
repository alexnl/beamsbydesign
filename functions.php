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

include_once('inc/cpt-proposal.php');
include_once('inc/shortcodes-proposals.php');
include_once('inc/functions-gf.php');