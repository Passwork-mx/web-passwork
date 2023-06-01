<?php
/**
 * The Portfolio template to display the content
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

$coworking_post_format = get_post_format();
$coworking_post_format = empty( $coworking_post_format ) ? 'standard' : str_replace( 'post-format-', '', $coworking_post_format );

?><div class="
<?php
if ( ! empty( $coworking_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( coworking_is_blog_style_use_masonry( $coworking_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $coworking_columns ) : esc_attr( $coworking_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $coworking_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $coworking_columns )
		. ( 'portfolio' != $coworking_blog_style[0] ? ' ' . esc_attr( $coworking_blog_style[0] )  . '_' . esc_attr( $coworking_columns ) : '' )
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

	$coworking_hover   = ! empty( $coworking_template_args['hover'] ) && ! coworking_is_inherit( $coworking_template_args['hover'] )
								? $coworking_template_args['hover']
								: coworking_get_theme_option( 'image_hover' );

	if ( 'dots' == $coworking_hover ) {
		$coworking_post_link = empty( $coworking_template_args['no_links'] )
								? ( ! empty( $coworking_template_args['link'] )
									? $coworking_template_args['link']
									: get_permalink()
									)
								: '';
		$coworking_target    = ! empty( $coworking_post_link ) && false === strpos( $coworking_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$coworking_components = ! empty( $coworking_template_args['meta_parts'] )
							? ( is_array( $coworking_template_args['meta_parts'] )
								? $coworking_template_args['meta_parts']
								: explode( ',', $coworking_template_args['meta_parts'] )
								)
							: coworking_array_get_keys_by_value( coworking_get_theme_option( 'meta_parts' ) );

	// Featured image
	coworking_show_post_featured( apply_filters( 'coworking_filter_args_featured',
        array(
			'hover'         => $coworking_hover,
			'no_links'      => ! empty( $coworking_template_args['no_links'] ),
			'thumb_size'    => ! empty( $coworking_template_args['thumb_size'] )
								? $coworking_template_args['thumb_size']
								: coworking_get_thumb_size(
									coworking_is_blog_style_use_masonry( $coworking_blog_style[0] )
										? (	strpos( coworking_get_theme_option( 'body_style' ), 'full' ) !== false || $coworking_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( coworking_get_theme_option( 'body_style' ), 'full' ) !== false || $coworking_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => coworking_is_blog_style_use_masonry( $coworking_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $coworking_components,
			'class'         => 'dots' == $coworking_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $coworking_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $coworking_post_link )
												? '<a href="' . esc_url( $coworking_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $coworking_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $coworking_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $coworking_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!