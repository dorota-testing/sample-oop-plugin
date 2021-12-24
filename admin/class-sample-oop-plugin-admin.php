<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/admin
 * @author     Your Name <email@example.com>
 */
class Sample_Oop_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sample_oop_plugin    The ID of this plugin.
	 */
	private $sample_oop_plugin;

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
	 * @param      string    $sample_oop_plugin       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sample_oop_plugin, $version ) {

		$this->sample_oop_plugin = $sample_oop_plugin;
		$this->version = $version;

		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wppb_Demo_Plugin_Admin_Settings. Registers the admin settings and page.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-sample-oop-plugin-settings.php';

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
		 * defined in Sample_Oop_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sample_Oop_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->sample_oop_plugin, plugin_dir_url( __FILE__ ) . 'css/sample-oop-plugin-admin.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'css/sample-oop-plugin-admin.css' ), 'all' );

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
		 * defined in Sample_Oop_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sample_Oop_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->sample_oop_plugin, plugin_dir_url( __FILE__ ) . 'js/sample-oop-plugin-admin.js', array( 'jquery' ), filemtime( plugin_dir_path( __FILE__ ) . 'js/sample-oop-plugin-admin.js' ), false );

	}

	/**
	 * Add my custom menu item in admin paneljavascript for image upload
	 * @since    1.0.0
	 */
	public function load_wp_media_files() {
		wp_enqueue_media();
	}



		/**
	 * Add a settings link under plugin name on the list of plugins
	 * This is used by a hook in class-sample-oop-plugin.php
	 *
	 * @since    1.0.0
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=soopp">' . __( 'Settings' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}

}
