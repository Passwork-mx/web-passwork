<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

$coworking_template_args = get_query_var( 'coworking_template_args' );

if ( is_array( $coworking_template_args ) ) {
	$coworking_columns    = empty( $coworking_template_args['columns'] ) ? 2 : max( 1, $coworking_template_args['columns'] );
	$coworking_blog_style = array( $coworking_template_args['type'], $coworking_columns );
    $coworking_columns_class = coworking_get_column_class( 1, $coworking_columns, ! empty( $coworking_template_args['columns_tablet']) ? $coworking_template_args['columns_tablet'] : '', ! empty($coworking_template_args['columns_mobile']) ? $coworking_template_args['columns_mobile'] : '' );
} else {
	$coworking_blog_style = explode( '_', coworking_get_theme_option( 'blog_style' ) );
	$coworking_columns    = empty( $coworking_blog_style[1] ) ? 2 : max( 1, $coworking_blog_style[1] );
    $coworking_columns_class = coworking_get_column_class( 1, $coworking_columns );
}
$coworking_expanded   = ! coworking_sidebar_present() && coworking_get_theme_option( 'expand_content' ) == 'expand';

$coworking_post_format = get_post_format();
$coworking_post_format = empty( $coworking_post_format ) ? 'standard' : str_replace( 'post-format-', '', $coworking_post_format );

?><div class="<?php
	if ( ! empty( $coworking_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( coworking_is_blog_style_use_masonry( $coworking_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $coworking_columns ) : esc_attr( $coworking_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $coworking_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $coworking_columns )
				. ' post_layout_' . esc_attr( $coworking_blog_style[0] )
				. ' post_layout_' . esc_attr( $coworking_blog_style[0] ) . '_' . esc_attr( $coworking_columns )
	);
	coworking_add_blog_animation( $coworking_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$coworking_hover      = ! empty( $coworking_template_args['hover'] ) && ! coworking_is_inherit( $coworking_template_args['hover'] )
							? $coworking_template_args['hover']
							: coworking_get_theme_option( 'image_hover' );

	$coworking_components = ! empty( $coworking_template_args['meta_parts'] )
							? ( is_array( $coworking_template_args['meta_parts'] )
								? $coworking_template_args['meta_parts']
								: explode( ',', $coworking_template_args['meta_parts'] )
								)
							: coworking_array_get_keys_by_value( coworking_get_theme_option( 'meta_parts' ) );

	coworking_show_post_featured( apply_filters( 'coworking_filter_args_featured',
		array(
			'thumb_size' => ! empty( $coworking_template_args['thumb_size'] )
				? $coworking_template_args['thumb_size']
				: coworking_get_thumb_size(
				'classic' == $coworking_blog_style[0]
						? ( strpos( coworking_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $coworking_columns > 2 ? 'big' : 'huge' )
								: ( $coworking_columns > 2
									? ( $coworking_expanded ? 'square' : 'square' )
									: ($coworking_columns > 1 ? 'square' : ( $coworking_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( coworking_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $coworking_columns > 2 ? 'masonry-big' : 'full' )
								: ($coworking_columns === 1 ? ( $coworking_expanded ? 'huge' : 'big' ) : ( $coworking_columns <= 2 && $coworking_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $coworking_hover,
			'meta_parts' => $coworking_components,
			'no_links'   => ! empty( $coworking_template_args['no_links'] ),
        ),
        'content-classic',
        $coworking_template_args
    ) );

	// Title and post meta
	$coworking_show_title = get_the_title() != '';
	$coworking_show_meta  = count( $coworking_components ) > 0 && ! in_array( $coworking_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $coworking_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'coworking_filter_show_blog_meta', $coworking_show_meta, $coworking_components, 'classic' ) ) {
				if ( count( $coworking_components ) > 0 ) {
					do_action( 'coworking_action_before_post_meta' );
					coworking_show_post_meta(
						apply_filters(
							'coworking_filter_post_meta_args', array(
							'components' => join( ',', $coworking_components ),
							'seo'        => false,
							'echo'       => true,
						), $coworking_blog_style[0], $coworking_columns
						)
					);
					do_action( 'coworking_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'coworking_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'coworking_action_before_post_title' );
				if ( empty( $coworking_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'coworking_action_after_post_title' );
			}

			if( !in_array( $coworking_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'coworking_filter_show_blog_readmore', ! $coworking_show_title || ! empty( $coworking_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $coworking_template_args['no_links'] ) ) {
						do_action( 'coworking_action_before_post_readmore' );
						coworking_show_post_more_link( $coworking_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'coworking_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $coworking_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('coworking_filter_show_blog_excerpt', empty($coworking_template_args['hide_excerpt']) && coworking_get_theme_option('excerpt_length') > 0, 'classic')) {
			coworking_show_post_content($coworking_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $coworking_template_args['more_button'] )) {
			if ( empty( $coworking_template_args['no_links'] ) ) {
				do_action( 'coworking_action_before_post_readmore' );
				coworking_show_post_more_link( $coworking_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'coworking_action_after_post_readmore' );
			}
		}
		$coworking_content = ob_get_contents();
		ob_end_clean();
		coworking_show_layout($coworking_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
