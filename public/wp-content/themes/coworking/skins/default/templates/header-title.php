<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

// Page (category, tag, archive, author) title

if ( coworking_need_page_title() ) {
	coworking_sc_layouts_showed( 'title', true );
	coworking_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								coworking_show_post_meta(
									apply_filters(
										'coworking_filter_post_meta_args', array(
											'components' => join( ',', coworking_array_get_keys_by_value( coworking_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', coworking_array_get_keys_by_value( coworking_get_theme_option( 'counters' ) ) ),
											'seo'        => coworking_is_on( coworking_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$coworking_blog_title           = coworking_get_blog_title();
							$coworking_blog_title_text      = '';
							$coworking_blog_title_class     = '';
							$coworking_blog_title_link      = '';
							$coworking_blog_title_link_text = '';
							if ( is_array( $coworking_blog_title ) ) {
								$coworking_blog_title_text      = $coworking_blog_title['text'];
								$coworking_blog_title_class     = ! empty( $coworking_blog_title['class'] ) ? ' ' . $coworking_blog_title['class'] : '';
								$coworking_blog_title_link      = ! empty( $coworking_blog_title['link'] ) ? $coworking_blog_title['link'] : '';
								$coworking_blog_title_link_text = ! empty( $coworking_blog_title['link_text'] ) ? $coworking_blog_title['link_text'] : '';
							} else {
								$coworking_blog_title_text = $coworking_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $coworking_blog_title_class ); ?>">
								<?php
								$coworking_top_icon = coworking_get_term_image_small();
								if ( ! empty( $coworking_top_icon ) ) {
									$coworking_attr = coworking_getimagesize( $coworking_top_icon );
									?>
									<img src="<?php echo esc_url( $coworking_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'coworking' ); ?>"
										<?php
										if ( ! empty( $coworking_attr[3] ) ) {
											coworking_show_layout( $coworking_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $coworking_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $coworking_blog_title_link ) && ! empty( $coworking_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $coworking_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $coworking_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'coworking_action_breadcrumbs' );
						$coworking_breadcrumbs = ob_get_contents();
						ob_end_clean();
						coworking_show_layout( $coworking_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
