<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Simple_Mapbox_Data
 * @subpackage Simple_Mapbox_Data/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Mapbox_Data
 * @subpackage Simple_Mapbox_Data/admin
 * @author     Raquel Smith <raquel@raquelmsmith.com>
 */
class Simple_Mapbox_Data_Admin {

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

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-mapbox-data-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-mapbox-data-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register the custom post type Map Data.
	 *
	 * @since    1.0.0
	 */
	public function register_map_data_post_type() {
		$labels = array(
			'name'					=> _x( 'Map Data', 'post type general name', 'simple-mapbox-data' ),
			'singular_name'			=> _x( 'Map Data Point', 'post type singular name', 'simple-mapbox-data' ),
			'menu_name'				=> _x( 'Map Data', 'admin menu', 'simple-mapbox-data' ),
			'name_admin_bar'		=> _x( 'Map Data Point', 'add new on admin bar', 'simple-mapbox-data' ),
			'add_new'				=> _x( 'Add New', 'data point', 'simple-mapbox-data' ),
			'add_new_item'			=> __( 'Add New Data Point', 'simple-mapbox-data' ),
			'new_item'				=> __( 'New Data Point', 'simple-mapbox-data' ),
			'edit_item'				=> __( 'Edit Data Point', 'simple-mapbox-data' ),
			'view_item'				=> __( 'View Data Point', 'simple-mapbox-data' ),
			'all_items'				=> __( 'All Map Data Points', 'simple-mapbox-data' ),
			'search_items'			=> __( 'Search Map Data Points', 'simple-mapbox-data' ),
			'parent_item_colon'		=> __( 'Parent Map Data Points:', 'simple-mapbox-data' ),
			'not_found'				=> __( 'No Map Data Points found.', 'simple-mapbox-data' ),
			'not_found_in_trash'	=> __( 'No Map Data Points found in Trash.', 'simple-mapbox-data' )
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
				'revisions',
				'excerpt' )
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
			'Simple Mapbox Data Custom Fields', 
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
        require_once plugin_dir_path( __FILE__ ) . 'partials/simple-mapbox-data-admin-display.php';
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
		if ( !isset( $_POST[ 'map_data_point_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'map_data_point_meta_box_nonce' ], 'map_data_point_meta_box_nonce_value' ) ) {
			return $post_id;
		}
		// check autosave
	    if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	        return $post_id;
	    }
		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ){
			return $post_id;
		}
		// loop through fields and save the data
	    foreach ( $custom_meta_fields as $field ) {
	    	$fieldID = strtolower( preg_replace( "/\s/", "_", $field[ 'id' ] ) );
	        $old = get_post_meta( $post_id, '_' . $fieldID, true );
	        $new = sanitize_text_field( $_POST[ $fieldID ] );
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
			$field_name = 'smd_custom_field_' . $i;
			$field_type = $field_name . '_type';
			if ( isset( $this->options[ $field_name ] ) ) {
				$$field_name = strtolower( $this->options[ $field_name ] );
				$custom_fields["custom_field_" . $$field_name] = $post_meta_data[ '_mapbox_custom_data_' . $$field_name][0];
			}
		}
		return $custom_fields;
	}

