<?php
// Proposals Shortcodes

function get_proposals_for_active_user() {
	$userData = get_userdata(get_current_user_id());
	$userEmail = $userData->user_email;

	$props = get_posts (
		array (
			'post_type'		=> 'proposal',
			'numberposts'	=> -1,
			'orderby'		=> 'date',
			'order'			=> 'DESC',
			'post_status'   => 'publish',
			'meta_key' 		=> 'customer',
			'meta_value' 	=> $userEmail,
		),
	);
	if(count($props) > 0) :
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
				$output .= '<td><div class="fixture-1"><a target="_blank" href="'.wp_get_attachment_url($fix1).'"><img src="'.get_stylesheet_directory_uri().'/assets/images/file-lines-solid.svg"> Attachment</a> ('.$fix1_qty.' qty)</td>';
				if($fix2) {
					$output .= '<td><div class="fixture-2"><a target="_blank" href="'.wp_get_attachment_url($fix2).'"><img src="'.get_stylesheet_directory_uri().'/assets/images/file-solid.svg"> Attachment</a> ('.$fix2_qty.' qty)</td>';
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
					$output .= '<td class="status payment-button"><a href="'.get_permalink($prop->ID).'">Make Payment</td>';
				} else {
					$output .= '<td class="status">Ready</td>';
				}
			$output .= '<tr>';
		}
		$output .= '</tbody>';
		$output .= '</table>';

	else : $output = 'No proposals found for this email address: ' . $userEmail;

	endif;

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
		$output = '<div class="proposal-address">' . $address . ', ' . $address2 . '<br>' . $city . ', ' . $prov . '<br>' . $country . '&nbsp;&nbsp;' . $zip . '</div>'; 
	} else {
		$output = '';
	}

	return $output;

}
add_shortcode('proposal-address', 'proposal_delivery_address');

function proposal_delivery() {
	if(is_singular('proposal')) {
		$delivery = get_field('delivery_required');
		return 'Delivery Required to Above Address';
	} else {
		return '';
	}
}
add_shortcode('delivery-required', 'proposal_delivery');

function fixture_one() {
	$file = get_field('fixture_1_details_file');
	$qty = get_field('fixture_1_quantity');

	return '<a class="proposal-file" target="_blank" href="'.$file['url'].'"><img src="'.get_stylesheet_directory_uri().'/assets/images/file-lines-solid.svg">'.$file['title'].' @ '.$qty.' (qty)</a>';
}
add_shortcode('fixture-one', 'fixture_one');

function fixture_two() {
	$file = get_field('fixture_2_details_file');
	$qty = get_field('fixture_2_quantity');

	return '<a class="proposal-file" target="_blank" href="'.$file['url'].'"><img src="'.get_stylesheet_directory_uri().'/assets/images/file-solid.svg">'.$file['title'].' @ '.$qty.' (qty)</a>';
}
add_shortcode('fixture-two', 'fixture_two');

function proposal_costs() {
	$cost = get_field('price');
	$ship = get_field('shipping_charge');
	if($cost) {
		$output = '<div class="cost-table">';
		$output.= '<div class="sub-total"><span>Sub-total:</span> $'.number_format($cost, 2, '.', '').'</div>';
		$output.= '<div class="shipping"><span>Shipping:&nbsp;</span> $'.number_format($ship, 2, '.', '').'</div>';
		$hst = ($cost+$ship)*0.13;
		$output.= '<div class="hst"><span>HST:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> $'.number_format($hst, 2, '.', '').'</div>';
		$total = $cost+$ship+$hst;
		$output.= '<div class="total"><span>Total:&nbsp;&nbsp;&nbsp;&nbsp;</span> $'.number_format($total, 2, '.', '').'</div>';
		$output.= '</div>';
	} else {
		$output = 'Cost breakdown is pending...';
	}
	return $output;
}
add_shortcode('proposal-cost-breakdown', 'proposal_costs');

function proposal_payment_form() {
	$cost = get_field('price');
	$status = get_field('status', $prop->ID);
	if($cost and $status == 'ready') {
		GFCommon::log_debug( __METHOD__ . '(): running.' );
		$output = '<h3>Make Payment</h3>';
		$output .= gravity_form( 3, false, false, false, false, true, false, false );
		return $output;
	}
}
add_shortcode('payment-form', 'proposal_payment_form');