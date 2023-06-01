<?php
/**
 * The template to display default site footer
 *
 * @package COWORKING
 * @since COWORKING 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$coworking_footer_scheme = coworking_get_theme_option( 'footer_scheme' );
if ( ! empty( $coworking_footer_scheme ) && ! coworking_is_inherit( $coworking_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $coworking_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
