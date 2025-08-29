<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://youbehero.com
 * @since      1.0.1
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/admin
 * @author     Vasilis Kolip <bill@youbehero.com>
 */
class You_Be_Hero_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

    }

            
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles( $hook_suffix ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in You_Be_Hero_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The You_Be_Hero_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if ( $hook_suffix == 'youbehero_page_ybh-dashboard' ||
            $hook_suffix == 'toplevel_page_ybh-settings' )  {

            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/you-be-hero-admin.css', array(), $this->version, 'all' );

        }

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in You_Be_Hero_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The You_Be_Hero_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/you-be-hero-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * @return void
     */
    public function ybh_add_admin_menu() {

        $icon_url = plugin_dir_url(__FILE__) . 'img/ybh-dark-icon-20x20.png';
        add_menu_page(
            'YouBeHero API Settings',
            'YouBeHero',
            'manage_options',
            'ybh-settings',
            array( $this, 'ybh_settings_page' ),
            $icon_url,
            56
        );

    }

    /**
     * @return void
     */
    public function ybh_settings_page() {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'youbehero' ) );
        }

        // Nonce check skipped: api_token may come from third-party service, not user-submitted form.
        $ybh_token = isset( $_GET['api_token'] ) ? sanitize_text_field( wp_unslash( $_GET['api_token'] ) ) : get_option( 'ybh_token' );

        //update json on page load
        $this->ybh_fetch_store_info( $ybh_token );

        $data = get_option( 'ybh_dashboard_json' );
        $data = !empty( $data ) ? json_decode( $data, true ) : [];

        if( !empty( $ybh_token ) && ( isset( $data['data'] ) && !empty( $data['data'] ) ) ) {
            $data = $data['data'];
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/you-be-hero-dashboard.php';
        } else {
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/you-be-hero-api-settings.php';
        }

    }

    /**
     * @return void
     */
    public function ybh_submit_apikey() {

        check_admin_referer( 'ybh_submit_apikey', 'ybh_submit_apikey_nonce' );

        $token = isset( $_POST['ybh_token'] )
            ? sanitize_text_field( wp_unslash( $_POST['ybh_token'] ) )
            : '';

        update_option( 'ybh_token', $token );

        $data = $this->ybh_fetch_store_info( $token );

        $status = empty( $data ) ? 'fail' : 'success';

        // Safely get referer
        $http_referer = isset( $_SERVER['HTTP_REFERER'] )
            ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) )
            : get_admin_url();

        // Sanitize URL
        $referer = esc_url_raw( $http_referer );

        // Append status param
        $redirect_url = add_query_arg( [ 'status' => $status ], $referer );

        // Safe redirect
        wp_safe_redirect( $redirect_url );
        exit();

    }

    /**
     * @return void
     */
    public function ybh_enqueue_checkout_block_editor_assets() {

        wp_enqueue_script(
            'ybh-checkout-block-settings',
            plugins_url( 'js/checkout-block-settings.js', __FILE__ ),
            array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-data', 'wp-compose', 'wc-blocks-checkout' ),//'wp-element', 'wc-blocks-checkout'
            filemtime( YBH_PLUGIN_ADMIN_DIR . 'js/checkout-block-settings.js' ),
            true
        );

    }

    /**
     * @return void
     */
    public function ybh_donation_checkout_block_modifications() {

        wp_enqueue_script(
            'custom-checkout-widget',
            YBH_PLUGIN_URL.'admin/js/checkout-widget.js',
            array('wp-blocks', 'wp-edit-post', 'wp-hooks'),
            filemtime(YBH_PLUGIN_ADMIN_DIR . '/js/checkout-widget.js'),
            false
        );

    }

    /**
     * @param $order_id
     * @return void
     */
    public function woocommerce_admin_order_totals_after_discount_fun( $order_id ) {

        $order = wc_get_order( $order_id );
        $donation_total = 0;
        $other_fees_total = 0;

        foreach ( $order->get_fees() as $fee ) {
            $fee_total = ( float ) $fee->get_total(); // Ensure proper numeric type

            if ( stripos( $fee->get_name(), 'donation' ) !== false ) {
                $donation_total += $fee_total;
            } else {
                $other_fees_total += $fee_total;
            }
        }

        if ($other_fees_total > 0) {
            echo '<tr>';
            echo '<td class="label">' . esc_html( __( 'Other Fees:', 'youbehero' ) ) . '</td>';
            echo '<td width="1%"></td>';
            echo '<td class="total"><strong>' . esc_html( wc_price( $other_fees_total ) ) . '</strong></td>';
            echo '</tr>';
        }

    }

    /**
     * @return false|void
     */
    public function ybh_update_dashboard_json() {

        try {
            $response = wp_remote_get( 'https://dev.youbehero.com/api/shop-details?api_token='.get_option( 'ybh_token' ) );

            if ( is_wp_error( $response ) ) {
                return false;
            }

            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body, true );

            update_option( 'ybh_dashboard_json', $body );

            wp_send_json(array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Found ' . count($data) . ' results',
                'data' => $data
            ));
        } catch (Exception $e) {
            wp_send_json(array(
                'status' => 'error',
                'code' => 400,
                'message' => $e->getMessage(),
            ), 400);
        }
    }

    /**
     * @param $token
     * @return false|mixed
     */
    public function ybh_fetch_store_info( $token = '' ) {

        $api_key = empty( $token ) ? get_option( 'ybh_token' ) : $token;
        $response = wp_remote_get( 'https://dev.youbehero.com/api/shop-details?api_token='.$api_key );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $body = wp_remote_retrieve_body( $response );

        update_option( 'ybh_dashboard_json', $body );

        return json_decode( $body, true );

    }

    /**
     * @return void
     */
    public function ybh_logout() {

        update_option( 'ybh_token', '' );
        wp_send_json( ['status' => 'success' ] );

    }

}
