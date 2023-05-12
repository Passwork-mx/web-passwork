<?php
/**
 * The template to display single post
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

// Full post loading
$full_post_loading          = coworking_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = coworking_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = coworking_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$coworking_related_position   = coworking_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$coworking_posts_navigation   = coworking_get_theme_option( 'posts_navigation' );
$coworking_prev_post          = false;
$coworking_prev_post_same_cat = coworking_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( coworking_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	coworking_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'coworking_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $coworking_posts_navigation ) {
		$coworking_prev_post = get_previous_post( $coworking_prev_post_same_cat );  // Get post from same category
		if ( ! $coworking_prev_post && $coworking_prev_post_same_cat ) {
			$coworking_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $coworking_prev_post ) {
			$coworking_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $coworking_prev_post ) ) {
		coworking_sc_layouts_showed( 'featured', false );
		coworking_sc_layouts_showed( 'title', false );
		coworking_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $coworking_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/content', 'single-' . coworking_get_theme_option( 'single_style' ) ), 'single-' . coworking_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $coworking_related_position, 'inside' ) === 0 ) {
		$coworking_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'coworking_action_related_posts' );
		$coworking_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $coworking_related_content ) ) {
			$coworking_related_position_inside = max( 0, min( 9, coworking_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $coworking_related_position_inside ) {
				$coworking_related_position_inside = mt_rand( 1, 9 );
			}

			$coworking_p_number         = 0;
			$coworking_related_inserted = false;
			$coworking_in_block         = false;
			$coworking_content_start    = strpos( $coworking_content, '<div class="post_content' );
			$coworking_content_end      = strrpos( $coworking_content, '</div>' );

			for ( $i = max( 0, $coworking_content_start ); $i < min( strlen( $coworking_content ) - 3, $coworking_content_end ); $i++ ) {
				if ( $coworking_content[ $i ] != '<' ) {
					continue;
				}
				if ( $coworking_in_block ) {
					if ( strtolower( substr( $coworking_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$coworking_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $coworking_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $coworking_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$coworking_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $coworking_content[ $i + 1 ] && in_array( $coworking_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$coworking_p_number++;
					if ( $coworking_related_position_inside == $coworking_p_number ) {
						$coworking_related_inserted = true;
						$coworking_content = ( $i > 0 ? substr( $coworking_content, 0, $i ) : '' )
											. $coworking_related_content
											. substr( $coworking_content, $i );
					}
				}
			}
			if ( ! $coworking_related_inserted ) {
				if ( $coworking_content_end > 0 ) {
					$coworking_content = substr( $coworking_content, 0, $coworking_content_end ) . $coworking_related_content . substr( $coworking_content, $coworking_content_end );
				} else {
					$coworking_content .= $coworking_related_content;
				}
			}
		}

		coworking_show_layout( $coworking_content );
	}

	// Comments
	do_action( 'coworking_action_before_comments' );
	comments_template();
	do_action( 'coworking_action_after_comments' );

	// Related posts
	if ( 'below_content' == $coworking_related_position
		&& ( 'scroll' != $coworking_posts_navigation || coworking_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || coworking_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'coworking_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $coworking_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $coworking_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $coworking_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $coworking_prev_post ) ); ?>"
			<?php do_action( 'coworking_action_nav_links_single_scroll_data', $coworking_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
