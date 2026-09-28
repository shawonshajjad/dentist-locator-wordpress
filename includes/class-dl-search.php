<?php
defined( 'ABSPATH' ) || exit;

final class DL_Search {
    const MAX_RESULTS = 50;

    public static function handle() {
        check_ajax_referer( 'dl_search', 'nonce' );

        $type  = isset( $_POST['filter_type'] ) ? sanitize_key( wp_unslash( $_POST['filter_type'] ) ) : '';
        $value = isset( $_POST['filter_value'] ) ? sanitize_text_field( wp_unslash( $_POST['filter_value'] ) ) : '';

        if ( ! in_array( $type, array( 'state', 'search' ), true ) || '' === $value ) {
            wp_send_json_error( array( 'message' => __( 'Enter a search term or choose a state.', 'dentist-locator' ) ), 400 );
        }

        if ( mb_strlen( $value ) > 100 ) {
            wp_send_json_error( array( 'message' => __( 'Search term is too long.', 'dentist-locator' ) ), 400 );
        }

        $args = array(
            'post_type'              => 'dentist',
            'post_status'            => 'publish',
            'posts_per_page'         => self::MAX_RESULTS,
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
        );

        if ( 'state' === $type ) {
            $states = array( 'WA', 'NT', 'SA', 'QLD', 'NSW', 'ACT', 'VIC', 'TAS' );
            $state  = strtoupper( $value );
            if ( ! in_array( $state, $states, true ) ) {
                wp_send_json_error( array( 'message' => __( 'Invalid state.', 'dentist-locator' ) ), 400 );
            }
            $args['meta_query'] = array(
                array( 'key' => 'state', 'value' => $state, 'compare' => '=' ),
            );
        } else {
            $args['s'] = $value;
            $args['meta_query'] = array(
                'relation' => 'OR',
                array( 'key' => 'postcode', 'value' => $value, 'compare' => 'LIKE' ),
                array( 'key' => 'address', 'value' => $value, 'compare' => 'LIKE' ),
                array( 'key' => 'doctors_name', 'value' => $value, 'compare' => 'LIKE' ),
                array( 'key' => 'dentist_category', 'value' => $value, 'compare' => 'LIKE' ),
            );
        }

        $query = new WP_Query( $args );
        ob_start();

        if ( $query->have_posts() ) {
            echo '<div class="dma-dentists-title"><h2>' . esc_html__( 'Dentists', 'dentist-locator' ) . '</h2></div><div class="dentist-list">';
            while ( $query->have_posts() ) {
                $query->the_post();
                include DL_PATH . 'templates/dentist-card.php';
            }
            echo '</div>';
        } else {
            self::no_results();
        }

        wp_reset_postdata();
        wp_send_json_success( array( 'html' => ob_get_clean() ) );
    }

    private static function no_results() {
        $title = get_option( 'dma_no_results_title', __( 'No dentists matched your search', 'dentist-locator' ) );
        $text  = get_option( 'dma_no_results_text', __( 'Revise your search or contact us directly.', 'dentist-locator' ) );
        $phone = get_option( 'dma_contact_phone', '' );
        $email = sanitize_email( get_option( 'dma_contact_email', '' ) );

        echo '<div class="no-results-box"><h2>' . esc_html( $title ) . '</h2><p>' . esc_html( $text ) . '</p>';
        if ( $phone ) {
            echo '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>';
        }
        if ( $email ) {
            echo ' <a href="mailto:' . esc_attr( $email ) . '">' . esc_html__( 'Email us', 'dentist-locator' ) . '</a>';
        }
        echo '</div>';
    }
}
