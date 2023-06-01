<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

$coworking_columns     = max( 1, min( 3, count( get_option( 'sticky_posts' ) ) ) );
$coworking_post_format = get_post_format();
$coworking_post_format = empty( $coworking_post_format ) ? 'standard' : str_replace( 'post-format-', '', $coworking_post_format );

?><div class="column-1_<?php echo esc_attr( $coworking_columns ); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class( 'post_item post_layout_sticky post_format_' . esc_attr( $coworking_post_format ) );
	coworking_add_blog_animation( $coworking_template_args );
	?>
>

	<?php
	if ( is_sticky() && is_home() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	coworking_show_post_featured(
		array(
			'thumb_size' => coworking_get_thumb_size( 1 == $coworking_columns ? 'big' : ( 2 == $coworking_columns ? 'med' : 'avatar' ) ),
		)
	);

	if ( ! in_array( $coworking_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h5 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			coworking_show_post_meta( apply_filters( 'coworking_filter_post_meta_args', array(), 'sticky', $coworking_columns ) );
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div><?php

// div.column-1_X is a inline-block and new lines and spaces after it are forbidden
