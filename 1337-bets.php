<?php

/**
 *
 * @link              https://fingerjones.com
 * @since             1.0.1
 * @package           1337_Bets
 *
 * Plugin Name:       1337 Bets
 * Plugin URI:        https://1337bets.com
 * Description:       Get the latest reviews of all major betting platforms.
 * Version:           1.0.1
 * Author:            Harrison Barnes
 * Author URI:        https://fingerjones.com
 */


/**
 * 
 * Activate
 *
 */
function activate_1337_bets() {

    // Get JSON Data
    $json_data = file_get_contents(dirname( __FILE__ ) . '/data/data.json');
    // Save Data to Option (data is static)
    add_option('leet_bets', $json_data);
    // Create Option for Admin Redirect
    add_option( 'leet_bets_activation_redirect', true );

}
register_activation_hook( __FILE__, 'activate_1337_bets' );


/**
 * 
 * Admin Page
 *
 */
function admin_page_1337_bets(){

    // Create Admin Page for Plugin Information
    add_menu_page( '1337 Bets', '1337 Bets', 'manage_options', 'leet-beets', 'admin_page_1337_bets_view', 'dashicons-money-alt' );
}
add_action('admin_menu', 'admin_page_1337_bets');


/**
 * 
 * Admin Page View
 *
 */
function admin_page_1337_bets_view() {
    ?>
        <article>
            <header>
                <h1>1337 Bets Reviews</h1>
                <p>Get the latest reviews of the top betting sites around the world.</p>
            </header>
        </article>
    <?php
}


/**
 * 
 * Activation Redirect
 *
 */
function leet_bets_activation_redirect() {
    
    if ( get_option( 'leet_bets_activation_redirect', false ) ) {
        // Delete Option to Avoid Multiple Redirects
        delete_option( 'leet_bets_activation_redirect' );
        // Redirect to Plugin Admin Page
        wp_safe_redirect( admin_url( '/admin.php?page=leet-beets' ) );
        exit;
    }
}
add_action( 'admin_init', 'leet_bets_activation_redirect' );


/**
 * 
 * Deactivate
 *
 */
function deactivate_1337_bets() {

    // Remove Plugin Admin Page
    remove_menu_page( 'leet-beets' );
    // Delete JSON Data Option
    delete_option('leet_bets');
    
}
register_deactivation_hook( __FILE__, 'deactivate_1337_bets' );


/**
 * 
 * Dump Data for Admins Only (utility)
 * 
 *
 */
function da($data) {
    if( current_user_can('manage_options') ) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
    
}

