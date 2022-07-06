<?php
// Options Page
if( function_exists('acf_add_options_page') ) {	
	acf_add_options_page(array(
		'page_title' 	=> 'Site Options',
		'menu_title'	=> 'Site Options',
		'menu_slug' 	=> 'site-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

// Setup Fixture File Fields
add_action( 'acf/init', 'setup_fixture_fields' );
function setup_fixture_fields() {
	if( function_exists('acf_add_local_field_group') ):
		acf_add_local_field_group(array(
			'key' => 'group_62b4c5ef8fae3fix',
			'title' => 'Fixtures',
			'fields' => array(),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'proposal',
					),
				),
			),
			'menu_order' => 1,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
			'show_in_rest' => 1,
		));
		for ($i=1; $i <= 15 ; $i++) : 
			if($i>3) {
				$c = 0;
			} else {
				$c = 1;
			}
			acf_add_local_field( array (
				'key' => 'field_62c5aff4e23fd'.$i,
				'label' => 'Fixture '.$i,
				'name' => 'fixture_'.$i,
				'type' => 'group',
				'parent' => 'group_62b4c5ef8fae3fix',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'table',
				'sub_fields' => array(),
			));
			acf_add_local_field( array (
				'key' => 'field_62b4c62af6b0b'.$i,
				'label' => 'Fixture '.$i.' File',
				'name' => 'fixture_'.$i.'_details_file',
				'type' => 'file',
				'parent' => 'field_62c5aff4e23fd'.$i,
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'id',
				'library' => 'all',
				'min_size' => '',
				'max_size' => 20,
				'mime_types' => '',
				'show_column' => $c,
				'show_column_weight' => 120,
				'allow_quickedit' => 0,
				'allow_bulkedit' => 0,
			));
			acf_add_local_field( array (
				'key' => 'field_62b4c67af6b0c'.$i,
				'label' => 'Fixture '.$i.' Quantity',
				'name' => 'fixture_'.$i.'_quantity',
				'type' => 'number',
				'parent' => 'field_62c5aff4e23fd'.$i,
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
				'show_column' => $c,
				'show_column_sortable' => 0,
				'show_column_weight' => 130,
				'allow_quickedit' => 0,
				'allow_bulkedit' => 0,
			));
		endfor;
	endif;
}