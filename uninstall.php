<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Simple_Mapbox_Data
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$option_name = 'mapbox_data';
 
delete_option( $option_name );