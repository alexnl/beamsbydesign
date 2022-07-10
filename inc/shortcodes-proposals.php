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
			$output .= '<th>Fixtures</th>';
			$output .= '<th>Sub-total</th>';
			$output .= '<th>Status</th>';
		$output .= '</tr></thead>';
		$output .= '<tbody>';
		foreach($props as $prop) {
			// Get ACF Fields
			for ($i=1; $i < 16 ; $i++) { 
				$file = get_field('fixture_'.$i.'_fixture_'.$i.'_details_file', $prop->ID);
				if(empty($file)) {
					break;
				}
			}
			$filecount = $i;
			$status 	= get_field('status', $prop->ID);
			$cost 		= get_field('price', $prop->ID);
			$payment_details = get_proposal_payment_data($prop->ID);
			// Output Proposal
			$output .= '<tr>';
				$output .= '<td class="proposal-details"><a href="'.get_permalink($prop->ID).'"><img alt="Proposal Details" src="'.get_stylesheet_directory_uri().'/assets/images/square-arrow-up-right-solid.svg"></a></td>';
				$output .= '<td class="proposal-date">'.get_the_date(('M d, Y'), $prop->ID).'</td>';
				if(get_the_title($prop->ID)) {
					$output .= '<td class="project-name"><a href="'.get_permalink($prop->ID).'">'.get_the_title($prop->ID).'</a></td>';
				} else {
					$output .= '<td class="no-project-name">-</td>';
				}
				$output .= '<td><div class="fixture-1">'.($filecount - 1).' Fixtures Uploaded <a href="'.get_permalink($prop->ID).'">(View)</a></td>';
				if($cost) {
					$output .= '<td class="cost">$'.$cost.'</td>';
				} else {
					$output .= '<td class="cost">TBD</td>';
				}
				if($payment_details['payment-status'] == false) {
					if($status == 'ready' and !empty($cost)) {
						$output .= '<td class="status payment-button"><a href="'.get_permalink($prop->ID).'">Make Payment</td>';
					} else {
						$output .= '<td class="status">Pending</td>';
					}	
				} else {
					$output .= '<td class="status">--- PAID ---</td>';
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

function proposal_fixtures() {
	$output = '<div class="proposal-fixture">';
	for ($i=1; $i < 16 ; $i++) { 
		$file = get_field('fixture_'.$i.'_fixture_'.$i.'_details_file');
		if(empty($file)) {
			break;
		}
		$qty = get_field('fixture_'.$i.'_fixture_'.$i.'_quantity');
		$fileURL = wp_get_attachment_url($file);
		$fileMETA = wp_get_attachment_metadata($file);
		$fileMIME = get_post_mime_type($file);
		$output.= '<div class="fixture fixture-'.$i.'">';
		if($fileMIME != 'image/jpeg') {
			$output.= '<a class="proposal-file" target="_blank" href="'.$fileURL.'"><span>'.$qty.'</span> x <img class="svg" src="'.get_stylesheet_directory_uri().'/assets/images/file-lines-solid.svg"> (<i>file name</i>: '.get_the_title($file).')('.$fileMIME.')</a>';
		} else {
			$img = wp_get_attachment_image_src($file, 'thumbnail');
			$output.= '<a class="proposal-file" target="_blank" href="'.$fileURL.'"><span>'.$qty.'</span> x <img src="'.$img[0].'">(<i>file name</i>: '.$fileMETA['sizes']['thumbnail']['file'].')</a>';
		}
		$output.= '</div>';
	}
	$output.= '</div>';
	return $output;
}
add_shortcode('proposal-fixtures', 'proposal_fixtures');

function proposal_costs() {
	$cost = get_field('price');
	$ship = get_field('shipping_charge');
	$payment_details = get_proposal_payment_data(get_the_ID());
	if($cost) {
		$output = '<div class="cost-table">';
		$output.= '<div class="sub-total"><span>Sub-total:</span> $'.number_format($cost, 2, '.', '').'</div>';
		$output.= '<div class="shipping"><span>Shipping:&nbsp;</span> $'.number_format($ship, 2, '.', '').'</div>';
		$hst = ($cost+$ship)*0.13;
		$output.= '<div class="hst"><span>HST:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> $'.number_format($hst, 2, '.', '').'</div>';
		$total = $cost+$ship+$hst;
		$output.= '<div class="total"><span>Total:&nbsp;&nbsp;&nbsp;&nbsp;</span> $'.number_format($total, 2, '.', '').'</div>';
		$output.= '</div>';
		if($payment_details['payment-status'] == true) {
			$output .= '<div class="payment-details">Payment made by ' . $payment_details['payment-method'] . ' on ' . $payment_details['payment-date'] . ' (UTC)<br>' . 'Transaction ID: ' . $payment_details['transaction-id'].'</div>';
		}
	} else {
		$output = 'Cost breakdown is pending...';
	}
	return $output;
}
add_shortcode('proposal-cost-breakdown', 'proposal_costs');

function proposal_payment_form() {
	$cost = get_field('price');
	$status = get_field('status');
	$output = '<div class="payment-section">';
	if(is_proposal_paid(get_the_ID()) == false) {
		if($cost and $status == 'ready') {
			$output .= '<h3>Make Payment</h3>';
			$output .= gravity_form( 3, false, false, false, false, true, false, false );
		}
	} else {
		$output .= '<h1 class="payment-confirmation">Thank you for your payment.</h1>';
	}
	$output .= '</div>';
	return $output;
}
add_shortcode('payment-form', 'proposal_payment_form');