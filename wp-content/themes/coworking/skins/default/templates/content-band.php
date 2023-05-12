<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package COWORKING
 * @since COWORKING 1.71.0
 */

$coworking_template_args = get_query_var( 'coworking_template_args' );

$coworking_columns       = 1;

$coworking_expanded      = ! coworking_sidebar_present() && coworking_get_theme_option( 'expand_content' ) == 'expand';

$coworking_post_format   = get_post_format();
$coworking_post_format   = empty( $coworking_post_format ) ? 'standard' : str_replace( 'post-format-', '', $coworking_post_format );

if ( is_array( $coworking_template_args ) ) {
	$coworking_columns    = empty( $coworking_template_args['columns'] ) ? 1 : max( 1, $coworking_template_args['columns'] );
	$coworking_blog_style = array( $coworking_template_args['type'], $coworking_columns );
	if ( ! empty( $coworking_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $coworking_columns > 1 ) {
	    $coworking_columns_class = coworking_get_column_class( 1, $coworking_columns, ! empty( $coworking_template_args['columns_tablet']) ? $coworking_template_args['columns_tablet'] : '', ! empty($coworking_template_args['columns_mobile']) ? $coworking_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $coworking_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $coworking_post_format ) );
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
								: array_map( 'trim', explode( ',', $coworking_template_args['meta_parts'] ) )
								)
							: coworking_array_get_keys_by_value( coworking_get_theme_option( 'meta_parts' ) );
	coworking_show_post_featured( apply_filters( 'coworking_filter_args_featured',
		array(
			'no_links'   => ! empty( $coworking_template_args['no_links'] ),
			'hover'      => $coworking_hover,
			'meta_parts' => $coworking_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $coworking_template_args['thumb_size'] )
								? $coworking_template_args['thumb_size']
								: coworking_get_thumb_size( 
								in_array( $coworking_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( coworking_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $coworking_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$coworking_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$coworking_show_title = get_the_title() != '';
		$coworking_show_meta  = count( $coworking_components ) > 0 && ! in_array( $coworking_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $coworking_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'coworking_filter_show_blog_categories', $coworking_show_meta && in_array( 'categories', $coworking_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'coworking_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						coworking_show_post_meta( apply_filters(
															'coworking_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $coworking_hover, 1
															)
											);
						?>
					</div>
					<?php
					$coworking_components = coworking_array_delete_by_value( $coworking_components, 'categories' );
					do_action( 'coworking_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'coworking_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'coworking_action_before_post_title' );
					if ( empty( $coworking_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'coworking_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $coworking_template_args['excerpt_length'] ) && ! in_array( $coworking_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$coworking_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'coworking_filter_show_blog_excerpt', empty( $coworking_template_args['hide_excerpt'] ) && coworking_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				coworking_show_post_content( $coworking_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'coworking_filter_show_blog_meta', $coworking_show_meta, $coworking_components, 'band' ) ) {
			if ( count( $coworking_components ) > 0 ) {
				do_action( 'coworking_action_before_post_meta' );
				coworking_show_post_meta(
					apply_filters(
						'coworking_filter_post_meta_args', array(
							'components' => join( ',', $coworking_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'coworking_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'coworking_filter_show_blog_readmore', ! $coworking_show_title || ! empty( $coworking_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $coworking_template_args['no_links'] ) ) {
				do_action( 'coworking_action_before_post_readmore' );
				coworking_show_post_more_link( $coworking_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'coworking_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $coworking_template_args ) ) {
	if ( ! empty( $coworking_template_args['slider'] ) || $coworking_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
