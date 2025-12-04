<?php

/**
 * Fired during plugin activation
 *
 * @link       https://youbehero.com
 * @since      1.0.1
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/includes
 * @author     YouBeHero <info@youbehero.com>
 */
class You_Be_Hero_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.1
	 */
	public static function activate() {
		// Schedule the cron job to refresh dashboard JSON hourly
		if ( ! wp_next_scheduled( 'youbehero_refresh_dashboard_json' ) ) {
			wp_schedule_event( time(), 'hourly', 'youbehero_refresh_dashboard_json' );
		}
	}

}
