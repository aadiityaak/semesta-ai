<?php

namespace SemestaAi\Core;

if (! defined('ABSPATH')) {
    exit;
}

class PostTypes
{
    public function __construct()
    {
        add_action('init', array($this, 'register_post_types'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    public function enqueue_admin_scripts($hook)
    {
        global $post;
        if (($hook == 'post-new.php' || $hook == 'post.php') && 'semesta_template' === $post->post_type) {
            wp_enqueue_media();
        }
    }

    public function register_post_types()
    {
        $labels = array(
            'name'                  => 'Template Konten',
            'singular_name'         => 'Template',
            'menu_name'             => 'Template Konten',
            'name_admin_bar'        => 'Template Konten',
            'add_new'               => 'Tambah Baru',
            'add_new_item'          => 'Tambah Template Baru',
            'new_item'              => 'Template Baru',
            'edit_item'             => 'Edit Template',
            'view_item'             => 'Lihat Template',
            'all_items'             => 'Semua Template',
            'search_items'          => 'Cari Template',
            'not_found'             => 'Tidak ada template ditemukan.',
            'not_found_in_trash'    => 'Tidak ada template diampah.',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false, // Not publicly queryable on frontend via single URL
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'semesta-template'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-media-spreadsheet',
            'supports'           => array('title', 'editor'), // editor for description
        );

        register_post_type('semesta_template', $args);
    }

    public function add_meta_boxes()
    {
        add_meta_box(
            'semesta_template_details',
            'Detail Template',
            array($this, 'render_meta_box'),
            'semesta_template',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post)
    {
        // Add an nonce field so we can check for it later.
        wp_nonce_field('semesta_template_save_meta_box_data', 'semesta_template_meta_box_nonce');

        $file_url = get_post_meta($post->ID, '_semesta_template_file_url', true);
        $type = get_post_meta($post->ID, '_semesta_template_type', true);
        $btn_text = get_post_meta($post->ID, '_semesta_template_btn_text', true);

        if (empty($btn_text)) {
            $btn_text = 'Download Template';
        }
?>
        <p>
            <label for="semesta_template_type"><strong>Jenis Template</strong></label><br>
            <select name="semesta_template_type" id="semesta_template_type" class="widefat" style="width: 100%; max-width: 300px;">
                <option value="excel" <?php selected($type, 'excel'); ?>>Excel File</option>
                <option value="google_sheet" <?php selected($type, 'google_sheet'); ?>>Google Sheet</option>
                <option value="pdf" <?php selected($type, 'pdf'); ?>>PDF Document</option>
                <option value="doc" <?php selected($type, 'doc'); ?>>Word Document</option>
            </select>
        </p>
        <p>
            <label for="semesta_template_file_url"><strong>URL File / Link</strong></label><br>
        <div style="display: flex; gap: 10px;">
            <input type="text" id="semesta_template_file_url" name="semesta_template_file_url" value="<?php echo esc_attr($file_url); ?>" class="widefat" placeholder="https://..." />
            <button type="button" class="button" id="semesta_template_upload_btn">Upload File</button>
        </div>
        <span class="description">Upload file atau masukkan link Google Sheet.</span>
        </p>
        <script>
            jQuery(document).ready(function($) {
                $('#semesta_template_upload_btn').click(function(e) {
                    e.preventDefault();
                    var custom_uploader = wp.media({
                            title: 'Upload File Template',
                            button: {
                                text: 'Gunakan File Ini'
                            },
                            multiple: false
                        })
                        .on('select', function() {
                            var attachment = custom_uploader.state().get('selection').first().toJSON();
                            $('#semesta_template_file_url').val(attachment.url);
                        })
                        .open();
                });
            });
        </script>
        <p>
            <label for="semesta_template_btn_text"><strong>Teks Tombol</strong></label><br>
            <input type="text" id="semesta_template_btn_text" name="semesta_template_btn_text" value="<?php echo esc_attr($btn_text); ?>" class="widefat" placeholder="Download Template" />
        </p>
<?php
    }

    public function save_meta_boxes($post_id)
    {
        // Check if our nonce is set.
        if (! isset($_POST['semesta_template_meta_box_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (! wp_verify_nonce($_POST['semesta_template_meta_box_nonce'], 'semesta_template_save_meta_box_data')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }

        // Make sure that it is set.
        if (isset($_POST['semesta_template_file_url'])) {
            update_post_meta($post_id, '_semesta_template_file_url', sanitize_text_field($_POST['semesta_template_file_url']));
        }
        if (isset($_POST['semesta_template_type'])) {
            update_post_meta($post_id, '_semesta_template_type', sanitize_text_field($_POST['semesta_template_type']));
        }
        if (isset($_POST['semesta_template_btn_text'])) {
            update_post_meta($post_id, '_semesta_template_btn_text', sanitize_text_field($_POST['semesta_template_btn_text']));
        }
    }
}
