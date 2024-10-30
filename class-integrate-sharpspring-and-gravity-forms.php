<?php

GFForms::include_feed_addon_framework();

class ISGF_GFSimpleFeedAddOn extends GFFeedAddOn {
    protected $_version = INTEGRATE_SHARPSPRING_AND_GRAVITY_FORMS;
    protected $_min_gravityforms_version = '1.9';
    protected $_slug = 'integrate-sharpspring-and-gravity-forms';
    protected $_path = 'integrate-sharpspring-and-gravity-forms/integrate-sharpspring-and-gravity-forms.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Integrate SharpSpring and Gravity Forms';
    protected $_short_title = 'SharpSpring';
    protected $_multiple_feeds = true;
    private static $_instance = null;

	/**
	 * Get an instance of this class.
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new ISGF_GFSimpleFeedAddOn();
		}
		return self::$_instance;
    }
    
    /**
	 * Plugin starting point.
	 */
	public function init() {
		parent::init();
    }

    /**
	 * Register needed styles.
	 */
	public function styles() {
		$styles = array(
			array(
				'handle'  => $this->_slug . '_form_settings',
				'src'     => $this->get_base_url() . "/css/form_settings.css",
				'version' => $this->_version,
				'enqueue' => array(
					array( 'admin_page' => array( 'form_settings' ) ),
				),
			),
		);
		return array_merge( parent::styles(), $styles );
    }
    
    /**
	 * Register needed scripts.
	 */
    public function scripts() {
		$scripts = array(
			array(
				'handle'  => 'form_settings_js',
				'src'     => $this->get_base_url() . '/js/form_settings.js',
				'version' => $this->_version,
				'deps'    => array( 'jquery' ),
				'enqueue' => array(
					array(
						'admin_page' => array( 'form_settings' )
					),
				),
			),
		);
		return array_merge( parent::scripts(), $scripts );
	}

    /**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 */
	public function plugin_settings_fields() {
		return array(
            array(
                'title'         => esc_html__('SharpSpring API Settings', 'simplefeedaddon'),
                'description'   => __('In SharpSpring account settings, click on the "API settings" tab to find your account id', 'simplefeedaddon'),
                'fields'        => array(
                    array(
                        'name'              => 'account_number',
                        'tooltip'           => esc_html__('Found in the API Settings under Account ID', 'simplefeedaddon'),
                        'label'             => esc_html__('Account ID', 'simplefeedaddon'),
                        'type'              => 'text',
                        'class'             => 'medium',
                        'feedback_callback' => array($this, 'initialize_api'),
                    ),
                ),
            ),
            array(
                'description'   => __('In SharpSpring account settings, click on the "API settings" tab to find your Secret Key', 'simplefeedaddon'),
                'fields'        => array(
                    array(
                        'name'              => 'secret_key',
                        'tooltip'           => esc_html__('Found in the API Settings under Secret Key', 'simplefeedaddon'),
                        'label'             => esc_html__('Secret Key', 'simplefeedaddon'),
                        'type'              => 'text',
                        'class'             => 'medium',
                        'feedback_callback' => array($this, 'initialize_api'),
                    )
                ),
            ),
        );
    }

