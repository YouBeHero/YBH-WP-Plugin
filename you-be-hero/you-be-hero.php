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
 * Plugin URI:        https://youbehero.com
 * Description:       YouBeHero is a powerful WordPress plugin that seamlessly integrates with WooCommerce, allowing store owners to enable a donation system at checkout and product pages. Customers can contribute to nonprofit organizations directly during their shopping experience.
With dynamic widgets, shortcodes, and API-powered configurations, YouBeHero ensures a customizable and smooth donation process.
 * Version:           1.0.1
 * Author:            Vasilis Kolip
 * Author URI:        https://youbehero.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       youbehero
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Tested up to:      6.8
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Plugin directory path.
define( 'YBH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Plugin URL.
define( 'YBH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Directories for organized structure.
define( 'YBH_PLUGIN_ADMIN_DIR', YBH_PLUGIN_DIR . 'admin/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-you-be-hero-activator.php
 */
function activate_youbehero_donation() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-you-be-hero-activator.php';
    YouBeHero_Donation_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-you-be-hero-deactivator.php
 */
function deactivate_youbehero_donation() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-you-be-hero-deactivator.php';
    YouBeHero_Donation_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_youbehero_donation' );
register_deactivation_hook( __FILE__, 'deactivate_youbehero_donation' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-you-be-hero.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_youbehero_donation() {

	$plugin = new YouBeHero_Donation();
	$plugin->run();

}
run_youbehero_donation();
