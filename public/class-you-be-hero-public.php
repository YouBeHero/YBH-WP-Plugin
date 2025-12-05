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
 * @author     YouBeHero <info@youbehero.com>
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
                'youbehero-checkout-fields',
                plugin_dir_url( __FILE__ ) . 'js/you-be-hero-checkout.js',
//                        [ 'wp-element', 'wc-blocks-checkout' ], // Dependencies
               [ 'lodash', 'react', 'wc-blocks-checkout', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n' ], // Ensure required dependencies
                filemtime( plugin_dir_path( __FILE__ ) . 'js/you-be-hero-checkout.js' ),
                true
            );

            // Add "type=module" attribute to the script
            add_filter( 'script_loader_tag', function( $tag, $handle ) {
                if ( 'youbehero-checkout-fields' === $handle ) {
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
        register_block_type(YBHD_PLUGIN_DIR . 'build');

        wp_register_script(
            'donation-widget-ybh-chekcout-donation-block-editor-script',
            plugins_url( 'build/index.js', __DIR__ ),
            [ 'wp-i18n', 'wp-blocks', 'wp-element', 'wp-editor' ],
            $this->version,
            true
        );

        wp_set_script_translations( 'donation-widget-ybh-chekcout-donation-block-editor-script', 'youbehero', YBHD_PLUGIN_DIR . 'languages' );

        wp_register_script(
            'ybhd-thankyou-note',
            plugins_url( 'blocks/thankyou-note/thankyou-note.js', __DIR__ ),
            [ 'wp-i18n', 'wp-element', 'wp-compose', 'wp-hooks' ],
            filemtime( YBHD_PLUGIN_ADMIN_DIR . 'js/checkout-block-settings.js' ),
            true
        );

        wp_set_script_translations(
            'ybhd-thankyou-note',
            'youbehero',
            YBHD_PLUGIN_DIR . 'languages'
        );

        wp_enqueue_script( 'ybhd-thankyou-note' );
    }


    // Enqueue scripts and styles
    function donation_widget_enqueue_scripts() {

        if ( is_checkout() ) {
            // Fetch data from the API
            $data = $this->donation_widget_fetch_data();
            wp_enqueue_style( 'donation-widget-style', YBHD_PLUGIN_URL.'assets/css/style.css', array(), $this->version, 'all' );
            wp_deregister_script('donation-widget-script');
            wp_enqueue_script( 'donation-widget-script', YBHD_PLUGIN_URL.'assets/js/script.js', array( 'jquery' ), $this->version, true );

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

            $fees = method_exists( $cart, 'get_fees' )
                ? $cart->get_fees()
                : ( isset( $cart->fees ) ? $cart->fees : array() );

            $last_fee_index = count($fees) - 1;
            if (isset($fees[$last_fee_index]) && $fees[$last_fee_index]->id === $fee_id) {
                $fees[$last_fee_index]->_ybh_donation_amount = $donation_amount;
                $fees[$last_fee_index]->ybh_donation_cause = $donation_cause;
                $fees[$last_fee_index]->_donation_org_name = $donation_cause;
                $fees[$last_fee_index]->ybh_donation_cause_id = $donation_cause_id;
                $fees[$last_fee_index]->ybh_donation_cause_img = $donation_cause_img;
            }

//            $last_fee_index = count($cart->fees) - 1;
//            if (isset($cart->fees[$last_fee_index]) && $cart->fees[$last_fee_index]->id === $fee_id) {
//                $cart->fees[$last_fee_index]->_ybh_donation_amount = $donation_amount;
//                $cart->fees[$last_fee_index]->ybh_donation_cause = $donation_cause;
//                $cart->fees[$last_fee_index]->_donation_org_name = $donation_cause;
//                $cart->fees[$last_fee_index]->ybh_donation_cause_id = $donation_cause_id;
//                $cart->fees[$last_fee_index]->ybh_donation_cause_img = $donation_cause_img;
//            }
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

        // Frontend should only read from cached JSON to avoid blocking checkout.
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

    /**
     * Check if widget should be displayed based on is_scheduled and has_ended flags
     * 
     * @return bool True if widget should be displayed, false if it should be blocked
     */
    private function youbehero_should_display_widget() {
        $youbehero_data = json_decode( get_option('ybhd_dashboard_json' ), true );
        $youbehero_data = $youbehero_data['data'] ?? [];
        $is_scheduled = isset($youbehero_data['is_scheduled']) && (intval($youbehero_data['is_scheduled']) === 1);
        $has_ended = isset($youbehero_data['has_ended']) && (intval($youbehero_data['has_ended']) === 1);
        
        return !$is_scheduled && !$has_ended;
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
            echo do_shortcode( '[youbehero_donation_form]' );
            echo '</div>';
        } );
    }

    /**
     * @return void
     */
    function ybhd_register_checkout_meta() {
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

        $shortcodes_class = new YouBeHero_ShortCodes_Public();
        
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

        if ( is_checkout() ) {
            $youbehero_data = json_decode( get_option( 'ybhd_dashboard_json' ), true );
            $youbehero_data = $youbehero_data['data'] ?? [];

            if ( ! empty( $youbehero_data ) ) {
                $btn_color_raw = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['btn_color'] ?? '#3b82f6';

                // Escape/sanitize late for CSS context
                $btn_color = sanitize_hex_color( $btn_color_raw );
                if ( empty( $btn_color ) ) {
                    $btn_color = '#3b82f6'; // fallback
                }

                wp_register_style( 'youbehero-inline-style', false, array(), $this->version );
                wp_enqueue_style( 'youbehero-inline-style' );

                // Add inline styles (safe now)

                $custom_css = sprintf(
                    '                    /* Idle/Focused state - default */
                    .donation-btn {
                        background-color: white;
                        color: #212121;
                        border-color: #ccc;
                    }
                    
                    /* Delete button - always white bg and dark text */
                    .donation-btn.delete-button {
                        background-color: white !important;
                        color: #212121 !important;
                        border-color: #ccc !important;
                    }
                    
                    .donation-btn.delete-button:hover,
                    .donation-btn.delete-button:active,
                    .donation-btn.delete-button:focus {
                        background-color: white !important;
                        color: #212121 !important;
                        border-color: #ccc !important;
                    }
                    
                    /* Hovered state - show JSON color (exclude delete button) */
                    .donation-btn:not(.delete-button):not(.long-pressed):hover,
                    .donation-btn:not(.delete-button):not(.long-pressed):active {
                        background-color: var(--btn-color, %1$s) !important;
                        border-color: var(--btn-color, %1$s) !important;
                        color: #ffffff !important;
                    }
                    
                    /* Selected state - always show JSON color (exclude delete button) */
                    .donation-btn.selected:not(.delete-button) {
                        background-color: var(--btn-color, %1$s) !important;
                        border-color: var(--btn-color, %1$s) !important;
                        color: #ffffff !important;
                    }
                    
                    /* Focused state - same as idle */
                    .donation-btn:focus {
                        background-color: white;
                        color: #212121;
                        border-color: #ccc;
                        outline: none;
                    }
                    
                    /* Long pressed - prevent hover styles */
                    .donation-btn.long-pressed {
                        background-color: white !important;
                        border-color: #ccc !important;
                        color: #212121 !important;
                    }
                    
                    /* Spinner for donation buttons */
                    .donation-btn .button-spinner {
                        display: none;
                        width: 16px;
                        height: 16px;
                        border: 2px solid #FFF;
                        border-bottom-color: transparent;
                        border-radius: 50%%;
                        box-sizing: border-box;
                        animation: rotation 1s linear infinite;
                        vertical-align: middle;
                        flex-shrink: 0;
                    }
                    
                    /* Spinner color for delete button - black */
                    .donation-btn.delete-button .button-spinner {
                        border-color: #000;
                        border-bottom-color: transparent;
                    }
                    
                    .donation-btn.loading .button-spinner {
                        display: inline-block;
                    }
                    
                    /* Hide button text when loading */
                    .donation-btn.loading {
                        pointer-events: none;
                        opacity: 0.7;
                        position: relative;
                        font-size: 0;
                        text-align: center;
                        justify-content: center;
                        align-items: center;
                    }
                    
                    /* Remove transitions from donation buttons to prevent weird spinner transitions */
                    .donation-btn {
                        transition: none !important;
                    }
                    
                    .donation-btn * {
                        transition: none !important;
                    }
                    
                    /* But keep the spinner animation */
                    .donation-btn .button-spinner {
                        transition: none !important;
                    }
                    
                    /* Show spinner and reset its font-size */
                    .donation-btn.loading .button-spinner {
                        font-size: initial;
                    }
                    
                    /* Hide all child elements except spinner when loading */
                    .donation-btn.loading > *:not(.button-spinner) {
                        display: none !important;
                    }
                    
                    .donation-buttons.disabled .donation-btn,
                    .donation-amounts.disabled .donation-btn {
                        pointer-events: none;
                        opacity: 0.6;
                        cursor: not-allowed;
                    }
                    
                    @keyframes rotation {
                        0%% {
                            transform: rotate(0deg);
                        }
                        100%% {
                            transform: rotate(360deg);
                        }
                    }',
                    esc_attr( $btn_color )
                );

                wp_add_inline_style( 'youbehero-inline-style', $custom_css );
            }
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

        $fees = $order->get_fees();

        if ( empty( $fees ) ) {
            $cart = WC()->cart;
            $fees = method_exists( $cart, 'get_fees' )
                ? $cart->get_fees()
                : ( isset( $cart->fees ) ? $cart->fees : array() );
        }

//        foreach ( $order->get_fees() as $fee ) {
        foreach ( $fees as $fee ) {
            $fee_total = (float) method_exists( $fee, 'get_total' ) ? $fee->get_total() : $fee->total;

            $name = method_exists( $fee, 'get_name' ) ? $fee->get_name() : $fee->name;
//            if ( stripos( $fee->get_name(), 'donation' ) !== false ) {
//            if ( stripos( $fee->get_name(), WC()->session->get( '_donation_org_name' ) ) !== false ) {
            if ( stripos( $name, WC()->session->get( '_donation_org_name' ) ) !== false ) {
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
        $api_key = get_option( 'ybhd_token' );

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

    /**
     * Extend wp_kses_post to allow extra tags and attributes
     *
     * @param $allowed_tags
     * @param $context
     * @return array|mixed
     */
    public function yobehero_allowed_html_tags( $allowed_tags, $context ) {

        if ( $context === 'post' ) {

            // Add missing tags if not present
            $extra_tags = array(
                'div'    => array(),
                'span'   => array(),
                'button' => array(
                    'type'  => true,
                    'name'  => true,
                    'value' => true,
                ),
                'img'    => array(
                    'src'    => true,
                    'alt'    => true,
                    'width'  => true,
                    'height' => true,
                ),
                'input'  => array(
                    'type'  => true,
                    'name'  => true,
                    'value' => true,
                ),
            );

            // Merge extra tags with defaults
            $allowed_tags = array_merge( $allowed_tags, $extra_tags );

            foreach ( $allowed_tags as $tag => $attrs ) {
                $allowed_tags[ $tag ]['class']  = true;
                $allowed_tags[ $tag ]['id']     = true;
                $allowed_tags[ $tag ]['style']  = true;
                $allowed_tags[ $tag ]['data-*'] = true;
            }
        }
        return $allowed_tags;

    }

    /**
     * Add custom content after the order details table on the thank you page
     *
     * @param $order
     * @return void
     */
    public function youbehero_thank_you_widget( $order ) {

        $ybhd_token = get_option( 'ybhd_token' );

        if ( ! empty( $ybhd_token ) ) {
            $data = get_option('ybhd_dashboard_json');
            $youbehero_data = !empty($data) ? json_decode($data, true) : [];
            $youbehero_data = !empty($youbehero_data) ? $youbehero_data['data'] : [];

            $donation_org_id = 0;
            foreach ($order->get_items('fee') as $item_id => $item) {
                $donation_org_id = $item->get_meta('_donation_org_id');
            }

            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/you-be-hero-thankyou-widget.php';
        }
    }

    /**
     * @param $data
     * @param $id
     * @return mixed|null
     */
    public function youbehero_get_ordered_cause( $data, $id ) {

        foreach ( $data as $item ) {
            if ( isset( $item['id'] ) && $item['id'] == $id ) {
                return $item;
            }
        }
        return null;

    }

    /**
     * @param $data_for
     * @param $index
     * @return false|mixed
     */
    public function youbehero_get_mpb_value( $data_for, $index ) {

        $array = array(
            'margin' => array(
                'big'   => '20px', 'mid'   => '12px', 'small' => '4px'
            ),
            'padding' => array(
                'big'   => '24px', 'mid'   => '16px', 'small' => '8px'
            ),
            'b_radius' => array(
                'big'   => '16px', 'mid'   => '8px', 'small' => '4px'
            )
        );

        $matched = array_filter( $array[$data_for], function( $v, $k ) use ( $index ) {
            return strpos( $index, $k ) !== false;
        }, ARRAY_FILTER_USE_BOTH );

        return reset( $matched );

    }

    /**
     * @param $order
     * @param $sent_to_admin
     * @param $plain_text
     * @param $email
     * @return void
     */
    public function youbehero_execute_email_widget( $order, $sent_to_admin, $plain_text, $email ) {

        $ybhd_token = get_option( 'ybhd_token' );

        if ( ! empty( $ybhd_token ) ) {
            // Only add to new order email ( customer emails)
//        if ( $email->id !== 'customer_processing_order' ) {
//            return;
//        }

            if (in_array($email->id, ['customer_on_hold_order', 'customer_processing_order', 'customer_completed_order'], true)) {
                $dashboard_data = get_option('ybhd_dashboard_json');
                $data = !empty($dashboard_data) ? json_decode($dashboard_data, true) : [];
                $youbehero_data = !empty($data) ? $data['data'] : [];

                if (isset($youbehero_data['status']) && $youbehero_data['status'] == 'active' && !empty($youbehero_data)) {

                    $check_w_active = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['active'] ?? false;

                    if ($check_w_active) {
                        $donation_org_id = 0;
                        foreach ($order->get_items('fee') as $item_id => $item) {
                            $donation_org_id = $item->get_meta('_donation_org_id');
                        }

                        $selected_cause_info = $this->youbehero_get_ordered_cause($youbehero_data['selected_causes'], $donation_org_id);

                        if (!empty($selected_cause_info)) {
                            $email_widget_obj = new YouBeHero_Email_Widget();
                            $email_widget_obj->youbehero_send_email($order, $youbehero_data, $selected_cause_info);
                        }
                    }
                }
            }
        }
    }

    /**
     * Initialize WooCommerce Hooks for Donation Widget
     * This runs early enough to catch WooCommerce hooks
     */
    public function youbehero_init_woocommerce_hooks() {

        // Check if Elementor is active
        if (!did_action('elementor/loaded')) {
            return;
        }

        // Only run on frontend
        if (is_admin()) {
            return;
        }

        // Check for WooCommerce
        if (!class_exists('WooCommerce')) {
            return;
        }

        // Run on checkout page OR during AJAX order review update
        $is_checkout = is_checkout();
        $is_ajax_update = defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['wc-ajax']) && $_REQUEST['wc-ajax'] === 'update_order_review';

        if (!$is_checkout && !$is_ajax_update) {
            return;
        }

        // Get the current page ID
        $post_id = get_the_ID();

        // For AJAX requests, try to get the checkout page ID
        if (!$post_id && $is_ajax_update) {
            $checkout_page_id = wc_get_page_id('checkout');
            if ($checkout_page_id) {
                $post_id = $checkout_page_id;
            }
        }

        if (!$post_id) {
            return;
        }

        // Check if Elementor Plugin is available
        if (!class_exists('\Elementor\Plugin')) {
            return;
        }

        // Check if this page is built with Elementor
        $elementor_instance = \Elementor\Plugin::$instance;
        if (!$elementor_instance || !isset($elementor_instance->documents)) {
            return;
        }

        $document = $elementor_instance->documents->get($post_id);

        if (!$document) {
            return;
        }

        $elements_data = $document->get_elements_data();

        if (empty($elements_data)) {
            return;
        }

        // Initialize global settings
        global $youbehero_widget_settings;
        $youbehero_widget_settings = array(
            'enabled' => false,
            'position' => ''
        );

        // Scan for our widget and add hooks
        $this->youbehero_scan_and_add_hooks($elements_data);

    }

    /**
     * Recursively scan Elementor elements for our widget
     */
    public function youbehero_scan_and_add_hooks($elements) {

        static $hooks_added = false;

        global $youbehero_widget_settings; // Access the global variable

        foreach ($elements as $element) {
            // Check if this is our widget
            if (isset($element['widgetType']) && $element['widgetType'] === 'youbehero_donation_widget_v2') {
                $settings = $element['settings'];

                // Check if explicitly set to 'yes' (SWITCHER returns 'yes' when ON, empty string when OFF)
                // If the key exists but is empty/false, it means 'no'. If key doesn't exist, default to 'yes'
                if (isset($settings['woocommerce_hook_enable'])) {
                    $wc_hook_enabled = ($settings['woocommerce_hook_enable'] === 'yes') ? 'yes' : 'no';
                } else {
                    $wc_hook_enabled = 'yes'; // Default to 'yes' if not set
                }
                $placement_position = !empty($settings['placement_position']) ? $settings['placement_position'] : 'woocommerce_after_checkout_billing_form';

                if ($wc_hook_enabled === 'yes' && !$hooks_added) {
                    // Update the global settings
                    $youbehero_widget_settings['enabled'] = true;
                    $youbehero_widget_settings['position'] = $placement_position;

                    // Capture widget HTML ONCE at the beginning
                    // The shortcode itself (render.php) will handle is_scheduled/has_ended checks
                    ob_start();
                    echo do_shortcode('[youbehero_donation_form]');
                    $captured_widget_html = ob_get_clean();

                    // Add the WooCommerce hook
                    add_action($placement_position, function() use ($placement_position, $captured_widget_html) {
                        static $script_added = false;

                        // Only output if we have captured HTML (shortcode already handled is_scheduled/has_ended checks)
                        if (empty($captured_widget_html)) {
                            return; // Don't output widget if empty
                        }

                        // Output the widget
                        echo $captured_widget_html;

                        // Add script inline right after the widget (only once)
                        if (!$script_added) {
                            ?>
                            <script type="text/javascript">
                                (function() {
                                    if (typeof jQuery === 'undefined') {
                                        console.error('YouBeHero: jQuery not loaded!');
                                        return;
                                    }

                                    jQuery(document).ready(function($) {


                                        let youbeheroWidgetHtml = <?php echo json_encode($captured_widget_html); ?>;
                                        var youbeheroPlacement = <?php echo json_encode($placement_position); ?>;

                                        console.log('YouBeHero: Script loaded, placement:', youbeheroPlacement);
                                        console.log('YouBeHero: Widget HTML length:', youbeheroWidgetHtml.length);

                                        if (!youbeheroWidgetHtml || youbeheroWidgetHtml.length < 10) {
                                            console.error('YouBeHero: Widget HTML is empty or too short!');
                                            return;
                                        }

                                        function injectYoubeheroWidget() {
                                            console.log('YouBeHero: Injecting widget...');
                                            //====================//
                                            var storedWidgetHtml = $('#hidden-donation-html').text();
                                            var decodedStoredWidgetHtml = $('<div/>').html(storedWidgetHtml).html();
                                            if (decodedStoredWidgetHtml || $.trim(decodedStoredWidgetHtml) !== '') {
                                                youbeheroWidgetHtml = decodedStoredWidgetHtml;
                                            }
                                            //====================//

                                            // Remove any existing instances first
                                            $('.youbehero-donation-wrapper').remove();

                                            var widgetWrapped = '<div class="youbehero-donation-wrapper">' + youbeheroWidgetHtml + '</div>';
                                            var injected = false;

                                            // Inject based on placement - try multiple selectors for compatibility
                                            if (youbeheroPlacement === 'woocommerce_review_order_before_submit') {
                                                if ($('#order_review .place-order').length) {
                                                    $('#order_review .place-order').before(widgetWrapped);
                                                    injected = true;
                                                } else if ($('.woocommerce-checkout-payment .place-order').length) {
                                                    $('.woocommerce-checkout-payment .place-order').before(widgetWrapped);
                                                    injected = true;
                                                } else if ($('#place_order').length) {
                                                    $('#place_order').parent().before(widgetWrapped);
                                                    injected = true;
                                                }
                                            }

                                            if (injected) {
                                                console.log('YouBeHero: Widget injected successfully');
                                                // CSS handles all button styling - no JS manipulation needed
                                                // Reset delete button SVG to default state
                                                let delte_svg_path = $('.delete-button img').attr("src");
                                                let old_svg_path = delte_svg_path.replace("delete-hover.svg", "delete.svg");
                                                $('.delete-button img').attr("src", old_svg_path);

                                                // Clear any loading states from buttons after re-injection
                                                jQuery('.donation-btn').removeClass('loading').find('.button-spinner').remove();
                                                jQuery('.donation-buttons, .donation-amounts').removeClass('disabled');

                                                //Trigger value update on page load if amount is already selected
                                                const selected_donation_amount = jQuery('.donation-btn.radio-button.selected').data('value');
                                                const donationAmountEle = document.getElementById('donation-amount');
                                                if (donationAmountEle) {
                                                donationAmountEle.value = selected_donation_amount;
                                                }

                                                // Verify it's still there after 200ms
                                                setTimeout(function() {
                                                    var stillExists = $('.youbehero-donation-wrapper').length;
                                                    console.log('YouBeHero: Widget still exists:', stillExists > 0);
                                                    if (stillExists === 0) {
                                                        console.warn('YouBeHero: Widget was removed! Re-injecting...');
                                                        injectYoubeheroWidget();
                                                    }
                                                }, 200);

                                                // setTimeout(function() { $('.widget-loader').hide() }, 500);
                                            } else {
                                                console.warn('YouBeHero: Could not find target element for injection');
                                                console.log('Available elements:', {
                                                    'order_review': $('#order_review').length,
                                                    'place-order': $('.place-order').length,
                                                    'place_order': $('#place_order').length,
                                                    'payment': $('#payment').length
                                                });
                                            }
                                        }

                                        // Re-inject after WooCommerce AJAX updates
                                        $(document.body).on('updated_checkout', function() {
                                            console.log('YouBeHero: Checkout updated, re-injecting...');
                                            // Clear loading states before re-injecting to prevent spinner from reappearing
                                            jQuery('.donation-btn').removeClass('loading').find('.button-spinner').remove();
                                            jQuery('.donation-buttons, .donation-amounts').removeClass('disabled');
                                            // // Try multiple times with different delays to catch all updates
                                            setTimeout(function() { injectYoubeheroWidget(); }, 500);
                                        });

                                        // Also try on payment method change
                                        $(document.body).on('payment_method_selected', function() {
                                            console.log('YouBeHero: Payment method changed');
                                        });
                                    });
                                })();
                            </script>
                            <?php
                            $script_added = true;
                        }
                    }, 10);

                    $hooks_added = true;
                }
            }

            // Recursively check nested elements (sections, columns, etc)
            if (!empty($element['elements'])) {
                $this->youbehero_scan_and_add_hooks($element['elements']);
            }
        }
    }

    /**
     * Ensure hooks persist during AJAX order review updates
     * @return void
     */
    public function youbehero_persist_hooks_on_ajax() {

        global $youbehero_widget_settings;

        if ( !empty( $youbehero_widget_settings['enabled'] ) ) {
            $placement_position = $youbehero_widget_settings['position'];

            // Re-add the hook for AJAX requests
            $instance = $this;
            add_action( $placement_position, function() use ($instance) {
                // Only output widget if not scheduled and not ended
                if ($instance->youbehero_should_display_widget()) {
                echo do_shortcode( '[youbehero_donation_form]' );
                }
            }, 10 );
        }

    }


    /**
     * Initialize WooCommerce hooks for WPBakery widgets
     */
    function youbehero_wpbakery_init_woocommerce_hooks() {

        // Only run on frontend
        if (is_admin()) {
            return;
        }

        // Check for WooCommerce
        if (!class_exists('WooCommerce')) {
            return;
        }

        // Run on checkout page OR during AJAX order review update
        $is_checkout = is_checkout();
        $is_ajax_update = defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['wc-ajax']) && $_REQUEST['wc-ajax'] === 'update_order_review';

        if (!$is_checkout && !$is_ajax_update) {
            return;
        }

        // Get the current page ID
        $post_id = get_the_ID();

        // For AJAX requests, try to get the checkout page ID
        if (!$post_id && $is_ajax_update) {
            $checkout_page_id = wc_get_page_id('checkout');
            if ($checkout_page_id) {
                $post_id = $checkout_page_id;
            }
        }

        if (!$post_id) {
            return;
        }

        // Get WPBakery content
        $post_content = get_post_field('post_content', $post_id);

        if (empty($post_content)) {
            return;
        }

        // Parse WPBakery shortcodes to find our widget
        $this->youbehero_wpbakery_scan_and_add_hooks($post_content);
    }

    /**
     * Scan WPBakery content for our widget and add hooks
     */
    function youbehero_wpbakery_scan_and_add_hooks($content) {

        static $hooks_added = false;

        if ($hooks_added) {
            return;
        }

        // Find all instances of our shortcode in the content
        $pattern = get_shortcode_regex(array('youbehero_donation_wpbakery'));

        if (preg_match_all('/' . $pattern . '/s', $content, $matches)) {
            foreach ($matches[0] as $shortcode) {
                // Parse shortcode attributes
                preg_match('/\[youbehero_donation_wpbakery([^\]]*)\]/', $shortcode, $attr_matches);

                if (isset($attr_matches[1])) {
                    $attrs = shortcode_parse_atts($attr_matches[1]);

                    $wc_hook_enabled = isset($attrs['woocommerce_hook_enable']) ? $attrs['woocommerce_hook_enable'] : 'yes';
                    $placement_position = isset($attrs['placement_position']) ? $attrs['placement_position'] : 'woocommerce_after_checkout_billing_form';

                    if ($wc_hook_enabled === 'yes') {

                        // Capture widget HTML
                        ob_start();
                        echo do_shortcode('[youbehero_donation_form]');
                        $captured_widget_html = ob_get_clean();

                        // Add the WooCommerce hook
                        add_action($placement_position, function() use ($placement_position, $captured_widget_html) {
                            static $script_added = false;

                            // Add script inline right after the widget (only once)
                            if (!$script_added) {
                                ?>
                                <script type="text/javascript">
                                    (function() {
                                        if (typeof jQuery === 'undefined') {
                                            console.error('YouBeHero WPBakery: jQuery not loaded!');
                                            return;
                                        }

                                        jQuery(document).ready(function($) {
                                            let youbeheroWidgetHtml = <?php echo json_encode($captured_widget_html); ?>;
                                            var youbeheroPlacement = <?php echo json_encode($placement_position); ?>;

                                            console.log('YouBeHero WPBakery: Script loaded, placement:', youbeheroPlacement);
                                            console.log('YouBeHero WPBakery: Widget HTML length:', youbeheroWidgetHtml.length);

                                            if (!youbeheroWidgetHtml || youbeheroWidgetHtml.length < 10) {
                                                console.error('YouBeHero WPBakery: Widget HTML is empty or too short!');
                                                return;
                                            }

                                            function injectYoubeheroWidget() {
                                                console.log('YouBeHero WPBakery: Injecting widget...');

                                                // Try to get fresh HTML from hidden element if available
                                                var storedWidgetHtml = $('#hidden-donation-html').text();
                                                var decodedStoredWidgetHtml = $('<div/>').html(storedWidgetHtml).html();
                                                if (decodedStoredWidgetHtml || $.trim(decodedStoredWidgetHtml) !== '') {
                                                    youbeheroWidgetHtml = decodedStoredWidgetHtml;
                                                }

                                                // Remove any existing instances first
                                                $('.youbehero-donation-wrapper').remove();

                                                var widgetWrapped = '<div class="youbehero-donation-wrapper">' + youbeheroWidgetHtml + '</div>';
                                                var injected = false;

                                                // Inject based on placement - try multiple selectors for compatibility
                                                if (youbeheroPlacement === 'woocommerce_review_order_before_submit') {
                                                    if ($('#order_review .place-order').length) {
                                                        $('#order_review .place-order').before(widgetWrapped);
                                                        injected = true;
                                                    } else if ($('.woocommerce-checkout-payment .place-order').length) {
                                                        $('.woocommerce-checkout-payment .place-order').before(widgetWrapped);
                                                        injected = true;
                                                    } else if ($('#place_order').length) {
                                                        $('#place_order').parent().before(widgetWrapped);
                                                        injected = true;
                                                    }
                                                } else if (youbeheroPlacement === 'woocommerce_after_checkout_billing_form') {
                                                    if ($('.woocommerce-billing-fields').length) {
                                                        $('.woocommerce-billing-fields').after(widgetWrapped);
                                                        injected = true;
                                                    }
                                                }

                                                if (injected) {
                                                    console.log('YouBeHero WPBakery: Widget injected successfully');
                                                    // CSS handles all button styling - no JS manipulation needed
                                                    // Reset delete button SVG to default state
                                                    let delte_svg_path = $('.delete-button img').attr("src");
                                                    let old_svg_path = delte_svg_path.replace("delete-hover.svg", "delete.svg");
                                                    $('.delete-button img').attr("src", old_svg_path);

                                                    // Clear any loading states from buttons after re-injection
                                                    jQuery('.donation-btn').removeClass('loading').find('.button-spinner').remove();
                                                    jQuery('.donation-buttons, .donation-amounts').removeClass('disabled');

                                                    $('.donation-btn').on('touchstart click', function () {
                                                        this.focus();
                                                    });

                                                    //Trigger value update on page load if amount is already selected
                                                    const selected_donation_amount = jQuery('.donation-btn.radio-button.selected').data('value');
                                                    const donationAmountEle = document.getElementById('donation-amount');
                                                    if (donationAmountEle) {
                                                    donationAmountEle.value = selected_donation_amount;
                                                    }

                                                    // Verify it's still there after 200ms
                                                    setTimeout(function() {
                                                        var stillExists = $('.youbehero-donation-wrapper').length;
                                                        console.log('YouBeHero WPBakery: Widget still exists:', stillExists > 0);

                                                        if (stillExists === 0) {
                                                            console.warn('YouBeHero WPBakery: Widget was removed! Re-injecting...');
                                                            injectYoubeheroWidget();
                                                        }
                                                    }, 200);

                                                    // setTimeout(function() { $('.widget-loader').hide(); }, 500);
                                                } else {
                                                    console.warn('YouBeHero WPBakery: Could not find target element for injection');
                                                    console.log('Available elements:', {
                                                        'order_review': $('#order_review').length,
                                                        'place-order': $('.place-order').length,
                                                        'place_order': $('#place_order').length,
                                                        'payment': $('#payment').length
                                                    });
                                                }
                                            }

                                            // Re-inject after WooCommerce AJAX updates
                                            $(document.body).on('updated_checkout', function() {
                                                console.log('YouBeHero WPBakery: Checkout updated, re-injecting...');
                                                // Clear loading states before re-injecting to prevent spinner from reappearing
                                                jQuery('.donation-btn').removeClass('loading').find('.button-spinner').remove();
                                                jQuery('.donation-buttons, .donation-amounts').removeClass('disabled');
                                                setTimeout(function() { injectYoubeheroWidget(); }, 500);

                                            });

                                            // Also try on payment method change
                                            $(document.body).on('payment_method_selected', function() {
                                                console.log('YouBeHero WPBakery: Payment method changed');
                                            });
                                        });
                                    })();
                                </script>
                                <?php
                                $script_added = true;
                            }
                        }, 10);

                        $hooks_added = true;
                        break; // Only process first widget instance
                    }
                }
            }
        }
    }
}
