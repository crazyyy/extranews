<?php
/**
 * The Theme Header
 * @package WordPress
 * @subpackage Bookcase
 * @since ExtraNews 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
  <?php
    global $browser;
    $browser = $_SERVER['HTTP_USER_AGENT'];
  ?>
  <title><?php
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;

    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
      echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
      echo ' | ' . sprintf( __( 'Page %s', 'ellipsis' ), max( $paged, $page ) );

    ?>
  </title>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/favicon.ico"/>
  <?php

  $cyrillic = of_get_option('of_cyrillic_chars');

    if ($cyrillic == 'Yes') { $cyrillic_suffix = '::cyrillic,latin'; } else { $cyrillic_suffix = ''; }   ?>

  <link href="<?php bloginfo( 'stylesheet_url' ); ?>" rel="stylesheet" type="text/css" media="all" />
  <?php wp_head(); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
</head>
<body <?php body_class(); ?>>

<noscript>
  <div class="alert">
    <p><?php _e('Please enable javascript to view this site.', 'framework'); ?></p>
  </div>
</noscript>
 <?php if ( $topbar = of_get_option('of_top_bar') ) {
    if ($topbar == 'On') { ?>
      <div class="topbar">
      <div class="container clearfix">
        <p class="alignleft"><?php bloginfo( 'name' ); ?> | <?php echo date("F j, Y");  ?></p>
          <div class="alignright clearfix">
            <?php if ( has_nav_menu( 'top_nav_menu' ) ) { /* if menu location 'Top Navigation Menu' exists then use custom menu */ ?>
            <?php wp_nav_menu( array('menu' => 'Top Bar Navigation Menu', 'theme_location' => 'top_nav_menu', 'menu_class' => 'sf-menu')); ?>
            <?php } ?>
            <div id="top"></div>
            <div class="mobilenavcontainer clearfix">
              <?php $menutext = of_get_option('of_menu_text');
              if ($menutext == ''){ $menutext = __('Select a Page', 'framework'); } ?>
              <a id="jump_top" href="#mobilenav_top" class="scroll"><?php echo  $menutext; ?></a><div class="clear"></div>
              <div class="mobilenavigation">
                <?php if ( has_nav_menu( 'top_nav_menu' ) ) { /* if menu location 'Top Navigation Menu' exists then use custom menu */ ?>
                      <?php wp_nav_menu( array('menu' => 'Top Navigation Menu', 'theme_location' => 'top_nav_menu', 'items_wrap' => '<ul id="mobilenav_top"><li id="back_top"><a href="#top" class="menutop">'. __('Hide Navigation', 'framework') . '</a></li>%3$s</ul>')); ?>
                <?php } ?>
              </div>
            </div>
          </div>
      </div>
    </div>
<?php }
} ?>
<div class="sitecontainer container clearfix">
<div class="container clearfix navcontainer">
    <div class="logo">
        <?php if ( is_front_page() && is_home() ){ } else { ?>
            <a href="<?php echo home_url(); ?>">
        <?php  } ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php wp_title( '' ); ?>" title="<?php wp_title( '' ); ?>" class="logo-img"><span><?php bloginfo( 'name' ); ?></span>
        <?php if ( is_front_page() && is_home() ){
        } else { ?>
            </a>
        <?php } ?>
    </div>
    <!-- /logo -->
    <div class="mobileclear"></div>
    <div class="headerwidget">
        <div class="logowidget">
          <?php  /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Top Area') ) ?>
        </div>
    </div>
    <div class="clear"></div>
    	<div class="nav"><div class="clear"></div>
            <?php if ( has_nav_menu( 'main_nav_menu' ) ) { /* if menu location 'Top Navigation Menu' exists then use custom menu */ ?>
              <?php wp_nav_menu( array('menu' => 'Main Navigation Menu', 'theme_location' => 'main_nav_menu', 'menu_class' => 'sf-menu')); ?>
            <?php } else { /* else use wp_list_pages */?>
            <ul class="sf-menu">
                <?php wp_list_pages( array('title_li' => '','sort_column' => 'menu_order')); ?>
            </ul>
            <?php } ?>
            <div class="search"><div class="clear"></div><?php get_search_form(true); ?></div>
             <div class="clear"></div>
         </div>

       <div class="mobilenavcontainer clearfix">
        <?php $menutext = of_get_option('of_menu_text');
         if ($menutext == ''){ $menutext = __('Select a Page', 'framework'); } ?>
       <a id="jump" href="#mobilenav" class="scroll"><?php echo  $menutext; ?></a>
       <div class="clear"></div>
        <div class="mobilenavigation">
        <?php if ( has_nav_menu( 'main_nav_menu' ) ) { /* if menu location 'Top Navigation Menu' exists then use custom menu */ ?>
                <?php wp_nav_menu( array('menu' => 'Main Navigation Menu', 'theme_location' => 'main_nav_menu', 'items_wrap' => '<ul id="mobilenav"><li id="back"><a href="#top" class="menutop">'. __('Hide Navigation', 'framework') . '</a></li>%3$s</ul>')); ?>
            <?php } else { /* else use wp_list_pages */?>
                <ul class="sf-menu sf-vertical">
                    <?php wp_list_pages( array('title_li' => '','sort_column' => 'menu_order', )); ?>
                </ul>
            <?php } ?>
        </div>
      </div>
</div>
<div class="top clearfix">
  <a href="#"><?php _e('Scroll to top', 'framework'); ?></a>
  <div class="scroll">
      <p>
          <?php _e('Top', 'framework'); ?>
      </p>
  </div>
</div>
<?php   if ( !($sidebar = of_get_option('of_sidebar_width') ) ) { $sidebar = 'default'; } else { $sidebar = of_get_option('of_sidebar_width'); } ?>
<div class="mainbody <?php echo ($sidebar == 'extended') ? 'extended' : ''; ?>">
