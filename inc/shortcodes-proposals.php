<?php
// Proposals Shortcodes

function get_proposals_for_active_user() {
	$userID = get_current_user_id();
	$props = get_posts (
		array (
			'post_type'		=> 'proposal',
			'numberposts'	=> -1,
			'orderby'		=> 'date',
			'order'			=> 'DESC',
			'post_status'   => 'publish',
			'meta_key' 		=> 'customer',
			'meta_value' 	=> $userID,
		),
	);

	$output = '<table class="proposal-table">';
	$output .= '<thead><tr>';
		$output .= '<th></th>';
		$output .= '<th>Submitted</th>';
		$output .= '<th>Project Name</th>';
		$output .= '<th>Fixture 1</th>';
		$output .= '<th>Fixture 2</th>';
		$output .= '<th>Sub-total</th>';
		$output .= '<th>Status</th>';
	$output .= '</tr></thead>';
	$output .= '<tbody>';
	foreach($props as $prop) {
		// Get ACF Fields
		$status 	= get_field('status', $prop->ID);
		$fix1 		= get_field('fixture_1_details_file', $prop->ID);
		$fix1_qty 	= get_field('fixture_1_quantity', $prop->ID);
		$fix2 		= get_field('fixture_2_details_file', $prop->ID);
		$fix2_qty 	= get_field('fixture_2_quantity', $prop->ID);
		$cost 		= get_field('price', $prop->ID);
		// Output Proposal
		$output .= '<tr>';
			$output .= '<td class="proposal-details"><a href="'.get_permalink($prop->ID).'"><img alt="Proposal Details" src="'.get_stylesheet_directory_uri().'/assets/images/square-arrow-up-right-solid.svg"></a></td>';
			$output .= '<td class="proposal-date">'.get_the_date(('M d, Y'), $prop->ID).'</td>';
			if(get_the_title($prop->ID)) {
				$output .= '<td class="project-name"><a href="'.get_permalink($prop->ID).'">'.get_the_title($prop->ID).'</a></td>';
			} else {
				$output .= '<td class="no-project-name">-</td>';
			}
			$output .= '<td><div class="fixture-1"><a target="_blank" href="'.$fix1['url'].'"><img src="'.get_stylesheet_directory_uri().'/assets/images/file-lines-solid.svg"> '.$fix1['title'].'</a> ('.$fix1_qty.' qty)</td>';
			if($fix2) {
				$output .= '<td><div class="fixture-2"><a target="_blank" href="'.$fix2['url'].'"><img src="'.get_stylesheet_directory_uri().'/assets/images/file-solid.svg"> '.$fix2['title'].'</a> ('.$fix2_qty.' qty)</td>';
			} else {
				$output .= '<td class="no-fixture-2"></td>';
			}
			if($cost) {
				$output .= '<td class="cost">$'.$cost.'</td>';
			} else {
				$output .= '<td class="cost">TBD</td>';
			}
			if($status == 'pending') {
				$output .= '<td class="status">Pending</td>';	
			} elseif($status == 'ready' and !empty($cost)) {
				$output .= '<td class="status payment-button"><a href="#">Make Payment</td>';
			} else {
				$output .= '<td class="status">Ready</td>';
			}
		$output .= '<tr>';
	}
	$output .= '</tbody>';
	$output .= '</table>';

	return $output;
}
add_shortcode('proposals-table', 'get_proposals_for_active_user');

function proposal_delivery_address() {
	if(is_singular('proposal')) {
		$address 	= get_field('delivery_address');
		$address2 	= get_field('delivery_address_line_2');
		$city 		= get_field('city');
		$prov 		= get_field('province_state');
		$zip 		= get_field('zip_postal_code');
		$country	= get_field('country');
		if($address2) {
			$address2 = $address2;
		} else {
			$address2 = '';
		}
		$output = '<div class="proposal-address"><h6>Address</h6>' . $address . ', ' . $address2 . '<br>' . $city . ', ' . $prov . '<br>' . $country . '&nbsp;&nbsp;' . $zip . '</div>'; 
	} else {
		$output = '';
	}

	return $output;

}
add_shortcode('proposal-address', 'proposal_delivery_address');