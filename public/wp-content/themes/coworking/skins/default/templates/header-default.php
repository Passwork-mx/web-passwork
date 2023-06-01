<?php
/**
 * The template to display default site header
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

$coworking_header_css   = '';
$coworking_header_image = get_header_image();
$coworking_header_video = coworking_get_header_video();
if ( ! empty( $coworking_header_image ) && coworking_trx_addons_featured_image_override( is_singular() || coworking_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$coworking_header_image = coworking_get_current_mode_image( $coworking_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $coworking_header_image ) || ! empty( $coworking_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $coworking_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $coworking_header_image ) {
		echo ' ' . esc_attr( coworking_add_inline_css_class( 'background-image: url(' . esc_url( $coworking_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( coworking_is_on( coworking_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight coworking-full-height';
	}
	$coworking_header_scheme = coworking_get_theme_option( 'header_scheme' );
	if ( ! empty( $coworking_header_scheme ) && ! coworking_is_inherit( $coworking_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $coworking_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $coworking_header_video ) ) {
		get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( coworking_is_on( coworking_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
