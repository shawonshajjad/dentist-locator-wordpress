<?php
defined( 'ABSPATH' ) || exit;
$post_id   = get_the_ID();
$address   = get_post_meta( $post_id, 'address', true );
$phone     = get_post_meta( $post_id, 'phone', true );
$doctor    = get_post_meta( $post_id, 'doctors_name', true );
$category  = get_post_meta( $post_id, 'dentist_category', true );
$map_raw   = get_post_meta( $post_id, 'map_link', true );
$book_raw  = get_post_meta( $post_id, 'book_now_link', true );
$map_url   = is_array( $map_raw ) ? ( $map_raw['url'] ?? '' ) : $map_raw;
$book_url  = is_array( $book_raw ) ? ( $book_raw['url'] ?? '' ) : $book_raw;
$logo      = function_exists( 'get_field' ) ? get_field( 'practice_logo' ) : '';
$logo_url  = is_array( $logo ) ? ( $logo['url'] ?? '' ) : $logo;
?>
<article class="dentist-item">
    <div class="dentist-images">
        <?php if ( $logo_url ) : ?><img class="dentist-logo" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( sprintf( __( '%s logo', 'dentist-locator' ), get_the_title() ) ); ?>" loading="lazy"><?php endif; ?>
        <?php if ( has_post_thumbnail() ) : echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'loading' => 'lazy' ) ); endif; ?>
    </div>
    <div class="dentist-details">
        <?php if ( $category ) : ?><span class="dentist-category-badge badge-<?php echo esc_attr( sanitize_html_class( $category ) ); ?>"><?php echo esc_html( ucwords( str_replace( '-', ' ', $category ) ) ); ?></span><?php endif; ?>
        <h3><?php echo esc_html( get_the_title() ); ?></h3>
        <?php if ( $doctor ) : ?><p class="dentist-doctor"><?php echo esc_html( sprintf( __( 'with %s', 'dentist-locator' ), $doctor ) ); ?></p><?php endif; ?>
        <?php if ( $address ) : ?><p><?php echo esc_html( $address ); ?></p><?php endif; ?>
        <?php if ( $phone ) : ?><p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p><?php endif; ?>
        <?php if ( $map_url ) : ?><a href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View on map', 'dentist-locator' ); ?></a><?php endif; ?>
    </div>
    <?php if ( $book_url ) : ?><div class="dentist-actions"><a class="book-now button" href="<?php echo esc_url( $book_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Book now', 'dentist-locator' ); ?></a></div><?php endif; ?>
</article>
