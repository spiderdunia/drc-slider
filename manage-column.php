<?php
// Show slider shortcode in table as extra column name shortcode
add_filter('manage_posts_columns', 'drc_manage_posts_columns', 'slider');
function drc_manage_posts_columns($columns) {
    // ptr($columns);
    return array_merge($columns, array('drc_grp_data' => __('Shortcode', 'Shortcode Of Slider')));
}
add_action('manage_posts_custom_column', 'display_posts_featured_image_dp', 10, 2);
function display_posts_featured_image_dp($column, $post_id) {
    echo "[drc_slider id=".$post_id."]";
}