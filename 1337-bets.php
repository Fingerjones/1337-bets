<?php

/**
 *
 * @link              https://fingerjones.com
 * @since             1.0.0
 * @package           1337_Bets
 *
 * Plugin Name:       1337 Bets
 * Plugin URI:        https://1337bets.com
 * Description:       Get the latest reviews of all major betting platforms.
 * Version:           1.0.0
 * Author:            Harrison Barnes
 * Author URI:        https://fingerjones.com
 */


/**
 * 
 * Activate
 *
 */
function activate_1337_bets() {

}
register_activation_hook( __FILE__, 'activate_1337_bets' );


/**
 * 
 * Deactivate
 *
 */
function deactivate_1337_bets() {
    
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

