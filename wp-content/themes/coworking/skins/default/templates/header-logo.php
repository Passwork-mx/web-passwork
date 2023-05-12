<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

$coworking_args = get_query_var( 'coworking_logo_args' );

// Site logo
$coworking_logo_type   = isset( $coworking_args['type'] ) ? $coworking_args['type'] : '';
$coworking_logo_image  = coworking_get_logo_image( $coworking_logo_type );
$coworking_logo_text   = coworking_is_on( coworking_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$coworking_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $coworking_logo_image['logo'] ) || ! empty( $coworking_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $coworking_logo_image['logo'] ) ) {
			if ( empty( $coworking_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($coworking_logo_image['logo']) && (int) $coworking_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$coworking_attr = coworking_getimagesize( $coworking_logo_image['logo'] );
				echo '<img src="' . esc_url( $coworking_logo_image['logo'] ) . '"'
						. ( ! empty( $coworking_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $coworking_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $coworking_logo_text ) . '"'
						. ( ! empty( $coworking_attr[3] ) ? ' ' . wp_kses_data( $coworking_attr[3] ) : '' )
						. '>';
			}
		} else {
			coworking_show_layout( coworking_prepare_macros( $coworking_logo_text ), '<span class="logo_text">', '</span>' );
			coworking_show_layout( coworking_prepare_macros( $coworking_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
