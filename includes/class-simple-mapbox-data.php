<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Simple_Mapbox_Data
 * @subpackage Simple_Mapbox_Data/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Simple_Mapbox_Data
 * @subpackage Simple_Mapbox_Data/includes
 * @author     Raquel Smith <raquel@raquelmsmith.com>
 */
class Simple_Mapbox_Data {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      simple_mapbox_data_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	protected $options;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'simple-mapbox-data';
		$this->version = '1.0.0';
		$this->options = get_option( 'mapbox_data' );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - simple_mapbox_data_Loader. Orchestrates the hooks of the plugin.
	 * - simple_mapbox_data_i18n. Defines internationalization functionality.
	 * - simple_mapbox_data_Admin. Defines all hooks for the admin area.
	 * - simple_mapbox_data_Options. Defines all hooks for the options page.
	 * - simple_mapbox_data_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-mapbox-data-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-mapbox-data-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-simple-mapbox-data-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-simple-mapbox-data-public.php';

		$this->loader = new simple_mapbox_data_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the simple_mapbox_data_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new simple_mapbox_data_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new simple_mapbox_data_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_options() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_map_data_post_type' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_box' );
		$this->loader->add_action( 'publish_map_data_point', $plugin_admin, 'save_meta_boxes_data' );
		$this->loader->add_action( 'publish_map_data_point', $plugin_admin, 'send_data_to_mapbox' );
		//$this->loader->add_action( 'publish_map_data_point', $plugin_admin, 'update_tileset' );
		$this->loader->add_action( 'untrash_post', $plugin_admin, 'send_data_to_mapbox' );
		//$this->loader->add_action( 'untrash_post', $plugin_admin, 'update_tileset' );
		$this->loader->add_action( 'wp_trash_post', $plugin_admin, 'delete_data_from_mapbox' );
		$this->loader->add_action( 'publish_to_draft', $plugin_admin, 'delete_data_from_mapbox' );
		$this->loader->add_action( 'publish_to_pending', $plugin_admin, 'delete_data_from_mapbox' );
		//$this->loader->add_action( 'wp_trash_post', $plugin_admin, 'update_tileset' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'mapbox_data_settings_menu' );
		$this->loader->add_action( 'wp_ajax_get_all_data_points', $plugin_admin, 'get_all_data_points' );
		$this->loader->add_action( 'wp_ajax_get_id_send_data', $plugin_admin, 'get_id_send_data' );
		$this->loader->add_action( 'wp_ajax_update_tileset', $plugin_admin, 'update_tileset' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new simple_mapbox_data_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    simple_mapbox_data_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the options for the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_options() {
		return $this->options;
	}

}
