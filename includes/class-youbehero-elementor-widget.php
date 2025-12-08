<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class YouBeHero_Elementor_Widget extends Widget_Base {

    /**
     * @return string
     */
    public function get_name() {
        return 'youbehero_donation_widget_v2';
    }

    /**
     * @return string|null
     */
    public function get_title() {
        return __( 'YouBeHero Donation Widget', 'youbehero' );
    }

    /**
     * @return string
     */
    public function get_icon() {
        return 'eicon-cart';
    }

    /**
     * @return string[]
     */
    public function get_categories() {
        return [ 'general' ];
    }

    /**
     * @return void
     */
    protected function register_controls() {

        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'youbehero' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'widget_content',
            [
                'label' => esc_html__('Content', 'youbehero' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Your widget content here', 'youbehero' ),
            ]
        );

        $this->end_controls_section();

        // Advanced Tab - Placement Method Section
        $this->start_controls_section(
            'advanced_placement_section',
            [
                'label' => esc_html__( 'Placement method', 'youbehero' ),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        // WooCommerce Hook Enable/Disable Toggle
        $this->add_control(
            'woocommerce_hook_enable',
            [
                'label' => esc_html__( 'WooCommerce Hook', 'youbehero' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'youbehero' ),
                'label_off' => esc_html__( 'No', 'youbehero' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Placement Dropdown
        $this->add_control(
            'placement_position',
            [
                'label' => esc_html__( 'Placement', 'youbehero' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'woocommerce_after_checkout_billing_form',
                'options' => [
                    'woocommerce_after_checkout_billing_form' => esc_html__( 'After billing form', 'youbehero' ),
                    'woocommerce_review_order_before_submit' => esc_html__( 'Before place order button', 'youbehero' ),
                ],
                'condition' => [
                    'woocommerce_hook_enable' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * @return void
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        // Get settings - check if explicitly set to 'yes' (SWITCHER returns 'yes' when ON, empty string when OFF)
        $wc_hook_enabled = isset( $settings['woocommerce_hook_enable'] ) && $settings['woocommerce_hook_enable'] === 'yes' ? 'yes' : 'no';

        // Only render normally if WooCommerce hook is NOT enabled
        if ( $wc_hook_enabled !== 'yes' ) {
            if ( is_checkout() && ! is_order_received_page() ) {
                echo do_shortcode( '[youbehero_donation_form]' );
            }
        } else {
            // Show message in editor
            if ( Plugin::$instance->editor->is_edit_mode() ) {
                $placement = !empty($settings['placement_position']) ? $settings['placement_position'] : 'woocommerce_after_checkout_billing_form';
                $placement_labels = [
                    'woocommerce_after_checkout_billing_form'   => esc_html__( 'After billing form', 'youbehero' ),
                    'woocommerce_review_order_before_submit'    => esc_html__( 'Before place order button', 'youbehero' ),
                ];
                $placement_label = isset($placement_labels[$placement]) ? $placement_labels[$placement] : esc_html($placement);
                
                echo '<div style="padding: 15px; background: #e8f5e9; border: 1px solid #4caf50; border-radius: 4px; margin: 10px 0;">';
                echo '<strong>' . esc_html__( '✓ Add Donation to Cart, YouBeHero', 'youbehero' ) . '</strong><br>';
                echo esc_html__( 'WooCommerce Hook is Active and the widget will appear on the checkout page at: ', 'youbehero' );
                echo '<strong>' . $placement_label . '</strong>';
                echo '</div>';
            }
        }
    }

}