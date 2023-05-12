<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package COWORKING
 * @since COWORKING 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$coworking_copyright_scheme = coworking_get_theme_option( 'copyright_scheme' );
if ( ! empty( $coworking_copyright_scheme ) && ! coworking_is_inherit( $coworking_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $coworking_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$coworking_copyright = coworking_get_theme_option( 'copyright' );
			if ( ! empty( $coworking_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$coworking_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $coworking_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$coworking_copyright = coworking_prepare_macros( $coworking_copyright );
				// Display copyright
				echo wp_kses( nl2br( $coworking_copyright ), 'coworking_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
