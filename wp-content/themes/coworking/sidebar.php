<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

if ( coworking_sidebar_present() ) {
	
	$coworking_sidebar_type = coworking_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $coworking_sidebar_type && ! coworking_is_layouts_available() ) {
		$coworking_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $coworking_sidebar_type ) {
		// Default sidebar with widgets
		$coworking_sidebar_name = coworking_get_theme_option( 'sidebar_widgets' );
		coworking_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $coworking_sidebar_name ) ) {
			dynamic_sidebar( $coworking_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$coworking_sidebar_id = coworking_get_custom_sidebar_id();
		do_action( 'coworking_action_show_layout', $coworking_sidebar_id );
	}
	$coworking_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $coworking_out ) ) {
		$coworking_sidebar_position    = coworking_get_theme_option( 'sidebar_position' );
		$coworking_sidebar_position_ss = coworking_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $coworking_sidebar_position );
			echo ' sidebar_' . esc_attr( $coworking_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $coworking_sidebar_type );

			$coworking_sidebar_scheme = apply_filters( 'coworking_filter_sidebar_scheme', coworking_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $coworking_sidebar_scheme ) && ! coworking_is_inherit( $coworking_sidebar_scheme ) && 'custom' != $coworking_sidebar_type ) {
				echo ' scheme_' . esc_attr( $coworking_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="coworking_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'coworking_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $coworking_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$coworking_title = apply_filters( 'coworking_filter_sidebar_control_title', 'float' == $coworking_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'coworking' ) : '' );
				$coworking_text  = apply_filters( 'coworking_filter_sidebar_control_text', 'above' == $coworking_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'coworking' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $coworking_title ); ?>"><?php echo esc_html( $coworking_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'coworking_action_before_sidebar', 'sidebar' );
				coworking_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $coworking_out ) );
				do_action( 'coworking_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'coworking_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
