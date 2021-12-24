<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/public
 * @author     Your Name <email@example.com>
 */
class Sample_Oop_Plugin_Public {

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
	 * @param      string    $sample_oop_plugin       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sample_oop_plugin, $version ) {

		$this->sample_oop_plugin = $sample_oop_plugin;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->sample_oop_plugin, plugin_dir_url( __FILE__ ) . 'css/sample-oop-plugin-public.css', array(), filemtime( plugin_dir_path( __FILE__ ) . 'css/sample-oop-plugin-public.css' ), 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->sample_oop_plugin, plugin_dir_url( __FILE__ ) . 'js/sample-oop-plugin-public.js', array( 'jquery' ), filemtime( plugin_dir_path( __FILE__ ) . 'js/sample-oop-plugin-public.js' ), false );

	}

	// sample shortcode function
	public function show_soopp_options(){
		$options = get_option( 'soopp_options' );
		$html = 'Sample OOP Plugin\'s options are:';
		foreach($options as $key=>$value){
			$html .= '<br>key = '. $key .' value= '. $value ;
		}
		return '<p>'.$html.'</p>';
	}

}
