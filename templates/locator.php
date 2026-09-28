<?php defined( 'ABSPATH' ) || exit; ?>
<div class="dentist-search-map">
    <section class="search-box" aria-labelledby="dl-search-heading">
        <h2 id="dl-search-heading"><?php esc_html_e( 'Select your nearest dental practice', 'dentist-locator' ); ?></h2>
        <label for="dentist-search"><?php esc_html_e( 'Search by practice, doctor, address, postcode or category', 'dentist-locator' ); ?></label>
        <div class="search-input">
            <input type="search" id="dentist-search" maxlength="100" autocomplete="postal-code" placeholder="<?php echo esc_attr__( 'e.g. Sydney, Dr Smith, 2000', 'dentist-locator' ); ?>">
            <button type="button" id="dentist-search-btn" aria-label="<?php echo esc_attr__( 'Search dentists', 'dentist-locator' ); ?>">
                <span aria-hidden="true">🔍</span>
            </button>
        </div>
    </section>
    <section class="map-box" aria-labelledby="dl-map-heading">
        <h2 id="dl-map-heading"><?php esc_html_e( 'Search by state', 'dentist-locator' ); ?></h2>
        <div class="state-buttons" role="group" aria-label="<?php echo esc_attr__( 'Australian states and territories', 'dentist-locator' ); ?>">
            <?php foreach ( array( 'WA','NT','SA','QLD','NSW','ACT','VIC','TAS' ) as $state ) : ?>
                <button type="button" class="state-button" data-state="<?php echo esc_attr( $state ); ?>"><?php echo esc_html( $state ); ?></button>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<div id="dentist-results" role="region" aria-live="polite" aria-atomic="false"></div>
