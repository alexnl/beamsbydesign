<?php
// Register Custom Post Type
function proposal_post() {

	$labels = array(
		'name'                  => _x( 'Proposal', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Proposal', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Proposals', 'text_domain' ),
		'name_admin_bar'        => __( 'Proposals', 'text_domain' ),
		'archives'              => __( 'Proposal Archives', 'text_domain' ),
		'attributes'            => __( 'Proposal Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Proposal:', 'text_domain' ),
		'all_items'             => __( 'All Proposals', 'text_domain' ),
		'add_new_item'          => __( 'Add New Proposal', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Proposal', 'text_domain' ),
		'edit_item'             => __( 'Edit Proposal', 'text_domain' ),
		'update_item'           => __( 'Update Proposal', 'text_domain' ),
		'view_item'             => __( 'View Proposal', 'text_domain' ),
		'view_items'            => __( 'View Proposals', 'text_domain' ),
		'search_items'          => __( 'Search Proposal', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Proposal', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Proposal', 'text_domain' ),
		'items_list'            => __( 'Proposals list', 'text_domain' ),
		'items_list_navigation' => __( 'Proposals list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Proposals list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Proposal', 'text_domain' ),
		'description'           => __( 'Add a Proposal', 'text_domain'),
		'labels'                => $labels,
		'supports'              => array( 'title', 'revisions', 'author', 'custom-fields'),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-media-spreadsheet',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'show_in_rest' 			=> true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'proposal', $args );

}
add_action( 'init', 'proposal_post', 0 );