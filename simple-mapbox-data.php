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
 * @package           simple_mapbox_data
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Mapbox Data
 * Plugin URI:        raquelmsmith.com/simple-mapbox-data
 * Description:       Manage your Mapbox data from right within your WordPress installation.
 * Version:           1.0.0
 * Author:            Raquel Smith
 * Author URI:        raquelmsmith.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-mapbox-data
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-mapbox-data-activator.php
 */
function activate_simple_mapbox_data() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-mapbox-data-activator.php';
	simple_mapbox_data_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-mapbox-data-deactivator.php
 */
function deactivate_simple_mapbox_data() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-mapbox-data-deactivator.php';
	simple_mapbox_data_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_mapbox_data' );
register_deactivation_hook( __FILE__, 'deactivate_simple_mapbox_data' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-mapbox-data.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_mapbox_data() {

	$plugin = new Simple_Mapbox_Data();
	$plugin->run();

}
run_simple_mapbox_data();
