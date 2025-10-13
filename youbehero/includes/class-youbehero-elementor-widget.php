<?php

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class YouBeHero_Elementor_Widget extends \Elementor\Widget_Base {

    public function get_name() {

        return 'youbehero_donation_widget';

    }

    public function get_title() {

        return __( 'YouBeHero Donation Widget', 'youbehero' );

    }

    public function get_icon() {

        return 'eicon-cart';

    }

    public function get_categories() {

        return [ 'general' ];

    }

    protected function render() {

        // Output your existing widget or shortcode here
        echo do_shortcode('[youbehero_donation_form]');

    }
}
