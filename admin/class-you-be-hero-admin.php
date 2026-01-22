<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://youbehero.com
 * @since      1.1.0
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
 * @author     YouBeHero <info@youbehero.com>
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

        if ( $hook_suffix == 'toplevel_page_youbehero-settings' )  {

            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/you-be-hero-admin.css', array(), $this->version, 'all' );

        }

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.1
	 * @param string $hook_suffix The current admin page hook suffix.
	 */
	public function enqueue_scripts( $hook_suffix ) {

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
    public function ybhd_add_admin_menu() {

        $icon_svg = '<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_4438_167)"><path d="M9.06969 0.925293H6.73779V3.18994H9.06969V0.925293Z" fill="#A7AAAD"/><path d="M3.26281 0.925293H0.930908V3.18989H3.26281V0.925293Z" fill="#A7AAAD"/><path d="M6.73774 4.31104V4.62491C6.73774 6.01512 5.99784 6.84475 4.98884 6.84475C3.84531 6.84475 3.26233 5.83573 3.26233 4.62491V4.31104H0.93042V4.78191C0.93042 7.51742 2.56724 9.01968 4.98884 9.01968C7.61222 9.01968 9.06967 7.33803 9.06967 4.78191V4.31104H6.73774Z" fill="#A7AAAD"/></g><defs><clipPath id="clip0_4438_167"><rect width="10" height="10" fill="white"/></clipPath></defs></svg>';

        $icon_data = 'data:image/svg+xml;base64,' . base64_encode($icon_svg);

        add_menu_page(
            'YouBeHero API Settings',
            'YouBeHero',
            'manage_options',
            'youbehero-settings',
            array( $this, 'ybhd_settings_page' ),
            $icon_data,
            56
        );

    }

    /**
     * @return void
     */
    public function ybhd_settings_page() {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'youbehero' ) );
        }

        $ybhd_token = get_option( 'ybhd_token' );

        // Default view: API settings page
        $template = 'admin/partials/you-be-hero-api-settings.php';

        if ( ! empty( $ybhd_token ) ) {
            // Fetch and update store info
            $this->ybhd_fetch_store_info( $ybhd_token );

            $data = get_option( 'ybhd_dashboard_json' );
            $data = ! empty( $data ) ? json_decode( $data, true ) : [];

            if ( isset( $data['data'] ) && ! empty( $data['data'] ) ) {
                $data     = $data['data'];
                $template = 'admin/partials/you-be-hero-dashboard.php';
            }
        }

        require_once plugin_dir_path( dirname( __FILE__ ) ) . $template;

    }


    /**
     * @return void
     */
    public function ybhd_submit_apikey() {

        check_admin_referer( 'ybhd_submit_apikey', 'ybhd_submit_apikey_nonce' );

        $token = isset( $_POST['ybhd_token'] )
            ? sanitize_text_field( wp_unslash( $_POST['ybhd_token'] ) )
            : '';

        update_option( 'ybhd_token', $token );

        $data = $this->ybhd_fetch_store_info( $token );

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
            $this->version,
            true
        );

    }

    /**
     * @return void
     */
    public function ybh_donation_checkout_block_modifications() {

        wp_enqueue_script(
            $this->plugin_name.'-checkout-widget',
            YBHD_PLUGIN_URL.'admin/js/checkout-widget.js',
            array('wp-blocks', 'wp-edit-post', 'wp-hooks'),
            $this->version,
            false
        );

    }

    /**
     * @param $order_id
     * @return void
     */
    public function woocommerce_admin_order_totals_after_discount_fun( $order_id ) {

        $order = wc_get_order( $order_id );
        
        // Check if order exists
        if ( ! $order ) {
            return;
        }
        
        $other_fees_total = 0;

        foreach ( $order->get_fees() as $fee ) {
            $fee_total = ( float ) $fee->get_total(); // Ensure proper numeric type

            // Skip YouBeHero donation fees (identified by stored meta)
            if ( method_exists( $fee, 'get_meta' ) && $fee->get_meta( '_donation_org_id' ) ) {
                continue;
            }

            $other_fees_total += $fee_total;
        }

        if ($other_fees_total > 0) {
            echo '<tr>';
            echo '<td class="label">' . esc_html( __( 'Other Fees:', 'youbehero' ) ) . '</td>';
            echo '<td width="1%"></td>';
            echo '<td class="total"><strong>' . wp_kses_post( wc_price( $other_fees_total ) ) . '</strong></td>';
            echo '</tr>';
        }

    }

    /**
     * @return false|void
     */
    public function ybh_update_dashboard_json() {

        try {
            $response = wp_remote_get( 'https://youbehero.com/api/shop-details?api_token='.get_option( 'ybhd_token' ) );

            if ( is_wp_error( $response ) ) {
                return false;
            }

            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body, true );

            update_option( 'ybhd_dashboard_json', $body );

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
     * Cron-safe refresh of dashboard JSON.
     *
     * This is used by the `youbehero_refresh_dashboard_json` WP-Cron event.
     * It should NOT echo or send JSON responses.
     *
     * @return void
     */
    public function youbehero_refresh_dashboard_json() {

        $api_key = get_option( 'ybhd_token' );
        if ( empty( $api_key ) ) {
            return;
        }

        $response = wp_remote_get( 'https://youbehero.com/api/shop-details?api_token=' . $api_key );

        if ( is_wp_error( $response ) ) {
            return;
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( json_last_error() !== JSON_ERROR_NONE || ! isset( $data['data'] ) ) {
            return;
        }

        // Cache raw body so existing consumers that decode it continue to work.
        update_option( 'ybhd_dashboard_json', $body );
    }

    /**
     * @param $token
     * @return false|mixed
     */
    public function ybhd_fetch_store_info( $token = '' ) {

        $api_key = empty( $token ) ? get_option( 'ybhd_token' ) : $token;
        $response = wp_remote_get( 'https://youbehero.com/api/shop-details?api_token='.$api_key );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $body = wp_remote_retrieve_body( $response );

        update_option( 'ybhd_dashboard_json', $body );

        return json_decode( $body, true );

    }

    /**
     * Ensure cron is scheduled (safety check for existing installations)
     * This runs on admin_init to catch cases where the plugin was already active
     * when the cron feature was added.
     *
     * @return void
     */
    public function ensure_cron_scheduled() {
        if ( ! wp_next_scheduled( 'youbehero_refresh_dashboard_json' ) ) {
            wp_schedule_event( time(), 'hourly', 'youbehero_refresh_dashboard_json' );
        }
    }

    /**
     * @return void
     */
    public function ybhd_logout() {

        update_option( 'ybhd_token', '' );
        wp_send_json( ['status' => 'success' ] );

    }


    /**
     * Get checkout page ID
     * 
     * @return int Checkout page ID or 0 if not found
     */
    private static function get_checkout_page_id() {
        return function_exists('wc_get_page_id') ? wc_get_page_id('checkout') : 0;
    }

    /**
     * Get page content (cached per request)
     * 
     * @param int $page_id Page ID
     * @return string|false Page content or false
     */
    private static function get_page_content($page_id) {
        static $content_cache = [];
        if (!isset($content_cache[$page_id])) {
            $content_cache[$page_id] = get_post_field('post_content', $page_id);
        }
        return $content_cache[$page_id];
    }

    /**
     * Check if WPBakery plugin is active
     * 
     * @return bool True if WPBakery is active
     */
    private static function is_wpbakery_active() {
        return class_exists('WPBakeryShortCode') || defined('WPB_VC_VERSION');
    }

    /**
     * Check if page uses Elementor
     * 
     * @param int $page_id Page ID
     * @return bool True if page uses Elementor
     */
    private static function is_elementor_page($page_id) {
        if (!class_exists('\Elementor\Plugin')) {
            return false;
        }
        
        // Check post meta first
        if (get_post_meta($page_id, '_elementor_edit_mode', true) === 'builder') {
            $elementor_data = get_post_meta($page_id, '_elementor_data', true);
            if (!empty($elementor_data)) {
                return true;
            }
        }
        
        // Check via Elementor API
        try {
            $elementor_instance = \Elementor\Plugin::$instance;
            if ($elementor_instance && isset($elementor_instance->documents)) {
                $document = $elementor_instance->documents->get($page_id);
                if ($document && !empty($document->get_elements_data())) {
                    return true;
                }
            }
        } catch (Exception $e) {
            // Silent fail
        }
        
        return false;
    }

    /**
     * Check if page has WPBakery meta indicators (most reliable)
     * 
     * @param int $page_id Page ID
     * @return bool True if WPBakery meta exists
     */
    private static function has_wpbakery_meta($page_id) {
        return !empty(get_post_meta($page_id, '_wpb_shortcodes_custom_css', true)) ||
               !empty(get_post_meta($page_id, '_wpb_post_custom_css', true));
    }

    /**
     * Check if content has WPBakery shortcodes
     * 
     * @param string $content Page content
     * @return bool True if WPBakery shortcodes found
     */
    private static function content_has_wpbakery_shortcodes($content) {
        if (!$content) {
            return false;
        }
        
        $vc_patterns = ['[vc_row', '[vc_column', '[vc_', 'youbehero_donation_wpbakery'];
        foreach ($vc_patterns as $pattern) {
            if (strpos($content, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if page has Gutenberg blocks
     * 
     * @param int $page_id Page ID
     * @return bool True if page has Gutenberg blocks
     */
    private static function has_gutenberg_blocks($page_id) {
        $content = self::get_page_content($page_id);
        if (!$content) {
            return false;
        }
        
        return strpos($content, '<!-- wp:') !== false ||
               (function_exists('has_blocks') && has_blocks($page_id));
    }

    /**
     * Detect which editor is used on the checkout page
     * Preserves exact original logic order for 100% accuracy
     * 
     * @return string Editor name: 'Elementor', 'WPBakery', or 'Gutenberg'
     */
    public static function detect_checkout_editor() {
        $checkout_page_id = self::get_checkout_page_id();
        
        if (!$checkout_page_id) {
            return 'Unknown';
        }
        
        // 1. Check for Elementor (most reliable method)
        if (self::is_elementor_page($checkout_page_id)) {
            return 'Elementor';
        }
        
        // 2. Check for WPBakery (check multiple indicators for reliability)
        // Check post meta FIRST (most reliable indicator)
        if (self::has_wpbakery_meta($checkout_page_id)) {
            return 'WPBakery';
        }
        
        // Then check if WPBakery is active and page has WPBakery shortcodes
        $wpbakery_active = self::is_wpbakery_active();
        if ($wpbakery_active) {
            $page_content = self::get_page_content($checkout_page_id);
            if (self::content_has_wpbakery_shortcodes($page_content)) {
                return 'WPBakery';
            }
        }
        
        // 3. Check for Gutenberg blocks (only if WPBakery not detected)
        if (self::has_gutenberg_blocks($checkout_page_id)) {
            // Double-check: if WPBakery is active, prioritize it over Gutenberg
            // This handles edge case where page has both Gutenberg blocks AND WPBakery shortcodes
            if ($wpbakery_active) {
                $page_content = self::get_page_content($checkout_page_id);
                if (strpos($page_content, '[vc_') !== false) {
                    return 'WPBakery';
                }
            }
            return 'Gutenberg';
        }
        
        // 4. Default fallback - if WPBakery is active and no Gutenberg blocks, assume WPBakery
        if ($wpbakery_active) {
            return 'WPBakery';
        }
        
        return 'Gutenberg'; // WordPress default
    }

    /**
     * Check if widget is installed on checkout page
     * 
     * @param int $page_id Page ID
     * @param string $editor Editor type
     * @return bool True if widget is installed
     */
    private static function is_widget_installed($page_id, $editor) {
        $content = self::get_page_content($page_id);
        
        // Check for shortcode using regex (works in all editors, including WPBakery raw HTML)
        // Simple regex pattern that finds the shortcode anywhere in content
        $has_shortcode = false;
        if ($content) {
            $has_shortcode = preg_match('/\[youbehero_donation_form[^\]]*\]/', $content) === 1;
        }
        
        switch ($editor) {
            case 'Elementor':
                try {
                    $elementor_instance = \Elementor\Plugin::$instance;
                    if ($elementor_instance && isset($elementor_instance->documents)) {
                        $document = $elementor_instance->documents->get($page_id);
                        if ($document) {
                            $elements_data = $document->get_elements_data();
                            $has_elementor_widget = !empty($elements_data) && 
                                                   self::get_elementor_widget_data($elements_data) !== false;
                            return $has_elementor_widget || $has_shortcode;
                        }
                    }
                } catch (Exception $e) {
                    // Silent fail
                }
                return $has_shortcode;
                
            case 'WPBakery':
                $has_wpbakery_widget = $content && strpos($content, 'youbehero_donation_wpbakery') !== false;
                return $has_wpbakery_widget || $has_shortcode;
                
            case 'Gutenberg':
                if (!$content) {
                    return false;
                }
                $has_gutenberg_block = strpos($content, 'donation-widget/ybh-chekcout-donation-block') !== false;
                return $has_gutenberg_block || $has_shortcode;
                
            default:
                return $has_shortcode;
        }
    }

    /**
     * Check if widget is installed and if checkout page exists
     * 
     * @return array Minimal diagnostic data
     */
    public static function get_checkout_widget_diagnostics() {
        $checkout_page_id = self::get_checkout_page_id();
        $editor = self::detect_checkout_editor();
        
        return [
            'checkout_page_id' => $checkout_page_id,
            'checkout_page_exists' => $checkout_page_id > 0,
            'widget_already_installed' => $checkout_page_id > 0 ? 
                self::is_widget_installed($checkout_page_id, $editor) : false
        ];
    }

    /**
     * Recursively check if Elementor widget exists and get its data
     * 
     * @param array $elements Elementor elements data
     * @return array|false Widget element data if found, false otherwise
     */
    private static function get_elementor_widget_data($elements) {
        if (!is_array($elements)) {
            return false;
        }
        
        foreach ($elements as $element) {
            if (isset($element['widgetType']) && $element['widgetType'] === 'youbehero_donation_widget_v2') {
                return $element;
            }
            
            if (isset($element['elements']) && is_array($element['elements'])) {
                $result = self::get_elementor_widget_data($element['elements']);
                if ($result !== false) {
                    return $result;
                }
            }
        }
        
        return false;
    }

    /**
     * Find Gutenberg block position in the block list
     * 
     * @param array $blocks Parsed Gutenberg blocks
     * @param string $block_name Block name to find (e.g., 'donation-widget/ybh-chekcout-donation-block')
     * @return array|false Position info with index, total, before, after blocks, or false if not found
     */
    private static function find_gutenberg_block_position($blocks, $block_name) {
        if (!is_array($blocks) || empty($blocks)) {
            return false;
        }
        
        // Flatten blocks (including inner blocks) to get a flat list
        $flat_blocks = self::flatten_gutenberg_blocks($blocks);
        $total_blocks = count($flat_blocks);
        
        // Find the block
        foreach ($flat_blocks as $index => $block) {
            if (isset($block['blockName']) && $block['blockName'] === $block_name) {
                $result = [
                    'index' => $index,
                    'total' => $total_blocks,
                    'before' => '',
                    'after' => ''
                ];
                
                // Get block before (if exists)
                if ($index > 0 && isset($flat_blocks[$index - 1])) {
                    $before_block = $flat_blocks[$index - 1];
                    $result['before'] = self::get_block_display_name($before_block);
                }
                
                // Get block after (if exists)
                if ($index < $total_blocks - 1 && isset($flat_blocks[$index + 1])) {
                    $after_block = $flat_blocks[$index + 1];
                    $result['after'] = self::get_block_display_name($after_block);
                }
                
                return $result;
            }
        }
        
        return false;
    }

    /**
     * Flatten Gutenberg blocks including inner blocks
     * 
     * @param array $blocks Blocks to flatten
     * @return array Flattened array of blocks
     */
    private static function flatten_gutenberg_blocks($blocks) {
        $flat = [];
        
        foreach ($blocks as $block) {
            // Skip empty blocks (spacers, etc.)
            if (empty($block['blockName']) && empty($block['innerBlocks'])) {
                continue;
            }
            
            // Add the block itself if it has a name
            if (!empty($block['blockName'])) {
                $flat[] = $block;
            }
            
            // Recursively add inner blocks
            if (!empty($block['innerBlocks']) && is_array($block['innerBlocks'])) {
                $inner_flat = self::flatten_gutenberg_blocks($block['innerBlocks']);
                $flat = array_merge($flat, $inner_flat);
            }
        }
        
        return $flat;
    }

    /**
     * Find donation block in parsed blocks array
     * 
     * @param array $blocks Parsed blocks
     * @param string $block_name Block name to find
     * @return array|false Block data if found, false otherwise
     */
    private static function find_donation_block_in_parsed($blocks, $block_name) {
        if (!is_array($blocks)) {
            return false;
        }
        
        foreach ($blocks as $block) {
            if (isset($block['blockName']) && $block['blockName'] === $block_name) {
                return $block;
            }
            
            // Check inner blocks
            if (!empty($block['innerBlocks']) && is_array($block['innerBlocks'])) {
                $found = self::find_donation_block_in_parsed($block['innerBlocks'], $block_name);
                if ($found !== false) {
                    return $found;
                }
            }
        }
        
        return false;
    }

    /**
     * Get a readable display name for a Gutenberg block
     * 
     * @param array $block Block data
     * @return string Display name
     */
    private static function get_block_display_name($block) {
        if (empty($block['blockName'])) {
            return 'Unknown block';
        }
        
        $block_name = $block['blockName'];
        
        // Remove namespace for cleaner display
        $name_parts = explode('/', $block_name);
        $short_name = end($name_parts);
        
        // Common block names mapping
        $block_labels = [
            'woocommerce/checkout' => 'WooCommerce Checkout',
            'woocommerce/checkout-fields-block' => 'Checkout Fields',
            'woocommerce/checkout-totals-block' => 'Checkout Totals',
            'core/paragraph' => 'Paragraph',
            'core/heading' => 'Heading',
            'core/image' => 'Image',
            'core/columns' => 'Columns',
            'core/column' => 'Column',
            'core/group' => 'Group',
            'core/spacer' => 'Spacer',
            'donation-widget/ybh-chekcout-donation-block' => 'YouBeHero Donation Widget',
        ];
        
        if (isset($block_labels[$block_name])) {
            return $block_labels[$block_name];
        }
        
        // Return formatted name
        return ucwords(str_replace(['-', '_'], ' ', $short_name));
    }

    /**
     * Get installation guidelines for the detected editor
     * 
     * @return array Guidelines with steps and editor link
     */
    public static function get_installation_guidelines() {
        $checkout_page_id = function_exists('wc_get_page_id') ? wc_get_page_id('checkout') : 0;
        $editor = self::detect_checkout_editor();
        
        $guidelines = [
            'editor' => $editor,
            'checkout_page_id' => $checkout_page_id,
            'steps' => [],
            'editor_link' => '',
            'editor_link_text' => ''
        ];
        
        if (!$checkout_page_id) {
            return $guidelines;
        }
        
        // Generate editor-specific link
        switch ($editor) {
            case 'Elementor':
                $guidelines['editor_link'] = admin_url('post.php?post=' . $checkout_page_id . '&action=elementor');
                $guidelines['editor_link_text'] = __('Edit Checkout Page', 'youbehero');
                $guidelines['steps'] = [
                    __('Click the "Edit Checkout Page" button above to open the checkout page in Elementor', 'youbehero'),
                    __('In the Elementor panel on the left, search for "YouBeHero" in the widget search box', 'youbehero'),
                    __('Click on "YouBeHero Donation Widget" and it will be placed at the end of the page', 'youbehero'),
                    __('Click the "Publish" button to save your changes', 'youbehero'),
                    __('You\'re ready!', 'youbehero'),
                ];
                $guidelines['additional_info'] = __('Additionally: From the widget settings panel (select widget and Advanced), in the "Placement" menu you can change the position.', 'youbehero');
                break;
                
            case 'WPBakery':
                $post_type = get_post_type($checkout_page_id);
                $guidelines['editor_link'] = admin_url('post.php?vc_action=vc_inline&post_id=' . $checkout_page_id . '&post_type=' . $post_type);
                $guidelines['editor_link_text'] = __('Edit Checkout Page', 'youbehero');
                $guidelines['steps'] = [
                    __('Click the "Edit Checkout Page" button above to open the checkout page in WPBakery', 'youbehero'),
                    __('Click the "+" (Add new element top left) button in the WPBakery editor', 'youbehero'),
                    __('Search for "YouBeHero" in the search box', 'youbehero'),
                    __('Click on "YouBeHero Donation Widget" to add it to the page', 'youbehero'),
                    __('Click "Update" to save your changes', 'youbehero'),
                    __('You\'re ready!', 'youbehero'),
                ];
                $guidelines['additional_info'] = __('Additionally: From the widget settings panel (select widget / edit pencil), in the "Placement Position" menu you can change the position.', 'youbehero');
                break;
                
            case 'Gutenberg':
            default:
                $guidelines['editor_link'] = admin_url('post.php?post=' . $checkout_page_id . '&action=edit');
                $guidelines['editor_link_text'] = __('Edit Checkout Page', 'youbehero');
                $guidelines['steps'] = [
                    __('Click the "Edit Checkout Page" button above to open the checkout page in the block editor', 'youbehero'),
                    __('Click the "+" (Add Block) button or press "/" to open the block inserter', 'youbehero'),
                    __('Search for "YouBeHero" in the block search', 'youbehero'),
                    __('Click on "YouBeHero Checkout form" to insert it into the page', 'youbehero'),
                    __('Click the "List View" button (three horizontal lines icon) in the toolbar to open the block list view', 'youbehero'),
                    __('In the list view, expand "Checkout" and "Checkout Fields" to see inner blocks', 'youbehero'),
                    __('Find the "Terms and Conditions" section', 'youbehero'),
                    __('Drag the "YouBeHero Checkout form" block right above it', 'youbehero'),
                    __('Click "Save" to save your changes', 'youbehero'),
                    __('You\'re ready!', 'youbehero'),
                ];
                break;
        }
        
        return $guidelines;
    }

}
