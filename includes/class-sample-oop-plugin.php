<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/includes
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
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/includes
 * @author     Your Name <email@example.com>
 */
class Sample_Oop_Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sample_Oop_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $sample_oop_plugin    The string used to uniquely identify this plugin.
	 */
	protected $sample_oop_plugin;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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
		if ( defined( 'SAMPLE_OOP_PLUGIN_VERSION' ) ) {
			$this->version = SAMPLE_OOP_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->sample_oop_plugin = 'sample-oop-plugin';

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
	 * - Sample_Oop_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Sample_Oop_Plugin_i18n. Defines internationalization functionality.
	 * - Sample_Oop_Plugin_Admin. Defines all hooks for the admin area.
	 * - Sample_Oop_Plugin_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sample-oop-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sample-oop-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sample-oop-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sample-oop-plugin-public.php';

		$this->loader = new Sample_Oop_Plugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sample_Oop_Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sample_Oop_Plugin_i18n();

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

		$plugin_admin = new Sample_Oop_Plugin_Admin( $this->get_sample_oop_plugin(), $this->get_version() );
		$plugin_settings = new Sample_Oop_Plugin_Admin_Settings( $this->get_sample_oop_plugin(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// this makes uploading images possible
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'load_wp_media_files' );

		//this adds link to settings on the listing of plugins
		$this->loader->add_filter( 'plugin_action_links_'.SAMPLE_OOP_PLUGIN_BASENAME, $plugin_admin, 'add_settings_link' );
				
		$this->loader->add_action( 'admin_menu', $plugin_settings, 'soopp_options_page' );
		//register main settings
		$this->loader->add_action( 'admin_init', $plugin_settings, 'soopp_settings_init' );

		$this->loader->add_action( 'rest_api_init', $plugin_admin, 'register_my_api_route');
		$this->loader->add_action( 'rest_api_init', $plugin_admin, 'register_my_second_api_route');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sample_Oop_Plugin_Public( $this->get_sample_oop_plugin(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		// first param is shortcode name, last shortcode function
		$this->loader->add_shortcode( 'soopp-options', $plugin_public, 'show_soopp_options' );

		// this uses function 'custom_excerpt_more' form class-sample-oop-plugin-public.php
		$this->loader->add_filter( 'excerpt_more', $plugin_public, 'custom_excerpt_more' );

		$this->loader->add_action( 'wp_footer', $plugin_public, 'add_copyright_to_footer' );

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
	public function get_sample_oop_plugin() {
		return $this->sample_oop_plugin;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sample_Oop_Plugin_Loader    Orchestrates the hooks of the plugin.
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

}
