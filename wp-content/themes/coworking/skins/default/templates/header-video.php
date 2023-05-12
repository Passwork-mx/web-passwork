<?php
/**
 * The template to display the background video in the header
 *
 * @package COWORKING
 * @since COWORKING 1.0.14
 */
$coworking_header_video = coworking_get_header_video();
$coworking_embed_video  = '';
if ( ! empty( $coworking_header_video ) && ! coworking_is_from_uploads( $coworking_header_video ) ) {
	if ( coworking_is_youtube_url( $coworking_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $coworking_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php coworking_show_layout( coworking_get_embed_video( $coworking_header_video ) ); ?></div>
		<?php
	}
}
