<?php
/**
 * The template to display default site footer
 *
 * @package COWORKING
 * @since COWORKING 1.0.10
 */

$coworking_footer_id = coworking_get_custom_footer_id();
$coworking_footer_meta = get_post_meta( $coworking_footer_id, 'trx_addons_options', true );
if ( ! empty( $coworking_footer_meta['margin'] ) ) {
	coworking_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( coworking_prepare_css_value( $coworking_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $coworking_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $coworking_footer_id ) ) ); ?>
						<?php
						$coworking_footer_scheme = coworking_get_theme_option( 'footer_scheme' );
						if ( ! empty( $coworking_footer_scheme ) && ! coworking_is_inherit( $coworking_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $coworking_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'coworking_action_show_layout', $coworking_footer_id );
	?>
</footer><!-- /.footer_wrap -->
