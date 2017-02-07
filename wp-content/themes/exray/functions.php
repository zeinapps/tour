<?php 
/***************************************************************/
/* Define Constant */
/***************************************************************/
define( 'HOME_URI', home_url() );
define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_IMAGES', THEME_URI . '/images' );
define( 'THEME_CSS', THEME_URI . '/css' );
define( 'THEME_JS', THEME_URI . '/js' );

/***************************************************************/
/* Exray class */
/***************************************************************/
require 'classes/exray.php';

/***************************************************************/
/* Theme template / parts */
/***************************************************************/
require ('functions/exray-theme-template.php');
// require ('functions/exray-theme-options.php');
require ('functions/exray-theme-stylesheet.php');
require ('functions/exray-theme-customizer.php');
require('functions/exray-theme-banner.php');

add_action( 'customize_register', 'exray_load_customize_controls', 0 );

function exray_load_customize_controls() {
	require_once( trailingslashit( get_template_directory() ) . '/functions/control-radio-image.php' );
    require_once( trailingslashit( get_template_directory() ) . '/functions/control-checkbox-multiple.php' );
}

/* Global Variable */
$default_options = array('toggle_menu'=> array(''), 'layout_options' => 'default', 'content_options' => 'default', 'go_to_top_navigation' => false);
$exray_general_options = get_option('exray_theme_general_options', $default_options);
$exray = new Exray;

$exray->set_max_content_width(542);
$exray->get_max_content_width();
$exray->set_aside_symbol(true);

/***************************************************************/
/* Add Post Thumbnail and Post Format Theme Support*/
/***************************************************************/
add_action( 'after_setup_theme', 'exray_setup' );

function exray_setup(){
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	add_theme_support('post-formats', array('link', 'quote', 'gallery', 'aside'));
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails', array('post'));
	add_theme_support( 'title-tag' );
	set_post_thumbnail_size( 150, 150, true);	// Post Thumbnail default size 	
	load_theme_textdomain( 'exray', THEME_URI. '/languages' );
	
	register_nav_menus(
		array(
		  'top-menu' => __( 'Top Menu', 'exray' ),
		  'main-menu' => __( 'Main Menu', 'exray' )
		)
	);
}

/***************************************************************/
/* Enqueu scripts and stylesheet */
/***************************************************************/
add_action('wp_enqueue_scripts', 'exray_scripts_styles');

function exray_scripts_styles(){
	wp_enqueue_style( 'style.css', get_stylesheet_uri(),'', false, 'all' );
	wp_enqueue_script( 'custom_scripts', THEME_JS . '/scripts.js', array('jquery'), false, true );
}

add_action('admin_enqueue_scripts', 'exray_admin_scripts');

function exray_admin_scripts(){
	wp_enqueue_style( 'radio_image_style', THEME_CSS . '/customize-controls.css');
	wp_enqueue_script('jquery-ui-button');
	wp_enqueue_script( 'multicheckbox_customizer', get_template_directory_uri() . '/js/customize-controls.js', array('jquery'), false, true );
}

/***************************************************************/
/* add ie conditional html5 shim to header  */
/***************************************************************/
add_action('wp_head', 'add_ie_html5_shim');

function add_ie_html5_shim () {
    echo '<!--[if lt IE 9]>';
    echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
    echo '<![endif]-->';
}

/***************************************************************/
/* Sanitize options on customizer  */
/***************************************************************/
function exray_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function exray_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

function exray_sanitize_toggle_menu( $input ) {
	$valid = array(
		'top_menu'      => __( 'Hide top menu ',      'exray' ),
		'main_menu'     => __( 'Hide main menu',     'exray' ),
	);

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return array('');
    }
}

function exray_sanitize_content( $input ) {
	$valid = array(
		'default'  => __('Excerpt ' , 'exray'),
		'full' => __(' Full post with readmore' , 'exray'),
	);

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return array('default');
    }
}

function exray_sanitize_pagination( $input ) {
	$valid = array(
		'default'  => __('Paginated Link' , 'exray'),
		'old' => __('Prev / Next Link (Old)' , 'exray'),
	);

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return array('default');
    }
}

function exray_sanitize_layout( $input ) {
	$valid = array(
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
	);

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return 'default';
    }
}

function exray_sanitize_image( $input ){
 
    /* default output */
    $output = '';
 
    /* check file type */
    $filetype = wp_check_filetype( $input );
    $mime_type = $filetype['type'];
 
    /* only mime type "image" allowed */
    if ( strpos( $mime_type, 'image' ) !== false ){
        $output = $input;
    }
 
    return $output;
}