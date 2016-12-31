<?php



add_action( 'wp_enqueue_scripts', function(){

    wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'vuejs', get_template_directory_uri() . '/assets/js/vue.js' );
});

add_action('init', function () {
    global $wp_post_types;
    foreach (get_post_types() as $post_type) {
        if ($wp_post_types[$post_type]->public && !$wp_post_types[$post_type]->show_in_rest) {
            $wp_post_types[$post_type]->show_in_rest = true;
            if (empty($wp_post_types[$post_type]->rest_base)) {
                $wp_post_types[$post_type]->rest_base = $wp_post_types[$post_type]->name;
            }
        }
    }
}, 40000);