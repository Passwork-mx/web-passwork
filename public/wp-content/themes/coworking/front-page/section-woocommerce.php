<?php
$coworking_woocommerce_sc = coworking_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $coworking_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$coworking_scheme = coworking_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $coworking_scheme ) && ! coworking_is_inherit( $coworking_scheme ) ) {
			echo ' scheme_' . esc_attr( $coworking_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( coworking_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( coworking_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$coworking_css      = '';
			$coworking_bg_image = coworking_get_theme_option( 'front_page_woocommerce_bg_image' );
			if ( ! empty( $coworking_bg_image ) ) {
				$coworking_css .= 'background-image: url(' . esc_url( coworking_get_attachment_url( $coworking_bg_image ) ) . ');';
			}
			if ( ! empty( $coworking_css ) ) {
				echo ' style="' . esc_attr( $coworking_css ) . '"';
			}
			?>
	>
	<?php
		// Add anchor
		$coworking_anchor_icon = coworking_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$coworking_anchor_text = coworking_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $coworking_anchor_icon ) || ! empty( $coworking_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $coworking_anchor_icon ) ? ' icon="' . esc_attr( $coworking_anchor_icon ) . '"' : '' )
											. ( ! empty( $coworking_anchor_text ) ? ' title="' . esc_attr( $coworking_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( coworking_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' coworking-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$coworking_css      = '';
				$coworking_bg_mask  = coworking_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$coworking_bg_color_type = coworking_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $coworking_bg_color_type ) {
					$coworking_bg_color = coworking_get_theme_option( 'front_page_woocommerce_bg_color' );
				} elseif ( 'scheme_bg_color' == $coworking_bg_color_type ) {
					$coworking_bg_color = coworking_get_scheme_color( 'bg_color', $coworking_scheme );
				} else {
					$coworking_bg_color = '';
				}
				if ( ! empty( $coworking_bg_color ) && $coworking_bg_mask > 0 ) {
					$coworking_css .= 'background-color: ' . esc_attr(
						1 == $coworking_bg_mask ? $coworking_bg_color : coworking_hex2rgba( $coworking_bg_color, $coworking_bg_mask )
					) . ';';
				}
				if ( ! empty( $coworking_css ) ) {
					echo ' style="' . esc_attr( $coworking_css ) . '"';
				}
				?>
		>
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$coworking_caption     = coworking_get_theme_option( 'front_page_woocommerce_caption' );
				$coworking_description = coworking_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $coworking_caption ) || ! empty( $coworking_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $coworking_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $coworking_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $coworking_caption, 'coworking_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $coworking_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $coworking_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $coworking_description ), 'coworking_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $coworking_woocommerce_sc ) {
						$coworking_woocommerce_sc_ids      = coworking_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$coworking_woocommerce_sc_per_page = count( explode( ',', $coworking_woocommerce_sc_ids ) );
					} else {
						$coworking_woocommerce_sc_per_page = max( 1, (int) coworking_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$coworking_woocommerce_sc_columns = max( 1, min( $coworking_woocommerce_sc_per_page, (int) coworking_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$coworking_woocommerce_sc}"
										. ( 'products' == $coworking_woocommerce_sc
												? ' ids="' . esc_attr( $coworking_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $coworking_woocommerce_sc
												? ' category="' . esc_attr( coworking_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $coworking_woocommerce_sc
												? ' orderby="' . esc_attr( coworking_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( coworking_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $coworking_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $coworking_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
