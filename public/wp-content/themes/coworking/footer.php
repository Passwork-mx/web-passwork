<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

							do_action( 'coworking_action_page_content_end_text' );
							
							// Widgets area below the content
							coworking_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'coworking_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'coworking_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'coworking_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'coworking_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$coworking_body_style = coworking_get_theme_option( 'body_style' );
					$coworking_widgets_name = coworking_get_theme_option( 'widgets_below_page' );
					$coworking_show_widgets = ! coworking_is_off( $coworking_widgets_name ) && is_active_sidebar( $coworking_widgets_name );
					$coworking_show_related = coworking_is_single() && coworking_get_theme_option( 'related_position' ) == 'below_page';
					if ( $coworking_show_widgets || $coworking_show_related ) {
						if ( 'fullscreen' != $coworking_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $coworking_show_related ) {
							do_action( 'coworking_action_related_posts' );
						}

						// Widgets area below page content
						if ( $coworking_show_widgets ) {
							coworking_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $coworking_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'coworking_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'coworking_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! coworking_is_singular( 'post' ) && ! coworking_is_singular( 'attachment' ) ) || ! in_array ( coworking_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="coworking_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'coworking_action_before_footer' );

				// Footer
				$coworking_footer_type = coworking_get_theme_option( 'footer_type' );
				if ( 'custom' == $coworking_footer_type && ! coworking_is_layouts_available() ) {
					$coworking_footer_type = 'default';
				}
				get_template_part( apply_filters( 'coworking_filter_get_template_part', "templates/footer-" . sanitize_file_name( $coworking_footer_type ) ) );

				do_action( 'coworking_action_after_footer' );

			}
			?>

			<?php do_action( 'coworking_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'coworking_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'coworking_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>