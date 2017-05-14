<?php
/*
	Plugin Name: Mapbox Data for WordPress
	Plugin URI: TBD
	Description: A plugin to manage Mapbox data in a WordPress install
	Version: 0.0.1
	Author: Raquel M Smith
	Author URI: http://raquelmsmith.com
	License: GPL2
*/

add_action( 'init', 'mapbox_data_init' );

/**
	* Assign Global Variables.
	*
*/

$plugin_url = WP_PLUGIN_URL . '/mapbox-data-for-wordpress';
$options = array();
$number_fields = 3;

/**
	* Register a Map Data post type.
*/

function mapbox_data_init() {
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

/**
 * Add meta boxes for Year and Location
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function map_data_point_add_meta_boxes( $post ){
	add_meta_box( 
		'map_data_point_meta_box', 
		'Mapbox Custom Data', 
		'map_data_point_build_meta_box', 
		'map_data_point', 
		'normal', 
		'high'
	);
}
add_action( 'add_meta_boxes_map_data_point', 'map_data_point_add_meta_boxes' );

function create_custom_meta_fields_array() {
	// Field Array Example
	$prefix = 'mapbox_custom_data_';
	$custom_meta_fields = array(
	    array(
	        'label' => 'Longitude',
	        'desc'  => 'Enter the longitudinal coordinate here',
	        'id'    => $prefix . 'longitude',
	        'type'  => 'text'
	    ),
	    array(
	        'label' => 'Latitude',
	        'desc'  => 'Enter the latitudinal coordinate here',
	        'id'    => $prefix . 'latitude',
	        'type'  => 'text'
	    ),
	); 

	$updated_custom_fields_options = get_option( 'mapbox_data' );
	$updated_custom_fields = $updated_custom_fields_options['custom_fields'];

	foreach ($updated_custom_fields as $field) {
		$custom_meta_fields[] = array(
			'label' => $field['name'],
			'id'	=> $prefix . strtolower( $field['name'] ),
			'type'	=> $field['type'],
			'json'	=> $field['json']
		);
	}
	return $custom_meta_fields;
}


/**
 * Build meta box to hold custom fields
 *
 * @param post $post The post object
 */

function map_data_point_build_meta_box( $post ) {
	global $post;

	$custom_meta_fields = create_custom_meta_fields_array();

	// Use nonce for verification
	echo '<input type="hidden" name="map_data_point_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, '_' . strtolower($field['id']), true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // case items will go here
                    // text
					case 'text':
					    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
					        <br /><span class="description">'.$field['desc'].'</span>';
						break;
					// textarea
					case 'textarea':
					    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
					        <br /><span class="description">'.$field['desc'].'</span>';
						break;
					// checkbox
					case 'checkbox':
					    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
					        <label for="'.$field['id'].'">'.$field['desc'].'</label>';
						break;
					// select
					case 'select':
					    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
					    foreach ($field['options'] as $option) {
					        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
					    }
					    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
						break;
                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 */
function map_data_point_save_meta_boxes_data( $post_id ){
	$custom_meta_fields = create_custom_meta_fields_array();

	if ( !isset( $_POST['map_data_point_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['map_data_point_meta_box_nonce'], basename( __FILE__ ) ) ){
		return $post_id;
	}
	// check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return $post_id;
	}
	// loop through fields and save the data
    foreach ($custom_meta_fields as $field) {
    	$fieldID = strtolower($field['id']);
        $old = get_post_meta($post_id, '_' . $fieldID, true);
        $new = $_POST[$fieldID];
        if ($new && $new != $old) {
            update_post_meta($post_id, '_' . $fieldID, $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, '_' . $fieldID, $old);
        }
    } // end foreach
}
add_action( 'save_post_map_data_point', 'map_data_point_save_meta_boxes_data', 10, 2 );

/**
 * Add a link to the settings page in the admin menu
 * under Settings -> Mapbox Data
 *
 */

function mapbox_data_settings_menu() {
	add_options_page( 
		'Mapbox Data for WordPress', 
		'Mapbox Data', 'manage_options', 
		'mapbox-data-for-wordpress', 
		'mapbox_data_settings_page'
	);
}
add_action( 'admin_menu', 'mapbox_data_settings_menu' );

function mapbox_data_settings_page() {
	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	global $plugin_url;
	global $options;
	global $number_fields;

	//Write to the database

	if( isset( $_POST['mdfw_mapbox_info_form_submitted'] ) ) {
		$hidden_field = esc_html( $_POST['mdfw_mapbox_info_form_submitted'] );
		if ( $hidden_field == 'Y' ) {
			$mapbox_account_username = $_POST['mapbox_account_username'];
			$options['mapbox_account_username']	= $mapbox_account_username;
			$mapbox_access_token = $_POST['mapbox_access_token'];
			$options['mapbox_access_token']	= $mapbox_access_token;
			$mapbox_dataset_id = $_POST['mapbox_dataset_id'];
			$options['mapbox_dataset_id']	= $mapbox_dataset_id;
			$custom_fields = array();
			for ( $i = 0; $i < $number_fields; $i++ ) { 
				$field_name = 'mdfw_custom_field_' . $i;
				$field_type = $field_name . '_type';
				$field_json = $field_name . '_json';

				if( '' != $_POST[$field_name] ) {
					$$field_name = $_POST[$field_name];
					$options[$field_name]	= $$field_name;
					$$field_type = $_POST[$field_type];
					$options[$field_type]	= $$field_type;
					$$field_json = $_POST[$field_json];
					$options[$field_json]	= $$field_json;

					//Save to custom fields array
					$custom_fields[] = array(
						'name'	=> $$field_name,
				        'type'  => $$field_type,
				        'json'	=> $$field_json,
					);
				}
			}
			$options['last_updated'] = time();
			$options['custom_fields'] = $custom_fields;

			update_option( 'mapbox_data', $options );
		}

	}

	// Get option values from the database

	$options = get_option( 'mapbox_data' );
	if( $options != '' ) {
		$mapbox_account_username = $options[ 'mapbox_account_username' ];
		$mapbox_access_token = $options[ 'mapbox_access_token' ];
		$mapbox_dataset_id = $options[ 'mapbox_dataset_id' ];
		for ( $i = 0; $i < $number_fields; $i++ ) { 
			$field_name = 'mdfw_custom_field_' . $i;
			$field_type = $field_name . '_type';
			$field_json = $field_name . '_json';

			$$field_name = $options[ $field_name ];
			$$field_type = $options[ $field_type ];
			$$field_json = $options[ $field_json ];
		}
		$last_updated = $options[ 'last_updated' ];
	}

	require( 'inc/options-page-wrapper.php' );
}

/**
 * Link to styles for the admin settings page
 *
 */

function mapbox_data_styles() {
	wp_enqueue_style( 'mapbox_data_styles', plugins_url( 'mapbox-data-for-wordpress/inc/style.css' ) );
}
add_action( 'admin_head', 'mapbox_data_styles' );


/**
 * Create custom endpoint for REST API
 *
 */

function get_map_data_REST($thePostId) {
	$postInfo = get_post($thePostId);
	return $postInfo -> $post_title;
}

//Example...

function get_data_point( $data ) {
  $postInfo = get_post($data);
  $author = $postInfo->post_author;
  return $postInfo;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'mdfw/v1', '/map-data-point/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_data_point',
  ) );
} );











