<?php

// Register custom post type name as Slider while active plugin
add_action( 'init', 'drc_custom_post_type' );
function drc_custom_post_type() {
    $args=array(
    'label' => 'Slider',    
    'capability_type' => 'post',
    'hierarchical' => false,
    'rewrite' => array(
        'slug' => 'slider',
        'with_front' => false
        ),
	'public' => true,
    'show_ui' => true,
    'query_var' => true,
    'supports' => array(
        'title',
        'editor',      
        'thumbnail',
        'author',
        'custom-fields'     
        )
    ); 
    register_post_type( 'slider', $args );
}