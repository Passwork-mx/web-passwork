<?php
/**
 * The "Style 4" template to display the post header of the single post or attachment:
 * featured image and title placed in the post header
 *
 * @package COWORKING
 * @since COWORKING 1.75.0
 */

if ( apply_filters( 'coworking_filter_single_post_header', is_singular( 'post' ) || is_singular( 'attachment' ) ) ) {
	$coworking_post_format = str_replace( 'post-format-', '', get_post_format() );
    $post_meta = in_array( $coworking_post_format, array( 'video' ) ) ? get_post_meta( get_the_ID(), 'trx_addons_options', true ) : false;
    $video_autoplay = ! empty( $post_meta['video_autoplay'] )
        && ! empty( $post_meta['video_list'] )
        && is_array( $post_meta['video_list'] )
        && count( $post_meta['video_list'] ) == 1
        && ( ! empty( $post_meta['video_list'][0]['video_url'] ) || ! empty( $post_meta['video_list'][0]['video_embed'] ) );

	// Post title and meta
    ob_start();
	coworking_show_post_title_and_meta( array(
										'share_type'   => 'list',
										'author_avatar' => true,
										'show_labels'  => true,
										'add_spaces'    => true,
										)
									);
	$coworking_post_header = ob_get_contents();
	ob_end_clean();

	// Featured image
	ob_start();
	coworking_show_post_featured_image( array(
		'thumb_bg' => false,
		'popup'    => true,
        'class_avg' => $video_autoplay
            ? 'with_video with_video_autoplay'	// 'with_thumb' is removed
            : '',
        'autoplay'  => $video_autoplay,
        'post_meta' => $post_meta
	) );
	$coworking_post_header .= ob_get_contents();
	ob_end_clean();

	$coworking_with_featured_image = coworking_is_with_featured_image( $coworking_post_header );

	if ( strpos( $coworking_post_header, 'post_featured' ) !== false
		|| strpos( $coworking_post_header, 'post_title' ) !== false
		|| strpos( $coworking_post_header, 'post_meta' ) !== false
	) {
		?>
		<div class="post_header_wrap post_header_wrap_in_header post_header_wrap_style_<?php
			echo esc_attr( coworking_get_theme_option( 'single_style' ) );
			if ( $coworking_with_featured_image ) {
				echo ' with_featured_image';
			}
		?>">
			<div class="content_wrap">
				<?php
				do_action( 'coworking_action_before_post_header' );
				coworking_show_layout( $coworking_post_header );
				do_action( 'coworking_action_after_post_header' );
				?>
			</div>
		</div>
		<?php
	}
}
