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

	// this is used by filter
	public function custom_excerpt_more( $more ) {
    return '...';
	}
	// this is used by hook wp_footer
	public function add_copyright_to_footer( $more ) {
		$strHtml = '<footer>';  
		$strHtml .= '<div class="footer-bottom">';
    $strHtml .= '<div class="container">';
		$strHtml .= '<br><p>Copyright notice set with wp_footer hook.</p>';
    $strHtml .= '</div>';
		$strHtml .= '</div>';
		$strHtml .= '</footer>';
		echo $strHtml;
	}

	// sample shortcode function
	public function show_soopp_options(){
		$options = get_option( 'soopp_options' );
		// print the options
		$html = 'Sample OOP Plugin\'s options are:';
		foreach($options as $key=>$value){
			$html .= '<br>key = '. $key .' value= '. $value ;
		}
		$str1 = '<p>'.$html.'</p><br><br>';

		// call api
		$employee_id = 3;
		$url = 'http://dummy.restapiexample.com/api/v1/employee/'.$employee_id;
		$response = $this->call_api($url);

		$arrEmp = $response['data'];
		//$arrEmp = [];
		//var_dump($options['soopp_dropdown']);
		$str = '';
		if(is_array($arrEmp)){
			$str .= '<p> Employee\'s ID is: '.$arrEmp['id'].'</p>';
			$str .= '<p> Employee\'s name is: '.$arrEmp['employee_name'].'</p>';
			$str .= '<p> Employee\'s salary is: '.$arrEmp['employee_salary'].'</p>';
			$str .= '<p> Employee\'s age is: '.$arrEmp['employee_age'].'</p>';
		} else {
			$str .= '<p>'.$arrEmp.'</p>';
		}

		$nonce = wp_create_nonce( 'wp_rest' );
		//this is supposed to send the nonce, but I don't know hoe to access it and verify where it gets the request
		$headers = array ('X-WP-Nonce' => $nonce);
		// call my api endpoint
		$url2 = 'http://localhost/plants/wp-json/soopp/v1/lorem/aaa/';
		$response2 = $this->call_api($url2, 'GET', '', $headers);
		print_r($response2);
		$arrBody = $response2['data'];
		$str3 = '<br>My response = '.$arrBody['result'];
		return '<p>'.$str1.'</p>'.$str.$str3;
	}


	/**
	 * Universal function for api calls
	 * @param string $url - api url
	 * @param string $method - Accepts 'GET', 'POST', 'HEAD', 'PUT', 'DELETE', 'TRACE', 'OPTIONS', or 'PATCH'. Some transports technically allow others, but should not be assumed. Default 'GET'.
	 * @param array $data_string - data to be sent in the body of POST. Depending on API it can be something like url params: 'email='.$email.'&properties='.$string.'&confirm_optin=false'; (Maybe sometimes json too?)
	 * @param array $headers - request headers
	 * @param bool  $return_json - defalt false. If set true will rturn json
	 * @return array or json string depending on the last param. Also error message?
	 */
	public function call_api($url, $method = 'GET', $data_string = '', $headers = [], $return_json = false ) {

		$response = wp_remote_request($url, $args = array(
			'method' => $method,
			'timeout' => 15,
			'redirection' => 5,
			'httpversion' => '1.1',
			'blocking' => true,
			'headers' => $headers,
			'body' => $data_string,
			'cookies' => array()
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			return "Something went wrong: $error_message";
		} else {

			$body = wp_remote_retrieve_body($response);
			//echo 'Response body:<pre>'; var_dump( $body ); echo '</pre>';
			// if json requred, return here
			if($return_json){
				return $body;
			}
			$body = json_decode($body, true);
			//echo 'Response:<pre>'; print_r( $body ); echo '</pre>';
			return $body;
		}
	}

	/**
	 * Sample of POST call to api
	 */
	public function ki_klaviyo_add_profile_to_list($email, $params = array()) {
		$list_id = get_option('ki_list_id'); // list name 
		$api_key = get_option('ki_private_key'); // private key		
	if($email != '' && !empty($params) && array_key_exists('$first_name', $params) && array_key_exists('$last_name', $params) && array_key_exists('$title', $params) && $list_id != '' && $api_key != ''){

	//	$email = 'aaa@aaa.aa';
	//	$email = 'ccc@cc.cc';
	/*/
		$params = array(
			'$first_name'=> 'Lorem',
			'$last_name'=> 'Ipsum',	
			'$title'=> 'Ms',
		);
	/*/	
		$site_codename = ki_get_site_codename();
		$params['newsletter_consent_source'] = $site_codename.' website';
		$string = json_encode($params);
	//	var_dump($string);
	//	die;

		$url = 'https://a.kl@viyo.com/api/v1/list/'.$list_id.'/members?api_key='.$api_key;

		$data_string = 'email='.$email.'&properties='.$string.'&confirm_optin=false';
		
		$response = wp_remote_post( $url, array(
			'method' => 'POST',
			'timeout' => 15,
			'redirection' => 5,
			'httpversion' => '1.1',
			'blocking' => true,
			'headers' => array(),
			'body' => $data_string,
			'cookies' => array()
			)
		);
		
		$body = wp_remote_retrieve_body($response);
		$body = json_decode($body, true);
		
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
		//	   echo "Something went wrong: $error_message";
			} else {
		//	   echo 'Response:<pre>';
		//	   print_r( $body );
		//	   echo '</pre>';
		//	echo $body['person']['id'];
				return $body['person']['id'];
			}
		}
	}

}
