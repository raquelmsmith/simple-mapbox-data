<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/includes
 * @author     Raquel Smith <raquel@raquelmsmith.com>
 */
class Mapbox_Data_For_Wordpress_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mapbox-data-for-wordpress',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
