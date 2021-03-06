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

	/**
	 * Return param multiplied by 2
	 *
	 * @param array $data Options for the function. Params are specified in function register_my_api_route()
	 * @return string Result of multiplication, or error.
	 */
	public function my_awesome_func( $data ) {
		$number = $data['number'];
		$result = $number * 2;
	
		if ( empty( $number) ) {
			return new WP_Error( 'wrong_number', 'Number not valid', array( 'status' => 404 ) );
		}
		// Create the response object
		//$data =  array('result'=>$result);
		$data = array(
			'code' => 'my_awesome_func',
			'message' => 'Success',
			'data' => array('status'=> 201, 'result'=>$result)
		);
    $response = new WP_REST_Response($data);	
		// Add a custom status code
		$response->set_status(201);

		return $response;
	}

	// the action for this is hooked in class-sample-oop-plugin.php
	public function register_my_api_route() {
		// the thing after the <param> is regex validation [\w-]+ is word, [\d]+ is  number > 0 . This is first way to add of validation. Also validation callbacj can be used.
		register_rest_route( 'soopp/v1', '/multiply/(?P<number>[\d]+)', array(
			'methods' => 'GET',
			'callback' => [$this, 'my_awesome_func'],
		) );
	} 

	/**
	 * Return string in the param
	 *
	 * @param array $data Options for the function. Params are specified in function register_my_api_route()
	 * @return string Result of multiplication, or error.
	 */
	public function return_string_funct( $data ) {
		//var_dump($data);
		$string = $data['string'];
	
		if ( empty( $string) ) {
			return new WP_Error( 'wrong_string', 'String not valid', array( 'status' => 404 ) );
		}
		// Create the response object
		$data = array(
			'code' => 'return_string_funct',
			'message' => 'Success',
			'data' => array('status'=> 201,'result'=>$string)
		);
    $response = new WP_REST_Response($data);	
		// Add a custom status code
		$response->set_status(201);

		return $response;
	}

	public function register_my_second_api_route() {
		// the thing after the <param> is regex validation [\w-]+ is word, [\d]+ is  number > 0 . This is first way to add of validation. Also validation callbacj can be used.
		register_rest_route( 'soopp/v1', '/lorem/(?P<string>[\w-]+)', array(
			'methods' => 'GET',
			'callback' => [$this, 'return_string_funct'],
			'args' => array(
				'string' => array(
					'validate_callback' => [ $this, 'is_max_20_chars']
				),
			),
			'permission_callback' => function () {
				
/*  				$nonce = $_REQUEST['_wpnonce'];
				 var_dump($_REQUEST);
				if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
					return false;
				} */
				return true;
			} 

		) );
	}
	public function is_max_20_chars ($string) {
		if(strlen($string) > 20){
			return false;
		}
		return true;
	}
}