	/**
	 * Configures the settings which should be rendered on the feed edit page.
	 */
    public function feed_settings_fields() {        
		return array(
            array(
                'title'         => esc_html__('SharpSpring Feed Settings', 'simplefeedaddon'),
                'fields'        => array(
                    array(
                        'label'         => esc_html__('Feed Name', 'simplefeedaddon'),
                        'type'          => 'text',
                        'name'          => 'feed_name',
                        'placeholder'   => '',
                        'required'      => 1,
                        'class'         => 'medium',
                        'tooltip'       => esc_html__('Enter a feed name to uniquely identify this setup.', 'simplefeedaddon'),
                    ),
                    array(
                        'label'         => esc_html__('SharpSpring List', 'simplefeedaddon'),
                        'type'          => 'sharpspring_list',
                        'name'          => 'sharpspring_list',
                        'placeholder'   => '',
                        'required'      => 1,
                        'class'         => 'medium',
                        'tooltip'       => esc_html__('Select the SharpSpring list you would like to add your contacts to.', 'simplefeedaddon'),
                    ),
                ),
            ),
            array(
				'dependency' => 'sharpspring_list',
				'fields'     => array(
					array(
						'name'      => 'mappedFields',
                        'label'     => esc_html__( 'Map Fields', 'simplefeedaddon' ),
                        'type'      => 'field_map',
                        'tooltip'   => 'Associate your SharpSpring fields to the appropriate Gravity Form fields.',
						'field_map' => array(
							array(
								'name'          => 'emailAddress',
								'label'         => esc_html__( 'Email', 'simplefeedaddon' ),
								'required'      => 1,
								'field_type'    => array( 'email', 'hidden' )
							),
							array(
								'name'          => 'firstName',
								'label'         => esc_html__( 'First Name', 'simplefeedaddon' ),
								'required'      => 0,
                            ),
                            array(
								'name'          => 'lastName',
								'label'         => esc_html__( 'Last Name', 'simplefeedaddon' ),
								'required'      => 0,
							),
							array(
								'name'          => 'phoneNumber',
								'label'         => esc_html__( 'Phone', 'simplefeedaddon' ),
								'required'      => 0,
								'field_type'    => 'phone',
                            ),
                            array(
								'name'          => 'street',
								'label'         => esc_html__( 'Address', 'simplefeedaddon' ),
								'required'      => 0,
								'field_type'    => 'address',
                            ),
                            array(
								'name'          => 'city',
								'label'         => esc_html__( 'City', 'simplefeedaddon' ),
								'required'      => 0,
								'field_type'    => 'address',
                            ),
                            array(
								'name'          => 'state',
								'label'         => esc_html__( 'State', 'simplefeedaddon' ),
								'required'      => 0,
								'field_type'    => 'address',
                            ),
                            array(
								'name'          => 'zipcode',
								'label'         => esc_html__( 'Zip', 'simplefeedaddon' ),
								'required'      => 0,
								'field_type'    => 'address',
                            ),
                            array(
								'name'          => 'country',
								'label'         => esc_html__( 'Country', 'simplefeedaddon' ),
								'required'      => 0,
								'field_type'    => 'address',
                            ),
                            array(
								'name'          => 'companyName',
								'label'         => esc_html__( 'Company', 'simplefeedaddon' ),
								'required'      => 0,
                            ),
						),
                    ),
                    array(
                        'label'             => esc_html__('Custom Fields', 'simplefeedaddon'),
                        'type'              => 'allow_custom_fields',
                        'name'              => 'allow_custom_fields',
                        'tooltip'           => esc_html__('Check this box to allow custom fields from SharpSpring. Associate your SharpSpring custom fields to the appropriate Gravity Form fields.', 'simplefeedaddon'),
                    ),
                    array(
						'name'              => 'mappedFieldsCustom',
                        'type'              => 'field_map',
						'field_map'         => $this->custom_fields_field_map(),
                    ),
                    array(
                        'name'              => 'condition',
                        'label'             => esc_html__( 'Conditional Logic', 'simplefeedaddon' ),
                        'type'              => 'feed_condition',
                        'checkbox_label'    => esc_html__( 'Enable Condition', 'simplefeedaddon' ),
                        'tooltip'           => esc_html__( 'When conditional logic is enabled, form submissions will only be sent to SharpSpring when the conditions are met. When disabled all form submissions will be sent.', 'simplefeedaddon' ),
                    ),
                ),
            ),
        );
    }

    /**
	 * Initialize API.
	 */
    public function initialize_api() {
        // Send a request to verify credentials.
        $params     = array( 'where' => array(), 'limit' => 0, 'offset' => 0 );  
        $results    = $this->sharpspring_post( $params, 'getActiveLists' );
        
        // Check to make sure the secret key is valid
        $secret_results = json_decode($results['body'], true);

        // 104 = Header missing Secret Key
        // 105 = User authentication failed
        $error_code = isset($secret_results['error']) ? $secret_results['error']['code'] : '';
        $error_msg  = isset($secret_results['error']) ? $secret_results['error']['message'] : '';

        // If the secret key response returns either a 104 or 105 return false
        if ( $error_code === 104 || $error_code === 105 ) {
            return false;
        }

        // Check to make sure the Account ID is valid
        $id_results = $results['response'];

        // If the response returns unathorized return false
        if( $id_results['code'] === 401 ) {
            return false;
        }

        // If the Account ID & Secret Key are valid return true
        return true;
    }

