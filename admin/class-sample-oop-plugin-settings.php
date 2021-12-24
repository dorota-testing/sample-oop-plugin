<?php

/**
 * The settings of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/admin
 */

/**
 * The settings of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sample_Oop_Plugin
 * @subpackage Sample_Oop_Plugin/admin
 * @author     Your Name <email@example.com>
 */

class Sample_Oop_Plugin_Admin_Settings {

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
  * top level menu
  */
  public function soopp_options_page() {
	// first one makes new menu item, second ads into settings submenu	
	//
		// add top level menu page
		add_menu_page(
		'OOP Plugin Starter (Title)',
		'OOP Plugin Starter (Menu)',
		'manage_options', //level of permissions (admin)
		'soopp', //slug
		array( $this, 'soopp_options_page_html'), //callback function in this class
		'dashicons-image-filter', // icon
		);
		//
		// create new item in Plugin menu
		add_submenu_page(
		'soopp', //parent slug
		'OOP Plugin Starter2 (Title)',
		'OOP Plugin Starter2 (Menu)',
		'manage_options', //level of permissions (admin)
		'soopp2', //slug
		array( $this, 'soopp_options_page_html2'),  //callback function in this class
		);
			
	}

			/**
	 * Add my custom menu item in admin panel
	 *
	 * @since    1.0.0
	 */
	public function soopp_options_page_html() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

