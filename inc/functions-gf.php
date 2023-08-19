<?php
// Gravity Forms Functions

add_filter( 'gform_countries', 'remove_country' );
function remove_country( $countries ){
    return array( 'Canada', 'United States');
}

add_action( 'gform_advancedpostcreation_post_after_creation', 'add_fixtures_acf_file_ids', 10, 4 );
function add_fixtures_acf_file_ids( $post_id, $feed, $entry, $form ){
    $file1 = rgar($entry, 'gpml_ids_24');
    if($file1) {
        $imgID = maybe_unserialize($file1);
        update_post_meta( $post_id, 'fixture_1_fixture_1_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_1_fixture_1_quantity', $entry['16'] );
    }
    $file2 = rgar($entry, 'gpml_ids_26');
    if($file2) {
        $imgID = maybe_unserialize($file2);
        update_post_meta( $post_id, 'fixture_2_fixture_2_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_2_fixture_2_quantity', $entry['27'] );
    }
    $file3 = rgar($entry, 'gpml_ids_28');
    if($file3) {
        $imgID = maybe_unserialize($file3);
        update_post_meta( $post_id, 'fixture_3_fixture_3_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_3_fixture_3_quantity', $entry['29'] );
    }
    $file4 = rgar($entry, 'gpml_ids_34');
    if($file4) {
        $imgID = maybe_unserialize($file4);
        update_post_meta( $post_id, 'fixture_4_fixture_4_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_4_fixture_4_quantity', $entry['35'] );
    }
    $file5 = rgar($entry, 'gpml_ids_36');
    if($file5) {
        $imgID = maybe_unserialize($file5);
        update_post_meta( $post_id, 'fixture_5_fixture_5_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_5_fixture_5_quantity', $entry['37'] );
    }
    $file6 = rgar($entry, 'gpml_ids_39');
    if($file6) {
        $imgID = maybe_unserialize($file6);
        update_post_meta( $post_id, 'fixture_6_fixture_6_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_6_fixture_6_quantity', $entry['40'] );
    }
    $file7 = rgar($entry, 'gpml_ids_41');
    if($file7) {
        $imgID = maybe_unserialize($file7);
        update_post_meta( $post_id, 'fixture_7_fixture_7_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_7_fixture_7_quantity', $entry['42'] );
    }
    $file8 = rgar($entry, 'gpml_ids_43');
    if($file8) {
        $imgID = maybe_unserialize($file8);
        update_post_meta( $post_id, 'fixture_8_fixture_8_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_8_fixture_8_quantity', $entry['44'] );
    }
    $file9 = rgar($entry, 'gpml_ids_45');
    if($file9) {
        $imgID = maybe_unserialize($file9);
        update_post_meta( $post_id, 'fixture_9_fixture_9_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_9_fixture_9_quantity', $entry['46'] );
    }
    $file10 = rgar($entry, 'gpml_ids_47');
    if($file10) {
        $imgID = maybe_unserialize($file10);
        update_post_meta( $post_id, 'fixture_10_fixture_10_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_10_fixture_10_quantity', $entry['48'] );
    }
    $file11 = rgar($entry, 'gpml_ids_50');
    if($file11) {
        $imgID = maybe_unserialize($file11);
        update_post_meta( $post_id, 'fixture_11_fixture_11_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_11_fixture_11_quantity', $entry['51'] );
    }
    $file12 = rgar($entry, 'gpml_ids_52');
    if($file12) {
        $imgID = maybe_unserialize($file12);
        update_post_meta( $post_id, 'fixture_12_fixture_12_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_12_fixture_12_quantity', $entry['53'] );
    }
    $file13 = rgar($entry, 'gpml_ids_55');
    if($file13) {
        $imgID = maybe_unserialize($file13);
        update_post_meta( $post_id, 'fixture_13_fixture_13_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_13_fixture_13_quantity', $entry['56'] );
    }
    $file14 = rgar($entry, 'gpml_ids_57');
    if($file14) {
        $imgID = maybe_unserialize($file14);
        update_post_meta( $post_id, 'fixture_14_fixture_14_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_14_fixture_14_quantity', $entry['58'] );
    }
    $file15 = rgar($entry, 'gpml_ids_59');
    if($file15) {
        $imgID = maybe_unserialize($file15);
        update_post_meta( $post_id, 'fixture_15_fixture_15_details_file', $imgID[0] );
        update_post_meta( $post_id, 'fixture_15_fixture_15_quantity', $entry['60'] );
    }
}

