<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

$coworking_template_args = get_query_var( 'coworking_template_args' );
$coworking_columns = 1;
if ( is_array( $coworking_template_args ) ) {
	$coworking_columns    = empty( $coworking_template_args['columns'] ) ? 1 : max( 1, $coworking_template_args['columns'] );
	$coworking_blog_style = array( $coworking_template_args['type'], $coworking_columns );
	if ( ! empty( $coworking_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $coworking_columns > 1 ) {
	    $coworking_columns_class = coworking_get_column_class( 1, $coworking_columns, ! empty( $coworking_template_args['columns_tablet']) ? $coworking_template_args['columns_tablet'] : '', ! empty($coworking_template_args['columns_mobile']) ? $coworking_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $coworking_columns_class ); ?>">
		<?php
	}
}
$coworking_expanded    = ! coworking_sidebar_present() && coworking_get_theme_option( 'expand_content' ) == 'expand';
$coworking_post_format = get_post_format();
$coworking_post_format = empty( $coworking_post_format ) ? 'standard' : str_replace( 'post-format-', '', $coworking_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $coworking_post_format ) );
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
			'thumb_size' => ! empty( $coworking_template_args['thumb_size'] )
							? $coworking_template_args['thumb_size']
							: coworking_get_thumb_size( strpos( coworking_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $coworking_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$coworking_template_args
	) );

	// Title and post meta
	$coworking_show_title = get_the_title() != '';
	$coworking_show_meta  = count( $coworking_components ) > 0 && ! in_array( $coworking_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $coworking_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'coworking_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'coworking_action_before_post_title' );
				if ( empty( $coworking_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'coworking_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'coworking_filter_show_blog_excerpt', empty( $coworking_template_args['hide_excerpt'] ) && coworking_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'coworking_filter_show_blog_meta', $coworking_show_meta, $coworking_components, 'excerpt' ) ) {
				if ( count( $coworking_components ) > 0 ) {
					do_action( 'coworking_action_before_post_meta' );
					coworking_show_post_meta(
						apply_filters(
							'coworking_filter_post_meta_args', array(
								'components' => join( ',', $coworking_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'coworking_action_after_post_meta' );
				}
			}

			if ( coworking_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'coworking_action_before_full_post_content' );
					the_content( '' );
					do_action( 'coworking_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'coworking' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'coworking' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				coworking_show_post_content( $coworking_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'coworking_filter_show_blog_readmore',  ! isset( $coworking_template_args['more_button'] ) || ! empty( $coworking_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $coworking_template_args['no_links'] ) ) {
					do_action( 'coworking_action_before_post_readmore' );
					if ( coworking_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						coworking_show_post_more_link( $coworking_template_args, '<p>', '</p>' );
					} else {
						coworking_show_post_comments_link( $coworking_template_args, '<p>', '</p>' );
					}
					do_action( 'coworking_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $coworking_template_args ) ) {
	if ( ! empty( $coworking_template_args['slider'] ) || $coworking_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
