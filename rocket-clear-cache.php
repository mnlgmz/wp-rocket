<?php 
// Load WordPress
require( 'wp-load.php' );

// Clear WP-Rocket Cache
if ( function_exists( 'rocket_clean_domain' ) ) {
	rocket_clean_domain();
 }
