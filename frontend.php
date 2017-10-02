
add_filter('et_builder_post_types', 'new_post_types');
add_filter('et_fb_post_types','new_post_types' ); // Enable Divi Visual Builder on the custom post types
function new_post_types($post_types)
{

    foreach (get_post_types() as $post_type) {
        if (!in_array($post_type, $post_types) and post_type_supports($post_type, 'editor')) {
            $post_types[] = $post_type;
        }
    }
    return $post_types;
}

add_action('add_meta_boxes', 'new_add_meta_box');
function new_add_meta_box()
{
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'editor') and function_exists('et_single_settings_meta_box')) {
            $obj= get_post_type_object( $post_type );
            add_meta_box('et_settings_meta_box', sprintf(__('Divi %s Settings', 'Divi'), $obj->labels->singular_name), 'et_single_settings_meta_box', $post_type, 'side', 'high');
        }
    }
}
add_action('admin_head', 'new_admin_js');
function new_admin_js()
{
    $s = get_current_screen();
    if (!empty($s->post_type) and $s->post_type != 'page' and $s->post_type != 'post') {
        ?>
        <script>
            jQuery(function ($) {
                $('#et_pb_layout').insertAfter($('#et_pb_main_editor_wrap'));
            });
        </script>
        <?php
    }
}
