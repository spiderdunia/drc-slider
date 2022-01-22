<?php

// Initialize repeater meta box
add_action('admin_init', 'drc_repeater_meta', 2);
function drc_repeater_meta() {
    add_meta_box( 'drc-meta-slider', 'DRC Slider', 'drc_repeater_meta_box', 'slider');
}

// Repeater meta box call back
function drc_repeater_meta_box() { 
	global $post;
    $drc_grp = get_post_meta($post->ID, 'drc_grp_data', true);
    wp_nonce_field( 'slider_drc_repeater_meta_box_nonce', 'slider_drc_repeater_meta_box_nonce' );
?>
<table id="repeatable-fieldset-one" class="table table-bordered" width="100%">
    <thead>
        <tr>
            <th>Slide Image</th>
            <th>Slide Title</th>
            <th>Slide Description</th>
            <th>Slide Show/Hide</th>
            <th>Remove</th>
        </tr>
    </thead>

    <tbody>
        <?php
     if ( $drc_grp ){
       $i = 0;
      foreach ( $drc_grp as $drc_grp_list ) {
    ?>
        <tr class="row" style="display: table-row;">
            <td>
                <div class="img_container">
                    <?php if( $drc_grp_list['img_upload'] ){ echo '<img width="100" src="'.$drc_grp_list['img_upload'].'">'; } ?>
                </div>
                <input id="img_upload" class="img-slide" type="hidden" size="36" name="img_upload[]"
                    value="<?php echo $drc_grp_list['img_upload']; ?>" /><br />
                <input id="img_upload_button" class="drc-slide-button button button-primary button-medium" type="button"
                    value="Upload Image" />

            </td>
            <td>
                <input type="text" placeholder="Slider Title" name="s_title[]"
                    value="<?php echo $drc_grp_list['s_title'] ?>" />
            </td>
            <td>
                <textarea placeholder="Description" cols="30" rows="5"
                    name="s_desc[]"><?php echo $drc_grp_list['s_desc'] ?></textarea>
            </td>
            <td>
                <input type="radio" name="s_h_slide[<?php echo $i; ?>]"
                    <?php if($drc_grp_list['s_h_slide'] == 'Show'){ echo 'checked'; } ?> value="Show"
                    id="lbl_html_<?php echo $i; ?>"><label for="lbl_html_<?php echo $i; ?>">Show</label><br />
                <input type="radio" name="s_h_slide[<?php echo $i; ?>]"
                    <?php if($drc_grp_list['s_h_slide'] == 'Hide'){ echo 'checked'; } ?> value="Hide"
                    id="lbl_hide_<?php echo $i; ?>"><label for="lbl_hide_<?php echo $i; ?>">Hide</label>
            </td>
            <td><a type="button" class="btn btn-danger btn-sm px-3 row-delete" style="" href="#1">
                    <i class="fas fa-times"></i>
                </a></td>
        </tr>
        <?php
    $i++;
    }
} ?>

        <tr class="blank-line screen-reader-text row" style="display: table-row;">
            <td>
                <div class="img_container"></div>
                <input id="img_upload" class="img-slide" type="hidden" size="36" name="img_upload[]" value="" /><br />
                <input id="img_upload_button" class="drc-slide-button button button-primary button-medium" type="button"
                    value="Upload Image" />
            </td>
            <td>
                <input type="text" placeholder="Title" name="s_title[]" />
            </td>
            <td>
                <textarea placeholder="Description" cols="30" rows="5" name="s_desc[]"> </textarea>
            </td>
            <td>
                <input type="radio" name="s_h_slide[]" value="Show" id="lbl_html"><label
                    for="lbl_html">Show</label><br />
                <input type="radio" name="s_h_slide[]" value="Hide" id="lbl_hide"><label for="lbl_hide">Hide</label>
            </td>
            <td><a type="button" class="btn btn-danger btn-sm px-3 row-delete" style="" href="#1">
                    <i class="fas fa-times"></i>
                </a></td>
        </tr>
    </tbody>
</table>

<p><a id="new-row" class="button" href="#">Add Slide</a></p>
<?php
}

// save data of repeater meta box
add_action('save_post', 'slider_drc_repeater_meta_box_save');
function slider_drc_repeater_meta_box_save($post_id) {
    if ( ! isset( $_POST['slider_drc_repeater_meta_box_nonce'] ) ||
    ! wp_verify_nonce( $_POST['slider_drc_repeater_meta_box_nonce'], 'slider_drc_repeater_meta_box_nonce' ) ){
        return;
    }
        

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return;
    }
        

    if (!current_user_can('edit_post', $post_id)){
        return;
    }
    $previuos_data = get_post_meta($post_id, 'drc_grp_data', true);
    $next_data = array();
    $s_title = $_POST['s_title'];
    $s_desc = $_POST['s_desc'];
    $s_h_slide = $_POST['s_h_slide'];
    $img_upload = $_POST['img_upload'];
     $count = count( $s_title );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $img_upload[$i] != '' ) {
            $next_data[$i]['s_title'] = stripslashes( strip_tags( $s_title[$i] ) );
            $next_data[$i]['s_desc'] = stripslashes( $s_desc[$i] );
            $next_data[$i]['s_h_slide'] = stripslashes( $s_h_slide[$i] );
            $next_data[$i]['img_upload'] = stripslashes( $img_upload[$i] );
        }
    }
    
    if ( !empty( $next_data ) && $next_data != $previuos_data ){
        update_post_meta( $post_id, 'drc_grp_data', $next_data );
    }
        
    elseif ( empty($next_data) && $previuos_data ){
        delete_post_meta( $post_id, 'drc_grp_data', $previuos_data );
    }
        
}