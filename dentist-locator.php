<?php
/**
 * Plugin Name: Dentist Locator with Interactive Map
 * Description: A custom CPT and AJAX-based search with an interactive SVG map of Australia and customizable "No Results" settings.
 * Version: 1.2
 * Author: Shawon
 */

if (!defined('ABSPATH')) exit;

// ===============================
// 1. Register Dentist CPT
// ===============================
function register_dentist_cpt() {
    $args = array(
        'labels' => array(
            'name' => 'Dentists List',
            'singular_name' => 'Dentist'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'dentists'),
        'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
        'menu_icon' => 'dashicons-location-alt'
    );
    register_post_type('dentist', $args);
}
add_action('init', 'register_dentist_cpt');

// ===============================
// 2. Enqueue Assets
// ===============================
function dentist_locator_scripts() {
    wp_enqueue_style('dentist-locator-css', plugin_dir_url(__FILE__) . 'assets/css/dentist-locator.css');
    wp_enqueue_script('dentist-locator-js', plugin_dir_url(__FILE__) . 'assets/js/dentist-locator.js', array(), '1.1', true);
    wp_localize_script('dentist-locator-js', 'dentistLocatorAjax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'dentist_locator_scripts');

// ===============================
// 3. Shortcode: [dentist_locator]
// ===============================
function dentist_locator_shortcode() {
    ob_start(); ?>
    <div class="dentist-search-map">
        <div class="search-box">
            <h4>Select your nearest Dental Practice</h4>
            <div class="search-field">
                <label>Search by location, practice, doctor, or category.</label>
                <div class="search-input">
                    <input type="text" id="dentist-search" placeholder="e.g., NSW, Dr. Smith, Owned...">
                    <button id="dentist-search-btn">🔍</button>
                </div>
            </div>
        </div>
        <div class="map-box">
            <label>Search by State</label>
            <div id="australia-map">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 250" width="100%" height="auto">
                  <defs>
                    <filter id="dropshadow" height="130%">
                      <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
                      <feOffset dx="2" dy="2" result="offsetblur"/>
                      <feComponentTransfer><feFuncA type="linear" slope="0.3"/></feComponentTransfer>
                      <feMerge><feMergeNode/><feMergeNode in="SourceGraphic"/></feMerge>
                    </filter>
                  </defs>
                  <style>
                    .state-label{font-family:"trade-gothic",Sans-serif;font-weight:bold;fill:#FFFFFF;pointer-events:none;font-size:14px;text-anchor:middle;filter:url(#dropshadow)}#ACT-label,#TAS-label,#QLD-label{font-size:12px}#states path,#states g{stroke:#FFFFFF;stroke-width:.5;transition:all .2s ease-in-out;cursor:pointer;filter:url(#dropshadow)}#WA{fill:#FFF496}#NT{fill:#CDE8E0}#SA,#QLD{fill:#76B2A3}#NSW{fill:#FFF496}#ACT,#VIC{fill:#CDE8C0}#TAS{fill:#E6F4F1}#states path:hover,#states g:hover,#states path.active,#states g.active{transform:translateY(-2px);filter:brightness(1.1) url(#dropshadow)}
                  </style>
                  <g id="states">
                    <path id="WA" d="m38.3,168.2c-1.9,-0.6-3.6,-1.1-3.8,-1.3-0.2,-0.2 0.8,-2.5 2.25,-5.2 1.4,-2.7 2.6,-5.5 2.6,-6.2 0,-0.8 -1.8,-4.25 -4,-7.7 -2.2,-3.5 -4,-7.1 -4,-8.1l0,-1.8-6.4,-10.3-6.4,-10.3 1.8,0-7,-14.8 0.2,-7.3c0.1,-4 0.1,-8.9 0.1,-10.9l-0.1,-3.5 5.5,-6c3,-3.3 5.5,-6.3 5.5,-6.7 0,-0.4 0.9,-0.8 1.9,-0.8l1.9,0 9.8,-6.1 13.8,-2.2 4.1,-2.6 8.4,-15-1.2,-3 3.3,-5 1.8,1.1 4,-2.5 0,-3.1 4.6,-4.3 8.5,0 3.4,3.8c1.9,2.1 3.4,4.3 3.4,5l0,1.3 2.5,-0.6L97.5,33.2c0,38.3 0,77 0,113.8l-4.6,1.6-4.5,2.2-2.3,5.6-1.6,0.5c-0.9,0.3-4.8,1-8.6,1.6l-7,1.1-8.2,4.9-8.2,4.9-5.3,0c-2.9,0-6.9,-0.5-8.8,-1.1z"/>
                    <text x="60" y="120" class="state-label">WA</text>
                    <g id="NT"><path d="m99,33 3.9,0.4c2,0.2 4.4,-0.5 5.5,-1l1.9,-1 0,-2.5 0,-2.5-2,0 0,-4 1.9,-1.7c1,-0.9 1.7,-2 1.5,-2.4l-0.5,-0.7 6.8,-4.2 11.5,-1.4 0.8,-2.4-5.6,-3 1.7,0c0.9,0 2,0.4 2.3,1 0.3,0.6 1.2,0.9 1.8,0.8 0.6,-0.1 3.4,0.8 6.2,2.1l5,2.4 7.5,0 0,3.7-4.2,4 1.2,3.2-3,5.8 17,11.2 0,60.8-61,0z"/><path d="m115,8.7-2.8,-0.4 0.8,-2.4 4.2,0c2.3,0 4.2,0.2 4.2,0.5 0,0.8-2.3,3-2.9,2.8-0.3,-0-1.8,-0.3-3.4,-0.6z"/></g>
                    <text x="130" y="80" class="state-label">NT</text>
                    <path id="SA" d="m176,181-6.8,-9.4 0.7,-3.7 0.7,-3.7-5.6,-6-2.2,0.8 0.7,-7.8-1.1,0c-1.1,0-2.2,1.1-4.6,4.5l-1.4,2 1,-4.8c0.6,-2.7 0.8,-5 0.6,-5.3-0.8,-0.8-6.1,2.5-7.9,4.8-0.9,1.2-1.9,2-2.1,1.8-0.2,-0.3-1.6,-2.6-3.1,-5.2l-2.7,-4.7-11.4,-2.6-19.2,0.2-5.8,2.6C102.7,146.2 99,147.2 99,147l0,-44 77,0z"/>
                    <text x="150" y="160" class="state-label">SA</text>
                    <path id="QLD" d="m200.3,123.9c-11.8,-0.7-14.8,-0.8-22.8,-1.3 0,-8.5 0,-21 0,-21l-16,0c0,0 0,-39.3 0,-60l6,3.5 5.2,3.5 4.4,0 6,-9.8 3.4,-24.6 2.8,-5.7c1.6,-3.1 3.3,-6 3.9,-6.3l1,-0.6 1.8,4.3c1,2.4 2.2,6.6 2.6,9.3 0.4,2.8 1.2,7.1 1.7,9.8l1,4.8 4.8,0 3.2,5 2.8,11c1.5,6.1 3.3,11.7 4,12.5 0.6,0.8 3.4,2.9 6.2,4.6l5,3.2 5,10 3.8,1 1.2,5.2 11.2,14.8 1.2,7.1c0.7,3.9 1.5,8.7 1.9,10.8l0.6,3.7-1.3,5.1-4.6,-1.1-1.3,1.6c-1.6,2-3.7,2-4.4,0.1l-0.6,-1.5-2.4,0c-1.3,0-4.3,0.7-6.7,1.5-2.3,0.8-5.4,1.4-6.9,1.3-1.4,-0.1-12.3,-0.7-24.1,-1.4z"/>
                    <text x="200" y="80" class="state-label" id="QLD-label">QLD</text>
                    <path id="NSW" d="m220.5,176.4-2.4,-2.7-2.4,-1.5c-2.1,-0.3-6.2,-1.1-9.1,-1.8l-5.4,-1.4-8.2,-10.4-2.8,-0.7-2.8,-0.7-1,-1.9-1,-1.9-3.9,0-4,1.5 0,-30.9c5.8,0.4 22.5,1.4 25.3,1.6l23.5,1.4 4.8,-1.2c4.6,-1.1 5.7,-2.1 8.3,-2 0,0 0.9,2.3 1.9,2.8 1.1,0.5 2.5,0.1 3.7,-0.3 1.1,-0.4 2,-2 3.1,-1.8l2.8,0.5-1.3,5.1c-0.7,2.7-2.1,7.5-2.9,10.9-1.8,8.3-3.1,11.6-5.3,13.4l-1.8,1.5-4.1,12.5c-2.2,6.9-4.2,13.5-4.4,14.7l-0.3,2.2"/>
                    <text x="210" y="150" class="state-label" id="NSW-label">NSW</text>
                    <path id="ACT" stroke-width="1.5" stroke="#fff" d="m222,165.7 0.1,2.8 0.4,1.4 1,1 0.4,-0.9 0.2,2.9 2.6,1.6 1,-2.2 0,-3.6c0,0 -0.3,-0.5 -0.6,-1.1 0.8,-0.3 1.2,0.1 1.2,0.1l0.1,-3.4 1.5,-2 2.4,0.3 0.5,-1-2.7,-1.3c0,0 -0.7,-1.8-1.8,-2.4-1.6,1.1-4,2-5.2,3.9-0.4,0.7-0.5,2.3-0.5,2.3z"/>
                    <text x="225" y="170" class="state-label" id="ACT-label">ACT</text>
                    <path id="VIC" d="m219.5,177.3 0.8,1c0,0.6 2.3,2.7 5,4.8l5,3.8-11.4,3.4-5.7,5.4-6.9,-3.7-2.8,1.4c-1.5,0.8-3,1.5-3.3,1.6-0.3,0.1-2.3,-0.9-4.5,-2.2c-2.2,-1.3-6.3,-3.1-9,-4l-5,-1.6-2.3,-2-2.1,-2.1c0,-9 0,-17.9 0,-26.6l3.9,-1.3 3.1,0 1.6,3.4 1.9,0.5 2.4,0.5 1.5,0.9 4.7,6 3.2,3.9c3.2,0.9 6.5,1.7 9.2,2.4 3,0.8 4.7,0.9 6.2,1l2.9,2.6"/>
                    <text x="200" y="200" class="state-label">VIC</text>
                    <path id="TAS" d="m202.7,223.9-2.7,-3.6-0.1,-3.4c-0.1,-1.9-0.4,-3.7-0.8,-4.1-0.4,-0.4-0.7,-1.8-0.7,-3.1l0,-2.3 1,0c0.6,0 2.4,0.7 4.2,1.6l3.1,1.6 9.6,-1.2 0,7.2-3.4,5.8-2.6,-1-1.7,3c-0.9,1.6-2,3-2.4,3-0.4,0-1.9,-1.6-3.4,-3.6z"/>
                    <text x="205" y="230" class="state-label" id="TAS-label">TAS</text>
                  </g>
                </svg>
            </div>
        </div>
    </div>
    <div id="dentist-results"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('dentist_locator', 'dentist_locator_shortcode');

// ===============================
// 4. AJAX handler
// ===============================
function fetch_dentists_ajax() {
    $filter_type  = isset($_POST['filter_type']) ? sanitize_text_field($_POST['filter_type']) : '';
    $filter_value = isset($_POST['filter_value']) ? sanitize_text_field($_POST['filter_value']) : '';

    $meta_query = array( 'relation' => 'AND' );

    if ($filter_type == "state" && $filter_value) {
        $meta_query[] = array(
            'key' => 'state',
            'value' => strtoupper($filter_value),
            'compare' => '='
        );
    }
    
    if ($filter_type == "search" && $filter_value) {
        $meta_query[] = array(
            'relation' => 'OR',
            array('key' => 'postcode', 'value' => $filter_value, 'compare' => 'LIKE'),
            array('key' => 'address', 'value' => $filter_value, 'compare' => 'LIKE'),
            array('key' => 'doctors_name', 'value' => $filter_value, 'compare' => 'LIKE'),
            array('key' => 'dentist_category', 'value' => $filter_value, 'compare' => 'LIKE')
        );
    }

    $args = array(
        'post_type' => 'dentist',
        'posts_per_page' => -1,
        'meta_query' => $meta_query
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo "<div class='dma-dentists-title'><h4>DMA Dentists</h4></div>";
        echo "<div class='dentist-list'>";
        while ($query->have_posts()) {
            $query->the_post();
            $address = get_post_meta(get_the_ID(), 'address', true);
            $phone   = get_post_meta(get_the_ID(), 'phone', true);
            $map_link_field = get_post_meta(get_the_ID(), 'map_link', true);
            $doctors_name = get_post_meta(get_the_ID(), 'doctors_name', true);
            $category = get_post_meta(get_the_ID(), 'dentist_category', true);
            $map_link_url = is_array($map_link_field) && isset($map_link_field['url']) ? $map_link_field['url'] : $map_link_field;
            $book_now_field = get_post_meta(get_the_ID(), 'book_now_link', true);
            $book_now_link = is_array($book_now_field) && isset($book_now_field['url']) ? $book_now_field['url'] : $book_now_field;
            $logo_url = function_exists('get_field') ? get_field('practice_logo') : '';
            $photo_html = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
            
            $category_badge = '';
            if ($category) {
                $category_name = ucwords(str_replace('-', ' ', $category));
                $category_badge = "<span class='dentist-category-badge badge-{$category}'>" . esc_html($category_name) . "</span>";
            }

            echo "<div class='dentist-item'>
                    <div class='dentist-images'>";
            if ($logo_url) echo "<div class='dentist-logo-container'><img src='" . esc_url($logo_url) . "' alt='Logo'></div>";
            if ($photo_html) echo "<div class='dentist-photo-container'>" . $photo_html . "</div>";
            echo "  </div>
                    <div class='dentist-details'>
                        " . $category_badge . "
                        <strong>" . get_the_title() . "</strong>";
            if ($doctors_name) echo "<p class='dentist-doctor'><em>with " . esc_html($doctors_name) . "</em></p>";
            echo "      <div class='dentist-info'>
                            <p>" . esc_html($address) . "</p>
                            <p>phone: " . esc_html($phone) . "</p>";
            if ($map_link_url) echo "<a href='" . esc_url($map_link_url) . "' class='view-on-map-link' target='_blank'>View on Map ➔</a>";
            echo "      </div>
                    </div>
                    <div class='dentist-actions'>";
            if ($book_now_link) echo "<a href='" . esc_url($book_now_link) . "' class='book-now button' target='_blank'>Book Now</a>";
            echo "  </div>
                </div>";
        }
        echo "</div>";
        wp_reset_postdata();
    } else {
        $no_results_title = get_option('dma_no_results_title', 'Could not find DMA Dentists based on your search query');
        $no_results_text  = get_option('dma_no_results_text', 'Revise your search using the form above, or contact us directly by phoning');
        $phone            = get_option('dma_contact_phone', '+61 7 3381 8840');
        $email            = get_option('dma_contact_email', 'info@dentalmembers.com.au');

        echo "<div class='dma-dentists-title'><h4>DMA Dentists</h4></div>";
        echo "<div class='no-results-box'>
            <p><strong>" . esc_html($no_results_title) . "</strong></p>
            <p><em>" . esc_html($no_results_text) . " 
                <a href='tel:" . esc_attr(str_replace(' ', '', $phone)) . "'>" . esc_html($phone) . "</a> 
                or <a href='mailto:" . esc_attr($email) . "'>email us</a>.</em></p>
        </div>";
    }
    wp_die();
}
add_action('wp_ajax_fetch_dentists', 'fetch_dentists_ajax');
add_action('wp_ajax_nopriv_fetch_dentists', 'fetch_dentists_ajax');

// ===============================
// 5. Professional Settings Menu
// ===============================

/**
 * Adds "Locator Settings" as a sub-item under the "Dentists List" menu.
 * Restricted to 'manage_options' (Administrators) for security.
 */
function dma_dentist_settings_menu() {
    add_submenu_page(
        'edit.php?post_type=dentist',    // Parent: The Dentists List menu
        'Locator Settings',              // Page Title
        'Locator Settings',              // Menu Title
        'manage_options',                // Capability (Security)
        'dentist-locator-settings',      // Slug
        'dma_dentist_settings_page_html' // Function
    );
}
add_action('admin_menu', 'dma_dentist_settings_menu');

/**
 * Register settings to the database
 */
function dma_dentist_register_settings() {
    register_setting('dma_dentist_settings_group', 'dma_no_results_title');
    register_setting('dma_dentist_settings_group', 'dma_no_results_text');
    register_setting('dma_dentist_settings_group', 'dma_contact_phone');
    register_setting('dma_dentist_settings_group', 'dma_contact_email');
}
add_action('admin_init', 'dma_dentist_register_settings');

/**
 * The Settings Page UI
 */
function dma_dentist_settings_page_html() {
    ?>
    <div class="wrap">
        <h1>Dentist Locator: Global Settings</h1>
        <p>Update the information displayed when no search results are found.</p>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('dma_dentist_settings_group'); //
            do_settings_sections('dentist-locator-settings');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">No Results Title</th>
                    <td><input type="text" name="dma_no_results_title" value="<?php echo esc_attr(get_option('dma_no_results_title', 'Could not find DMA Dentists based on your search query')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row">Instructional Text</th>
                    <td><textarea name="dma_no_results_text" rows="3" class="large-text"><?php echo esc_textarea(get_option('dma_no_results_text', 'Revise your search using the form above, or contact us directly by phoning')); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row">Contact Phone</th>
                    <td><input type="text" name="dma_contact_phone" value="<?php echo esc_attr(get_option('dma_contact_phone', '+61 7 3381 8840')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row">Contact Email</th>
                    <td><input type="email" name="dma_contact_email" value="<?php echo esc_attr(get_option('dma_contact_email', 'info@dentalmembers.com.au')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button('Save Locator Settings'); ?>
        </form>
    </div>
    <?php
}