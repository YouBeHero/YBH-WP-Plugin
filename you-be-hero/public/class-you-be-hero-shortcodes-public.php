<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://youbehero.com
 * @since      1.0.1
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/public
 */

class YouBeHero_ShortCodes_Public {

    public function __construct( ) {


        add_shortcode('youbehero_donation_form', [ $this, 'ybhd_add_donation_form_shortcode' ]);
        add_shortcode('ybhd_donation_form', [ $this, 'ybhd_add_donation_form_shortcode' ]);
    }
    
    function ybhd_add_donation_form_shortcode() {
        ob_start();
        include_once( __DIR__.'/../build/render.php' );
        return ob_get_clean();
    }

}
