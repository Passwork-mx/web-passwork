<?php
/**
 * The template to display the socials in the footer
 *
 * @package COWORKING
 * @since COWORKING 1.0.10
 */


// Socials
if ( coworking_is_on( coworking_get_theme_option( 'socials_in_footer' ) ) ) {
	$coworking_output = coworking_get_socials_links();
	if ( '' != $coworking_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php coworking_show_layout( $coworking_output ); ?>
			</div>
		</div>
		<?php
	}
}
