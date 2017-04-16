<?php
/*
	Plugin Name: WP Mapbox
	Plugin URI: TBD
	Description: A plugin to manage Mapbox data in a WordPress install
	Version: 0.0.0
	Author: Raquel M Smith
	Author URI: http://raquelmsmith.com
	License: GPL2
*/

add_action( 'init', 'wp_mapbox_init' );

/**
	* Register a Map Data post type.
*/

function wp_mapbox_init() {
	$labels = array(
		'name'					=> _x( 'Map Data', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'			=> _x( 'Map Data Point', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'				=> _x( 'Map Data', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'		=> _x( 'Map Data Point', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'				=> _x( 'Add New', 'data point', 'your-plugin-textdomain' ),
		'add_new_item'			=> __( 'Add New Data Point', 'your-plugin-textdomain' ),
		'new_item'				=> __( 'New Data Point', 'your-plugin-textdomain' ),
		'edit_item'				=> __( 'Edit Data Point', 'your-plugin-textdomain' ),
		'view_item'				=> __( 'View Data Point', 'your-plugin-textdomain' ),
		'all_items'				=> __( 'All Map Data Points', 'your-plugin-textdomain' ),
		'search_items'			=> __( 'Search Map Data Points', 'your-plugin-textdomain' ),
		'parent_item_colon'		=> __( 'Parent Map Data Points:', 'your-plugin-textdomain' ),
		'not_found'				=> __( 'No Map Data Points found.', 'your-plugin-textdomain' ),
		'not_found_in_trash'	=> __( 'No Map Data Points found in Trash.', 'your-plugin-textdomain' )
	);
	$args = array(
		'labels'				=> $labels,
		'public'				=> true,
		'publicly_queryable'	=> true,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'query_var'				=> true,
		'rewrite'				=> array( 'slug' => 'map' ),
		'capability_type'		=> 'post',
		'has_archive'			=> true,
		'Hierarchical'			=> false,
		'menu_position'			=> 5,
		'supports'				=> array( 
			'title', 
			'editor', 
			'author', 
			'thumbnail', 
			'excerpt', 
			'comments', 
			'revisions' )
	);
	register_post_type( 'map-data-point', $args );
}
