<?php
/**
 * The template to display the site logo in the footer
 *
 * @package COWORKING
 * @since COWORKING 1.0.10
 */

// Logo
if ( coworking_is_on( coworking_get_theme_option( 'logo_in_footer' ) ) ) {
	$coworking_logo_image = coworking_get_logo_image( 'footer' );
	$coworking_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $coworking_logo_image['logo'] ) || ! empty( $coworking_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $coworking_logo_image['logo'] ) ) {
					$coworking_attr = coworking_getimagesize( $coworking_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $coworking_logo_image['logo'] ) . '"'
								. ( ! empty( $coworking_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $coworking_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'coworking' ) . '"'
								. ( ! empty( $coworking_attr[3] ) ? ' ' . wp_kses_data( $coworking_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $coworking_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $coworking_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