    /**
	 * Prevent feeds being listed or created if the API credentials are not valid.
	 */
	public function can_create_feed() {
		return $this->initialize_api();
	}
    
    /**
	 * Configures which columns should be displayed on the feed list page.
	 */
	public function feed_list_columns() {        
		return array(
			'feed_name'             => esc_html__( 'Feed Name', 'simplefeedaddon' ),
            'sharpspring_list'      => esc_html__( 'SharpSpring List', 'simplefeedaddon' ),
		);
    }

    /**
	 * Customize the sharpspring list column text to get the name instead of ID.
	 */
    public function get_column_value_sharpspring_list( $feed ){
        $params     = array( 'where' => array( 'id' => rgars( $feed, 'meta/sharpspring_list' ) ), 'limit' => 1, 'offset' => 0 );
        $list       = $this->sharpspring_post( $params, 'getActiveLists' );
        $list       = json_decode($list['body'], true);
        $list_name  = $list['result']['activeList'][0]['name'];
        return $list_name;
    }

    /**
	 * Retrieve lists from sharpspring.
	 */
    public function settings_sharpspring_list( $field ) {
        // If API is not initialized, return false.
		if ( ! $this->initialize_api() ) {
			return false;
		}
        
        $options = array(
			array(
				'label' => esc_html__( 'Select a SharpSpring List', 'simplefeedaddon' ),
				'value' => '',
			),
        );
        
        $params     = array( 'where' => array(), 'limit' => 100, 'offset' => 0 );  
        $results    = $this->sharpspring_post( $params, 'getActiveLists' );
        $results    = json_decode($results['body'], true);
        $lists      = $results['result']['activeList'];

        foreach( $lists as $list ) {
            $options[] = array(
				'label' => esc_html( $list['name'] ),
				'value' => esc_attr( $list['id'] ),
			);
        }

        // Add select field properties.
		$field['type']     = 'select';
        $field['choices']  = $options;
        $field['onchange'] = 'jQuery(this).parents("form").submit();window.onbeforeunload = null;';

		// Generate select field.
        $html = $this->settings_select( $field, false );
    
        echo $html;
    }

    /**
	 * Retrieve custom fields from SharpSpring with checkbox.
	 */
    public function settings_allow_custom_fields( $field ) {
        // If API is not initialized, return false.
		if ( ! $this->initialize_api() ) {
			return false;
        }
        
        $options = array(
			array(
                'label'             => esc_html__( 'Enable Custom Fields', 'simplefeedaddon' ),
                'name'              => 'customfields_checkbox',
                'checkbox_label'    => esc_html__( 'Enable Custom Fields', 'simplefeedaddon' ),
			),
        );

        // Add the checkbox field properties.
        $field['type']      = 'checkbox';
        $field['choices']   = $options;
        $field['class']     = "customfield-checkbox";
        $field['onclick']   = "if(this.checked){jQuery('#gaddon-setting-row-mappedFieldsCustom, #_gform_setting_mappedFieldsCustom_container').show();} else{jQuery('#gaddon-setting-row-mappedFieldsCustom, #_gform_setting_mappedFieldsCustom_container').hide();}";

		// Generate checkbox field.
        $html = $this->settings_checkbox( $field, false );
    
        echo $html;
    }

    /**
	 * Get custom fields for field map.
	 */
    public function custom_fields_field_map() {
        $field_params  = array( 'where' => array( 'isCustom' => '1' ) );
        $custom_fields = $this->sharpspring_post( $field_params, 'getFields');
        $custom_fields = json_decode($custom_fields['body'], true);
        $fields        = $custom_fields['result']['field'];
        $field_map     = array();

        foreach ( $fields as $field ) {
            $new_field =    array(
                'name'          => $field['systemName'],
                'label'         => esc_html__( $field['label'], 'simplefeedaddon' ),
                'required'      => 0,
            );
            array_push($field_map, $new_field);
        }
        return $field_map;
    }