	/**
	 * Send data to Mapbox for a given ID. Used for updating all data points.
	 *
	 */

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
		$properties = array();
		$post_array = (array) $post_object;
		$properties = array_merge( $properties, $post_array );
		/* Get and send the tags */
		$tags = get_the_tags( $post_id );
		$properties['all_tags'] = array();
		foreach ($tags as $tag) {
			$properties['tag_' . $tag->slug] = $tag;
			$properties['all_tags'][] = $tag->slug;
		}
		/* Get and send the categories */
		$categories = get_the_category($post_id);
		$properties['all_categories'] = array();
		foreach ($categories as $category) {
			$properties['category_' . $category->slug] = $category;
			$properties['all_categories'][] = $category->slug;
		}
		$custom_fields = $this->get_custom_fields_data( $post_id );
		if ( $custom_fields ) {
			$properties = array_merge( $properties, $custom_fields );
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

	public function delete_data_from_mapbox( $post ) {
		if ( !is_object( $post ) ) {
			$post = get_post( $post );
		}
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

	public function update_tileset() {
		if( $this->options != '' ) {
			$mapbox_account_username = $this->options[ 'mapbox_account_username' ];
			$mapbox_access_token = $this->options[ 'mapbox_access_token' ];
			$mapbox_dataset_id = $this->options[ 'mapbox_dataset_id' ];
			$mapbox_tileset_id = $this->options[ 'mapbox_tileset_id' ];
		}

		$headers = array(
			'content-type' => 'application/json',
		);
		$request_body = array(
			'tileset' => $mapbox_account_username . '.' . $mapbox_tileset_id,
			'url'     => 'mapbox://datasets/' . $mapbox_account_username . '/' . $mapbox_dataset_id,
		);
		$request_body = json_encode( $request_body );
		$url = 'https://api.mapbox.com/uploads/v1/' 
			. $mapbox_account_username 
			. '?access_token='
			. $mapbox_access_token;
		$args = array(
			'method'  => 'POST',
			'headers' => $headers,
			'body'    => $request_body
		);
		$response = wp_remote_post( $url, $args );
		echo json_encode( $response );
	}

	/**
	 * Add a link to the settings page in the admin menu
	 * under Settings -> Mapbox Data
	 *
	 */

	public function mapbox_data_settings_menu() {
		add_options_page( 
			'Simple Mapbox Data', 
			'Simple Mapbox Data', 'manage_options', 
			'simple-mapbox-data', 
			array( $this, 'simple_mapbox_data_settings_page' )
		);
	}

	/**
	 * Fill fields in options page with existing data
	 * and write new field data to the database
	 *
	 */

	public function simple_mapbox_data_settings_page() {
		if( !current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		$options;
		$number_fields = 3;

		//Write to the database

		if( isset( $_POST['smd_mapbox_info_form_submitted'] ) ) {
			// Verify nonce before saving
			if ( !isset( $_POST[ 'smd_options_nonce' ] ) || !wp_verify_nonce( $_POST[ 'smd_options_nonce' ], 'smd_options_nonce_value' ) ) {
				wp_die( 'The settings could not be saved.' );
			}
			$hidden_field = esc_html( $_POST['smd_mapbox_info_form_submitted'] );
			if ( $hidden_field == 'Y' ) {
				$mapbox_account_username = sanitize_text_field( $_POST['mapbox_account_username'] );
				$options['mapbox_account_username']	= $mapbox_account_username;
				$mapbox_access_token = sanitize_text_field( $_POST['mapbox_access_token'] );
				$options['mapbox_access_token']	= $mapbox_access_token;
				$mapbox_dataset_id = sanitize_text_field( $_POST['mapbox_dataset_id'] );
				$options['mapbox_dataset_id']	= $mapbox_dataset_id;
				$mapbox_tileset_id = sanitize_text_field( $_POST['mapbox_tileset_id'] );
				$options['mapbox_tileset_id']	= $mapbox_tileset_id;
				$custom_fields = array();
				for ( $i = 0; $i < $number_fields; $i++ ) { 
					$field_name = 'smd_custom_field_' . $i;
					$field_type = $field_name . '_type';

					if( '' != $_POST[$field_name] ) {
						$$field_name = sanitize_text_field( $_POST[$field_name] );
						$options[$field_name]	= $$field_name;
						$$field_type = sanitize_text_field( $_POST[$field_type] );
						$options[$field_type]	= $$field_type;

						//Save to custom fields array
						$custom_fields[] = array(
							'name'	=> $$field_name,
					        'type'  => $$field_type,
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
			$mapbox_tileset_id = $options[ 'mapbox_tileset_id' ];
			for ( $i = 0; $i < $number_fields; $i++ ) { 
				$field_name = 'smd_custom_field_' . $i;
				$field_type = $field_name . '_type';
				if ( isset( $options[ $field_name ] ) ) {
					$$field_name = $options[ $field_name ];
					$$field_type = $options[ $field_type ];
				} else {
					$$field_name = '';
					$$field_type = '';
				}
			}
			$last_updated = $options[ 'last_updated' ];
		}

		require( 'partials/simple-mapbox-data-options-display.php' );
	}

	/**
	 * Gets all the posts with the map_data_point post type
	 *
	 */
	public function get_all_data_points() {
		$low = sanitize_text_field( intval( $_POST['low'] ) );
		$high = sanitize_text_field( intval( $_POST['high'] ) );
		$args = array( 'post_type' => 'map_data_point', 'nopaging' => true );
		$posts_in_range = array();
		if ( 0 != $low || 0 != $high ) {
			if ( 0 != $low && 0 == $high ) {
				$high = $low;
			}
			if ( 0 == $low && 0 != $high ) {
				$low = $high;
			}
			for ( $i = $low; $i <= $high; $i++ ) {
				$posts_in_range[] = $i;
			}
			$args['post__in'] = $posts_in_range;
		}
		$map_data_points = new WP_Query( $args );
		exit( json_encode( $map_data_points ) );
	}

}
