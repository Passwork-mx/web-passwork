<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package COWORKING
 * @since COWORKING 1.0
 */

$coworking_template = apply_filters( 'coworking_filter_get_template_part', coworking_blog_archive_get_template() );

if ( ! empty( $coworking_template ) && 'index' != $coworking_template ) {

	get_template_part( $coworking_template );

} else {

	coworking_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$coworking_stickies   = is_home()
								|| ( in_array( coworking_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) coworking_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$coworking_post_type  = coworking_get_theme_option( 'post_type' );
		$coworking_args       = array(
								'blog_style'     => coworking_get_theme_option( 'blog_style' ),
								'post_type'      => $coworking_post_type,
								'taxonomy'       => coworking_get_post_type_taxonomy( $coworking_post_type ),
								'parent_cat'     => coworking_get_theme_option( 'parent_cat' ),
								'posts_per_page' => coworking_get_theme_option( 'posts_per_page' ),
								'sticky'         => coworking_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $coworking_stickies )
															&& count( $coworking_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		coworking_blog_archive_start();

		do_action( 'coworking_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'coworking_action_before_page_author' );
			get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'coworking_action_after_page_author' );
		}

		if ( coworking_get_theme_option( 'show_filters' ) ) {
			do_action( 'coworking_action_before_page_filters' );
			coworking_show_filters( $coworking_args );
			do_action( 'coworking_action_after_page_filters' );
		} else {
			do_action( 'coworking_action_before_page_posts' );
			coworking_show_posts( array_merge( $coworking_args, array( 'cat' => $coworking_args['parent_cat'] ) ) );
			do_action( 'coworking_action_after_page_posts' );
		}

		do_action( 'coworking_action_blog_archive_end' );

		coworking_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'coworking_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
