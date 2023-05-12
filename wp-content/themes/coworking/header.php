<?php
/**
 * The Header: Logo and main menu
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( coworking_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'coworking_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'coworking_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('coworking_action_body_wrap_attributes'); ?>>

		<?php do_action( 'coworking_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'coworking_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('coworking_action_page_wrap_attributes'); ?>>

			<?php do_action( 'coworking_action_page_wrap_start' ); ?>

			<?php
			$coworking_full_post_loading = ( coworking_is_singular( 'post' ) || coworking_is_singular( 'attachment' ) ) && coworking_get_value_gp( 'action' ) == 'full_post_loading';
			$coworking_prev_post_loading = ( coworking_is_singular( 'post' ) || coworking_is_singular( 'attachment' ) ) && coworking_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $coworking_full_post_loading && ! $coworking_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="coworking_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to content", 'coworking' ); ?></a>
				<?php if ( coworking_sidebar_present() ) { ?>
				<a class="coworking_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to sidebar", 'coworking' ); ?></a>
				<?php } ?>
				<a class="coworking_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to footer", 'coworking' ); ?></a>

				<?php
				do_action( 'coworking_action_before_header' );

				// Header
				$coworking_header_type = coworking_get_theme_option( 'header_type' );
				if ( 'custom' == $coworking_header_type && ! coworking_is_layouts_available() ) {
					$coworking_header_type = 'default';
				}
				get_template_part( apply_filters( 'coworking_filter_get_template_part', "templates/header-" . sanitize_file_name( $coworking_header_type ) ) );

				// Side menu
				if ( in_array( coworking_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'coworking_action_after_header' );

			}
			?>

			<?php do_action( 'coworking_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( coworking_is_off( coworking_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $coworking_header_type ) ) {
						$coworking_header_type = coworking_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $coworking_header_type && coworking_is_layouts_available() ) {
						$coworking_header_id = coworking_get_custom_header_id();
						if ( $coworking_header_id > 0 ) {
							$coworking_header_meta = coworking_get_custom_layout_meta( $coworking_header_id );
							if ( ! empty( $coworking_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$coworking_footer_type = coworking_get_theme_option( 'footer_type' );
					if ( 'custom' == $coworking_footer_type && coworking_is_layouts_available() ) {
						$coworking_footer_id = coworking_get_custom_footer_id();
						if ( $coworking_footer_id ) {
							$coworking_footer_meta = coworking_get_custom_layout_meta( $coworking_footer_id );
							if ( ! empty( $coworking_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'coworking_action_page_content_wrap_class', $coworking_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'coworking_filter_is_prev_post_loading', $coworking_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( coworking_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'coworking_action_page_content_wrap_data', $coworking_prev_post_loading );
			?>>
				<?php
				do_action( 'coworking_action_page_content_wrap', $coworking_full_post_loading || $coworking_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'coworking_filter_single_post_header', coworking_is_singular( 'post' ) || coworking_is_singular( 'attachment' ) ) ) {
					if ( $coworking_prev_post_loading ) {
						if ( coworking_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'coworking_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$coworking_path = apply_filters( 'coworking_filter_get_template_part', 'templates/single-styles/' . coworking_get_theme_option( 'single_style' ) );
					if ( coworking_get_file_dir( $coworking_path . '.php' ) != '' ) {
						get_template_part( $coworking_path );
					}
				}

				// Widgets area above page
				$coworking_body_style   = coworking_get_theme_option( 'body_style' );
				$coworking_widgets_name = coworking_get_theme_option( 'widgets_above_page' );
				$coworking_show_widgets = ! coworking_is_off( $coworking_widgets_name ) && is_active_sidebar( $coworking_widgets_name );
				if ( $coworking_show_widgets ) {
					if ( 'fullscreen' != $coworking_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					coworking_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $coworking_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'coworking_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $coworking_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'coworking_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'coworking_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="coworking_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( coworking_is_singular( 'post' ) || coworking_is_singular( 'attachment' ) )
							&& $coworking_prev_post_loading 
							&& coworking_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'coworking_action_between_posts' );
						}

						// Widgets area above content
						coworking_create_widgets_area( 'widgets_above_content' );

						do_action( 'coworking_action_page_content_start_text' );
