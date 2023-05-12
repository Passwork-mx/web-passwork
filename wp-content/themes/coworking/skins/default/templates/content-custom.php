<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package COWORKING
 * @since COWORKING 1.0.50
 */

$coworking_template_args = get_query_var( 'coworking_template_args' );
if ( is_array( $coworking_template_args ) ) {
	$coworking_columns    = empty( $coworking_template_args['columns'] ) ? 2 : max( 1, $coworking_template_args['columns'] );
	$coworking_blog_style = array( $coworking_template_args['type'], $coworking_columns );
} else {
	$coworking_blog_style = explode( '_', coworking_get_theme_option( 'blog_style' ) );
	$coworking_columns    = empty( $coworking_blog_style[1] ) ? 2 : max( 1, $coworking_blog_style[1] );
}
$coworking_blog_id       = coworking_get_custom_blog_id( join( '_', $coworking_blog_style ) );
$coworking_blog_style[0] = str_replace( 'blog-custom-', '', $coworking_blog_style[0] );
$coworking_expanded      = ! coworking_sidebar_present() && coworking_get_theme_option( 'expand_content' ) == 'expand';
$coworking_components    = ! empty( $coworking_template_args['meta_parts'] )
							? ( is_array( $coworking_template_args['meta_parts'] )
								? join( ',', $coworking_template_args['meta_parts'] )
								: $coworking_template_args['meta_parts']
								)
							: coworking_array_get_keys_by_value( coworking_get_theme_option( 'meta_parts' ) );
$coworking_post_format   = get_post_format();
$coworking_post_format   = empty( $coworking_post_format ) ? 'standard' : str_replace( 'post-format-', '', $coworking_post_format );

$coworking_blog_meta     = coworking_get_custom_layout_meta( $coworking_blog_id );
$coworking_custom_style  = ! empty( $coworking_blog_meta['scripts_required'] ) ? $coworking_blog_meta['scripts_required'] : 'none';

if ( ! empty( $coworking_template_args['slider'] ) || $coworking_columns > 1 || ! coworking_is_off( $coworking_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $coworking_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( coworking_is_off( $coworking_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $coworking_custom_style ) ) . "-1_{$coworking_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $coworking_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $coworking_columns )
					. ' post_layout_' . esc_attr( $coworking_blog_style[0] )
					. ' post_layout_' . esc_attr( $coworking_blog_style[0] ) . '_' . esc_attr( $coworking_columns )
					. ( ! coworking_is_off( $coworking_custom_style )
						? ' post_layout_' . esc_attr( $coworking_custom_style )
							. ' post_layout_' . esc_attr( $coworking_custom_style ) . '_' . esc_attr( $coworking_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'coworking_action_show_layout', $coworking_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $coworking_template_args['slider'] ) || $coworking_columns > 1 || ! coworking_is_off( $coworking_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
