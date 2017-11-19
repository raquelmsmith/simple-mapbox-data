<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/admin
 * @author     Raquel Smith <raquel@raquelmsmith.com>
 */
class Mapbox_Data_For_Wordpress_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options data for the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $options    The options for the mapbox data plugin.
	 */
	private $options;
	private $mdfw_send_categories;
	private $mdfw_send_tags;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 * @param      array    $options    The options for this plugin.
	 */
	public function __construct( $plugin_name, $version, $options ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options = $options;
		$this->mdfw_send_tags = $this->options['mdfw_send_tags'];
		$this->mdfw_send_categories = $this->options['mdfw_send_categories'];

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mapbox-data-for-wordpress-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mapbox-data-for-wordpress-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'mdfwAjax', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'map_data_points' => self::get_all_data_points(),
		));
	}

	/**
	 * Register the custom post type Map Data.
	 *
	 * @since    1.0.0
	 */
	public function register_map_data_post_type() {
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
	 * Add meta box for custom fields
	 *
	 * @since    1.0.0
	 */
	public function add_meta_box() {
		add_meta_box( 
			'map_data_point_meta_box', 
			'Mapbox Custom Data', 
			array( $this, 'build_meta_box' ), 
			'map_data_point', 
			'normal', 
			'high'
		);
	}

	/**
	 * Build the meta box in the map data post type. 
	 *
	 * @since    1.0.0
	 */
	public function build_meta_box() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/mapbox-data-for-wordpress-admin-display.php';
    }

    /**
	 * Create the array that holds all the information for all the custom
	 * fields, including latitude and longitude
	 *
	 * @since    1.0.0
	 */
	public function create_custom_meta_fields_array() {
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
	 * Store custom field meta box data
	 *
	 * @param int $post_id The post ID.
	 */
	public function save_meta_boxes_data( $post_id ){
		$custom_meta_fields = self::create_custom_meta_fields_array();
		// Verify nonce before saving
		if ( !isset( $_POST['map_data_point_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['map_data_point_meta_box_nonce'], 'map_data_point_meta_box_nonce_value' ) ){
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
	    	$fieldID = strtolower( preg_replace( "/\s/", "_", $field[ 'id' ] ) );
	        $old = get_post_meta($post_id, '_' . $fieldID, true);
	        $new = $_POST[$fieldID];
	        if ($new && $new != $old) {
	            update_post_meta($post_id, '_' . $fieldID, $new);
	        } elseif ('' == $new && $old) {
	            delete_post_meta($post_id, '_' . $fieldID, $old);
	        }
	    }
	}

	/**
	 * Retrieve the custom fields info and 
	 *
	 * @param int $post_id The post ID.
	 */
	public function get_custom_fields_data( $post_id ) {
		$number_fields = 3;
		$post_meta_data = get_post_meta( $post_id );
		$custom_fields = array();
		for ( $i = 0; $i < $number_fields; $i++ ) { 
			$field_name = 'mdfw_custom_field_' . $i;
			$field_type = $field_name . '_type';
			$field_json = $field_name . '_json';
			if ( isset( $this->options[ $field_name ] ) &&  $this->options[ $field_json ] ) {
				$$field_name = strtolower( $this->options[ $field_name ] );
				$custom_fields[$$field_name] = $post_meta_data[ '_mapbox_custom_data_' . $$field_name][0];
			}
		}
		return $custom_fields;
	}

	public function get_id_send_data() {
		$id = $_POST[ 'data_point_id' ];
		$response = self::send_data_to_mapbox( $id );
		$response_code = wp_remote_retrieve_response_code( $response );
		echo $response_code;
		die();
	}

	/**
	 * Send the saved Map Data Point post info to Mapbox
	 *
	 */

	public function send_data_to_mapbox( $post_id ) {
		$post_object = get_post( $post_id );
		if ( $post_object->post_type != 'map_data_point' ){
			return;
		}
		if( $this->options != '' ) {
			// todo: give error message that says it needs info on the options page
			$mapbox_account_username = $this->options[ 'mapbox_account_username' ];
			$mapbox_access_token = $this->options[ 'mapbox_access_token' ];
			$mapbox_dataset_id = $this->options[ 'mapbox_dataset_id' ];
		}
		$post_meta_data = get_post_meta( $post_id );
		$latitude = $post_meta_data['_mapbox_custom_data_latitude'];
		$longitude = $post_meta_data['_mapbox_custom_data_longitude'];
		$url = 'https://api.mapbox.com/datasets/v1/' 
			. $mapbox_account_username 
			. '/' 
			. $mapbox_dataset_id
			. '/features/'
			. $post_id
			. '?access_token='
			. $mapbox_access_token;
		$geometry = array(
			'type' 			=> 'Point',
			'coordinates'	=> array( floatval($longitude[0]), floatval($latitude[0]) ),
		);
		$properties = array(
			'post' => $post_object,
		);
		if ( $this->mdfw_send_tags ) {
			$properties[ 'tags' ] = get_the_tags( $post_id );
		}
		if ( $this->mdfw_send_categories ) {
			$properties['categories'] = get_the_category($post_id);
		}
		$custom_fields = $this->get_custom_fields_data( $post_id );
		if ( $custom_fields ) {
			$properties['custom_fields'] = $custom_fields;
		}
		$thumb_id = get_post_thumbnail_id( $post_id );
		if ( $thumb_id ) {
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
			$thumb_url = $thumb_url_array[0];
			$properties['featured_image'] = $thumb_url;
		}
		$post_info = array(
			'id'			=> strval($post_id),
			'type'			=> 'Feature',
			'geometry'		=> $geometry,
			'properties' 	=> $properties,
		);
		$post_info = json_encode( $post_info );
		//send PUT request to mapbox
		$headers = array(
			'content-type' => 'application/json',
		);
		$args = array(
			'method' => 'PUT',
			'headers' => $headers,
			'body' => $post_info,

		);
		$response =wp_remote_post( $url, $args );
		return $response;
	}

	/**
	 * Delete a feature from Mapbox when moved to the trash in WordPress
	 *
	 */

	public function delete_data_from_mapbox( $post_id ) {
		$post = get_post( $post_id );
		if ( $post->post_type != 'map_data_point' ) {
			return;
		}
		if( $this->options != '' ) {
			$mapbox_account_username = $this->options[ 'mapbox_account_username' ];
			$mapbox_access_token = $this->options[ 'mapbox_access_token' ];
			$mapbox_dataset_id = $this->options[ 'mapbox_dataset_id' ];
		}
		$url = 'https://api.mapbox.com/datasets/v1/' 
			. $mapbox_account_username 
			. '/' 
			. $mapbox_dataset_id
			. '/features/'
			. $post_id
			. '?access_token='
			. $mapbox_access_token;
		$args = array(
			'method' => 'DELETE',
		);
		$response = wp_remote_post( $url, $args );
	}

	/**
	 * Add a link to the settings page in the admin menu
	 * under Settings -> Mapbox Data
	 *
	 */

	public function mapbox_data_settings_menu() {
		add_options_page( 
			'Mapbox Data for WordPress', 
			'Mapbox Data', 'manage_options', 
			'mapbox-data-for-wordpress', 
			array( $this, 'mapbox_data_settings_page' )
		);
	}

	/**
	 * Fill fields in options page with existing data
	 * and write new field data to the database
	 *
	 */

	public function mapbox_data_settings_page() {
		if( !current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		$options;
		$number_fields = 3;

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
				$mdfw_send_categories = $_POST['mdfw_send_categories'];
				$options['mdfw_send_categories']	= $mdfw_send_categories;
				$mdfw_send_tags = $_POST['mdfw_send_tags'];
				$options['mdfw_send_tags']	= $mdfw_send_tags;
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
			$mdfw_send_categories = $options[ 'mdfw_send_categories' ];
			$mdfw_send_tags = $options[ 'mdfw_send_tags' ];
			for ( $i = 0; $i < $number_fields; $i++ ) { 
				$field_name = 'mdfw_custom_field_' . $i;
				$field_type = $field_name . '_type';
				$field_json = $field_name . '_json';
				if ( isset( $options[ $field_name ] ) ) {
					$$field_name = $options[ $field_name ];
					$$field_type = $options[ $field_type ];
					$$field_json = $options[ $field_json ];
				} else {
					$$field_name = '';
					$$field_type = '';
					$$field_json = '';
				}
			}
			$last_updated = $options[ 'last_updated' ];
		}

		require( 'partials/mapbox-data-for-wordpress-options-display.php' );
	}

	public function get_all_data_points() {
		$map_data_points = new WP_Query( array( 'post_type' => 'map_data_point' ) );
		return $map_data_points;
	}

}