    /**
	 * Get custom field from sharpspring for marketing automation.
	 */
    public function get_sharpspring_custom_field() {
        // Get custom field named "list"
        $field_params  = array( 'where' => array( 'label' => 'list' ) );
        $custom_fields = $this->sharpspring_post( $field_params, 'getFields');
        $custom_fields = json_decode($custom_fields['body'], true);
        $form_field    = $custom_fields['result']['field'][0]['systemName'];
        return $form_field;
    }

    /**
	 * Process the feed - Create lead and add to list
	 */
	public function process_feed( $feed, $entry, $form ) {
        // If API is not initialized, return false.
		if ( ! $this->initialize_api() ) {
            return false;
        }

        // Don't process the lead if it has a status of spam
        if ( $entry[ 'status' ] === 'spam' ){
            return false;
        }
        
        // Retrieve the name => value pairs for all fields mapped in the 'mappedFields' field map.
        // Check to see if there's custom fields, if so merge the custom fields with the main fields.
        $customfields_checkbox = $feed['meta']['customfields_checkbox'];
        if( $customfields_checkbox != 0 ) {
            $field_map_main     = $this->get_field_map_fields( $feed, 'mappedFields' );
            $field_map_custom   = $this->get_field_map_fields( $feed, 'mappedFieldsCustom' );
            $field_map          = array_merge( $field_map_main, $field_map_custom);
        } else {
            $field_map          = $this->get_field_map_fields( $feed, 'mappedFields' );
        }

		// Loop through the fields from the field map setting building an array of values to be passed to SharpSpring.
        $merge_vars         = array();
        $custom_field       = $this->get_sharpspring_custom_field();
        $list_name          = $this->get_column_value_sharpspring_list( $feed );

		foreach ( $field_map as $name => $field_id ) {
            // Get the field value for the specified field id.
            $merge_vars[ $name ] = $this->get_field_value( $form, $entry, $field_id );

            // Check for custom field
            if( $custom_field ) {
                $merge_vars[ $custom_field ] = $list_name;
            }
        }
        
        // Create the lead.
        $params      = $merge_vars;
        $lead_post   = $this->sharpspring_post( $params, 'createLeads');
        $lead_post   = json_decode($lead_post['body'], true);

        if( isset( $lead_post['result']['creates'][0]['error']['code'] ) ) {
            $lead_error = $lead_post['result']['creates'][0]['error']['code'];

            if( $lead_error == '301' ) {
                $lead_params    = array( 'where' => array( 'emailAddress' => $params['emailAddress'] ) );
                $lead_results   = $this->sharpspring_post( $lead_params, 'getLeads');
                $lead_results   = json_decode($lead_results['body'], true);
                $lead_id        = $lead_results['result']['lead'][0]['id'];
    
                // If lead already exists, update the lead's information
                $lead_updated   = $this->sharpspring_post( $params, 'updateLeads' );
            }
        } else {
            // Check to see if the lead is created already, if so grab the ID.
            $lead_id = $lead_post['result']['creates'][0]['id'];
        }

        // Add lead to specified list.
        $list_id    = rgars( $feed, 'meta/sharpspring_list' );
        $params     = array( 'listID' => $list_id, 'memberID' => $lead_id );

        $list_post  = $this->sharpspring_post( $params, 'addListMembers' );
    }

    /**
	 * Handle all API requests to SharpSpring.
	 */
    public function sharpspring_post( $params, $method ) {     
        $account_id     = $this->get_plugin_setting( 'account_number' );
        $secret_key     = $this->get_plugin_setting( 'secret_key' );                                                     
        $request_id     = session_id();       
        $data           = array(                                                                                
            'method' => $method,                                                                      
            'params' => $params,                                                                      
            'id'     => $request_id,                                                                       
        );               

        $query_string   = http_build_query( array( 'accountID' => $account_id, 'secretKey' => $secret_key ) );
        $url            = "http://api.sharpspring.com/pubapi/v1/?$query_string";
        $json_data      = json_encode($data);

        $args = array(
            'body'      => $json_data,
            'headers'   => array(
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($json_data),
            ),
        );

        $sharpspring_result = wp_remote_post( $url, $args );

        return $sharpspring_result;
    }
}