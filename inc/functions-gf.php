<?php
// Gravity Forms Functions

add_filter( 'gform_countries', 'remove_country' );
function remove_country( $countries ){
    return array( 'Canada', 'United States');
}