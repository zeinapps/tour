<!DOCTYPE html>
<html <?php language_attributes(); ?> >
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php wp_title('|', true, 'right'); ?></title>
    
        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
         <!-- IE latest Meta -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <!-- Script required for extra functionality on the comment form -->
        <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>

        <?php wp_head(); ?>
    </head>
    <body <?php body_class() ?> >

        <?php 
            $default_options = array( 'display_logo' => true, 'exray_theme_logo' => THEME_IMAGES.'/logo.png' , 'top_ad' => 'http://lorempixel.com/468/60', 'top_ad_link' => home_url(), 'top_menu_color' => '#f5f5f5', 'link_color' => '#0d72c7', 'header_color' => '#ffffff', 'main_menu_color' => '#f5f5f5', 'bg_color' => '#ffffff', 'footer_color' => '#f7f7f7', 'copyright_container_color' => '#ededed', 'display_logo ' => true, 'display_top_ad' => true, 'top_ad_link' => home_url(), 'content_options' => 'default');
            $options = get_option('exray_custom_settings', $default_options);
            global $exray_general_options;
        ?>
        <!--[if lte IE 8 ]>
        <noscript>
                <strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong>
        </noscript>
        <![endif]-->

        <div id="page" class="wrap">

            <div class="header-container">

                <header class="top-header" id="top" role="banner">

                    <div class="top-menu-container">
                        <div class="container">
                            <?php   
                            if(!array_key_exists('toggle_menu', $exray_general_options) ){
                                $exray_general_options['toggle_menu'] = array('');
                                $toggle_menu = array('');
                            }
                            else if(is_array($exray_general_options['toggle_menu'])){
                                 $toggle_menu = array('');
                            }
                            else{
                                $toggle_menu =  explode(',', $exray_general_options['toggle_menu']);    
                            }
                           
                            // Show top menu if toggle_menu options != on
                            if (!in_array('top_menu', $toggle_menu)) : ?>             
                                <nav class="top-menu-navigation clearfix" role="navigation">
                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'top-menu',
                                        'container' => false,
                                        'container_class' => false,
                                        'menu_class' => false,
                                        'fallback_cb' => 'Exray::default_menu_fallback'
                                    ));
                                    ?>

                                </nav>
       
                            <a href="" class="small-button menus" id="adaptive-top-nav-btn"><?php _e('Menu', 'exray'); ?></a>
                            <div class="adaptive-top-nav"></div> <!-- End adaptive-top-nav -->
                            <!-- End top-menu-navigation -->
                            <?php endif; ?>
                        </div>
                        <!-- End container -->
                    </div> 
                    <!-- End top-menu-container -->
                        <img src="https://nnkq.files.wordpress.com/2012/02/img_8775-panoramacropmaster.jpg"/>
             
                    <!-- End container -->
                    <div class="main-menu-container">
                        <div class="container">
                        <?php    
                            // Show main menu if toggle_menu options != on
                            
                            if (!in_array('main_menu', $toggle_menu)) : ?>    
                            <nav class="main-menu-navigation clearfix" role="navigation">

                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'main-menu',
                                    'container' => false,
                                    'container_class' => false,
                                    'menu_class' => false,
                                    'fallback_cb' => 'Exray::default_menu_fallback'
                                ));
                                ?>

                            </nav>
                               
                            <a href="" class="small-button menus" id="adaptive-main-nav-btn"><?php _e('Menu', 'exray'); ?></a>
                            <div class="adaptive-main-nav"></div> <!-- End adaptive-main-nav -->
                            <?php endif; ?> 
                        </div>
                        <!-- End container -->
                    </div> 
                    <!-- End main-menu-container -->
                </header>   
                <!-- End top-main-header -->
            </div> 
            <!-- End header-container -->   
