<?php
/**
 * The template to display the widgets area in the header
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

// Header sidebar
$coworking_header_name    = coworking_get_theme_option( 'header_widgets' );
$coworking_header_present = ! coworking_is_off( $coworking_header_name ) && is_active_sidebar( $coworking_header_name );
if ( $coworking_header_present ) {
	coworking_storage_set( 'current_sidebar', 'header' );
	$coworking_header_wide = coworking_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $coworking_header_name ) ) {
		dynamic_sidebar( $coworking_header_name );
	}
	$coworking_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $coworking_widgets_output ) ) {
		$coworking_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $coworking_widgets_output );
		$coworking_need_columns   = strpos( $coworking_widgets_output, 'columns_wrap' ) === false;
		if ( $coworking_need_columns ) {
			$coworking_columns = max( 0, (int) coworking_get_theme_option( 'header_columns' ) );
			if ( 0 == $coworking_columns ) {
				$coworking_columns = min( 6, max( 1, coworking_tags_count( $coworking_widgets_output, 'aside' ) ) );
			}
			if ( $coworking_columns > 1 ) {
				$coworking_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $coworking_columns ) . ' widget', $coworking_widgets_output );
			} else {
				$coworking_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $coworking_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'coworking_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $coworking_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $coworking_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'coworking_action_before_sidebar', 'header' );
				coworking_show_layout( $coworking_widgets_output );
				do_action( 'coworking_action_after_sidebar', 'header' );
				if ( $coworking_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $coworking_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'coworking_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
