<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://youbehero.com
 * @since             1.0.1
 * @package           You_Be_Hero
 *
 * @wordpress-plugin
 * Plugin Name:       YouBeHero
 * Plugin URI:        https://dev.youbehero.com/gr/signup-eshop
 * Description:       Add Donation to Cart by YouBeHero is a powerful WordPress plugin that adds a donation widget to your WooCommerce checkout, transforming every purchase into an opportunity for social impact.
 * Version:           1.2.0
 * Author:            YouBeHero
 * Author URI:        https://youbehero.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       youbehero
 * Domain Path:       /languages
 * Requires at least: 5.7
 * Tested up to:      6.9
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

// Plugin directory path.
define('YBHD_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Plugin URL.
define('YBHD_PLUGIN_URL', plugin_dir_url(__FILE__));

// Directories for organized structure.
define('YBHD_PLUGIN_ADMIN_DIR', YBHD_PLUGIN_DIR . 'admin/');
define('YBHD_PLUGIN_PUBLIC_DIR', YBHD_PLUGIN_DIR . 'public/');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-you-be-hero-activator.php
 */
function ybhd_activate_youbehero_donation() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-you-be-hero-activator.php';
	You_Be_Hero_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-you-be-hero-deactivator.php
 */
function ybhd_deactivate_youbehero_donation() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-you-be-hero-deactivator.php';
	You_Be_Hero_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ybhd_activate_youbehero_donation' );
register_deactivation_hook( __FILE__, 'ybhd_deactivate_youbehero_donation' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-you-be-hero.php';

/**
 * Add a Settings link on the Plugins page row for this plugin.
 */
function youbehero_add_settings_link( $links ) {
	$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=ybhd-settings' ) ) . '">' . esc_html__( 'Settings', 'youbehero' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'youbehero_add_settings_link' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function ybhd_run_youbehero_donation() {

	$plugin = new You_Be_Hero();
	$plugin->run();

}
ybhd_run_youbehero_donation();
