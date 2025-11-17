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
    function youbehero_register_wpbakery_element() {

        vc_map( array(
            'name' => __( 'YouBeHero Donation Widget', 'youbehero'  ),
            'base' => 'youbehero_donation_wpbakery',
            'description' => __( 'Add donation form to checkout', 'youbehero' ),
            'category' => __( 'Content', 'youbehero' ),
            'icon' => 'icon-wpb-woocommerce',
            'params' => array(

                // WooCommerce Hook Toggle
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'WooCommerce Hook', 'youbehero' ),
                    'param_name' => 'woocommerce_hook_enable',
                    'value' => array(
                        __( 'No', 'youbehero' ) => 'no',
                        __( 'Yes', 'youbehero' ) => 'yes',
                    ),
                    'std' => 'no',
                    'description' => __( 'Enable to place widget on WooCommerce checkout page hooks', 'youbehero' ),
                ),

                // Placement Position
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Placement Position', 'youbehero' ),
                    'param_name' => 'placement_position',
                    'value' => array(
                        __( 'Before Place Order Button', 'youbehero' ) => 'woocommerce_review_order_before_submit',
                        __( 'After Billing Form', 'youbehero' ) => 'woocommerce_after_checkout_billing_form',
                    ),
                    'std' => 'woocommerce_review_order_before_submit',
                    'description' => __( 'Select where to place the widget on checkout page', 'youbehero' ),
                    'dependency' => array(
                        'element' => 'woocommerce_hook_enable',
                        'value' => 'yes',
                    ),
                ),

            ),
        ));
    }
    add_action( 'vc_before_init', 'youbehero_register_wpbakery_element' );

    /**
     * WPBakery Shortcode Class
     */
    class WPBakeryShortCode_YouBeHero_Donation_WPBakery extends WPBakeryShortCode {

        protected function content( $atts, $content = null ) {

            extract(shortcode_atts( array(
                'woocommerce_hook_enable' => 'no',
                'placement_position' => 'woocommerce_review_order_before_submit',
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
                    return '<div style="padding: 15px; background: #e8f5e9; border: 1px solid #4caf50; border-radius: 4px; margin: 10px 0;">' .
                        '<strong>' . __( '✓ Add Donation to Cart, YouBeHero', 'youbehero' ) . '</strong><br>' .
                        __( 'WooCommerce Hook is Active and the widget will appear on the checkout page at: ', 'youbehero' ) .
                        '<strong>' . $placement_position . '</strong>' .
                        '</div>';
                }

                // On frontend, widget will be rendered via hooks
                return '';
            }
        }
    }
} // End if WPBakery exists check