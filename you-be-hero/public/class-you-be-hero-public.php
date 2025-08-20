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

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/public
 * @author     Vasilis Kolip <bill@youbehero.com>
 */
class You_Be_Hero_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

    }
        
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/you-be-hero-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
                if ( function_exists( 'is_checkout' ) && is_checkout() ) {
                    wp_enqueue_script(
                        'custom-checkout-fields',
                        plugin_dir_url( __FILE__ ) . 'js/custom-checkout.js',
//                        [ 'wp-element', 'wc-blocks-checkout' ], // Dependencies
                       [ 'lodash', 'react', 'wc-blocks-checkout', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n' ], // Ensure required dependencies
                        filemtime( plugin_dir_path( __FILE__ ) . 'js/custom-checkout.js' ),
                        true
                    );

                    // Add "type=module" attribute to the script
                    add_filter( 'script_loader_tag', function( $tag, $handle ) {
                        if ( 'custom-checkout-fields' === $handle ) {
                            return str_replace( 'src', 'type="module" src', $tag );
                        }
                        return $tag;
                    }, 10, 2 );
                }
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/you-be-hero-public.js', array( 'jquery' ), $this->version, false );

	}

    // Register the block
    function donation_widget_register_block() {
        // Register the block using metadata from block.json
        register_block_type(YBH_PLUGIN_DIR . '/build');
    }

    // Enqueue scripts and styles
    function donation_widget_enqueue_scripts() {

        if ( is_checkout() ) {
            // Fetch data from the API
            $data = $this->donation_widget_fetch_data();
            wp_enqueue_style( 'donation-widget-style', YBH_PLUGIN_URL.'assets/css/style.css', array(), $this->version, 'all' );
            wp_enqueue_script( 'donation-widget-script', YBH_PLUGIN_URL.'assets/js/script.js', array( 'jquery' ), $this->version, true );

            if ($data) {

                // Extract causes and amounts
                $causes = array_map(function ($cause) {
                    return [
                        'label' => $cause['name'],
                        'value' => $cause['id'],
                        'image' => $cause['image']
                    ];
                }, $data['selected_causes']);

                $amounts = array_values($data['donation_settings']['fixed_amounts'] ?? []);

                $donation_amount = WC()->session->get('ybh_donation_amount', 0);//let's pick current selection
                // Localize script with the data
                wp_localize_script('donation-widget-script', 'ybh_donation_checkout_params', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce'    => wp_create_nonce( 'ybh_donation_action' ),
                    'causes'   => $causes,
                    'amounts'  => $amounts,
                    'selected_amount'  => $donation_amount,
                ));

            }
        }
    }

    /**
     * Add donation fee to cart
     * @param $cart
     * @return void
     */
    function donation_widget_add_fee($cart) {
        $donation_amount = WC()->session->get('ybh_donation_amount', 0);
        $donation_cause = WC()->session->get('ybh_donation_cause', '');
        $donation_cause = WC()->session->get('_donation_org_name', '');
        $donation_cause_id = WC()->session->get('_donation_org_id', 0);
        $donation_cause_img = WC()->session->get('_donation_org_img', '');

        // Don't proceed in admin or if there's no donation amount
        if (is_admin() && !is_ajax()) {
            return;
        }

        // If amount is empty or zero, remove the fee and clear session
        if (empty($donation_amount) || floatval($donation_amount) <= 0) {
            $this->donation_widget_remove_fee();
            return;
        }

        // Add fee if we have amount and cause
        if (!empty($donation_cause)) {
            $donation_amount = floatval($donation_amount);
            $donation_cause = sanitize_text_field($donation_cause);

            $fee_title = __('Donation for', 'youbehero') .' '.$donation_cause;
            $fee_id = $cart->add_fee($fee_title, $donation_amount);

            $last_fee_index = count($cart->fees) - 1;
            if (isset($cart->fees[$last_fee_index]) && $cart->fees[$last_fee_index]->id === $fee_id) {
                $cart->fees[$last_fee_index]->_ybh_donation_amount = $donation_amount;
                $cart->fees[$last_fee_index]->ybh_donation_cause = $donation_cause;
                $cart->fees[$last_fee_index]->_donation_org_name = $donation_cause;
                $cart->fees[$last_fee_index]->ybh_donation_cause_id = $donation_cause_id;
                $cart->fees[$last_fee_index]->ybh_donation_cause_img = $donation_cause_img;
            }
        }
    }

    /**
     * Handle AJAX request
     * @return void
     */
    function donation_widget_update_fee() {

        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ybh_donation_action' ) ) {
            wp_send_json_error( [ 'message' => 'Invalid nonce' ], 403 );
        }

        $org_id = isset( $_POST['org_id'] ) ? absint( $_POST['org_id'] ) : 0;
        $org_name = isset( $_POST['org_name'] ) ? sanitize_text_field( wp_unslash( $_POST['org_name'] ) ) : '';
        $amount = isset( $_POST['amount'] ) ? floatval( $_POST['amount'] ) : 0;
        $org_img = isset( $_POST['org_img'] ) ? sanitize_text_field( wp_unslash( $_POST['org_img'] ) ) : '';// Changed from floatval to sanitize_text_field for image

        // Initialize cart if not exists
        if ( !WC()->cart ) {
            wc_load_cart();
        }

        // If amount is empty or zero, remove the fee
        if ( empty($amount) || $amount <= 0 || empty( $org_name ) || empty( $org_id ) ) {
            $this->donation_widget_remove_fee();
            wp_send_json_success([
                'fees' => WC()->cart->get_fees(),
                'total' => WC()->cart->get_total('edit'),
                'message' => 'Donation removed'
            ]);
            return;
        }

        // Validate required fields only if we're adding a fee
        if ( empty( $org_name ) || empty( $org_id ) ) {
            wp_send_json_error( ['message' => 'Donation cause is not valid.'] );
            return;
        }


        // Add fee (WooCommerce native method)
        WC()->cart->add_fee(
            __( 'Donation for', 'youbehero' ) . $org_name,//"Donation for {$org_name}",
            $amount,
            false, // Not taxable
        );
        // Set session data
        WC()->session->set('ybh_donation_amount', $amount);
        WC()->session->set('ybh_donation_cause', $org_name);
        WC()->session->set('_donation_org_name', $org_name);
        WC()->session->set('_donation_org_id', $org_id);
        WC()->session->set('_donation_org_img', $org_img);

        wp_send_json_success([
            'fees' => WC()->cart->get_fees(),
            'total' => WC()->cart->get_total('edit'),
            'message' => 'Donation updated'
        ]);
    }

    /**
     * @return void
     */
    function donation_widget_remove_fee() {
        WC()->session->set('ybh_donation_amount', 0);
        WC()->session->set('ybh_donation_cause', '');
        WC()->session->set('_donation_org_name', '');
        WC()->session->set('_donation_org_id', 0);
        WC()->session->set('_donation_org_img', '');
        if (!WC()->cart) {
            return;
        }

        $fees = WC()->cart->get_fees();

        foreach ($fees as $key => $fee) {
            if (isset($fee->ybh_donation_cause) || isset($fee->_ybh_donation_amount)) {
                unset(WC()->cart->fees[$key]);
            }
        }
        if (WC()->cart) {
//                WC()->cart->calculate_totals();
        }
    }

    /**
     * @param $item
     * @param $fee_key
     * @param $fee
     * @param $order
     * @return void
     */
    function woocommerce_checkout_create_order_fee_item($item, $fee_key, $fee, $order) {

        $donation_amount = WC()->session->get( 'ybh_donation_amount', 0 );
        $donation_cause = WC()->session->get( 'ybh_donation_cause', '' );
        $donation_org_name = WC()->session->get( '_donation_org_name', '' );
        $donation_cause_id = WC()->session->get( '_donation_org_id', 0 );
        $donation_cause_img = WC()->session->get( '_donation_org_img', '' );
        if (isset($donation_cause_id)) {
            $item->add_meta_data('_ybh_donation_amount', $donation_amount);
            $item->add_meta_data('_donation_org_id', $donation_cause_id);
            $item->add_meta_data('_donation_org_img', $donation_cause_img);
            $item->add_meta_data('Donation Organization', $donation_org_name);
            $item->add_meta_data('_donation_org_name', $donation_org_name);
        }
    }

    /**
     * @return array|false|mixed
     */
    function donation_widget_fetch_data() {

        $api_token = get_option( 'ybh_token' );

        if( !empty( $api_token ) ) {
            $response = wp_remote_get( 'https://dev.youbehero.com/api/shop-details?api_token='.$api_token );

            if (is_wp_error($response)) {
                return false;
            }

            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($data['data'])) {
                return false;
            }

            update_option( 'ybh_dashboard_json', $body );
            return $data['data'];
        }

        return [];
    }

    /**
     * @param $order
     * @param $data
     * @return void
     */
    function save_custom_data_from_session($order, $data) {
        // Retrieve custom data from the session
        $ybh_donation_amount = WC()->session->get( 'ybh_donation_amount', 0 );
        $ybh_donation_cause = WC()->session->get( 'ybh_donation_cause', '' );

        if ($ybh_donation_amount && $ybh_donation_cause ) {
            $cause_name = $ybh_donation_cause;
            $item = new WC_Order_Item_Product();
            $item->set_name( $cause_name );
            $item->set_product_id( 0 );
            $item->set_subtotal( $ybh_donation_amount );
            $item->set_total( $ybh_donation_amount );
            $order->add_item( $item );

        }
    }

    /**
     * @return void
     */
    public function display_checkout_donation() {

        $this->youbehero_public_shortcodes();
        $checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
        if ( !$checkout_page_id ) return;

        // Retrieve the stored meta value
        $selected_position = get_post_meta( $checkout_page_id, '_ybh_donation_position', true );
        $selected_position = 'woocommerce_before_checkout_payment';

        if ( empty( $selected_position ) ) {
            $selected_position = 'woocommerce_after_checkout_billing_form'; // Default
        }

        // Add the donation form at the selected WooCommerce hook
        add_action( $selected_position, function () {
            echo '<div class="ybh-donation-form">';
            echo '<h3>Support Us</h3>';
            echo do_shortcode( '[donation_form]' );
            echo '</div>';
        } );
    }

    /**
     * @param $param
     * @return void
     */
    public function woocommerce_before_checkout_payment_fun( $param ) {
        echo do_shortcode( '[donation_form]' );
    }

    /**
     * @return void
     */
    function ybh_register_checkout_meta() {
        register_post_meta('post', '_ybh_donation_position', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ));
    }
    
    /**
     * Function for public shortcodes
     * 
     * @return void
     */
    public function youbehero_public_shortcodes() {

        $shortcodes_class = new ShortCodes_Public();
        
    }

    /**
     * @param $endpoints
     * @return mixed
     */
    function woocommerce_register_store_api_endpoints( $endpoints ) {

        $endpoints[] = [
            'namespace' => 'wc/store',
            'route' => '/youbehero',
            'callback' => function($request) {
                try {
                    // Validate request
                    if (!wp_verify_nonce($request->get_header('X-WC-Store-API-Nonce'), 'wc_store_api')) {
                        throw new Exception('Invalid nonce', 403);
                    }

                    // Process request
                    $params = $request->get_params();

                    // Your custom logic here
                    $result = [
                        'success' => true,
                        'data' => [
                            'custom_field' => 'custom_value',
                            'params' => $params
                        ]
                    ];

                    return new WP_REST_Response($result, 200);
                } catch (Exception $e) {
                    return new WP_Error(
                        'youbehero_error',
                        $e->getMessage(),
                        ['status' => $e->getCode() ?: 400]
                    );
                }
            },
            'methods' => ['GET', 'POST'],
            'permission_callback' => function() {
                return current_user_can('read'); // Adjust capability as needed
            }
        ];
        return $endpoints;
    }

    /**
     * @param $order_id
     * @return void
     */
    public function ybh_order_received_action( $order_id ) {
        if ( ! $order_id ) {
            return;
        }

        $donation_cause_id = WC()->session->get( '_donation_org_id', 0 );
        if (isset($donation_cause_id)) {
            WC()->session->__unset('ybh_donation_amount');
            WC()->session->__unset('ybh_donation_cause');
            WC()->session->__unset('_donation_org_name');
            WC()->session->__unset('_donation_org_id');
            WC()->session->__unset('_donation_org_img');
        }
    }

    /**
     * @return void
     */
    public function ybh_head_script() {

        $youbehero_data = json_decode( get_option('ybh_dashboard_json' ), true );
        $youbehero_data = $youbehero_data['data'] ?? [];

        if( !empty( $youbehero_data ) ){
            $btn_color = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['btn_color'] ?? "#3b82f6";
            ?>

            <style>
                .donation-btn.selected {
                    border-color: <?php echo esc_html( $btn_color ); ?>;
                    background-color: <?php echo esc_html($btn_color ); ?>;
                }
            </style>
            <?php
        }
    }

    /**
     * @param $order_id
     * @return void
     */
    public function ybh_execute_api_on_order_place( $order_id ) {

        $logger = wc_get_logger();
        $order = wc_get_order( $order_id );
        // Extract order data
        $order_data = $this->ybh_extract_order_data( $order );

        // Execute API call
        $api_response = $this->ybh_call_external_api( $order_data );

        // Log the response (optional)
        if ( $api_response ) {
            $logger->error( 'API Response for Order #' . $order_id . ': ' . $api_response, [ 'source' => 'youbehero' ] );
        }

    }

    /**
     * @param $order
     * @return array
     */
    public function ybh_extract_order_data( $order ) {

        $donation_total = 0;

        foreach ( $order->get_fees() as $fee ) {
            $fee_total = (float) $fee->get_total();

            if ( stripos( $fee->get_name(), 'donation' ) !== false ) {
                $donation_total += $fee_total;
            }
        }

        // Extract comprehensive order data
        return array(
            'transaction_id' => $order->get_order_number(),
            'sale_amount' => $order->get_total(),
            'commission_amount' => $donation_total,
            'cause_id' => WC()->session->get('_donation_org_id', 0)
        );
    }

    /**
     * @param $order_data
     * @return false|mixed
     */
    public function ybh_call_external_api( $order_data ) {

        $logger = wc_get_logger();

        // Configure your API endpoint and credentials
        $api_url = 'https://dev.youbehero.com/api/wp-transactions';
        $api_key = get_option( 'ybh_token' );

        // Prepare the request
        $args = array(
            'body' => json_encode($order_data),
            'headers' => array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $api_key,
                // Add other headers as needed
            ),
            'method' => 'POST',
//            'timeout' => 30,
//            'sslverify' => true
        );

        // Make the API call
        $response = wp_remote_post( $api_url, $args );

        // Handle response
        if (is_wp_error( $response ) ) {
            $logger->error( 'API Error: ' . $response->get_error_message(), [ 'source' => 'youbehero' ] );
            return false;
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ( $response_code === 200 || $response_code === 201 ) {
            return json_decode( $response_body, true );
        } else {
            $logger->error( 'API Response Error: Code ' . $response_code . ' - ' . $response_body, [ 'source' => 'youbehero' ] );
            return false;
        }

    }

}
