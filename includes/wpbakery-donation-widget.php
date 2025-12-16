<?php
/**
 * WPBakery YouBeHero Donation Widget
 *
 * Add this to your plugin or theme's functions.php
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Check if WPBakery is active
if (class_exists('WPBakeryShortCode')) {

    /**
     * Register the WPBakery element
     */
    function ybhd_register_wpbakery_element() {

        vc_map( array(
            'name' => __( 'YouBeHero Donation Widget', 'youbehero'  ),
            'base' => 'youbehero_donation_wpbakery',
            'description' => __( 'Add donation form to checkout', 'youbehero' ),
            'category' => __( 'Content', 'youbehero' ),
            // Use plugin SVG icon in the element picker
            'icon' => YBHD_PLUGIN_URL . 'admin/img/ybh-single-logo.svg',
            'params' => array(

                // WooCommerce Hook Toggle
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'WooCommerce Hook', 'youbehero' ),
                    'param_name' => 'woocommerce_hook_enable',
                    'value' => array(
                        __( 'Yes', 'youbehero' ) => 'yes',
                        __( 'No', 'youbehero' ) => 'no',
                    ),
                    'std' => 'yes',
                    'description' => __( 'Enable to place widget on WooCommerce checkout page hooks', 'youbehero' ),
                ),

                // Placement Position
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Placement position', 'youbehero' ),
                    'param_name' => 'placement_position',
                    'value' => array(
                        __( 'After billing form', 'youbehero' ) => 'woocommerce_after_checkout_billing_form',
                        __( 'Before place order button', 'youbehero' ) => 'woocommerce_review_order_before_submit',
                    ),
                    'std' => 'woocommerce_after_checkout_billing_form',
                    'description' => __( 'Select where to place the widget on checkout page', 'youbehero' ),
                    'dependency' => array(
                        'element' => 'woocommerce_hook_enable',
                        'value' => 'yes',
                    ),
                ),

            ),
        ));
    }
    // Registration will be called conditionally from ybhd_wpbakery_compatibility()

    /**
     * WPBakery Shortcode Class
     *
     * Note: Class name must follow WPBakery's required "WPBakeryShortCode_*" pattern.
     *
     * @phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
     */
    class WPBakeryShortCode_YouBeHero_Donation_WPBakery extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {

            extract(shortcode_atts( array(
                'woocommerce_hook_enable' => 'yes',
                'placement_position' => 'woocommerce_after_checkout_billing_form',
            ), $atts ) );

            // Store settings globally for hook initialization
            global $youbehero_wpbakery_settings;
            if ( !isset( $youbehero_wpbakery_settings ) ) {
                $youbehero_wpbakery_settings = array();
            }

            $youbehero_wpbakery_settings[] = array(
                'enabled' => $woocommerce_hook_enable === 'yes',
                'position' => $placement_position,
            );

            // If WooCommerce hook is NOT enabled, render normally
            if ( $woocommerce_hook_enable !== 'yes' ) {
                if ( is_checkout() && !is_order_received_page() ) {
                    return do_shortcode( '[youbehero_donation_form]' );
                }
                return '';
            } else {
                // In editor mode, show info message
                if ( function_exists( 'vc_is_page_editable' ) && vc_is_page_editable() ) {
                    $placement_labels = [
                        'woocommerce_after_checkout_billing_form'   => esc_html__( 'After billing form', 'youbehero' ),
                        'woocommerce_review_order_before_submit'    => esc_html__( 'Before place order button', 'youbehero' ),
                    ];
                    $placement_label = isset($placement_labels[$placement_position]) ? $placement_labels[$placement_position] : esc_html($placement_position);
                    
                    return '<div style="padding: 15px; background: #e8f5e9; border: 1px solid #4caf50; border-radius: 4px; margin: 10px 0;">' .
                        '<strong>' . esc_html__( '✓ Add Donation to Cart, YouBeHero', 'youbehero' ) . '</strong><br>' .
                        esc_html__( 'WooCommerce Hook is Active and the widget will appear on the checkout page at: ', 'youbehero' ) .
                        '<strong>' . $placement_label . '</strong>' .
                        '</div>';
                }

                // On frontend, widget will be rendered via hooks
                return '';
            }
        }
    }
} // End if WPBakery exists check