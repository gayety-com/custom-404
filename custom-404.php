<?php
/*
Plugin Name: 00 Gayety Custom 404 Redirect to Home
Description: Redirects all 404 errors to the home page and shows a message "That page does not exist."
Version: 1.0
Author: Jeff Kaufman
*/
 
// Disable WP's "guess" redirect behavior
remove_action( 'template_redirect', 'redirect_canonical' );

/**
 * Redirect 404s to the homepage with a query parameter
 */
function cfrh_redirect_404_to_home() {
    if ( is_404() ) {
        wp_redirect( home_url( '/?notfound=1' ) );
        exit;
    }
}
add_action( 'template_redirect', 'cfrh_redirect_404_to_home' );

/**
 * Display the "That page does not exist." message on the homepage
 */
function cfrh_show_notfound_message() {
    if ( isset($_GET['notfound']) && $_GET['notfound'] == '1' ) {
        echo '<div style="background:#f8d7da;color:#721c24;padding:12px;margin:12px 0;border:1px solid #f5c6cb;border-radius:4px;">
                That page does not exist.
              </div>';
    }
}
add_action( 'wp_body_open', 'cfrh_show_notfound_message' );
