<?php

/**
 * Prevent direct access to this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://youbehero.com
 * @since      1.0.1
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/includes
 * @author     YouBeHero <info@youbehero.com>
 */
class You_Be_Hero {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      You_Be_Hero_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function __construct() {
		$this->plugin_name = 'youbehero';                
		$this->version = '1.3.5';
		$this->load_dependencies();
		$this->ybhd_set_compatibility();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - You_Be_Hero_Loader. Orchestrates the hooks of the plugin.
	 * - You_Be_Hero_i18n. Defines internationalization functionality.
	 * - You_Be_Hero_Admin. Defines all hooks for the admin area.
	 * - You_Be_Hero_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-you-be-hero-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-you-be-hero-admin.php';

		/**
		 * The class responsible for YouBeHero Email Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-you-be-hero-email-widget.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-you-be-hero-public.php';

        /**
         * The class responsible for defining all Shortcodes that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-you-be-hero-shortcodes-public.php';

		$this->loader = new You_Be_Hero_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the You_Be_Hero_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */

    public function ybhd_set_compatibility() {

        add_action( 'plugins_loaded', array( $this, 'ybhd_elementor_compatibility' ) );
        add_action( 'plugins_loaded', array( $this, 'ybhd_wpbakery_compatibility' ) );
        
    }

    public function ybhd_elementor_compatibility() {

        $ybhd_token = get_option( 'ybhd_token' );

        if ( ! empty( $ybhd_token ) ) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');

            $youbehero_data = json_decode(get_option('ybhd_dashboard_json'), true);
            $youbehero_data = $youbehero_data['data'] ?? [];

            // Check if Elementor is installed and active
            // Also verify that we have valid data structure (not just cached invalid data)
            if (!did_action('elementor/loaded') 
                || empty($youbehero_data) 
                || !isset($youbehero_data['status']) 
                || $youbehero_data['status'] != 'active' 
                || !is_plugin_active('youbehero/youbehero.php')) {
                return; // Elementor not active, skip loading
            }

            // Register widget
            add_action('elementor/widgets/register', function ($widgets_manager) {

                // Include YouBeHero widget file
                require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-youbehero-elementor-widget.php';
                $widgets_manager->register(new \YouBeHero_Elementor_Widget());

            });
        }

    }

