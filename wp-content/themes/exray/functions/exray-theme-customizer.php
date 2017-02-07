<?php
	
add_action( 'customize_register', 'exray_customize_register');

function exray_customize_register($wp_customize){

	/* Create Theme Customizer sections */
	global $exray_general_options;
	//Logo section
	$wp_customize->add_section('exray_logo', array(
		'title' 		=> __('Logo', 'exray'),
		'description' 	=> __('Upload your Website logo below', 'exray'),
		'priority'		=> '35'
	));
	
	//Top Ad Section on Theme Customizer
	$wp_customize->add_section('exray_ad', array(
		'title' 		=> __('Top Ad', 'exray'),
		'description' 	=> __('Allow you to upload ad Banner on the top of the page', 'exray'),
		'priority' 		=> '36' 
	));

	/* General Options Section from Theme Options */
	$wp_customize->add_section('exray_general_options', array(
		'title' 		=> __('General Options', 'exray'),
		'description' 	=> __('General Options for Exray', 'exray'),
		'priority' 		=> '37' 
	));
		
	$wp_customize->add_section('exray_custom_css', array(
		'title' 		=> __('Custom CSS', 'exray'),
		'description' 	=> __('Custom CSS for Exray', 'exray'),
		'priority' 		=> '38' 
	));

	/* Theme Customizer setting & control */	

	/* Toggle Menu */
	$wp_customize->add_setting('exray_theme_general_options[toggle_menu]', array(
		'default'=> '',
		'type'=>'option',
		'sanitize_callback' => 'exray_sanitize_toggle_menu' 
	));

	$wp_customize->add_control(
        new JT_Customize_Control_Checkbox_Multiple(
            $wp_customize,
            'exray_theme_general_options[toggle_menu]',
            array(
                'section' => 'exray_general_options',
                'label'   => __( 'Toggle Menu', 'exray' ),
                'settings'=> 'exray_theme_general_options[toggle_menu]',
                'choices' => array(
                    'top_menu'      => __( 'Hide top menu ',      'exray' ),
                    'main_menu'     => __( 'Hide main menu',     'exray' ),
                )
            )
        )
    );

	/* Content Options */
	$wp_customize->add_setting('exray_theme_general_options[content_options]', array(
		'default'=> 'default',
		'type'=>'option',
		'sanitize_callback' => 'exray_sanitize_content'  
	));


	$wp_customize->add_control(
		'exray_theme_general_options[content_options]',
		array(
			'type'      => 'radio',
			'label'     => __('Show content with ' , 'exray'),
			'section'   => 'exray_general_options',
			'choices'   => array(
				'default'  => __('Excerpt ' , 'exray'),
				'full' => __(' Full post with readmore' , 'exray'),
			),
		)
	);

	/* Layout Options */
	$wp_customize->add_setting('exray_theme_general_options[layout_options]', array(
		'default'=> 'default',
		'type'=>'option',
		'sanitize_callback' => 'exray_sanitize_layout'
	));

    // Register the radio image control class as a JS control type.
    $wp_customize->register_control_type( 'JT_Customize_Control_Radio_Image' );

	$wp_customize->add_control(
        new JT_Customize_Control_Radio_Image(
            $wp_customize,
            'exray_theme_general_options[layout_options]',
            array(
                'label'    => esc_html__( 'Layout', 'exray' ),
                'section'  => 'exray_general_options',
                'choices'  => array(
                	'default' => array(
                        'label' => esc_html__( 'Default', 'exray' ),
                        'url'   => get_template_directory_uri(). '/images/default.png'
                    ),
                    'content_sidebar' => array(
                        'label' => esc_html__( 'Content / Sidebar', 'exray' ),
                        'url'   => get_template_directory_uri(). '/images/content-sidebar.png'
                    ),
                    'sidebar_content' => array(
                        'label' => esc_html__( 'Sidebar / Content', 'exray' ),
                        'url'   => get_template_directory_uri(). '/images/sidebar-content.png'
                    ),
                    'full_content' => array(
                        'label' => esc_html__( 'Fullwidth', 'exray' ),
                        'url'   => get_template_directory_uri(). '/images/content.png'
                    )
                )
            )
        )
    );
	
	/* Archive Navigation Options */
	$wp_customize->add_setting('exray_theme_general_options[pagination_options]', array(
		'default'           => 'default',
		'type'              => 'option',
		'sanitize_callback' => 'exray_sanitize_pagination'  
	));


	$wp_customize->add_control(
		'exray_theme_general_options[pagination_options]',
		array(
			'type'      => 'radio',
			'label'     => __('Post navigation style' , 'exray'),
			'section'   => 'exray_general_options',
			'choices'   => array(
				'default'  => __('Paginated Link' , 'exray'),
				'old' => __('Prev / Next Link (Old)' , 'exray'),
			),
		)
	);

	/* Display Go to top link */
	$wp_customize->add_setting('exray_theme_general_options[go_to_top_navigation]', array(
		'default'=> false,
		'type'=>'option' ,
		'sanitize_callback' => 'exray_sanitize_checkbox'
	));

	$wp_customize->add_control( 'exray_theme_general_options[go_to_top_navigation]', array(
		'label'=> esc_html__('Hide go to top link on footer',  'exray'),
		'section'=>'exray_general_options',
		'settings'=> 'exray_theme_general_options[go_to_top_navigation]',
		'type'=>'checkbox',
	));

	/* Content Options */
	$wp_customize->add_setting('exray_custom_css', array(
		'default'=> '',
		'type'=>'option',
		'sanitize_callback'    => 'wp_filter_nohtml_kses',
		'sanitize_js_callback' => 'wp_filter_nohtml_kses' 
	));


	$wp_customize->add_control(
		'exray_custom_css',
		array(
			'type'      => 'textarea',
			'label'     => __('Custom CSS ' , 'exray'),
			'section'   => 'exray_custom_css',
		)
	);

	/* Display logo */
	$wp_customize->add_setting('exray_custom_settings[display_logo]', array(
			'default'=> true,
			'type'=>'option',
			'sanitize_callback' => 'exray_sanitize_checkbox' 
		));
	
	$wp_customize->add_control('exray_custom_settings[display_logo]', array(
		'label'=> 'Display Website logo?',
		'section'=>'exray_logo',
		'settings'=>'exray_custom_settings[display_logo]',
		'type'=>'checkbox'	
	));

	
	 /*Logo upload control*/	
	$wp_customize->add_setting('exray_custom_settings[exray_theme_logo]', array(
		'default' => THEME_IMAGES.'/logo.png',
		'type' => 'option',
		'sanitize_callback' => 'exray_sanitize_image'
	));
		
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'exray_theme_logo', array(
		'label' => __('Upload Website logo', 'exray'),
		'section' => 'exray_logo',
		'settings' => 'exray_custom_settings[exray_theme_logo]'
	)));

	
	/*Add setting for checkbox enable displaying Top Ad (setting saved to db).*/	
	$wp_customize->add_setting('exray_custom_settings[display_top_ad]', array(
				'default' => true,
				'type' => 'option',
				'sanitize_callback' => 'exray_sanitize_checkbox' 
		));
	
	// Add checkbox control to Theme Customizer
	$wp_customize->add_control('exray_custom_settings[display_top_ad]',array(
		'label' => __('Display Top Ad?', 'exray'),
		'section' =>  'exray_ad',
		'settings' => 'exray_custom_settings[display_top_ad]',
		'type' => 'checkbox'

	));
	

	/*Setting for Banner Ad*/	
	$wp_customize->add_setting('exray_custom_settings[top_ad]', array(
		'default' => 'http://placehold.it/468x60',
		'type' => 'option',
		'sanitize_callback' => 'exray_sanitize_image'
	));
	
	// Add Image upload control to Theme Customizer
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'top_ad', array(
		'label' => __('Upload Top Banner Image', 'exray'),
		'section' => 'exray_ad',
		'settings' => 'exray_custom_settings[top_ad]'
	)));


	/* Add setting for Ad link.*/

	$wp_customize->add_setting('exray_custom_settings[top_ad_link]', array(
			'default' => home_url() ,
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw'
	));

	// Add Ad link textbox control to Theme Customizer
	$wp_customize->add_control('exray_custom_settings[top_ad_link]',array(
		'label' => __('Link for Ad', 'exray'),
		'section' =>  'exray_ad',
		'settings' => 'exray_custom_settings[top_ad_link]',
		'type' => 'text'

	));
	
	/* Colors Section */
	
	$exray_theme_customizer_colors = array();
	
	// Top Navigation color
	$exray_theme_customizer_colors[] = array(
		'settings' => 'exray_custom_settings[top_menu_color]',
		'default' => '#f5f5f5',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'option',
		'label' =>__('Top Menu Color', 'exray'),
		'section' => 'colors'
	);

	// Link color
	$exray_theme_customizer_colors[] = array(
		'settings' => 'exray_custom_settings[link_color]',
		'default' => '#0d72c7',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'option',
		'label' =>__('Link Color', 'exray'),
		'section' => 'colors'
	);

	// Header color
	$exray_theme_customizer_colors[] = array(
		'settings' => 'exray_custom_settings[header_color]',
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'option',
		'label' =>__('Header Color', 'exray'),
		'section' => 'colors'
	);

	// Main Navigation color
	$exray_theme_customizer_colors[] = array(
		'settings' => 'exray_custom_settings[main_menu_color]',
		'default' => '#f5f5f5',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'option',
		'label' =>__('Main Menu Color', 'exray'),
		'section' => 'colors'
	);

	// Background color
	$exray_theme_customizer_colors[] = array(
		'settings' => 'exray_custom_settings[bg_color]',
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'option',
		'label' =>__('Background Color', 'exray'),
		'section' => 'colors'
	);

	// Footer area color
	$exray_theme_customizer_colors[] = array(
		'settings' => 'exray_custom_settings[footer_color]',
		'default' => '#f7f7f7',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'option',
		'label' =>__('Footer Color', 'exray'),
		'section' => 'colors'
	);

	// Copyright area color
	$exray_theme_customizer_colors[] = array(
		'settings' => 'exray_custom_settings[copyright_container_color]',
		'default' => '#ededed',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'option',
		'label' =>__('Bottom container Color', 'exray'),
		'section' => 'colors'
	);

	// Initialize setting and render all Theme Customizer control
	foreach($exray_theme_customizer_colors as $field)
  	{
 		 // SETTINGS
	    $wp_customize->add_setting( $field['settings'], array( 
	    	'default' => $field['default'],
	    	'sanitize_callback' => $field['sanitize_callback'],
	    	'type' =>  $field['type']
	    ));

	    // CONTROLS
	    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $field['settings'], array( 
	    	'label' => $field['label'], 
	    	'section' => $field['section'],
	     	'settings' => $field['settings'] 
	     )));
		 		 
	}
	
}

?>