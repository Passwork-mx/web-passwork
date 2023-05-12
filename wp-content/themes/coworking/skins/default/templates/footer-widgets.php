<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package COWORKING
 * @since COWORKING 1.0.10
 */

// Footer sidebar
$coworking_footer_name    = coworking_get_theme_option( 'footer_widgets' );
$coworking_footer_present = ! coworking_is_off( $coworking_footer_name ) && is_active_sidebar( $coworking_footer_name );
if ( $coworking_footer_present ) {
	coworking_storage_set( 'current_sidebar', 'footer' );
	$coworking_footer_wide = coworking_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $coworking_footer_name ) ) {
		dynamic_sidebar( $coworking_footer_name );
	}
	$coworking_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $coworking_out ) ) {
		$coworking_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $coworking_out );
		$coworking_need_columns = true;   //or check: strpos($coworking_out, 'columns_wrap')===false;
		if ( $coworking_need_columns ) {
			$coworking_columns = max( 0, (int) coworking_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $coworking_columns ) {
				$coworking_columns = min( 4, max( 1, coworking_tags_count( $coworking_out, 'aside' ) ) );
			}
			if ( $coworking_columns > 1 ) {
				$coworking_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $coworking_columns ) . ' widget', $coworking_out );
			} else {
				$coworking_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $coworking_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'coworking_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $coworking_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $coworking_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'coworking_action_before_sidebar', 'footer' );
				coworking_show_layout( $coworking_out );
				do_action( 'coworking_action_after_sidebar', 'footer' );
				if ( $coworking_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $coworking_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'coworking_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