	  settings_errors( 'soopp_messages' ); ?>
		<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
		<?php
			// output security fields for the registered setting "soopp"
			settings_fields( 'soopp' );
			// output setting sections and their fields
			// (sections are registered for "soopp", each field is registered to a specific section)
			do_settings_sections( 'soopp' );
			// output save settings button
			submit_button( 'Save Settings' );
		?>
		</form>
		</div>
		<?php
	}

		/**
	 * Add a subpage to my custom menu item in admin panel
	 *
	 * @since    1.0.0
	 */
	public function soopp_options_page_html2() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

	  settings_errors( 'soopp_messages' ); ?>
		<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p>This is second page of the settings.</p>

		</div>
		<?php
	}
	

	public function soopp_settings_init() {
		// register a new setting for "soopp" page
		register_setting( 'soopp', 'soopp_options', array( $this,'soopp_validation_callback') );
		
		// register a new section in the "soopp" page
		add_settings_section(
			'soopp_first_section',
			__( 'First section title.', 'soopp' ),
			array( $this, 'soopp_first_section_cb'),
			'soopp'
		);
		// register a second section in the "soopp" page
		add_settings_section(
			'soopp_second_section',
			__( 'This is second section.', 'soopp' ),
			array( $this, 'soopp_second_section_cb'),
			'soopp'
		);
		// register a new field in the "soopp_first_section" section, inside the "soopp" page
		add_settings_field(
			'soopp_dropdown', // as of WP 4.6 this value is used only internally
			// use $args' label_for to populate the id inside the callback
			__( 'Dropdown', 'soopp' ),
			array( $this, 'soopp_dropdown_cb'),
			'soopp',
			'soopp_first_section',
			[
			'label_for' => 'soopp_dropdown',
			'class' => 'soopp_row_wrap',
			'soopp_custom_data' => 'custom',
			]
		); 
		// register a new field in the "soopp_first_section" section, inside the "soopp" page
		add_settings_field(
			'soopp_textfield', // as of WP 4.6 this value is used only internally
			// use $args' label_for to populate the id inside the callback
			__( 'Textfield', 'soopp' ),
			array( $this, 'soopp_textfield_cb'),
			'soopp',
			'soopp_first_section',
			[
				'label_for' => 'soopp_textfield',
				'class' => 'soopp_row_wrap',
				'soopp_custom_data' => 'lorem',
			]
		);
		// register a new field in the "soopp_first_section" section, inside the "soopp" page
		add_settings_field(
			'soopp_textarea', // as of WP 4.6 this value is used only internally
			// use $args' label_for to populate the id inside the callback
			__( 'Textarea', 'soopp' ),
			array( $this, 'soopp_textarea_cb'),
			'soopp',
			'soopp_first_section',
			[
				'label_for' => 'soopp_textarea',
				'class' => 'soopp_row_wrap',
			]
		);
		// register a new field in the "soopp_first_section" section, inside the "soopp" page
		add_settings_field(
			'soopp_image_id', // as of WP 4.6 this value is used only internally
			// use $args' label_for to populate the id inside the callback
			__( 'Image', 'soopp' ),
			array( $this, 'soopp_image_id_cb'),
			'soopp',
			'soopp_second_section',
			[
				'label_for' => 'soopp_image_id',
				'class' => 'soopp_row_wrap',
			]
		);
		// register a new field in the "soopp_first_section" section, inside the "soopp" page
		add_settings_field(
			'soopp_image2_id', // as of WP 4.6 this value is used only internally
			// use $args' label_for to populate the id inside the callback
			__( 'Image2', 'soopp' ),
			array( $this, 'soopp_image2_id_cb'),
			'soopp',
			'soopp_second_section',
			[
				'label_for' => 'soopp_image2_id',
				'class' => 'soopp_row_wrap',
			]
		);
		
	}


  // developers section cb
  
  // section callbacks can accept an $args parameter, which is an array.
  // $args have the following keys defined: title, id, callback.
  // the values are defined at the add_settings_section() function.
	public function soopp_first_section_cb( $args ) {
    ?>
      <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'This is explanation text for the first section.', 'soopp' ); ?></p>
    <?php
	}

	public function soopp_second_section_cb( $args ) {
    ?>
      <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Consecterur adipiscing elit.', 'soopp' ); ?></p>
    <?php
	}
	 
	// dropdown field cb
	 
	// field callbacks can accept an $args parameter, which is an array.
	// $args is defined at the add_settings_field() function.
	// wordpress has magic interaction with the following keys: label_for, class.
	// the "label_for" key value is used for the "for" attribute of the <label>.
	// the "class" key value is used for the "class" attribute of the <tr> containing the field.
	// you can add custom key value pairs to be used inside your callbacks.
	public	function soopp_dropdown_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'soopp_options' );
    //echo '<pre>'; print_r($options); echo '</pre>';
    // output the field
    ?>
		<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
		data-custom="<?php echo esc_attr( $args['soopp_custom_data'] ); ?>"
		name="soopp_options[<?php echo esc_attr( $args['label_for'] ); ?>]" >
			<option value="" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'Select...', 'soopp' ); ?>
			</option>		
			<option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'option one', 'soopp' ); ?>
			</option>
			<option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'option two', 'soopp' ); ?>
			</option>
		</select>
		<p class="description">
		<?php esc_html_e( 'Some description goes here.', 'soopp' ); ?>
		</p>
		<p class="description">
		<?php esc_html_e( 'Some more description follows.', 'soopp' ); ?>
		</p>
	<?php
	}

	public function soopp_textfield_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'soopp_options' );
    //echo '<pre>'; print_r($options); echo '</pre>';
    // output the field
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
      data-lorem="<?php echo esc_attr( $args['soopp_custom_data'] ); ?>"
      name="soopp_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?=(isset($options[ $args['label_for'] ]) ? $options[ $args['label_for'] ] : '')?>">
    
      <p class="description">
      <?php esc_html_e( 'Lorem ipsum dolor sit amet.', 'soopp' ); ?>
      </p>
    <?php
	}


	public function soopp_textarea_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'soopp_options' );
    //echo '<pre>'; print_r($options); echo '</pre>';
    // output the field
    ?>
		<textarea id="<?php echo esc_attr( $args['label_for'] ); ?>" name="soopp_options[<?php echo esc_attr( $args['label_for'] ); ?>]"><?=(isset($options[ $args['label_for'] ]) ? $options[ $args['label_for'] ] : '')?></textarea>
	
		<p class="description">
		<?php esc_html_e( 'Consectetur adipiscing elit.', 'soopp' ); ?>
		</p>
	<?php
	}
	
	public function soopp_image_id_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'soopp_options' );
    $image_id = ( isset($options['soopp_image_id']) ? $options['soopp_image_id'] : '' );
    //echo '<pre>'; print_r($options); echo '</pre>';
    // output the field
    ?>
    <table>
      <tr>
      <td>
        <table>
          <tr>
          <td>
            <input class="image-id"  type="hidden" name="soopp_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?=$image_id;?>"/>
            <input type="button" class="button soopp_upload-button" value="Select Image"/>
          </td>
          <td>
          <button class="button soopp_deleteIcon" type="button" data-placeholder="<?=esc_url( plugins_url( 'img/placeholder.png', __FILE__ ));?>">Mark for Deletion</button>
          </td>
          </tr>
          <tr>
            <td colspan="2"> 
            <small>Image should be 540px wide and 400px high.</small>
            </td>
          </tr>	  
        </table>
      </td>
      <td>
        <img src="<?= ($image_id=='' ? esc_url( plugins_url( 'img/placeholder.png', __FILE__ ) ) : wp_get_attachment_image_src($image_id)[0] ) ?>" width="70" style="width: 70px;" />
      </td>
      </tr>
      
    </table>
	<?php
	}

	public function soopp_image2_id_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'soopp_options' );
	$image_id = ( isset($options['soopp_image2_id']) ? $options['soopp_image2_id'] : '' );
	//echo '<pre>'; print_r($options); echo '</pre>';
	// output the field
	?>
	<table>
		<tr>
		<td>
			<table>
				<tr>
				<td>
					<input class="image-id" type="hidden" name="soopp_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?=$image_id;?>"/>
					<input type="button" class="button soopp_upload-button" value="Select Image"/>
				</td>
				<td>
				<button class="button soopp_deleteIcon" type="button" data-placeholder="<?=esc_url( plugins_url( 'img/placeholder.png', __FILE__ ));?>">Mark for Deletion</button>
				</td>
				</tr>
				<tr>
					<td colspan="2"> 
					<small>Image should be 540px wide and 400px high.</small>
					</td>
				</tr>	  
			</table>
		</td>
		<td>
			<img src="<?= ($image_id=='' ? esc_url( plugins_url( 'img/placeholder.png', __FILE__ ) ) : wp_get_attachment_image_src($image_id)[0] ) ?>" width='70' style='width: 70px;' />
		</td>
		</tr>
		
	</table>
	<?php
	}

  /**
 * custom option and settings:
 * callback functions
 */
  function soopp_validation_callback($input){
    // echo '<pre>'; print_r($input); echo '</pre>';
    // die;
    $success = true;
    $error = '';
    if ($input['soopp_dropdown'] == ''){
    //		die('error');	
        $error = 'Please select a Dropdown.';
    //		$input = get_option('soopp_options');
    $success = false;
    }
    if ($input['soopp_textfield'] == ''){
    //		die('error');
    if($error != ''){$error .= '</br>';}
    $error .= 'Textfield is mandatory.';
    //		$input = get_option('soopp_options');
    $success = false;
    }
  
    if($success){
      add_settings_error( 'soopp_messages', 'soopp_message', __( 'Settings Saved ', 'soopp' ), 'updated' );
    } else {
    // add one error for all		
      add_settings_error( 'soopp_messages', 'soopp_message', __( $error, 'soopp' ), 'error' );
    }
    
    return $input;
  }

}  