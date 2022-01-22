jQuery(document).ready(function ($) {

    // add new row
    $('#new-row').on('click', function () {
        var row = $('.blank-line.screen-reader-text').clone(true);
        row.removeClass('blank-line screen-reader-text');
        row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
        var newIndex = $('#repeatable-fieldset-one tr').length - 3;
        row.find('input[type="radio"]').attr('name', 's_h_slide[' + newIndex + ']');
        return false;
    });

    //delete row
    $('.row-delete').on('click', function () {
        $(this).parents('tr').remove();
        return false;
    });

    // slide button
    $('.drc-slide-button').click(function () {
        var imgurl;
        formfield = $(this).siblings('input').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.restore_send_to_editor = window.send_to_editor;
        var current_item = $(this);
        window.send_to_editor = function (html) {
            var imgurl = $(html).attr('src');
            current_item.siblings('.img-slide').val(imgurl);
            current_item.parent().find(".img_container").html('<img width="100" src="' + imgurl + '" alt="banner image" class="slider_img"/>');
            tb_remove();
            window.send_to_editor = window.restore_send_to_editor;
        }
        return false;
    });
});