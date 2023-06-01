<div class="front_page_section front_page_section_about<?php
	$coworking_scheme = coworking_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $coworking_scheme ) && ! coworking_is_inherit( $coworking_scheme ) ) {
		echo ' scheme_' . esc_attr( $coworking_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( coworking_get_theme_option( 'front_page_about_paddings' ) );
	if ( coworking_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$coworking_css      = '';
		$coworking_bg_image = coworking_get_theme_option( 'front_page_about_bg_image' );
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
	$coworking_anchor_icon = coworking_get_theme_option( 'front_page_about_anchor_icon' );
	$coworking_anchor_text = coworking_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $coworking_anchor_icon ) || ! empty( $coworking_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $coworking_anchor_icon ) ? ' icon="' . esc_attr( $coworking_anchor_icon ) . '"' : '' )
									. ( ! empty( $coworking_anchor_text ) ? ' title="' . esc_attr( $coworking_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( coworking_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' coworking-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$coworking_css           = '';
			$coworking_bg_mask       = coworking_get_theme_option( 'front_page_about_bg_mask' );
			$coworking_bg_color_type = coworking_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $coworking_bg_color_type ) {
				$coworking_bg_color = coworking_get_theme_option( 'front_page_about_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$coworking_caption = coworking_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $coworking_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $coworking_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $coworking_caption, 'coworking_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$coworking_description = coworking_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $coworking_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $coworking_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $coworking_description ), 'coworking_kses_content' ); ?></div>
				<?php
			}

			// Content
			$coworking_content = coworking_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $coworking_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $coworking_content ) ? 'filled' : 'empty'; ?>">
					<?php
					$coworking_page_content_mask = '%%CONTENT%%';
					if ( strpos( $coworking_content, $coworking_page_content_mask ) !== false ) {
						$coworking_content = preg_replace(
							'/(\<p\>\s*)?' . $coworking_page_content_mask . '(\s*\<\/p\>)/i',
							sprintf(
								'<div class="front_page_section_about_source">%s</div>',
								apply_filters( 'the_content', get_the_content() )
							),
							$coworking_content
						);
					}
					coworking_show_layout( $coworking_content );
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
