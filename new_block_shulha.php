<?php
/**
 *
 * Let's implement the class new_block_shulha_class
 *
 *
 */
if (!class_exists('new_block_shulha_class')) {
    class new_block_shulha_class
    {
        /**
         * The register function registers the necessary functions via clinging to the hook
         */
        public function register()
        {
            if (!empty($this)) {
                add_action('add_meta_boxes', [$this, 'add_meta_box_new_block_shulha']);
                add_action('save_post', [$this, 'save_meta_box_new_block_shulha'], 10, 2);
            }
        }
        /**
         * Add meta box to all pages
         */
        public function add_meta_box_new_block_shulha()
        {
            add_meta_box(
                'new_block_shulha_settings',
                'New Block By Shulha',
                [$this, 'meta_box_new_block_shulha_html'],
                'page',
                'side',
                'default'
            );
        }
        /**
         * Save Meta Box use verify_nonce off the AUTOSAVE, checking if user can edit post if all good update the post
         */
        public function save_meta_box_new_block_shulha($post_id, $post)
        {

            if (!isset($_POST['_new_block_shulha']) || !wp_verify_nonce($_POST['_new_block_shulha'], 'new_block_shulha_fields')) {
                return $post_id;
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }

            $post_type = get_post_type_object($post->post_type);
            if (!current_user_can($post_type->cap->edit_post, $post_id)) {
                return $post_id;
            }

            if (is_null($_POST['new_block_shulha_types'])) {
                delete_post_meta($post_id, 'new_block_shulha_types');
            } else {
                update_post_meta($post_id, 'new_block_shulha_types', sanitize_text_field($_POST['new_block_shulha_types']));
            }

            return $post_id;
        }
        /**
         * In this function I get the JSON from your link and paste data to select
         */

        public function meta_box_new_block_shulha_html($post)
        {
            $ourData = json_decode(file_get_contents('https://www.viscaweb.com/developers/test-front-end/pages/step2-sportsbooks.json'));
            $type = get_post_meta($post->ID, 'new_block_shulha_types', true);

            wp_nonce_field('new_block_shulha_fields', '_new_block_shulha');

            echo '
				<p>
					<label for="new_block_shulha_types">' . esc_html__('Sportsbooks', 'new_block_shulha') . '</label>
					<select id="new_block_shulha_types" name="new_block_shulha_types">
						<option value="">Select Sportsbook</option>';
            foreach ($ourData as $k) {
                echo '<option value="' . $k . '" ' . selected($k, $type, false) . '>' . esc_html__($k, 'new_block_shulha') . '</option>';
                }
            echo '</select>
				</p>';
        }
    }
}
/**
 * If class exists сreate an instance of the class
 */
if (class_exists('new_block_shulha_class')) {
    $new_block_shulha = new new_block_shulha_class();
    $new_block_shulha->register();
}
