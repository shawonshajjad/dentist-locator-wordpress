<?php
defined( 'ABSPATH' ) || exit;

final class DL_Post_Type {
    public static function register() {
        register_post_type(
            'dentist',
            array(
                'labels' => array(
                    'name'          => __( 'Dentists', 'dentist-locator' ),
                    'singular_name' => __( 'Dentist', 'dentist-locator' ),
                ),
                'public'       => true,
                'has_archive'  => true,
                'rewrite'      => array( 'slug' => 'dentists' ),
                'show_in_rest' => true,
                'supports'     => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
                'menu_icon'    => 'dashicons-location-alt',
            )
        );
    }
}
