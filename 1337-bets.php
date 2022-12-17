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
 * Version:           1.0.2
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

    // Get JSON Data from Option and Decode
    $json_data = json_decode(get_option('leet_bets'), false);
    // Target Entries
    $json_data = $json_data->toplists->{575};
    // Re-Sort Entries by 'position' property
    usort($json_data, function($a, $b) {
        if ($a->position == $b->position) {
            return 0;
        }
        return ($a->position < $b->position) ? -1 : 1;
    });


    // View
    ?>
        <article>
            <header style="margin-bottom:30px;">
                <h1>1337 Bets Reviews</h1>
                <p>Get the latest reviews of the top betting sites around the world.</p>
            </header>

            <main>
                <div id="shortcode-ex">
                    <h2>Shortcode:</h2>
                    <input type="text" readonly value="[reviews]">
                </div>

                <div class="reviews">
                    <div class="reviews-header">
                        <div class="column">
                            <p>Casino</p>
                        </div>
                        <div class="column">
                            <p>Bonus</p>
                        </div>
                        <div class="column">
                            <p>Features</p>
                        </div>
                        <div class="column">
                            <p>Play</p>
                        </div>
                    </div>

                    <div class="reviews-content">

                        <!-- Review -->
                        <?php foreach($json_data as $review) : ?>
                            <div class="review">
                                <div class="column">
                                    <img src="<?php echo $review->logo; ?>" alt="<?php echo $review->brand_id; ?>" class="logo">
                                    <a href="<?php echo $review->play_url . "/" . $review->brand_id; ?>" class="review">Review</a>
                                </div>
                                <div class="column">
                                    <p class="rating"></p>
                                    <p class="bonus"><?php echo $review->info->bonus; ?></p>
                                </div>
                                <div class="column">
                                    <ul class="features">
                                        <?php foreach($review->info->features as $feature) : ?>
                                            <li><?php echo $feature; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="column">
                                    <a href="<?php echo $review->play_url; ?>" class="play-now button primary">Play Now</a>
                                    <p class="tos"><?php echo $review->terms_and_conditions; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div><!-- .reviews-content -->
                </div><!-- .reviews -->

            </main>
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

