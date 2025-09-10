<?php
/*
Plugin Name: 00 Gayety Custom 404 - Redirect to Home
Description: Redirects all 404 errors to the home page and shows a JavaScript popup "That page does not exist." Removes the query string after showing.
Version: 1.2
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
 * Add a JavaScript alert on the homepage if notfound=1 is set
 */
function cfrh_show_notfound_alert() {
    if ( isset($_GET['notfound']) && $_GET['notfound'] == '1' ) {
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                alert("That page does not exist.");
                // Remove ?notfound=1 from the URL without reloading
                if (window.history.replaceState) {
                    let url = new URL(window.location);
                    url.searchParams.delete("notfound");
                    window.history.replaceState({}, document.title, url.pathname + url.search + url.hash);
                }
            });
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'cfrh_show_notfound_alert' );
