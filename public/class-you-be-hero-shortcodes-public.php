<?php

/**
 * Prevent direct access to this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
        add_shortcode('total-donations', [ $this, 'render_total_donations' ]);
        add_shortcode('total-number-of-donations', [ $this, 'render_total_number_of_donations' ]);
        add_shortcode('total-number-supported-non-profits', [ $this, 'render_total_number_supported_non_profits' ]);
    }
    
    function ybhd_add_donation_form_shortcode() {

        $ybhd_token = get_option( 'ybhd_token' );

        if ( ! empty( $ybhd_token ) ) {
            ob_start();
            include_once(__DIR__ . '/../build/render.php');
            return ob_get_clean();
        }
    }

    /**
     * Render total donations amount shortcode
     * 
     * @return string Total donations amount formatted with currency
     */
    function render_total_donations() {
        $data = $this->get_dashboard_data();
        
        if ( empty( $data ) || ! isset( $data['summary']['total_donations'] ) ) {
            return wp_kses_post( wc_price( 0 ) );
        }

        $total_donations = (float) $data['summary']['total_donations'];

        // Use WooCommerce price formatting to respect currency position and formatting settings
        return wp_kses_post( wc_price( $total_donations ) );
    }

    /**
     * Render total number of donations shortcode
     * 
     * @return string Total number of donations
     */
    function render_total_number_of_donations() {
        $data = $this->get_dashboard_data();
        
        if ( empty( $data ) || ! isset( $data['summary']['total_orders'] ) ) {
            return '0';
        }

        $total_orders = (int) $data['summary']['total_orders'];

        return (string) $total_orders;
    }

    /**
     * Render total number of supported non-profits shortcode
     * 
     * @return string Total number of supported non-profit organizations
     */
    function render_total_number_supported_non_profits() {
        $data = $this->get_dashboard_data();
        
        if ( empty( $data ) || ! isset( $data['summary']['benefited_organizations'] ) ) {
            return '0';
        }

        $benefited_orgs = (int) $data['summary']['benefited_organizations'];

        return (string) $benefited_orgs;
    }

    /**
     * Get dashboard data from cached JSON
     * 
     * @return array Dashboard data array or empty array if not available
     */
    private function get_dashboard_data() {
        $body = get_option( 'ybhd_dashboard_json' );
        
        if ( empty( $body ) ) {
            return [];
        }

        $data = json_decode( $body, true );
        
        if ( json_last_error() !== JSON_ERROR_NONE || ! isset( $data['data'] ) ) {
            return [];
        }

        return $data['data'];
    }

}
