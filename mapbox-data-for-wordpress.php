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

class Mapbox_Data_for_WordPress {

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Mapbox_Data_for_WordPress;
			self::$instance->setup_actions();
		}
		return self::$instance;
	}

	private function setup_actions() {
		add_action( 'init', array( 'Mapbox_Data_for_WordPress\Content_Model', 'mapbox_data_init_register_post_type') );
	}

}

// $mapboxDataForWordPress = new Mapbox_Data_for_WordPress();

/**
	* Assign Global Variables.
	*
*/

$plugin_url = WP_PLUGIN_URL . '/mapbox-data-for-wordpress';
$options = array();
$number_fields = 3;



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
				}
			}
			$options['last_updated']		= time();

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
 * Add meta boxes for Year and Location
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function map_data_point_add_meta_boxes( $post ){
	add_meta_box( 'map_data_point_year', 'Year', 'map_data_point_year_build_meta_box', 'map_data_point', 'side', 'low' );
	add_meta_box( 'map_data_point_location', 'Location', 'map_data_point_location_build_meta_box', 'map_data_point', 'normal', 'low' );
}
add_action( 'add_meta_boxes_map_data_point', 'map_data_point_add_meta_boxes' );

/**
 * Build custom field meta boxes for Year and Location
 *
 * @param post $post The post object
 */
function map_data_point_year_build_meta_box( $post ){
	wp_nonce_field( basename( __FILE__ ), 'map_data_point_meta_box_nonce' );
	$mapDataPoint_Year = get_post_meta( $post->ID, '_map_data_point_year', true );
	?>
	<input type="text" name="year" value="<?php echo $mapDataPoint_Year; ?>" /> 
	<?php
}

function map_data_point_location_build_meta_box( $post ){
	wp_nonce_field( basename( __FILE__ ), 'map_data_point_meta_box_nonce' );
	$mapDataPoint_Location = get_post_meta( $post->ID, '_map_data_point_location', true );
	?>
	<input type="text" name="location" value="<?php echo $mapDataPoint_Location; ?>" /> 
	<?php
}

/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 */
function map_data_point_save_meta_boxes_data( $post_id ){
	if ( !isset( $_POST['map_data_point_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['map_data_point_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	if ( isset( $_REQUEST['year'] ) ) {
		update_post_meta( $post_id, '_map_data_point_year', sanitize_text_field( $_POST['year'] ) );
	}
	if ( isset( $_REQUEST['location'] ) ) {
		update_post_meta( $post_id, '_map_data_point_location', sanitize_text_field($_POST['location'] ) );
	}
}
add_action( 'save_post_map_data_point', 'map_data_point_save_meta_boxes_data', 10, 2 );


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