    public function ybhd_wpbakery_compatibility() {

        $ybhd_token = get_option( 'ybhd_token' );

        if ( ! empty( $ybhd_token ) ) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');

            $youbehero_data = json_decode(get_option('ybhd_dashboard_json'), true);
            $youbehero_data = $youbehero_data['data'] ?? [];

            // Check if WPBakery is installed and active, and plugin status is active
            // Also verify that we have valid data structure (not just cached invalid data)
            if (!class_exists('WPBakeryShortCode') 
                || empty($youbehero_data) 
                || !isset($youbehero_data['status']) 
                || $youbehero_data['status'] != 'active' 
                || !is_plugin_active('youbehero/youbehero.php')) {
                return; // WPBakery not active or plugin not configured, skip loading
            }

            // Include and register widget
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/wpbakery-donation-widget.php';
            add_action( 'vc_before_init', 'ybhd_register_wpbakery_element' );
        }

    }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new You_Be_Hero_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'ybh_enqueue_checkout_block_editor_assets' );
		$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'ybh_donation_checkout_block_modifications' );
		$this->loader->add_action( 'woocommerce_admin_order_totals_after_discount', $plugin_admin, 'woocommerce_admin_order_totals_after_discount_fun' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'ybhd_add_admin_menu' );
        $this->loader->add_action( 'wp_ajax_ybh_update_dashboard_json', $plugin_admin, 'ybh_update_dashboard_json' );
        $this->loader->add_action( 'wp_ajax_nopriv_ybh_update_dashboard_json', $plugin_admin, 'ybh_update_dashboard_json' );
        $this->loader->add_action( 'admin_post_ybhd_submit_apikey', $plugin_admin, 'ybhd_submit_apikey' );
        $this->loader->add_action( 'admin_post_nopriv_ybhd_submit_apikey', $plugin_admin, 'ybhd_submit_apikey' );
        $this->loader->add_action( 'wp_ajax_ybhd_logout', $plugin_admin, 'ybhd_logout' );
        $this->loader->add_action( 'wp_ajax_nopriv_ybhd_logout', $plugin_admin, 'ybhd_logout' );

        // Cron: refresh dashboard JSON asynchronously.
        $this->loader->add_action( 'youbehero_refresh_dashboard_json', $plugin_admin, 'youbehero_refresh_dashboard_json' );
        
        // Ensure cron is scheduled (safety check for existing installations)
        $this->loader->add_action( 'admin_init', $plugin_admin, 'ensure_cron_scheduled' );

    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new You_Be_Hero_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp', $plugin_public, 'display_checkout_donation' );
		$this->loader->add_action( 'woocommerce_cart_calculate_fees', $plugin_public, 'donation_widget_add_fee' );
		$this->loader->add_action( 'wp_ajax_update_donation_fee', $plugin_public, 'donation_widget_update_fee' );
		$this->loader->add_action( 'wp_ajax_nopriv_update_donation_fee', $plugin_public, 'donation_widget_update_fee' );
        $this->loader->add_action( 'woocommerce_checkout_create_order_fee_item', $plugin_public,'woocommerce_checkout_create_order_fee_item', 10, 4 );
		// Commented out: woocommerce_checkout_create_order hook - donation is handled as fee only, not as product item
		// $this->loader->add_action( 'woocommerce_checkout_create_order', $plugin_public, 'save_custom_data_from_session', 10, 2 );
		$this->loader->add_action( 'init', $plugin_public, 'donation_widget_register_block' );
		$this->loader->add_action( 'init', $plugin_public, 'youbehero_public_shortcodes' );
		$this->loader->add_action( 'init', $plugin_public, 'ybhd_register_checkout_meta' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'donation_widget_enqueue_scripts' );
        $this->loader->add_action( 'woocommerce_thankyou', $plugin_public, 'ybh_order_received_action' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'ybh_head_script' );
        $this->loader->add_action( 'woocommerce_new_order', $plugin_public, 'ybh_execute_api_on_order_place', 10, 1 );
        $this->loader->add_filter( 'wp_kses_allowed_html', $plugin_public, 'yobehero_allowed_html_tags', 10, 2 );

        $this->loader->add_action( 'woocommerce_order_details_after_order_table', $plugin_public, 'youbehero_thank_you_widget', 20, 1 );
        $this->loader->add_action( 'woocommerce_email_after_order_table', $plugin_public, 'youbehero_execute_email_widget', 20, 4 );
        $this->loader->add_action( 'template_redirect', $plugin_public, 'youbehero_init_woocommerce_hooks', 5);
        $this->loader->add_action( 'woocommerce_checkout_update_order_review', $plugin_public, 'youbehero_init_woocommerce_hooks', 5 );

        // Hook into the AJAX update at various points to ensure persistence
        // Register early on wp_ajax hooks to ensure hook is ready before checkout form renders
        $this->loader->add_action( 'wp_ajax_woocommerce_update_order_review', $plugin_public, 'youbehero_register_ajax_hooks_early', 1 );
        $this->loader->add_action( 'wp_ajax_nopriv_woocommerce_update_order_review', $plugin_public, 'youbehero_register_ajax_hooks_early', 1 );
        $this->loader->add_action( 'woocommerce_checkout_update_order_review', $plugin_public, 'youbehero_persist_hooks_on_ajax', 1 );
        $this->loader->add_action( 'woocommerce_before_checkout_form', $plugin_public, 'youbehero_persist_hooks_on_ajax', 1 );

        $this->loader->add_action( 'wp_ajax_youbehero_get_widget_html', $plugin_public, 'youbehero_ajax_get_widget_html' );
        $this->loader->add_action( 'wp_ajax_nopriv_youbehero_get_widget_html', $plugin_public, 'youbehero_ajax_get_widget_html' );

        $this->loader->add_action( 'template_redirect', $plugin_public, 'youbehero_wpbakery_init_woocommerce_hooks', 5 );
        $this->loader->add_action( 'woocommerce_checkout_update_order_review', $plugin_public, 'youbehero_wpbakery_init_woocommerce_hooks', 5 );

    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.1
	 * @return    You_Be_Hero_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