add_filter( 'gform_field_value_proposal_cost', 'populate_proposal_cost' );
function populate_proposal_cost( $value ) {
    if(is_singular('proposal')) {
        $cost = get_field('price');
        if($cost) {
            return $cost;
        } else {
            return '0.00';
        }
    } else {
        return '0.00';
    }
}

add_filter( 'gform_field_value_proposal_quantity', 'populate_proposal_quantity' );
function populate_proposal_quantity( $value ) {
    return '1';
}

add_filter( 'gform_field_value_proposal_shipping', 'populate_proposal_shipping' );
function populate_proposal_shipping( $value ) {
    if(is_singular('proposal')) {
        $shipping = get_field('shipping_charge');
        if($shipping) {
            return $shipping;
        } else {
            return '0.00';
        }
    } else {
        return '0.00';
    }
}

add_filter( 'gform_field_value_proposal_id', 'populate_proposal_id' );
function populate_proposal_id( $value ) {
    return get_the_ID();
}

function is_proposal_paid( $proposal_id ) {
    $search_criteria = array(
        'field_filters' => array(
            'mode' => 'all',
            array(
                'key'   => '10',
                'value' => $proposal_id,
            ),
        )
    );
    $payment_entry = GFAPI::get_entries( 3, $search_criteria);
    $proposal_payment_data = array();
    if(empty($payment_entry)) {
        return false;
    } else {
        return true;
    }
    return $proposal_payment_data;
}

function get_proposal_payment_data( $proposal_id ) {
    $search_criteria = array(
        'field_filters' => array(
            'mode' => 'all',
            array(
                'key'   => '10',
                'value' => $proposal_id,
            ),
        )
    );
    $payment_entry = GFAPI::get_entries( 3, $search_criteria);
    if(empty($payment_entry)) {
        $proposal_payment_data = array('payment-status' => false, 'payment-date' => '', 'payment-method' => '', 'transaction-id' => '');
    } else {
        $proposal_payment_data = array('payment-status' => true, 'payment-date' => $payment_entry[0]['payment_date'], 'payment-method' => $payment_entry[0]['payment_method'], 'transaction-id' => $payment_entry[0]['transaction_id']);
    }
    return $proposal_payment_data;
}

add_action( 'gform_post_payment_action', 'update_proposal_paid_status', 10, 4 );
function update_proposal_paid_status($entry, $action) {
    if($action['is_success'] == true) {
        update_post_meta($entry['10'], 'status', 'paid' );
    }
}

// Load customer information into New Proposal form hidden fields
add_filter( 'gform_field_value_customer_first_name', 'populate_customer_first_name' );
function populate_customer_first_name( $value ) {
    $userData = get_userdata(get_current_user_id());
    if($userData) {
        return $userData->first_name;
    } else {
        return '';
    }
}

add_filter( 'gform_field_value_customer_last_name', 'populate_customer_last_name' );
function populate_customer_last_name( $value ) {
    $userData = get_userdata(get_current_user_id());
    if($userData) {
        return $userData->last_name;
    } else {
        return '';
    }
}

add_filter( 'gform_field_value_customer_company_name', 'populate_customer_company_name' );
function populate_customer_company_name( $value ) {
    $userID = get_current_user_id();
    $company = get_field('company', 'user_'.$userID);
    if($company) {
        return $company;
    } else {
        return '';
    }
}

add_filter( 'gform_field_value_customer_email', 'populate_customer_email' );
function populate_customer_email( $value ) {
    $userData = get_userdata(get_current_user_id());
    if($userData) {
        return $userData->user_email;
    } else {
        return '';
    }
}

add_filter( 'gform_field_value_customer_phone', 'populate_customer_phone' );
function populate_customer_phone( $value ) {
    $userID = get_current_user_id();
    $phone = get_field('phone', 'user_'.$userID);
    if($phone) {
        return $phone;
    } else {
        return '';
    }
}