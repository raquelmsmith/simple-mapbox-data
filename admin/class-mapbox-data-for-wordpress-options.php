<?php

/**
 * The options page functionality of the plugin.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/admin
 */

/**
 * The options page functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mapbox_Data_For_Wordpress
 * @subpackage Mapbox_Data_For_Wordpress/admin
 * @author     Raquel Smith <raquel@raquelmsmith.com>
 */
class Mapbox_Data_For_Wordpress_Options {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mapbox_Data_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mapbox_Data_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mapbox-data-for-wordpress-options.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mapbox_Data_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mapbox_Data_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mapbox-data-for-wordpress-options.js', array( 'jquery' ), $this->version, false );

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

		require( 'partials/mapbox-data-for-wordpress-options-display.php' );
	}

}
