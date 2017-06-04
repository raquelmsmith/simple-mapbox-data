<?php

namespace Mapbox_Data_for_WordPress;

use Mapbox_Data_for_WordPress;

class Content_Model {

	/**
	* Register a Map Data post type.
	*/

	public static function mapbox_data_init_register_post_type() {
		$labels = array(
			'name'					=> _x( 'Map Data', 'post type general name', 'mapbox-data-for-wordpress' ),
			'singular_name'			=> _x( 'Map Data Point', 'post type singular name', 'mapbox-data-for-wordpress' ),
			'menu_name'				=> _x( 'Map Data', 'admin menu', 'mapbox-data-for-wordpress' ),
			'name_admin_bar'		=> _x( 'Map Data Point', 'add new on admin bar', 'mapbox-data-for-wordpress' ),
			'add_new'				=> _x( 'Add New', 'data point', 'mapbox-data-for-wordpress' ),
			'add_new_item'			=> __( 'Add New Data Point', 'mapbox-data-for-wordpress' ),
			'new_item'				=> __( 'New Data Point', 'mapbox-data-for-wordpress' ),
			'edit_item'				=> __( 'Edit Data Point', 'mapbox-data-for-wordpress' ),
			'view_item'				=> __( 'View Data Point', 'mapbox-data-for-wordpress' ),
			'all_items'				=> __( 'All Map Data Points', 'mapbox-data-for-wordpress' ),
			'search_items'			=> __( 'Search Map Data Points', 'mapbox-data-for-wordpress' ),
			'parent_item_colon'		=> __( 'Parent Map Data Points:', 'mapbox-data-for-wordpress' ),
			'not_found'				=> __( 'No Map Data Points found.', 'mapbox-data-for-wordpress' ),
			'not_found_in_trash'	=> __( 'No Map Data Points found in Trash.', 'mapbox-data-for-wordpress' )
		);
		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'publicly_queryable'	=> true,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'query_var'				=> true,
			'rewrite'				=> array( 'slug' => 'map-data' ),
			'capability_type'		=> 'post',
			'has_archive'			=> true,
			'Hierarchical'			=> false,
			'menu_icon'				=> 'dashicons-location-alt',
			'menu_position'			=> 5,
			'show_in_rest'			=> true,
			'taxonomies'			=> array('category', 'post_tag'),
			'supports'				=> array( 
				'title', 
				'editor',
				'author',
				'thumbnail',  
				'revisions' )
		);
		register_post_type( 'map_data_point', $args );
	}

}