<?php
/*
Plugin Name: DRC Slider
Plugin URI: https://github.com/spiderdunia/drc-slider.git
Description: DRC Slider for practical Interview Test.
Version: 1.0
Author: Bhavik Panchal
Author URI: https://github.com/spiderdunia/
License: GPLv2 or later
Text Domain: drc-slider
*/


//Add Assets to admin panel
add_action( 'admin_enqueue_scripts', 'drc_admin_assets' );
function drc_admin_assets() {
    global $pagenow;
    if ( 'post.php' === $pagenow && isset($_GET['post']) && 'slider' === get_post_type( $_GET['post'] ) ){
        wp_enqueue_media();
        wp_enqueue_style( 'bootstrap-css', plugins_url("/css/bootstrap.min.css" , __FILE__ ));
        wp_enqueue_script( 'bootstrap-js', plugins_url( '/js/bootstrap.min.js' , __FILE__ ), array('jquery') );
        wp_enqueue_style( 'font-awsome-css', "https://pro.fontawesome.com/releases/v5.10.0/css/all.css" );
        wp_enqueue_script( 'custom-js', plugins_url( '/js/custom.js' , __FILE__ ), array('jquery'), '1.0' );
    }
}

include_once(plugin_dir_path(__FILE__)."custom-post-type.php");
include_once(plugin_dir_path(__FILE__)."repeater-metabox.php");
include_once(plugin_dir_path(__FILE__)."manage-column.php");