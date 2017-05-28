<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              raquelmsmith.com
 * @since             1.0.0
 * @package           Mapbox_Data_For_Wordpress
 *
 * @wordpress-plugin
 * Plugin Name:       Mapbox Data for WordPress
 * Plugin URI:        raquelmsmith.com/mapbox-data-for-wordpress
 * Description:       Manage your Mapbox data from right within your WordPress installation.
 * Version:           1.0.0
 * Author:            Raquel Smith
 * Author URI:        raquelmsmith.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mapbox-data-for-wordpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mapbox-data-for-wordpress-activator.php
 */
function activate_mapbox_data_for_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mapbox-data-for-wordpress-activator.php';
	Mapbox_Data_For_Wordpress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mapbox-data-for-wordpress-deactivator.php
 */
function deactivate_mapbox_data_for_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mapbox-data-for-wordpress-deactivator.php';
	Mapbox_Data_For_Wordpress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mapbox_data_for_wordpress' );
register_deactivation_hook( __FILE__, 'deactivate_mapbox_data_for_wordpress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mapbox-data-for-wordpress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mapbox_data_for_wordpress() {

	$plugin = new Mapbox_Data_For_Wordpress();
	$plugin->run();

}
run_mapbox_data_for_wordpress();
